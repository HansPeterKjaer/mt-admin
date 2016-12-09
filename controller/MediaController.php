<?php 

class MediaController extends SecureController{
	private $uploadPath = SITEROOT . "/mtassets/exercise-images";

	protected function indexAction(){
		$viewModel = $this->modelFactory->buildObject('MediaListViewModel');
   		$mapper = $this->modelFactory->buildMapper('BaseViewModelMapper');
   		$mapper->fetch($viewModel);

   		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');
		$mapper->search($viewModel->MediaItems, '');

		$viewModel->currentMenuItem = 'media';

		$this->view->output('/media/index', $viewModel);
	}
	
	public function insertImageJSONAction($controls = false, $image, $thumb){
		$resultData = [];
		$imageName = basename($image['name']);
		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');
		$id = $mapper->addImage($imageName);

		if($id){
			$t_resultData = $this->uploadImage($thumb, $imageName, 's/');
			$resultData = $this->uploadImage($image, $imageName);

			if($resultData['status'] == true){
				$mediaModel = $this->modelFactory->buildObject('MediaModel');
				$model = $this->modelFactory->buildObject('MediaListModel');
				$mediaModel->id = $id;
				$mediaModel->imageName = $resultData['data']['imageName'];
				$model->items = [$mediaModel];
				$model->controls = ($controls === 'true') ? true : false;

				ob_start();
					$this->view->output('/media/_imageResults', $model , false);			 
				$resultData['markup'] = ob_get_clean(); 
			}
			else{
				$mapper->deleteImage($id);
			}	
		}
		else{
			$msg = "Billedet kunne ikke tilføjes til databasen. Billedet findes allerede i databasen";
			$resultData = ['status' => false, 'data' => [], 'msg'=> $msg];
		}

		$this->view->outputJSON($resultData);
	}

	public function getImageJSONAction($imageName, $controls = false){
		$mediaModel = $this->modelFactory->buildObject('MediaListModel');
		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');
		$result = $mapper->fetchByImageName($mediaModel, $imageName);
		$html = "";
		$msg = "";
		$id = null;
		$mediaModel->controls = $controls;

		if($result && (count($mediaModel->items) == 1)){
			$msg = "Success";
			$id = $mediaModel->items[0]->id;
			ob_start();
				$this->view->output('/media/_imageResults', $mediaModel, false);			 
			$html = ob_get_clean();	
		}
		else if($result){
			$msg = "Image Doesn't exist";
			$result = false;
		}
		else{
			$msg = "A database error occured";
		}			

		$this->view->outputJSON(['status' => $result, 'id' => $id, 'markup' => $html, 'msg' => $msg]);
	}

	public function imagePanelJsonAction($term, $firstLetter, $page, $sort = null){
		$mediaModel = $this->modelFactory->buildObject('MediaListModel');
		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');
		$mapper->search($mediaModel, $term, $firstLetter, $page, $sort);
		
		ob_start();
		$this->view->output('/media/_imageResults', $mediaModel, false);			 
		$html = ob_get_clean();

		$this->view->outputJSON(['html' => $html, 'pages' => $mediaModel->totalPages]);
	}

	public function searchImageJsonAction($term, $firstLetter){
		$mediaModel = $this->modelFactory->buildObject('MediaListModel');
		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');
		$mapper->search($mediaModel, $term, $firstLetter, 0);
		/*$imageArray = [];
		foreach ($mediaModel->items as $item){
			$imageArray[$item->imageName] = $item->id;
		}
		ksort($imageArray);*/
		$this->view->outputJSON($mediaModel->items);
	}

	public function displayImageAction($id){
		$viewModel = $this->modelFactory->buildObject('MediaViewModel');
   		$mapper = $this->modelFactory->buildMapper('BaseViewModelMapper');
   		$mapper->fetch($viewModel);

   		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');
		//$viewModel->mediaItem = 
		$status = $mapper->fetchImage($viewModel->MediaItem, $id);
   		
   		if($status == false){
   			$controller = new ErrorController($this->modelFactory, $this->auth);
			$controller->action("PageDoesNotExistAction", []);	
   			exit(); // todo: should not be necessary
   		}

   		$viewModel->currentMenuItem = 'media';

   		$this->view->output('/media/image', $viewModel);	
	}

	public function deleteImageAction($id){
		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');

		$status = $mapper->deleteImage($id);
		if($status['status'] == true){
			@unlink("{$this->uploadPath}/{$status['imageName']}");
			@unlink("{$this->uploadPath}/thumbs/{$status['imageName']}");
			$status['msg'] = 'Billedet er nu slettet';
		}
		else if ($status['exercises'] != null){
			$status['msg'] = "Billedet er tilknyttet en eller flere øvelser. Billedet kan derfor ikke slettes!";
		}
		else {
			$status['msg'] = "Der er opstået en fejl. Prøv igen senere.";	
		}
		$this->view->outputJSON($status);
	}

	public function updateImageAction($id, $image){
		$model = $this->modelFactory->buildObject('MediaModel');
		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');
		$result = $mapper->fetchImage($model, $id);
		$status = "";
		$imageName = $model->imageName;

		if ($result){
			@unlink("{$this->uploadPath}/$imageName");
			$moveStatus = move_uploaded_file($image['tmp_name'], "{$this->uploadPath}/$imageName");
			$status = ['status' => $moveStatus, 'msg'=> ($moveStatus) ? "Image sucessfully updated" : "Could not move image on server"];
		}
		else{
			$status = ['status' => false , 'msg'=> "Image doesn't exist"];	
		}
		
		$this->view->outputJSON($status);
	}
	
	public function updateImageNameAction($id, $imageName){
		// todo: check mimetype/ file ending! there is a potential risk to save images with wrong extension.
		$mapper = $this->modelFactory->buildMapper('MediaModelMapper');

		$model = $this->modelFactory->buildObject('MediaModel');
		$mapper->fetchImage($model, $id);

		if (file_exists("{$this->uploadPath}/{$model->imageName}")){
			$status = $mapper->renameImage($id, $imageName);
			if ($status['status'] == true){
				rename("{$this->uploadPath}/{$model->imageName}", "{$this->uploadPath}/$imageName");	
			}
			$this->view->outputJSON($status);
		}
		else{
			$this->view->outputJSON(['status' => false, 'msg'=> 'Image does not exist on server!']);
		}
	}

	private function uploadImage($image, $imageName, $subPath = ''){
		$targetDir = "{$this->uploadPath}/" . $subPath;

		$targetFile = $targetDir . $imageName;
		$uploadStatus = false;
		$msg = '';
		$imageFileType = pathinfo($targetFile,PATHINFO_EXTENSION);
		
		// upload main image:
		if(empty($image['tmp_name'])){
			$msg = 'no imagefile provided';
		}
		else if (getimagesize($image['tmp_name']) == false){
			$msg = 'File is not an image.';
		}
		else{
    		if (move_uploaded_file($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $targetFile)){
    			$uploadStatus = true;
    			$msg = "'$imageName' er nu uploadet. Id: $id ";
    		}
	        else{
	        	$msg = 'File could not be moved on server';
	        }	
		}

	    return ['status' => $uploadStatus, 'data' => ['imageName' => $imageName], 'msg'=> $msg];
	}
}

?>