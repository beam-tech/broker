<?php
	class IndexController implements IController {
		function __construct(){
		if(Session::exists('user')) 
			header('Location: /user');
		if(Session::exists('admin')) 
			header('Location: /admin');
	}

	public function indexAction() {
		/* Инициализация контроллера*/
		$fc = FrontController::getInstance();
		/* Инициализация класса для вывода*/
		$model = new MPFileModel;
		/* Забираем данные из POST*/
		$data = RequestModel::getPost();
		if(!empty($data)) {
			/* Инициализация класса для взаимодействия с БД*/
			$gdb = GameDB::getInstance();
			
			/* Если авторизация*/
			if($data['mov'] == 'auth'){
				$user = new UserModel($gdb, $data);
				/* Если юзер может авторизоваться*/
				if($user->Authorized()){
					/* формируем массив из данных пользователя*/
					$userInfo = $user->getData();
					/* Заводим сессию*/
					Session::set($userInfo['role'], $userInfo);
					/* Перенаправляем*/
					$result = array('res'=>true, 'msg'=>"Вы авторизованы!");
					die(json_encode($result));
					//$user->Redirect();
				}else{
					$err = $user->getErrors();
					$result = array('res'=>false, 'msg'=>$err[0]);
					die(json_encode($result));
				}
			/* Если регистрация*/
			}elseif ($data['mov'] == 'reg') {
				$user = new UserModel($gdb, $data);
				/* если юзер может зарегистрироваться*/
				if($user->Registered()){
					/* создаем его*/
					$user->createPlayer();
					$result = array('res'=>true, 'msg'=>"Вы зарегистрированы!");
					die(json_encode($result));
				}else{
					$err= $user->getErrors();
					$result = array('res'=>false, 'msg'=>$err[0]);
					die(json_encode($result));
				}
			/* Если забыл пароль*/
			}

		}
		$output = $model->render(LOGIN_FILE);
		$fc->setBody($output);
	}
	public function retrieveAction() {
		/* Инициализация контроллера*/
		$fc = FrontController::getInstance();
		/* Инициализация класса для вывода*/
		$model = new MPFileModel;
		/* Забираем данные из POST*/
		$data = RequestModel::getPost();
		if(!empty($data)) {
			if($data['mov'] == 'retrieve') {
				$email = $data['email'];
				$emEx = GameDB::getInstance()->emailExists($email);
				/* если email нету*/
				if(!$emEx) {
					$result = array('res'=>false, 'msg'=>'Нет такого email');
				}else{
					//UserModel::sendMail($email);
					$result = array('res'=>true, 'msg'=>'Оправлено');
				}
				die(json_encode($result));
			}
		}
		$output = $model->render(RETRIEVE_FILE);
		$fc->setBody($output);
	}


}
