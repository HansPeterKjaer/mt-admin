
<?php 	
	$pr = $viewModel->protocol;
?>

<h1>Opdater Program</h1>

<form id="protocol-form" class="form-horizontal" method="POST" action="<?php URLHelper::renderUrl('/AdminProtocol/update'); ?>">
	<input id="" name="id" type="hidden" value="<?php echo $pr->id ?>" />
	<div class="form-group">
		<label for="inputName" class="col-sm-4 col-md-2 control-label">Navn</label>			
		<div class="col-sm-8 col-md-6">
			<input class="form-control" id="input-name" name="name" type="text" value="<?php echo $pr->name ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="inputDescr" class="col-sm-4 col-md-2 control-label">Beskrivelse</label>
		<div class="col-sm-8 col-md-6">	
			<?php ViewHelper::renderPartial("shared/scribetoolbar", $viewModel);?>
			<div class="form-control wysiwyg" id="input-descr" ><?php echo htmlspecialchars_decode($pr->descr, ENT_HTML5); ?></div>
			<textarea name="descr"><?php echo htmlspecialchars_decode($pr->descr, ENT_HTML5); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12 btn-group">
			<button id="btn-submit-protocol" class="pull-right btn btn-success" type="submit">Opdater program</button>
		</div>
	</div>
</form>