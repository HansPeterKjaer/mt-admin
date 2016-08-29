<?php

class AdminWorkoutController extends SecureController{

	public function indexAction(){
		$viewModel = $this->modelFactory->buildObject('WorkoutListViewModel');
		$mapper = $this->modelFactory->buildMapper('WorkoutViewModelMapper');
		$mapper->init($viewModel);

		$workoutListModel = $this->modelFactory->buildObject('WorkoutListModel');
		$workoutModelMapper = $this->modelFactory->buildMapper('WorkoutModelMapper');
    	$workoutModelMapper->search($workoutListModel, 10, 1);

    	$viewModel->workouts = $workoutListModel;

    	$viewModel->currentMenuItem = 'workouts';

		$this->view->output('workout/index',$viewModel);
	}

	public function workoutListJsonAction($page, $term, $filter){
		$workoutListModel = $this->modelFactory->buildObject('WorkoutListModel');
		$workoutModelMapper = $this->modelFactory->buildMapper('WorkoutModelMapper');
    	$workoutModelMapper->search($workoutListModel, 10, $page, $term, $filter);

    	ob_start();
			$this->view->output('/workout/_workoutList', $workoutListModel, false);			 
		$html = ob_get_clean();

		$this->view->outputJSON(['html' => $html, 'pages' => $workoutListModel->totalPages]);
	}

	public function displayAction($wo_id){
		$viewModel = $this->modelFactory->buildObject('WorkoutViewModel');
		$mapper = $this->modelFactory->buildMapper('WorkoutViewModelMapper');
		$mapper->init($viewModel);
    
    	$workoutModel = $this->modelFactory->buildObject('WorkoutModel');
        $workoutModelMapper = $this->modelFactory->buildMapper('WorkoutModelMapper');
        $protocolModelMapper = $this->modelFactory->buildMapper('ProtocolModelMapper');
                
        $protocolModelMapper->fetchAll($viewModel->protocols);
        $workoutModelMapper->fetchById($viewModel->workout, $wo_id);

        $viewModel->currentMenuItem = 'workouts';

		$this->view->output('workout/updateWorkout',$viewModel);
	}

	public function createAction(){
		$viewModel = $this->modelFactory->buildObject('WorkoutViewModel');
		$mapper = $this->modelFactory->buildMapper('WorkoutViewModelMapper');
		$mapper->fetchEmpty($viewModel);

		$viewModel->currentMenuItem = 'workouts';

		$this->view->output('workout/createWorkout',$viewModel);
	}

	public function insertAction($name, $diff, $focus, $descr, $protocol, $exercises){	
		$mapper = $this->modelFactory->buildMapper('WorkoutModelMapper');
		$this->view->outputJSON($mapper->insert($name, $diff, $focus, $descr, $protocol, $exercises));
	}

	public function updateAction($id, $name, $diff, $focus, $descr, $protocol, $exercises = []){	
		$mapper = $this->modelFactory->buildMapper('WorkoutModelMapper');

		$this->view->outputJSON( $mapper->update($id, $name, $diff, $focus, $descr, $protocol, $exercises) );
	}

	protected function deleteAction($id){
		$mapper = $this->modelFactory->buildMapper('WorkoutModelMapper');
		$status = $mapper->delete($id);
		$this->view->outputJSON(array('success'=>$status));
	}
}

?>