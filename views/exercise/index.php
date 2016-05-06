 
<div class="row">
  <div class="col-sm-12">
  	<div class="btn-toolbar pull-right">
	    <div class="btn-group">
	    <a href="<?php URLHelper::renderUrl('AdminExercise/Create') ?>" class="btn btn-success btn-lg btn-default">Opret ny øvelse</a>
	    </div>
	</div>
	<h1>Øvelser</h1>
  </div>
</div>

<div class="row">
  	<div class="col-xs-12">
		<?php ViewHelper::renderPartial("shared/_alphabetfilter", null); ?>
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

<table class="table table-striped">
	<thead>
		<tr>
			<th>Navn</th>
			<th>Beskrivelse</th>
			<th>Sværhed</th>
			<th>Fokus</th>
			<th>Billeder</th>
			<th></th>
		</tr>
	</thead>
	<tbody class="ajax-panel" data-url="<?php URLHelper::renderUrl('/AdminExercise/exerciseListPanel'); ?>" data-filter-class="ajax-panel-filter" data-search-id="ajax-panel-search-input" data-search-btn-id="ajax-panel-search-btn" data-load-more-btn-id="ajax-panel-load-more" data-sort-class="ajax-panel-sort" >
		<?php ViewHelper::renderPartial("exercise/_exerciseList", $viewModel->exercises); ?>
	</tbody>
</table>

<div class="col-xs-12">
	<button id="ajax-panel-load-more" class="btn btn-default <?php if($viewModel->exercises->totalPages == 1) echo 'hidden'; ?>" type="button">Vis flere</button>
</div>