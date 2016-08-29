<div class="row">
	<div class="col-xs-12 col-md-12">
		<h1>Oversigt</h1>
		<div class="mt-panel">
			<h1>Seneste Workouts</h1>
			<table class="table  frontpage-workout-table">
				<thead>
					<tr>
						<th>Navn (Internt)</th>
						<th>Program</th>
						<th>Øvelser</th>
						<th>Cardio/Styrke</th>
						<th>Fokus</th>		
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php ViewHelper::renderPartial("workout/_workoutList", $viewModel->workouts); ?>
				</tbody>	
			</table>
		</div>
	</div>
	<div class="col-xs-12 col-md-6">
		<div class="mt-panel">
			<h1>Seneste Øvelser</h1>
			<table class="table  frontpage-exercise-table">
				<thead>
					<tr>
						<th>Navn</th>
						<th>Cardio/Styrke</th>
						<th>Fokus</th>		
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php ViewHelper::renderPartial("exercise/_exerciseList", $viewModel->exercises); ?>
				</tbody>	
			</table>
		</div>
	</div>
	<div class="col-xs-12 col-md-6">
		<div class="mt-panel">
			<h1>Seneste Programmer</h1>
			<table class="table  frontpage-protocol-table">
				<thead>
					<tr>
						<th>Navn</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php ViewHelper::renderPartial("protocol/_protocolList", $viewModel->protocols); ?>
				</tbody>	
			</table>
		</div>
	</div>
</div>