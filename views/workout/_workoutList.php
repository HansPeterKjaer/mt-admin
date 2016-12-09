<?php
	foreach($viewModel->workouts as $wo){ 
?>
		<tr>
			<td><a href='<?php URLHelper::renderUrl("AdminWorkout/display/$wo->id"); ?>'><?php echo $wo->name ?></a></td>
			<td><?php if($wo->protocol){echo $wo->protocol->name;} ?></td>
			<td><?php foreach($wo->exercises as $index => $ex){echo (($index==0) ? '' : ', ') . $ex->name;} ?></td>
			<td><?php echo MapperHelper::diffToString($wo->diff); ?></td>
			<td><?php echo MapperHelper::focusToString($wo->focus); ?></td>
			<td>
				<a class="btn btn-sm btn-danger ajax-delete" data-url="<?php URLHelper::renderUrl("adminWorkout/delete/"); ?>" data-id="<?php echo $wo->id ?>" href="#"><i class="glyphicon glyphicon-trash icon-white"></i> Slet</a>
				<a class="btn btn-sm btn-success" href="<?php URLHelper::renderUrl("AdminWorkout/display/$wo->id"); ?>"><i class="glyphicon glyphicon-edit icon-white"></i> Rediger</a>
			</td>
		</tr>
<?php
	} 
?>