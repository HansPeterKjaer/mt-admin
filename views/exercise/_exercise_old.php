<div class='exercise small boxed thumbnail' data-id='<?php echo $viewModel->id; ?>'>
	<img src='' />
	<div class='caption'>
		<h1><?php echo $viewModel->name; ?></h1>
		<p><?php echo MapperHelper::focusToString($viewModel->focus); ?></p>
		<p><?php echo $viewModel->diff; ?></p>
		<button class="btn-move-left btn btn-xs btn-primary">
			<i class="glyphicon glyphicon-arrow-left"></i>
		</button>
		<button class="btn-remove btn btn-xs btn-danger">
			<i class="glyphicon glyphicon-remove"></i>
		</button>
		<button class="btn-move-right btn btn-xs btn-primary" >
			<i class="glyphicon glyphicon-arrow-right"></i>
		</button>
	</div>
</div>