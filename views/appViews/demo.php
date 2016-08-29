<?php
	$wo = $viewModel->workout;
	$formData = $viewModel->formData;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MT Workout Test</title>
	<link href="<?php URLHelper::renderUrl('assets/css/base.css')?>" rel="stylesheet">
<style>
	.navbar-brand img{
	margin-top: -5px;
    margin-bottom: -5px;
    height: 30px;
}
.workout-exercises .exercise .description{
		display:none;
	}
	.imageViewer{
	width:100%;
	position: relative;
	}
	.imageViewer img{
	width:100%;
	display: none;
	}
	.imageViewer img.current{
	display: inline-block;
	}
	h1.margin-sm, h2.margin-sm, h3.margin-sm, h4.margin-sm{
		margin-top:5px;
		margin-bottom: 0px;
	}
	.workout-exercises .exercise h1{
		font-size: 16px;
		margin: 0;
	}
	.workout-exercises .exercise button{
		display:none;
	}
	.workout-exercises .exercise p{
		margin: 0;
	}
	.workout-exercises .exercise.selected{
	    border: 2px #0f0 solid;
	}
	.row.small-gutters {
	  margin-right: -5px;
	  margin-left: -5px;
	}
	.row.small-gutters > [class^="col-"],
	.row.small-gutters > [class*=" col-"] {
	  padding-right: 5px;
	  padding-left: 5px;
	}
</style>
	</head>

	
	<body>
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#"><img src="mt/assets/images/mtlogo_b_inv.png" alt="My-trainer" /></a>
	    </div>
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="#">Workout Generator <span class="sr-only">(current)</span></a></li>
	        <li><a href="#">Blog</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	</div>
</nav>

<div class="container-fluid">
	<div class="row top-margin small-gutters">
		<div class="col-xs-12 col-sm-6 " >
			<div class="mt-panel generator clearfix">
				<h1 class="margin-sm">Generer workout</h1>
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-xs-4">Cardio/Styrke</label>
						<div class="col-xs-4">
							<input class="diff-range" type="range" name="diff" min="1" max="5" step="1" <?php if ($formData) { echo "value='{$formData['diff']}'"; }; ?> />
						</div>
						<div class="col-xs-4">
							<span id="diff-value" class="diff"><?php if ($formData) { echo "(" . (6 - intval($formData['diff'])) . "/{$formData['diff']})"; }; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-4" for="input-focus">Fokus</label>
						<div class="col-sm-4">
							<select class="form-control " id="input-focus" name="focus" >
							  <option value="1" <?php if($formData && $formData['focus']==1){echo "selected ";} ?>><?php echo MapperHelper::focusToString(1); ?></option>
							  <option value="2" <?php if($formData && $formData['focus']==2){echo "selected ";} ?>><?php echo MapperHelper::focusToString(2); ?></option>
							  <option value="3" <?php if($formData && $formData['focus']==3){echo "selected ";} ?>><?php echo MapperHelper::focusToString(3); ?></option>
							  <option value="4" <?php if($formData && $formData['focus']==4){echo "selected ";} ?>><?php echo MapperHelper::focusToString(4); ?></option>
							  <option value="5" <?php if($formData && $formData['focus']==5){echo "selected ";} ?>><?php echo MapperHelper::focusToString(5); ?></option>
							</select>
						</div>
					</div>
					<div class="form-group">					
						<label class="col-xs-4" for="time">Tid</label>
						<div class="col-sm-4">
							<select class="form-control" name="time">
								<option value="all" <?php if($formData && $formData['time']=='all'){echo "selected ";} ?> >Alle</option>
								<option value="short" <?php if($formData && $formData['time']=='short'){echo "selected ";} ?> >Under 15 min</option>
								<option value=">long" <?php if($formData && $formData['time']=='>long'){echo "selected ";} ?>>Over 15 min</option>
							</select>
						</div>
					</div>
					<button class="btn btn-lg btn-success pull-right">Generer Workout</button>
				</form>
			</div>
			<div class="mt-panel workout">
