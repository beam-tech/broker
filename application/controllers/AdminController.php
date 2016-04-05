<?php
/**
 * Контроллер админки.
 */
class AdminController implements IController {
	function __construct(){
		if(!Cookie::exist('admin')) {
			header('Location: /404/');
		}
		//$data= unserialize(Cookie::get('admin'));
		//var_dump($data);
		
	}
	/**
	 * Экшен по умолчанию. Простой вывод данных.
	 */
	public function indexAction() {
		/* Инициализация front-контроллера */
		$fc = FrontController::getInstance();

		/* Инициализация модели для формирования данных для вывода */
		$model = new FileModel();
		$model->name = "Страница админа";

		/* Забираем файл с данными и передаем на вывод */
		$output = $model->render(ADMIN_MAIN_FILE);
		$fc->setBody($output);	
	}

	/**
	 * Экшен для заполнения БД событиями.
	 */
	public function addEventAction() {
		$fc = FrontController::getInstance();
		$model = new FileModel();
		$model->name = "Добавить событие";

		/* Забираем данные из POST */
		$data = RequestModel::getPost();
		if(!empty($data)){
			/* Инициализация модели для взаимодействия с БД */
			$edb = GameDB::getInstance();
			/* Сохраняем данные */
			$edb->saveEvent($data);
			$model->done[] = "Событие добавлено";
		}
		$output = $model->render(ADMIN_ADD_EVENT_FILE);
		$fc->setBody($output);
	}

	/**
	 * Экшен для удаления из БД событий.
	 */
	public function deleteEventAction() {
		$fc = FrontController::getInstance();
		$model = new FileModel();
		$model->name = "Удалить событие";
		$edb = GameDB::getInstance();
		$ids = RequestModel::getPost();
		if(!empty($ids)){
			/* Удаляем данные по id */
			$cnt = $edb->deleteEvents($ids);
			$model->done[] = "Удалено $cnt собитий(я)";
		}
		/* Получить события */
		$model->data = $edb->getEvents();
		if(empty($model->data)){
			$model->errors[] = "нет событий";
		}
		$output = $model->render(ADMIN_DELETE_EVENT_FILE);
		$fc->setBody($output);
	}

/*	public function addCompanyAction() {
		$fc = FrontController::getInstance();
		$model = new FileModel();
		$model->name = "Добавить компании";

		$output = $model->render(ADMIN_MESSAGES_FILE);
		$fc->setBody($output);
	}*/

	/**
	 * Экшен для сообщений.
	 */
	public function messagesAction() {
		$fc = FrontController::getInstance();
		$model = new FileModel();
		$model->name = "Сообщения";
		$output = $model->render(ADMIN_MESSAGES_FILE);
		$fc->setBody($output);
	}

	/**
	 * Экшен для удаления cookie-админа.
	 */
	public function exitAction() {
		if(Cookie::exist('admin')){
			Cookie::del('admin') ;
			header("Location: /");
		}
	}
}