<div class="row">
  <div class="col-sm-12">
  	<div class="btn-toolbar pull-right">
	    <div class="btn-group">
	    	<span class="btn btn-success btn-margin-top btn-lg btn-file">
    			Upload billede<input class="btn-upload-image" type="file" data-target-url="<?php URLHelper::renderUrl('Media/insertImageJSON/'); ?>"></input>
			</span>
	    </div>
	</div>
	<h1>Mediearkiv</h1>
	<span class="upload-status"></span>
  </div>
</div>

<div class="row">
  	<div class="col-xs-12">
		<?php ViewHelper::renderPartial("shared/_alphabetfilter", null); ?>
	</div>
  	<div class="col-xs-12">
    	<div class="input-group">
      		<input id="ajax-panel-search" type="text" class="form-control" placeholder="Search for...">
      		<span class="input-group-btn">
        		<button id="ajax-panel-search-btn" class="btn btn-default" type="button">Søg</button>
      		</span>
    	</div>
  	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div id="exercise-images" class="ajax-panel" data-url="<?php URLHelper::renderUrl('Media/imagePanelJson'); ?>" data-filter-class="ajax-panel-filter" data-search-id="ajax-panel-search" data-search-btn-id="ajax-panel-search-btn" data-load-more-btn-id="ajax-panel-load-more" data-sort-class="ajax-panel-sort"  >
			<?php 
				ViewHelper::renderPartial("media/_imageResults", $viewModel->MediaItems); 
			?>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<button id="ajax-panel-load-more" class="btn btn-default  <?php if($viewModel->MediaItems->totalPages == 1) echo 'hidden'; ?>" type="button">Vis flere</button>
	</div>
</div>

