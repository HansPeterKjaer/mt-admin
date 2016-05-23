<?php

class AdminExerciseController extends SecureController{
	public function indexAction(){
		$viewModel = $this->modelFactory->buildObject('ExerciseListViewModel');
		$mapper = $this->modelFactory->buildMapper('ExerciseViewModelMapper');
		$mapper->init($viewModel);

		$exerciseListModel = $this->modelFactory->buildObject('ExerciseListModel');
		$exerciseModelMapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
    	$exerciseModelMapper->search($exerciseListModel, 10, 1);

    	$viewModel->exercises = $exerciseListModel;
		$this->view->output('exercise/index', $viewModel);
	}

	public function exerciseListPanelAction($page, $term, $filter, $sort){
		$exerciseListModel = $this->modelFactory->buildObject('ExerciseListModel');
		$exerciseModelMapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
    	$exerciseModelMapper->search($exerciseListModel, 10, $page, $term, $filter, $sort);

    	ob_start();
			$this->view->output('/exercise/_exerciseList', $exerciseListModel, false);			 
		$html = ob_get_clean();

		$this->view->outputJSON(['html' => $html, 'pages' => $exerciseListModel->totalPages]);
	}

	public function displayAction($id){
		$ex_id = $id;
		$viewModel = $this->modelFactory->buildObject('ExerciseListViewModel');
		$mapper = $this->modelFactory->buildMapper('ExerciseViewModelMapper');
		$mapper->fetchById($viewModel, $ex_id);
		$this->view->output('exercise/updateExercise', $viewModel);
	}

	public function createAction(){
		$viewModel = $this->modelFactory->buildObject('BaseViewModel');
		$mapper = $this->modelFactory->buildMapper('BaseViewModelMapper');
		$mapper->fetch($viewModel);
		$this->view->output('exercise/createExercise', $viewModel);
	}

	public function updateAction($id, $title, $diff, $descr, $focus, $images = []){
		$mapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
		$model = new ExerciseModel();
		$model->id = $id;
		$model->name = $title;
		$model->diff = $diff;
		$model->focus = $focus;
		$model->descr = $descr;
		$model->images = $images;

		if($mapper->update($model))
			$this->view->outputJSONString('{"status": 1, "msg": "Exercise successfully updated!"}');
		else
			$this->view->outputJSONString('{"status": 0, "msg": "An error occured! Please try again later."}');
	}

	protected function insertAction($title, $diff, $descr, $focus, $images = []){
	
		//print_r($images);	
		$mapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
		$model = new ExerciseModel();
		$model->name = $title;
		$model->diff = $diff;
		$model->focus = $focus;
		$model->descr = $descr;
		$model->images = $images;

		if($mapper->insert($model))
			$this->view->outputJSONString('{"status": 1, "msg": "Exercise successfully created!"}');
		else
			$this->view->outputJSONString('{"status": 0, "msg": "An error occured! Please try again later."}');
	}


	protected function deleteAction($id){
		$mapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
		$this->view->outputJSON($mapper->delete($id));
	}

	protected function exerciseListJsonAction(){
		$model = array();
		$mapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
		$mapper->fetchAll($model, false);

		$this->view->outputJSON($model);
	}
	protected function exerciseJsonAction($name, $controls = false){
		$model = $this->modelFactory->buildObject('ExerciseModel');
		$mapper = $this->modelFactory->buildMapper('ExerciseModelMapper');
		$result = $mapper->fetchByName($model, $name);
		$html = '';
		$msg = 'Øvelsen kunne ikke findes i systemet!';

		if($result == true){
			ob_start();
			$this->view->output('exercise/_exercise', $model, false);			 
			$html = ob_get_clean();	
			$msg = "Øvelse: {$name} hentet!";
		}
			
		$this->view->outputJSON(['status' => $result, 'markup' => $html, 'msg' => $msg ]);
	}
}

?>