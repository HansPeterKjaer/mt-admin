<?php

class AdminHomeController extends SecureController {
	public function indexAction(){
		$viewmodel = $this->modelFactory->buildObject('AdminFrontpageViewModel');
		$mapper = $this->modelFactory->buildMapper('AdminFrontpageViewModelMapper');
		$mapper->fetch($viewmodel);

		#$viewmodel->load();
		$this->view->output("indexView",$viewmodel);
	}	
}

?>