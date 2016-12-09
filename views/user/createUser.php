<h1>Tilføj ny Bruger</h1>

<form class="form-horizontal ajax-form" method="POST" action="<?php URLHelper::renderUrl('AdminUser/addUser'); ?>">
	<div class="form-group">
		<label for="brugernavn" class="col-sm-4 col-md-2 control-label">Brugernavn</label>
		<div class="col-sm-4">			
			<input class="form-control" id="brugernavn" type="text" name="brugernavn" />
		</div>
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-4 col-md-2 control-label">Email</label>
		<div class="col-sm-4">
			<input id="email" type="email" name="email" class="form-control" />
		</div>	
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-4 col-md-2 control-label">Password</label>
		<div class="col-sm-4">
			<input id="password" type="password" name="password" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label for="password2" class="col-sm-4 col-md-2 control-label">Gentag Password</label>
		<div class="col-sm-4">	
			<input id="password2" type="password" name="password2" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label for="role" class="col-sm-4 col-md-2 control-label">Rettigheder</label>
		<div class="col-sm-4">
			<select class="form-control col-sm-4" id="role" name="role">
				<option value="admin">Admin</option>
				<option value="editor">Editor</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12 btn-group">
			<input class="pull-right btn btn-success" type='submit' value ='Opret bruger' />
		</div>
	</div>
	
</form>