<?php 	
	$ex = $viewModel;
?>

<form id="exercise-form" class="form-horizontal ajax-form" method="POST" action="<?php isset($ex) ? URLHelper::renderUrl('/AdminExercise/update') : URLHelper::renderUrl('/AdminExercise/insert'); ?>">
	<?php if(isset($ex)){ echo "<input id='' name='id' type='hidden' value='{$ex->id}'/>"; } ?>	
	<div class="form-group">
		<label for="inputTitle" class="col-sm-4 col-md-2 control-label">Titel</label>			
		<div class="col-sm-8 col-md-6">
			<input class="form-control" id="inputTitle" name="title" type="text" value="<?php echo isset($ex) ? $ex->name : '' ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="inputDiff" class="col-sm-4 col-md-2 control-label" >Cardio/Styrke Forhold</label>	
		<div class="col-sm-4">
			<select class="form-control" id="inputDiff" name="diff" >
			  <option value="1" <?php if(isset($ex) && $ex->diff==1){echo "selected ";} ?> >1 (let)</option>
			  <option value="2" <?php if(isset($ex) && $ex->diff==2){echo "selected ";} ?> >2 (let-medium)</option>
			  <option value="3" <?php if(isset($ex) && $ex->diff==3){echo "selected ";} ?> >3 (medium)</option>
			  <option value="4" <?php if(isset($ex) && $ex->diff==4){echo "selected ";} ?> >4 (medium-hård)</option>
			  <option value="5" <?php if(isset($ex) && $ex->diff==5){echo "selected ";} ?> >5 (hård)</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="inputFocus" class="col-sm-4 col-md-2 control-label">Fokus</label>		
		<div class="col-sm-4">
			<select class="form-control" id="inputFocus" name="focus" >
			  <option value="1" <?php if(isset($ex) && $ex->focus==1){echo "selected ";} ?> >Arme</option>
			  <option value="2" <?php if(isset($ex) && $ex->focus==2){echo "selected ";} ?> >Ben</option>
			  <option value="3" <?php if(isset($ex) && $ex->focus==3){echo "selected ";} ?> >Mave</option>
			  <option value="4" <?php if(isset($ex) && $ex->focus==4){echo "selected ";} ?> >Ryg</option>
			  <option value="5" <?php if(isset($ex) && $ex->focus==5){echo "selected ";} ?> >Helkrop</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="inputDescr" class="col-sm-4 col-md-2 control-label">Beskrivelse</label>
		<div class="col-sm-8 col-md-6">	
			<?php ViewHelper::renderPartial("shared/scribetoolbar", $viewModel);?>
			<div class="form-control wysiwyg" id="input-descr" ><?php if(isset($ex)){ echo htmlspecialchars_decode($ex->descr, ENT_HTML5); } ?></div>
			<textarea class="form-control" name="descr" rows="3"/><?php if(isset($ex)){ echo htmlspecialchars_decode($ex->descr, ENT_HTML5); } ?></textarea>
		</div>
	</div>
	<div class="form-group form-inline">
		<label class="col-sm-4 col-md-2 control-label">Billeder</label> 
		<div class="col-sm-8 col-md-6">
			<span class="btn btn-success btn-file">
    			Upload billede<input class="btn-ex-upload" type="file" data-ex-controls="true" data-target-url="<?php URLHelper::renderUrl('/Media/insertImageJSON/'); ?>"></input>
			</span>
			<!--button type="button" class="btn btn-info" id="">Importer fra mediearkiv</button-->
			<div class="input-group pull-right">
	      		<input id="input-import-image1" type="text" name="imageName" class="form-control input-import-image autocomplete autocomplete-thumb sub-query" value="" data-url="<?php URLHelper::renderUrl('/media/searchImageJson?term='); ?>" autocomplete="off" />
	      		<span class="input-group-btn btn-import-image">
	        		<button class="btn btn-default btn-import-image" for="input-import-image1" type="button">Importer fra mediearkiv</button>
	      		</span>
	      	</div>
		</div>
	</div>
	<select id="image-composer-select" multiple class="images" name="images[]" hidden>
		<?php 
			foreach ($ex->images->items as $image) {
				echo "<option value='{$image->id}' selected ></option>";
			}
		?>
	</select>
	<div class="form-group ">
		<div class="col-sm-8 col-sm-offset-4 col-md-10 col-md-offset-2">
			<div class="row">
				<div id="exercise-images" class=" item-composer small-gutters" data-select-elm="#image-composer-select">
					<?php 
						if(isset($ex->images) && count($ex->images) > 0){
							$ex->images->controls = true;
							ViewHelper::renderPartial("media/_imageResults", $ex->images); 
						}
						else{
					?>
							<div class="itemplaceholder">Upload et nyt billede eller vælg et eksisterende fra billedarkivet</div>
					<?php 
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12 btn-group">
			<button id="btn-submit-exercise" class="pull-right btn btn-success" type="submit">
				<?php echo isset($ex) ? 'Opdater øvelse' : 'Opret øvelse'; ?>
			</button>
		</div>
	</div>
</form>