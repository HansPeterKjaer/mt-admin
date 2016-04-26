<?php 
class JSONController extends BaseController {
	public function getWorkoutByIdAction($wo_id){
		$mapper = $this->modelFactory->buildMapper('WorkoutModelMapper');
		$model = $mapper->fetch($wo_id);

		if($model){
			$this->view->outputJSON(get_object_vars($model));
		}
		else{ 
			// something meaningfull
		}
	}
	public function getExerciseByIdAction($wo_id){
		$mapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
		$model = $this->modelFactory->buildObject('ExerciseModel');
		
		if($mapper->fetchById($model, $wo_id)){
			$this->view->outputJSON(get_object_vars($model));
		}
		else{ 
			// something meaningfull		
		}
	}
	public function searchExerciseAction($term, $diff, $focus){
		$mapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
		$models = []; // b$this->modelFactory->buildObject('ExerciseModel');

		$result = $mapper->fetchBySearchData($models, $term, $diff, $focus);

		if($result['success'] == true){
			$this->view->outputJSON(['status'=>'success', 'data' => $models, 'msg'=> null]);
		}
		else{ 
			$this->view->outputJSON(['status'=>'error', 'data' => null, 'msg'=> $result['msg']]);
		}
	}
	public function searchWorkoutAction($term, $diff, $focus){
		$mapper = $this->modelFactory->buildMapper('WorkoutModelMapper');
		$models = []; // b$this->modelFactory->buildObject('ExerciseModel');

		$result = $mapper->fetchBySearchData($models, $term, $diff, $focus);

		if($result['success'] == true){
			$this->view->outputJSON(['status'=>'success', 'data' => $models, 'msg'=> null]);
		}
		else{ 
			$this->view->outputJSON(['status'=>'error', 'data' => null, 'msg'=> $result['msg']]);
		}
	}
}
?>