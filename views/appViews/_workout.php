<?php 
	$wo = $viewModel;
?>
<div class="row">
	<div class="col-xs-12" >
			<h1 class="margin-sm">Din Workout: <?php echo $wo->protocol->name; ?> <span class="hidden"><?php echo $wo->name; ?></span></h1>
		<div class="pull-left">
			<p>Fokus: <?php echo MapperHelper::diffToString($wo->diff); ?></p>
			<p>Type: <?php echo MapperHelper::focusToString($wo->focus); ?></p>
			<p class="hidden">Beskrivelse: <?php echo $wo->descr; ?></p>
		</div>
		<button class="btn workoutbtn btn-xxl btn-success pull-right">Start Workout</button>
	</div>

	<div class="col-xs-12" >
		<div class="panel">
			<h2 class="margin-sm">Program</h2>
			<p><?php echo $wo->protocol->descr; ?></p>		
		</div>
	</div>

	<div class="col-xs-12" >
		<div class="workout-exercises panel">
			<h2 class="margin-sm">Øvelser</h2>
			
			<div class="row small-gutters">

<?php 
	foreach ($wo->exercises as $ex ) {
?>
	<div class="col-sm-2">
		<div class='exercise small boxed thumbnail' data-id='<?php echo $ex->id; ?>'>
			<div class="imageViewer">
				<?php 
					$current = true;
					foreach($ex->images->items as $item){ 
				?>
					<img class="<?php if ($current == true){ echo 'current'; } ?>" src="<?php URLHelper::renderURL("uploads/$item->imageName") ?>" />
				<?php 
					$current = false;
				}?>
			</div>
			<button class="btn-play btn btn-xs btn-primary"><i class="_glyphicon _glyphicon-arrow-left"></i>></button>
			<button class="btn-next btn btn-xs btn-primary"><i class="_glyphicon _glyphicon-arrow-left"></i>-></button>
			<button class="btn-prev btn btn-xs btn-primary"><i class="_glyphicon _glyphicon-arrow-left"></i><-</button>  
			<div class=''>
				<h1 class="margin-sm"><?php echo $ex->name; ?></h1>
				<p><?php echo MapperHelper::focusToString($ex->focus); ?></p>
				<p><?php echo MapperHelper::diffToString($ex->diff); ?></p>
				<p><?php echo $ex->descr; ?></p>
			</div>
		</div>
	</div>
<?php 
	}
?>
			</div>
		</div>        
	</div>
</div>