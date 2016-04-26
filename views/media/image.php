<div class="row">
  <div class="col-sm-12">
	<h1>Mediearkiv <?php echo($viewModel->MediaItem->imageName) ?></h1>
  </div>
</div>
<div class="row">
	<div class="col-xs-12 imagecontainer">
		<div class="thumbnail">
			<img src="<?php URLHelper::renderUrl("assets/uploads/{$viewModel->MediaItem->imageName}"); ?>" data-id="<?php echo($viewModel->MediaItem->id) ?>" />
			<div class="caption">
				
					<form id="image-rename-form" class="ajax-form" method="post" action="<?php URLHelper::renderUrl("/media/updateImageName"); ?>">
			      		<input type="hidden" name="id" value="<?php echo($viewModel->MediaItem->id); ?>" />
			      		<div class="input-group">
				      		<input type="text" name="imageName" class="form-control" value="<?php echo($viewModel->MediaItem->imageName) ?>" />
				      		<span class="input-group-btn">
				        		<button class="btn btn-default" type="submit">Opdater navn</button>
				      		</span>
				      	</div>
			      	</form>
		    	</div>
		    	<span class="btn btn-success btn-file">
    				Opdater billede<input class="btn-upload-image" type="file" data-target-url="/mt/Media/updateImage/" data-target-id="<?php echo($viewModel->MediaItem->id) ?>">
				</span>
				<button class="btn-remove btn btn-danger" type="submit" form="image-delete-form"><i class="glyphicon glyphicon-remove"></i> Slet billede</button>
				<form id="image-delete-form" class="ajax-form" method="post" action="<?php URLHelper::renderUrl("/media/deleteImage"); ?>">
					<input type="hidden" name="id" value="<?php echo($viewModel->MediaItem->id); ?>" />
				</form>
			</div>
		</div>
	</div>
</div>
