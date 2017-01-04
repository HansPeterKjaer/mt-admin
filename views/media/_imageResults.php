<?php 
	foreach($viewModel->items as $img){ 
?>

	<div class='col-xs-6 col-sm-4 col-md-3 col-lg-2 imagecontainer itemcontainer'>
		<div class='thumbnail'>
			<img src='<?php URLHelper::renderUrl("/mtassets/exercise-images/$img->imageName"); ?>' data-id='<?php echo($img->id) ?>' />
			<div class='caption'>
				<p>
					<a href='<?php URLHelper::renderUrl("media/displayImage/$img->id"); ?>' ><?php echo($img->imageName) ?></a>
				</p>
<?php
	if($viewModel->controls != false){
?>
				<button class="btn-move-left btn btn-xs btn-primary">
					<i class="glyphicon glyphicon-arrow-left"></i>
				</button>
				<button class="btn-remove btn btn-xs btn-danger">
					<i class="glyphicon glyphicon-remove"></i>
				</button>
				<button class="btn-move-right btn btn-xs btn-primary" >
					<i class="glyphicon glyphicon-arrow-right"></i>
				</button>
<?php		
	}
?>
			</div>
		</div>
	</div>

<?php 
	}
?>