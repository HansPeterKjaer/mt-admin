
<h1>Seneste Workouts</h1>
<table class="table table-striped frontpage-workout-table">
	<thead>
		<tr>
			<th>Navn</th>
			<th>Øvelser</th>
			<th>Sværhed</th>
			<th>Fokus</th>		
			<th>Program</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php ViewHelper::renderPartial("workout/_workoutList", $viewModel->workouts); ?>
	</tbody>	
</table>

<h1>Seneste Øvelser</h1>
<table class="table table-striped frontpage-exercise-table">
	<tbody>
		<?php ViewHelper::renderPartial("exercise/_exerciseList", $viewModel->exercises); ?>
	</tbody>	
</table>

<h1>Seneste Programmer</h1>
<table class="table table-striped frontpage-protocol-table">
	<tbody>
		<?php ViewHelper::renderPartial("protocol/_protocolList", $viewModel->protocols); ?>
	</tbody>	
</table>