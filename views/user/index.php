<div class="row">
  <div class="col-sm-12">
  	<div class="btn-toolbar pull-right">
	    <div class="btn-group">
	    	<a href="<?php URLHelper::renderUrl('AdminUser/CreateUser') ?>" class="btn btn-margin-top btn-success btn-lg btn-default">Opret ny bruger</a>
	    </div>
	</div>
	<h1>Brugere</h1>
  </div>
</div>

<table class="table">
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
				<form method="POST" action="<?php URLHelper::renderUrl('/AdminUser/deleteUser'); ?>" class="inline"><input type="hidden" name="brugernavn" value="<?php echo $usr->username ?>" /><input type="hidden" name="email" value="<?php echo $usr->email ?>" /><button type="submit" id="btn_delete" class="btn btn-sm btn-danger" ><i class="glyphicon glyphicon-trash icon-white"></i> Slet</button></form>
				<button id="btn_update" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-edit icon-white"></i> Opdater</button>
			</td>
		</tr>
<?php }?>

	</tbody>
</table>

