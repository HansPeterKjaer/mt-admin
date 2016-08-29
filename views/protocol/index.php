<div class="row">
  <div class="col-sm-12">
  	<div class="btn-toolbar pull-right">
	    <div class="btn-group">
	    <a href="<?php URLHelper::renderUrl('AdminProtocol/Create') ?>" class="btn btn-success btn-margin-top btn-lg btn-default">Opret ny program</a>
	    </div>
	</div>
	<h1>Programmer</h1>
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

<table class="table ">
	<thead>
		<tr>
			<th>Navn</th>
			<th></th>
		</tr>
	</thead>
	<tbody class="ajax-panel" data-url="<?php URLHelper::renderUrl('/AdminProtocol/protocolListPanel'); ?>" data-filter-class="ajax-panel-filter" data-search-id="ajax-panel-search-input" data-search-btn-id="ajax-panel-search-btn" data-load-more-btn-id="ajax-panel-load-more" data-sort-class="ajax-panel-sort" >
		<?php ViewHelper::renderPartial("protocol/_protocolList", $viewModel->protocols); ?>
	</tbody>
</table>