<?php

class AdminFrontpageViewModelMapper extends BaseViewModelMapper{

	public function fetch(BaseViewModel &$model){
		$modelFactory = new ModelFactory($this->dbhandle);

		$workoutModelMapper = $modelFactory->buildMapper('WorkoutModelMapper');
		$exerciseModelMapper = $modelFactory->buildMapper('ExerciseModelMapper');
		$protocolModelMapper = $modelFactory->buildMapper('protocolModelMapper');		

		$workoutModelMapper->search($model->workouts, 5);
		$exerciseModelMapper->search($model->exercises, 5);
		$protocolModelMapper->search($model->protocols, 5);

		parent::fetch($model);
	}
}

?>