<div class="row">
  <div class="col-sm-12">
  	<div class="btn-toolbar pull-right">
	    <div class="btn-group">
	    <a href="<?php URLHelper::renderUrl('Workout/Create') ?>" class="btn btn-margin-top btn-success btn-lg btn-default">Opret ny Workout</a>
	    </div>
	</div>
	<h1>Workouts</h1>
  </div>
</div>

<div class="row">
  	<div class="col-xs-12">
		<?php ViewHelper::renderPartial("shared/_alphabetfilter", $viewModel->workouts); ?>
	</div>
  	<div class="col-xs-12">
    	<div class="input-group">
      		<input id="ajax-panel-search-input" type="text" class="form-control" placeholder="Search for...">
      		<span class="input-group-btn">
        		<button id="ajax-panel-search-btn" class="btn btn-default" type="button">Søg</button>
      		</span>
    	</div>
  	</div>
</div>

<div class="row">
  	<div class="col-xs-12">
		<table class="table ">
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

			<tbody class="ajax-panel" data-url="<?php URLHelper::renderUrl('Workout/workoutListJson'); ?>" data-filter-class="ajax-panel-filter" data-search-id="ajax-panel-search-input" data-search-btn-id="ajax-panel-search-btn" data-load-more-btn-id="ajax-panel-load-more" data-sort-class="ajax-panel-sort" >
				<?php ViewHelper::renderPartial("workout/_workoutList", $viewModel->workouts); ?>
			</tbody>
		</table>
	</div>
	
	<div class="col-xs-12">
		<button id="ajax-panel-load-more" class="btn btn-default <?php if($viewModel->workouts->totalPages == 1) echo 'hidden'; ?>" type="button">Vis flere</button>
	</div>
</div>