<?php 
	if($wo != null){
		ViewHelper::renderPartial("appViews/_workout", $wo);
	}
	else if ($formData != null){
		ViewHelper::renderPartial("appViews/_noWorkoutFound", null);
	}
	else{
		ViewHelper::renderPartial("appViews/_dummyWorkout", null);
	}
?>
			</div>
		</div>	
		<div class="col-xs-12 col-sm-6" >
			<div class="mt-panel exercise-panel">
				<div class="row">
					<div class="col-xs-12" >
						<h1 class="margin-sm">Øvelse</h1>
						<p class="placeholder">Generer en workout ud fra dine parametre og klik start for at komme igang!</p>
					</div>
				</div>
			</div>		
		</div>
	</div>
</div>





</div>
<script>
	var doc = document;
	var win = window;

	var exerciseThumbs = doc.querySelectorAll('.workout-exercises .exercise');
	var startBtn =  doc.querySelector('.workoutbtn');
	var diffRange = doc.querySelector('.diff-range');

	diffRange.addEventListener('input', function(evt){
		var diffValueElm = doc.querySelector('#diff-value');
		diffValueElm.textContent = '(' + (6-this.value) + '/' + this.value + ')';
	});

	startBtn && startBtn.addEventListener('click', function(evt){
		var nextExercise = null
		if (doc.querySelector('.workout-exercises .exercise.selected')) {
			nextExercise = doc.querySelector('.workout-exercises .exercise.selected').parentNode.nextElementSibling.childNodes[1];
			console.log(nextExercise);
		}
		if (nextExercise == null) nextExercise = doc.querySelector('.workout-exercises .exercise');
		selectExercise(nextExercise);
		startBtn.textContent = 'Næste Øvelse';
	});

	for (var i = 0; i < exerciseThumbs.length; ++i) {
		exerciseThumbs[i].addEventListener('click', function(evt){
			selectExercise(this);			
		});
	}

	function selectExercise(target){
		var exercise = target.cloneNode(true);
		doc.querySelector('.workout-exercises .exercise.selected') && doc.querySelector('.workout-exercises .exercise.selected').classList.remove('selected');
		target.classList.add('selected');
		var exercisePanel = doc.querySelector('.exercise-panel');

		var currentExercise = exercisePanel.querySelector('.exercise');
		currentExercise && exercisePanel.removeChild(currentExercise);
		exercisePanel.appendChild(exercise);
		var placeholder = exercisePanel.querySelector('.placeholder');
		placeholder && placeholder.classList.add('hidden');
		player(exercise);
	}
	function player(exercise){
		var imageViewer = exercise.querySelector('.imageViewer');
		var exerciseImages = imageViewer.querySelectorAll('img');
		var currentImage = imageViewer.querySelector('img.current');
		var exerciseTimer = null;

		var playBtn = exercise.querySelector('.btn-play');
		var prevBtn = exercise.querySelector('.btn-prev');
		var nextBtn = exercise.querySelector('.btn-next');

		playBtn.addEventListener('click', play);
		nextBtn.addEventListener('click', next);
		prevBtn.addEventListener('click', prev);

		function play(evt){
			if (exerciseTimer) {
				clearInterval(exerciseTimer);
				exerciseTimer = null;
			}else{
				exerciseTimer = setInterval(playCallback, 1000);
			}
		}
		
		function playCallback(){
		next();
		}

		function next(evt){
		var nextImage = currentImage.nextElementSibling;
		if (nextImage == null) nextImage = exerciseImages[0];
		nextImage.classList.add('current');
		currentImage.classList.remove('current');
		currentImage = nextImage;
		}

		function prev(evt){
		var prevImage = currentImage.previousElementSibling;
		if (prevImage == null) prevImage = exerciseImages[exerciseImages.length-1];
		prevImage.classList.add('current');
		currentImage.classList.remove('current');
		currentImage = prevImage;
		}	
	}

	


</script>
	</body>
</html>