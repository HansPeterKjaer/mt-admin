<h1>Opret Program</h1>

<form id="exercise-form" class="form-horizontal ajax-form" method="POST" action="<?php URLHelper::renderUrl('/AdminProtocol/insert'); ?>">
	<div class="form-group">
		<label for="inputTitle" class="col-sm-4 col-md-2 control-label">Navn</label>			
		<div class="col-sm-8 col-md-6">
			<input class="form-control" id="inputTitle" name="name" type="text" value="" />
		</div>
	</div>
	<div class="form-group">
		<label for="inputDescr" class="col-sm-4 col-md-2 control-label">Beskrivelse</label>
		<div class="col-sm-8 col-md-6">	
			<textarea class="form-control" id="inputDescr" name="descr" rows="3"/></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12 btn-group">
			<button id="btn-submit-exercise" class="pull-right btn btn-success" type="submit">Opret Program</button>
		</div>
	</div>
</form>
