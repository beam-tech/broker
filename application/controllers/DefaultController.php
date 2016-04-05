<?php
class DefaultController implements IController {
	public function indexAction() {
		$fc = FrontController::getInstance();
		$model = new MPFileModel();
		$model->name = "404";
		$output = $model->render(DEFAULT_FILE);
		$fc->setBody($output);
	}
}