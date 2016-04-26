<?php

class SettingMapper extends BaseModelMapper{
	public function fetchDBDump(){
		$dbh = $this->dbhandle;
		$content = '';
		$msg = '';
		$status = false;
		try {
			$tables = ['exercise', 'image', 'protocol', 'workout', 'exercise_image', 'workout_exercise'];
			
			foreach($tables as $table){

				$result  = $dbh->query('SELECT * FROM '.$table);

				$columns = $result->columnCount();
				$rows_num = $result->rowCount();
    
				$result2 = $dbh->query('SHOW CREATE TABLE '.$table); 
				$createTableSQL = $result2->fetch(PDO::FETCH_NUM);
				
				$content = $content . "\n\n".$createTableSQL[1].";\n\n";

				for ($i = 0, $st_counter = 0; $i < $columns; $i++, $st_counter=0) {
					while($row = $result->fetch(PDO::FETCH_NUM)) { 
						//when started (and every after 100 command cycle):
						
						if ($st_counter%100 == 0 || $st_counter == 0 )  
						{
							$content .= "\nINSERT INTO ".$table." VALUES";
						}
						$content .= "\n(";
						
						for($j = 0; $j < $columns; $j++)  
						{ 
							$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
							if (isset($row[$j]))
							{
								$content .= '"'.$row[$j].'"' ; 
							}
							else 
							{   
								$content .= '""';
							}     
							if ($j < ($columns-1))
							{
								$content.= ',';
							}      
						}
						$content .=")";
						
						//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
						if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
						{   
							$content .= ";";
						} 
						else 
						{
							$content .= ",";
						} 
						$st_counter=$st_counter+1;
					}
				} $content .="\n\n\n";
			}
			$msg = 'Sucessfully generated dbdump';
			$status = true;

		} catch (Exception $e) {
			if (@constant('DEVELOPMENT_ENVIRONMENT') == false)
				$msg = "Db error could not perform request";
			else
				$msg = $e->xdebug_message;
		}
		return ['status' => $status, 'msg' => $msg, 'dump' => $content];
	}
}
?>