<?php

class AdminProtocolController extends SecureController{
	public function displayAllAction(){
		$viewModel = $this->modelFactory->buildObject('ProtocolListViewModel');
		$viewModelMapper = $this->modelFactory->buildMapper('BaseViewModelMapper');
		$viewModelMapper->init($viewModel);

		$protocolListModel = $this->modelFactory->buildObject('ProtocolListModel');
		$protocolModelMapper = $this->modelFactory->buildMapper('ProtocolModelMapper');
    	$protocolModelMapper->search($protocolListModel, 10, 1);

    	$viewModel->protocols = $protocolListModel;

    	$viewModel->currentMenuItem = 'protocols';

		$this->view->output("protocol/index", $viewModel);
	}
	public function protocolListPanelAction($page, $term, $filter, $sort){
		$protocolListModel = $this->modelFactory->buildObject('ProtocolListModel');
		$protocolModelMapper = $this->modelFactory->buildMapper('ProtocolModelMapper');
    	$protocolModelMapper->search($protocolListModel, 10, $page, $term, $filter, $sort);

    	ob_start();
			$this->view->output('/protocol/_protocolList', $protocolListModel, false);			 
		$html = ob_get_clean();

		$this->view->outputJSON(['html' => $html, 'pages' => $protocolListModel->totalPages]);
	}

	public function displayAction($pr_id){
		$viewModel = $this->modelFactory->buildObject('ProtocolViewModel');
		$mapper = $this->modelFactory->buildMapper('ProtocolViewModelMapper');
		$mapper->fetchById($viewModel, $pr_id);

		$viewModel->currentMenuItem = 'protocols';

		$this->view->output("protocol/single", $viewModel);
	}

	public function createAction(){
		$viewModel = $this->modelFactory->buildObject('BaseViewModel');
		$viewModelMapper = $this->modelFactory->buildMapper('BaseViewModelMapper');
		$viewModelMapper->init($viewModel);

		$viewModel->currentMenuItem = 'protocols';

		$this->view->output("protocol/create", $viewModel);
	}

	public function insertAction($name, $descr){	
		$mapper = $this->modelFactory->buildMapper('ProtocolModelMapper');
		$model = new ProtocolModel();
		$model->name = $name;
		$model->descr = $descr;
			
		if(empty($name)){
			$this->view->outputJSON(array('msg'=>'Dette felt skal udfyldes', 'status'=>false, 'input'=>'#inputTitle'));
			return;
		}
		if(empty($descr)){
			$this->view->outputJSON(array('msg'=>'Dette felt skal udfyldes', 'status'=>false, 'input'=>'#inputDescr'));
			return;
		}
		
		$this->view->outputJSON($mapper->insert($model));
		return;
	}

	public function updateAction($name, $descr, $id){	
		$mapper = $this->modelFactory->buildMapper('ProtocolModelMapper');
		$model = new ProtocolModel();
		$model->name = $name;
		$model->descr = $descr;
		$model->id = $id;

		if($mapper->update($model) && !empty($name) && !empty($descr)){
			//$this->displayAction($model->id);
			header('Location: ' . URLHelper::getBasePath() . '/AdminProtocol/Display/' . $model->id);
		}
		else{
			$errorMsg = "";
			if(empty($name)) $errorMsg .= "&name=Dette felt må ikke være tomt!";
			if(empty($descr)) $errorMsg .= "&descr=Dette felt må ikke være tomt!";
			if($errorMsg == "") $errorMsg .= "&errormsg=Der er sket en fejl ved opdatering af databasen!";
			header('Location: ' . URLHelper::getBasePath() . '/AdminProtocol/Display/' . $model->id . '?status=error' . $errorMsg);
		}
	}

	public function deleteAction($id){
		$mapper = $this->modelFactory->buildMapper('ProtocolModelMapper');
		$status = $mapper->delete($id);
		$this->view->outputJSON(array('success'=>$status));
	}
}

?>