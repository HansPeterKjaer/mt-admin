<?php 

class settingController extends SecureController{
	protected function indexAction(){
		$viewModel = $this->modelFactory->buildObject('BaseViewModel');
		$viewModelMapper = $this->modelFactory->buildMapper('BaseViewModelMapper');
		$viewModelMapper->init($viewModel);
		
		$viewModel->currentMenuItem = 'settings';

		$this->view->output('/setting/index', $viewModel);
	}
	protected function fetchDBDumpAction(){
		$mapper = $this->modelFactory->buildMapper('SettingMapper');
		$result = $mapper->fetchDBDump();
		$this->view->outputFile($result['dump'], 'dbdump.sql');
	}
}

?>
