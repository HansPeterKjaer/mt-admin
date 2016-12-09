<?php
	$wo = $viewModel->workout;
?>

<form id="workout-form" class="form-horizontal ajax-form" method="POST" action="<?php ($wo->id != null) ? URLHelper::renderUrl('AdminWorkout/update') : URLHelper::renderUrl('AdminWorkout/insert'); ?>" >
	<input name="id" type="hidden" value="<?php echo $wo->id; ?>" />
	<div class="form-group">
		<label for="inputName" class="col-sm-4 col-md-2 control-label">Titel (Intern)</label>			
		<div class="col-sm-8 col-md-6">
			<input class="form-control" id="inputName" name="name" type="text" value="<?php echo $wo->name; ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="inputDiff" class="col-sm-4 col-md-2 control-label" >Cardio/Styrke Forhold</label>	
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
		<label for="inputFocus" class="col-sm-4 col-md-2 control-label">Tid</label>		
		<div class="col-sm-4">
			<input class="form-control" type="number" min="0" id="inputTime" disabled="true" name="time" value="<?php echo $wo->time; ?>" />
			<label><input class="" type="checkbox" id="input-check-time" onchange="document.getElementById('inputTime').disabled = !this.checked;" /></label>
		</div>
	</div>
	<div class="form-group hidden">
		<label for="inputDescr" class="col-sm-4 col-md-2 control-label">Beskrivelse</label>
		<div class="col-sm-8 col-md-6">
			<?php ViewHelper::renderPartial("shared/scribetoolbar", $viewModel);?>	
			<div class="form-control wysiwyg" id="input-descr" ><?php if(isset($wo)){ echo htmlspecialchars_decode($wo->descr, ENT_HTML5); } ?></div>
			<textarea class="form-control" name="descr" rows="3"/><?php if(isset($wo)){ echo htmlspecialchars_decode($wo->descr, ENT_HTML5); } ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="inputProtocol" class="col-sm-4 col-md-2 control-label">Program</label>		
		<div class="col-sm-4">
			<select class="form-control" id="inputProtocol" name="protocol" >
			  <?php 
			  	foreach ($viewModel->protocols->protocols as $key => $val) {
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
			<div class="input-group import-status">
	      		<input id="input-import-exercise" type="text" name="exercise" class="form-control autocomplete" value="" data-url="<?php URLHelper::renderUrl('AdminExercise/exerciseListJson'); ?>" autocomplete="off" />
	      		<span class="input-group-btn">
	        		<button class="btn btn-default btn-import-exercise" for="input-import-exercise" data-url="<?php URLHelper::renderUrl('adminexercise/ExerciseJSON?controls=true'); ?>" type="button">Importer øvelse</button>
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
				<div id="workout-exercises" class="item-composer small-gutters" data-select-elm="#composer-select">	
					<?php 
						if(isset($wo->exercises) && count($wo->exercises) > 0){
					  		foreach ($wo->exercises as $ex) {
					  			ViewHelper::renderPartial("exercise/_exercise", $ex);
					  		}
					  	} 
					  	else {
					?>
						<div class="itemplaceholder">Importer øvelser ovenfor. Indtast øvelsens navn og klik 'Importer øvelse'.</div>
					<?php 
						}
					?>
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




