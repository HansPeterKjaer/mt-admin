<?php

class Auth{
	private $dbh;

	public function __construct($dbh){
		$this->dbh = $dbh;
	}

	public function login($username, $password){
		
		$user = $this->getUser($username);

		if(!$user){
			return array('msg'=>'username_incorrect','error'=>1);
		}
		if (!password_verify($password, $user['password'])) {
			return array('msg'=>'username_password_incorrect','error'=>1);
		}
		$sessiondata = $this->addSession($user);
		
		if($sessiondata == false) {
			return array('msg'=>'system error','error'=>1);
		}

		return array('msg'=>'success','error'=>0, 'hash'=>$sessiondata['hash'], 'expire'=>$sessiondata['expire']);

	}
	
	public function addUser($email, $username, $password){
		$msg = 'error';
		$status = 0;
		
		$salt = substr(strtr(base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)), '+', '.'), 0, 22);
		$hash = password_hash($password, PASSWORD_BCRYPT, ['salt' => $salt, 'cost' => 10]);
		
		$stmt = $this->dbh->prepare("INSERT INTO users (username, password, email, salt, isactive) VALUES (:username, :hash, :email, :salt, :isactive)");
		try{
			$stmt->execute(array('username'=>$username,'hash'=>$hash,'email'=>$email,'salt'=>$salt, 'isactive'=>true));
			$msg = 'success';
			$status = 1;
		} 
		catch (PDOException $e){
			if ($e->getCode() == '23000') {
				$msg = "User {$username} already exists";
			}
			else if (@constant('DEVELOPMENT_ENVIRONMENT') == false) {
				$msg = 'db error could not perform request';
			}
			else {
				$msg = json_encode($e->xdebug_message);		
			}
	    }	
		return array('msg'=>$msg,'status'=>$status);
	}

	private function getUser($username){
		$stmt = $this->dbh->prepare("SELECT id, username, password, email, salt, isactive FROM 	users WHERE username = ?");
		$stmt->execute(array($username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$row)
			return false;
		return $row;
	}

	public function getAllUsers(){
		$stmt = $this->dbh->prepare("SELECT id, username, email FROM users WHERE isactive = 1");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	public function deleteUser($username, $email){
		$stmt = $this->dbh->prepare("DELETE FROM users WHERE username = ? AND email = ?");
		$result = $stmt->execute(array($username, $email));

		return $result;
	}

	private function addSession($user)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		
		if(!$user) {
			return false;
		}
		$data['hash'] = sha1($user['salt'] . microtime());
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$this->deleteExistingSessions($user['id']);
		
		$data['expire'] = date("Y-m-d H:i:s", strtotime('+30 minutes'));
		$data['expiretime'] = 0;

		$data['cookie_crc'] = sha1($data['hash'] . 'fghuior.)/%dgdhjUyhdbv7867HVHG7777ghg');
		$query = $this->dbh->prepare("INSERT INTO usersessions (uid, hash, expiredate, ip, agent, cookie_crc) VALUES (?, ?, ?, ?, ?, ?)");
		
		if(!$query->execute(array($user['id'], $data['hash'], $data['expire'], $ip, $agent, $data['cookie_crc']))) {
			return false;
		}
		
		$data['expire'] = strtotime($data['expire']);
		return $data;
	}

	private function deleteExistingSessions($id)
	{
		$query = $this->dbh->prepare("DELETE FROM usersessions WHERE uid = ?");
		return $query->execute(array($id));
	}

	public function checkSession($hash)
	{
		#$ip = $this->getIp();
		#if ($this->isBlocked()) {
		#	return false;
		#}
		if (strlen($hash) != 40) {
			return false;
		}
		$query = $this->dbh->prepare("SELECT id, uid, expiredate, ip, agent, cookie_crc FROM usersessions WHERE hash = ?");
		$query->execute(array($hash));
		if ($query->rowCount() == 0) {
			return false;
		}
		
		$row = $query->fetch(PDO::FETCH_ASSOC);
		$sid = $row['id'];
		$uid = $row['uid'];
		$expiredate = strtotime($row['expiredate']);
		$currentdate = strtotime(date("Y-m-d H:i:s"));
		$db_ip = $row['ip'];
		$db_agent = $row['agent'];
		$db_cookie = $row['cookie_crc'];
		
		if ($currentdate > $expiredate) {
			$this->deleteExistingSessions($uid);
			return false;
		}
		
		if ($this->getIp() != $db_ip) {
			if ($_SERVER['HTTP_USER_AGENT'] != $db_agent) {
				$this->deleteExistingSessions($uid);
				return false;
			}
			
			return $this->updateSessionIp($sid, $ip);
		}
		
		if ($db_cookie == sha1($hash . 'fghuior.)/%dgdhjUyhdbv7867HVHG7777ghg')) {
			// added HP: reset expirtedate on activity
			$query = $this->dbh->prepare("UPDATE usersessions SET expiredate = ? WHERE hash = ?");
    		$query->execute(array(date("Y-m-d H:i:s", strtotime('+30 minutes')), $hash));
			return true;
		}
		
		return false;
	}

	/*
	* Updates the IP of a session (used if IP has changed, but agent has remained unchanged)
	* @param int $sid
	* @param string $ip
	* @return boolean
	*/
	private function updateSessionIp($sid, $ip)
	{
		$query = $this->dbh->prepare("UPDATE usersessions SET ip = ? WHERE id = ?");
		return $query->execute(array($ip, $sid));
	}

	private function getIp()
	{
		return $_SERVER['REMOTE_ADDR'];
	}

	public function logout($hash)
	{
		if (strlen($hash) != 40) {
			return false;
		}
		return $this->deleteSession($hash);
	}

	private function deleteSession($hash)
	{
		$query = $this->dbh->prepare("DELETE FROM usersessions WHERE hash = ?");
		return $query->execute(array($hash));
	}
}

?>