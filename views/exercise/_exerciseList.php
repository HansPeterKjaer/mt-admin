<?php foreach($viewModel->exercises as $ex){ ?>
		<tr>
			<td><a href='<?php URLHelper::renderUrl("AdminExercise/display/$ex->id"); ?>'><?php echo $ex->name ?></a></td>
			<td><?php echo $ex->descr ?></td>
			<td><?php echo $ex->diff ?></td>
			<td><?php echo $ex->focus ?></td>
			<td>
				<?php foreach($ex->images->items as $item){ ?>
					<img class="img-sm" src="<?php URLHelper::renderURL("uploads/$item->imageName") ?>" />
				<?php }?>
			</td>
			<td>
				<a class="btn btn-sm btn-danger ajax-delete" data-url="<?php URLHelper::renderUrl("/adminExercise/delete/"); ?>" data-id="<?php echo $ex->id ?>" href="#"><i class="glyphicon glyphicon-trash icon-white"></i> Slet</a>
				<a class="btn btn-sm btn-success" href="<?php URLHelper::renderUrl("AdminExercise/display/$ex->id"); ?>"><i class="glyphicon glyphicon-edit icon-white"></i> Rediger</a>
			</td>
		</tr>
<?php }?>