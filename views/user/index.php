<div class="row">
  <div class="col-sm-12">
  	<div class="btn-toolbar pull-right">
	    <div class="btn-group">
	    	<a href="<?php URLHelper::renderUrl('AdminUser/CreateUser') ?>" class="btn btn-success btn-lg btn-default">Opret ny bruger</a>
	    </div>
	</div>
	<h1>Brugere</h1>
  </div>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Brugernavn</th>
			<th>Email</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

<?php foreach($viewModel->users as $usr){ ?>
		<tr>
			<td><?php echo $usr->username ?></td>
			<td><?php echo $usr->email ?></td>
			<td>
				<form method="POST" action="/mt/AdminUser/deleteUser" class="inline"><input type="hidden" name="brugernavn" value="<?php echo $usr->username ?>" /><input type="hidden" name="email" value="<?php echo $usr->email ?>" /><input type="submit" id="btn_delete" class="btn btn-sm btn-danger" value="Slet" /></form>
				<button id="btn_update" class="btn btn-sm btn-success">Opdater</button>
			</td>
		</tr>
<?php }?>

	</tbody>
</table>

