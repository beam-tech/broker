<?php
	class UserController implements IController{
		protected $_userData;
		function __construct(){
			if(!Session::exists('user')) {
				header('Location: /404/');
			}else{
				$data = Session::get('user');
				$this->_userData['login'] = $data['login'];
				$id = $this->_userData['id'] = $data['id'];
				$this->_userData['point'] = GameDB::getInstance()->getUserPoint($id);
				$this->_userData['events'] = GameDB::getInstance()->getUserEvent($id);
			}
		}
		/* По умолчанию страница пользоателя */
		public function indexAction(){
			$fc = FrontController::getInstance();
			$model = new UPFileModel;
			$userDb = GameDB::getInstance();
			/* Ощищаем данные о кол-ве компаний*/
			$userDb->CleanUserComp();
			/* Формируем данные*/
			$model->data['main'] = $this->_userData;
			$model->data['events'] = $this->_userData['events'];

			$model->data['node']['login'] = $this->_userData['login'];
			$id = $this->_userData['id'];
			$model->data['node']['info'] = $userDb->getUserInfo($id);

			if(empty($model->data['node']['info']['companies'])){
				$model->errors['err_msg'] = "Компании и акций пока отсутствуют";
			}
//----->	var_dump($model->data);
			$output = $model->render(USER_PROFILE);
			$fc->setBody($output);
		}

		/**
		 * Выводит топ юзеров
		 */
		public function topAction(){
			$fc = FrontController::getInstance();
			/* Инициализация модели */
			$model = new UPFileModel;

			$model->data['main'] = $this->_userData;
			$model->data['events'] = $this->_userData['events'];

			$userDb = GameDB::getInstance("Top users");
			$model->data['top']= $userDb->getTopUsers();

			$output = $model->render(USER_TOP_FILE);
			$fc->setBody($output);
		}

		/**
		 * Выводит информацию о юзере
		 */
		public function showAction(){
			$fc = FrontController::getInstance();
			$model = new UPFileModel;
			$userDb = GameDB::getInstance();
			$param = $fc->getParams();

			$model->data['main'] = $this->_userData;
			$model->data['events'] = $this->_userData['events'];

			$model->data['node']['login'] = $param['name'];
			$id = $userDb->getUserId($param['name']);
			if(is_null($id)){
				header('Location: /404');
				exit;
			}
			$model->data['node']['info'] = $userDb->getUserInfo($id);
			if(empty($model->data['node']['info']['companies'])){
				$model->data['node']['info']['companies'] = '';
				$model->errors[] = "Компании и акций пока отсутствуют";
			}
			$output = $model->render(USER_PROFILE);
			$fc->setBody($output);
		}

		public function chatAction() {
			$fc = FrontController::getInstance();
			$gdb = GameDB::getInstance();
			$model = new UPFileModel;

			$model->data['main'] = $this->_userData;
			$model->data['events'] = $this->_userData['events'];

			$cdb = GameDB::getInstance();
			
			$data = RequestModel::getPost();
			if(!empty($data)) {
				if(isset($data['show'])){
					$msgs = $cdb->getMsgs();
					die(json_encode($msgs));
				}
				$data['name'] = $this->_userData['login'];
				$cdb->saveMsgs($data);
				//header("Location: ".$_SERVER['REQUEST_URI']);
				//exit;
			}
			//$model->data['user'] = $cdb->getMsgs();

			/*if($model->data['user'] == false){
				$model->errors[] = "Чат пустой";
			}*/
			//var_dump($model->user);
			$output = $model->render(CHAT_FILE);
			$fc->setBody($output);
		}

		public function backpackAction(){
			$fc = FrontController::getInstance();
			/* Инициализация модели */
			$gdb = GameDB::getInstance();
			$model = new UPFileModel;
			$model->done['msgs'] = array();
			$model->errors['msgs'] = '';
			
			$model->data['main'] = $this->_userData;
			$model->data['events'] = $this->_userData['events'];

			$userId = $this->_userData['id'];
			$data = RequestModel::getPost();
			if(isset($data['item_id'])) {
				$login = $data['login'];
				$items = $data['item_id'];
				$EmemyId = $gdb->getUserId($login);
				/* если такой пользователь есть*/
				if($EmemyId != 0){
					$point = new Point($gdb, $EmemyId, $userId);
					$point->change($items);
					$model->done['msgs'] = $point->getSuccess();
				}else{
					$model->errors['msgs'] = "Такого пользователя не существует";
				}
				header("Refresh: 2;url=/user/backpack");
			}
			$model->data['items'] = $gdb->getUserItems($userId);
			if(!empty($model->data['items'])){
				$output = $model->render(BACKPACK_FILE);
				$fc->setBody($output);
			}else{
				$output = $model->render(EMPTY_BACKPACK_FILE);
				$fc->setBody($output);
			}
			
		}
		/**
		 * Выводит топ юзеров
		 */
		public function allAction(){
			$fc = FrontController::getInstance();
			/* Инициализация модели */
			$model = new UPFileModel;

			$model->data['main'] = $this->_userData;
			$model->data['events'] = $this->_userData['events'];

			$model->data['users'] = GameDB::getInstance()->getAllUsers();

			$output = $model->render(ALL_USERS);
			$fc->setBody($output);
		}

		/**
		 * Выводит топ юзеров
		 */
		public function FeedbackAction(){
			$fc = FrontController::getInstance();
			/* Инициализация модели */
			$model = new UPFileModel;

			$model->data['main'] = $this->_userData;
			$model->data['events'] = $this->_userData['events'];
			$data = RequestModel::getPost();
			if(!empty($data)) {
				$msg = $data['message'];
				if($msg != ''){
					GameDB::getInstance()->saveFeedback($msg);
					header("Location: /user/feedback");
				}
			}
			$model->data['fed_msg'] = GameDB::getInstance()->getFeedbackMsgs();
			$output = $model->render(FEEDBACK_FILE);
			$fc->setBody($output);
		}

		public function exitAction() {
			Session::destroy('user');
			header("Location: /");
		}

	}
