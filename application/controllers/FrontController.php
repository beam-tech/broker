<?php
class FrontController {
	protected $_controller, $_action, $_params, $_body;
	static $_instance;

	public static function getInstance() {
		if(!(self::$_instance instanceof self)) 
			self::$_instance = new self();
		return self::$_instance;
	}
	private function __construct(){
		$request = $_SERVER['REQUEST_URI'];
		//var_dump($request);
		$splits = explode('/', trim($request,'/'));
		//array_shift($splits);
		//
		//$this->_controller = !empty($splits[0]) ? ucfirst($splits[0]).'Controller' : 'IndexController';
		//if($this->_controller == '404Controller')
			//$this->_controller = 'DefaultController';
		switch ($splits[0]) {
			case 'user':
				$this->_controller = 'UserController';
				break;
			case 'area':
				$this->_controller = 'AreaController';
				break;
			case '':
				$this->_controller = 'IndexController';
				break;
			case 'index':
				$this->_controller = 'IndexController';
				break;
			default:
				$this->_controller = 'DefaultController';
				break;
		}
		$this->_action = !empty($splits[1]) ? $splits[1].'Action' : 'indexAction';
		//

		if(!empty($splits[2])){

			if(count($splits) > 4){
				header('Location: /404');
				exit;
			}
			if($splits[3] == ''){
				header('Location: /404');
				exit;
			}
			if($splits[2] != 'name'){
				header('Location: /404');
				exit;
			}
			$res =  array();
			$res[$splits[2]] = $splits[3];
			$this->_params = $res;
		}
	}
	/**
	 */
	public function route() {
		if(class_exists($this->getController())) {
			$rc = new ReflectionClass($this->getController());
			if($rc->implementsInterface('IController')) {
				if($rc->hasMethod($this->getAction())) {
					$controller = $rc->newInstance();
					$method = $rc->getMethod($this->getAction());
					$method->invoke($controller);
				} else {
					header('Location: /404');
					exit;
				}
			} else {
				echo "Ошибка  Interface";
			}
		} else {
			echo "Ошибка Controller";
		}
	}
	

	public function getParams() {
		return $this->_params;
	}

	public function getController() {
		return $this->_controller;
	}
	public function getAction() {
		return $this->_action;
	}
	public function getBody() {
		return $this->_body;
	}
	public function setBody($body) {
		$this->_body = $body;
	}
}	