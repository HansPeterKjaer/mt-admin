<?php
	$wo = $viewModel->workout;
?>

<form id="workout-form" class="form-horizontal ajax-form" method="POST" action="<?php isset($wo) ? URLHelper::renderUrl('/AdminWorkout/update') : URLHelper::renderUrl('/AdminWorkout/insert'); ?>" >
	<input name="id" type="hidden" value="<?php echo $wo->id; ?>" />
	<div class="form-group">
		<label for="inputName" class="col-sm-4 col-md-2 control-label">Titel</label>			
		<div class="col-sm-8 col-md-6">
			<input class="form-control" id="inputName" name="name" type="text" value="<?php echo $wo->name; ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="inputDiff" class="col-sm-4 col-md-2 control-label" >Sværhedsgrad</label>	
		<div class="col-sm-4">
			<select class="form-control" id="inputDiff" name="diff" >
			  <option value="1" <?php if($wo->diff==1){echo "selected ";} ?>><?php echo MapperHelper::diffToString(1); ?></option>
			  <option value="2" <?php if($wo->diff==2){echo "selected ";} ?>><?php echo MapperHelper::diffToString(2); ?></option>
			  <option value="3" <?php if($wo->diff==3){echo "selected ";} ?>><?php echo MapperHelper::diffToString(3); ?></option>
			  <option value="4" <?php if($wo->diff==4){echo "selected ";} ?>><?php echo MapperHelper::diffToString(4); ?></option>
			  <option value="5" <?php if($wo->diff==5){echo "selected ";} ?>><?php echo MapperHelper::diffToString(5); ?></option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="inputFocus" class="col-sm-4 col-md-2 control-label">Fokus</label>		
		<div class="col-sm-4">
			<select class="form-control" id="inputFocus" name="focus" >
			  <option value="1" <?php if($wo->focus==1){echo "selected ";} ?>><?php echo MapperHelper::focusToString(1); ?></option>
			  <option value="2" <?php if($wo->focus==2){echo "selected ";} ?>><?php echo MapperHelper::focusToString(2); ?></option>
			  <option value="3" <?php if($wo->focus==3){echo "selected ";} ?>><?php echo MapperHelper::focusToString(3); ?></option>
			  <option value="4" <?php if($wo->focus==4){echo "selected ";} ?>><?php echo MapperHelper::focusToString(4); ?></option>
			  <option value="5" <?php if($wo->focus==5){echo "selected ";} ?>><?php echo MapperHelper::focusToString(5); ?></option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="inputDescr" class="col-sm-4 col-md-2 control-label">Beskrivelse</label>
		<div class="col-sm-8 col-md-6">	
			<textarea class="form-control" id="inputDescr" name="descr" rows="3"/><?php echo $wo->descr; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="inputProtocol" class="col-sm-4 col-md-2 control-label">Program</label>		
		<div class="col-sm-4">
			<select class="form-control" id="inputProtocol" name="protocol" >
			  <?php 
			  	foreach ($viewModel->protocols as $key => $val) {
			  		$selected = ($val->id == $wo->protocol->id) ? "selected" : "";
			  		echo("<option value='$val->id' $selected >$val->name</option>");
			  	}
			  ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="input-import-exercise" class="col-sm-4 col-md-2 control-label">Øvelser</label>			
		<div class="col-sm-8 col-md-6">
			<div class="input-group">
	      		<input id="input-import-exercise" type="text" name="exercise" class="form-control autocomplete" value="" data-url="/mt/AdminExercise/exerciseListJson" autocomplete="off" />
	      		<span class="input-group-btn">
	        		<button class="btn btn-default btn-import-exercise" for="input-import-exercise" data-url="/mt/adminexercise/ExerciseJSON?controls=true" type="button">Importer øvelse</button>
	      		</span>
	      	</div>
	    </div>
	</div>
	<select id="composer-select" multiple class="" name="exercises[]" hidden>
		<?php 
			foreach ($wo->exercises as $ex ) {
				echo "<option value='{$ex->id}' selected ></option>";
			}
		?>
	</select>
	<div class="form-group">
		<div class="col-sm-8 col-sm-offset-4 col-md-10 col-md-offset-2">
			<div class="row">	
				<div id="workout-exercises" class="item-composer" data-select-elm="#composer-select">	
					<?php 
					  	foreach ($wo->exercises as $ex) {
					  		ViewHelper::renderPartial("exercise/_exercise", $ex);
					  	}
					?>
					<div>
				</div>
			</div>
		</div>
	</div>


	<div class="form-group form-msg">
		<div class="col-sm-12 btn-group">
			<button id="btn-submit-workout" class="pull-right btn btn-success" type="submit">Opdater workout</button>
		</div>
	</div>
</form>




