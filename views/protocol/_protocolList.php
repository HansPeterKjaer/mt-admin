<?php foreach($viewModel->protocols as $pr){ ?>
		<tr>
			<td><a href='<?php URLHelper::renderUrl("AdminProtocol/display/$pr->id"); ?>'><?php echo $pr->name ?></a></td>
			<td><?php echo $pr->descr ?></td>
			<td>
				<a class="btn btn-sm btn-danger ajax-delete" data-url="<?php URLHelper::renderUrl("/adminProtocol/delete/"); ?>" data-id="<?php echo $pr->id ?>" href="#"><i class="glyphicon glyphicon-trash icon-white"></i> Slet</a>
				<a class="btn btn-sm btn-success" href="<?php URLHelper::renderUrl("AdminProtocol/display/$pr->id"); ?>"><i class="glyphicon glyphicon-edit icon-white"></i> Rediger</a>
			</td>
		</tr>
<?php }?>