<?php
error_reporting(0);
class BankController implements IController {
	public function indexAction() {
		$fc = FrontController::getInstance();
		$model = new UPFileModel;

		$output = $model->render(BANK_MAIN_FILE);
		$fc->setBody($output);
	}

}

