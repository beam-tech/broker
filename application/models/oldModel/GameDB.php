<?php
/**
 * Be careful Singleton!
 */
class GameDB {
	/**
	 * @var array $option - доп. опции для PDO
	 * @var const string CONF_FILE - имя конфигурационного файла
	 * @var string $params - параметры конфигурационного файла ['dsn'-соединение к MySQL БД , 'user'-имя пользователя, 'pass'- пароль пользователя]
	 * @var object $_db - здесь будет хранить объект 'GameDB'
	 * @var object $_instance - инстанс объекта 'GameDB'
	 * 
	 */
	protected $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
	const CONF_FILE = 'conf/config.ini';
	protected $params;
	protected $_db;
	protected static $_instance = null;

	protected function __construct(){
		try{
			if(!is_file(self::CONF_FILE))
				throw new Exception("Не могу найти файл конфигурации ".self::CONF_FILE);	
			$this->params = parse_ini_file(self::CONF_FILE);
			$this->_db = new PDO($this->params['dsn'], $this->params['user'], $this->params['pass'], $this->options);
			$this->_db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		}catch(Exception $e){
			die($e->getMessage());
		}catch(PDOException $e){
			die($e->getMessage());
		}
 	}

	protected function __clone(){}
 	
 	/**
 	 * Возвращает инстанс 'GameDB'
 	 */
	public static function getInstance(){
		if(!self::$_instance instanceof self)
			self::$_instance = new self;
		return self::$_instance;
	}

	function __destruct(){
 		unset($this->_db);
 	}

 	public function getConfFile(){
		return $this->confFile;
	}
	public function setConfFile($file){
 		return $this->confFile = $file;
 	}

 	/**
	 * создает таблицу users.
	 */
 	protected function createUsersTable(){
		try {
			$sql ="CREATE TABLE `users` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`login` varchar(11) NOT NULL DEFAULT '',
						`password` varchar(40) NOT NULL DEFAULT '',
						`salt` varchar(40) NOT NULL DEFAULT '',
						`role` varchar(5) NOT NULL DEFAULT '',
						`email` varchar(20) NOT NULL DEFAULT '',
						`health` int(3) NOT NULL DEFAULT 100,
						`cash` int(9) NOT NULL DEFAULT 10000,
						`condition` int(2) NOT NULL DEFAULT 0,
						`action` int(2) NOT NULL DEFAULT 0,
						PRIMARY KEY (`id`)
					)ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			$db->exec($sql);
		} catch(PDOException $e) {
			echo $e->getMessage();//Remove or change message in production code
		}
	}


 	/**
	 * возвращает пароль юзера
	 * @param string $name - имя юзера
	 * 
	 * @return string - пароль
	 */
 	public function getUserPassword($name){
		try{
			$name =$this->_db->quote($name);
			$sql = "SELECT `password`
						FROM `users` WHERE `login` = $name";
			$stmt = $this->_db->query($sql);
			$pass = $stmt->fetch(PDO::FETCH_ASSOC);
			return $pass['password'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * возвращает соль юзера
	 * @param string $name - имя юзера
	 * 
	 * @return string - соль
	 */
	public function getUserSalt($name){
		try{
			$name =$this->_db->quote($name);
			$sql = "SELECT `salt`
						FROM `users` WHERE `login` = $name";
			$stmt = $this->_db->query($sql);
			$salt = $stmt->fetch(PDO::FETCH_ASSOC);
			return $salt['salt'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * возвращает роль юзера
	 * @param string $name - имя юзера
	 * 
	 * @return string - роль
	 */
	public function getUserRole($name){
		try{
			$name =$this->_db->quote($name);
			$sql = "SELECT `role`
						FROM `users` WHERE `login` = $name";
			$stmt = $this->_db->query($sql);
			$role = $stmt->fetch(PDO::FETCH_ASSOC);
			return $role['role'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * возвращает id юзера
	 * @param string $name - имя юзера
	 * 
	 * @return string - роль
	 */
	public function getUserId($name){
		try{
			$name =$this->_db->quote($name);
			$sql = "SELECT `id`
						FROM `users` WHERE `login` = $name";
			$stmt = $this->_db->query($sql);
			$id = $stmt->fetch(PDO::FETCH_ASSOC);
			return $id['id'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * возвращает name юзера по id
	 * @param int $id - id юзера
	 * 
	 * @return string - имя
	 */
	public function getUserLogin($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `login`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			$login = $stmt->fetch(PDO::FETCH_ASSOC);
			return $login['login'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * возвращает email юзера по id
	 * @param int $id - id юзера
	 * 
	 * @return string - email
	 */
	public function getUserEmail($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `email`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			$email = $stmt->fetch(PDO::FETCH_ASSOC);
			return $email['email'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}


	/**
	 * возвращает email, health, cash
	 * @param string $name - имя юзера
	 * 
	 * @return array - массив вида ['role'=>'...', 'password'=>'...', 'salt=>'...'];
	 */
	public function getUserInfo($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `email`,`health`, `cash`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}


	public function getUserData($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `login`,`password`, `role`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}


	/**
	 * возвращает роль, пароль, соль юзера
	 * @param string $name - имя юзера
	 * 
	 * @return array - массив вида ['role'=>'...', 'password'=>'...', 'salt=>'...'];
	 */
	public function getUserRolePasswordSalt($name){
		try{
			$name =$this->_db->quote($name);
			$sql = "SELECT `role`,`password`, `salt`
						FROM `users` WHERE `login` = $name";
			$stmt = $this->_db->query($sql);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * Возвращает email юзера по id
	 * @param int $email - email юзера
	 * 
	 * @return string - email
	 */
	public function getUserIdByEmail($email){
		try{
			$email =$this->_db->quote($email);
			$sql = "SELECT `id`
						FROM `users` WHERE `email` = $email";
			$stmt = $this->_db->query($sql);
			$id = $stmt->fetch(PDO::FETCH_ASSOC);
			return $id['id'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	/**
	 * Возвращает login юзера по id
	 * @param int $login - login юзера
	 * 
	 * @return string - login
	 */
	public function getUserIdByLogin($login){
		try{
			$login =$this->_db->quote($login);
			$sql = "SELECT `id`
						FROM `users` WHERE `login` = $login";
			$stmt = $this->_db->query($sql);
			$id = $stmt->fetch(PDO::FETCH_ASSOC);
			return $id['id'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	/**
	 * Создает нового юзера
	 * @param  array $data - массив с данными вида
	 *					['login'=>'vasya']
	 *					['password'=>'sadvj98u0']
	 *					['email'=>'vasya@pupkin.ru']
	 */
	public function createUser(array $data){
		try{
			if(empty($data))
				throw new Exception("Засада, данные не пришли!");
			$sql = "INSERT INTO `users` (login, password, salt, role, email)
								VALUES (:login, :password, :salt, :role, :email);";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':login', $data['login'], PDO::PARAM_STR, 11);
			$stmt -> bindParam(':password', $data['password'], PDO::PARAM_STR, 40);
			$stmt -> bindParam(':salt', $data['salt'], PDO::PARAM_STR, 40);
			$stmt -> bindParam(':role', $data['role'], PDO::PARAM_STR, 5);
			$stmt -> bindParam(':email', $data['email'], PDO::PARAM_STR, 20);
			$stmt -> execute($data);
		}catch(PDOException $e){
			die($e->getMessage());
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

	function getTopUsers($offset=0,$rows=10){
		try{
			$sql = "SELECT `cash`, `login`
						FROM `users` ORDER BY `cash` DESC LIMIT {$offset},{$rows}";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}

	/**
	 * Возвращает информацию о кол-во акций определенного пользователя,
	 * а также имя этой компании в виде массива.
	 * 	
	 * @param $id - идентификатор пользователя
	 *
	 * @return array $result - массив ['shareCnt'=>'кол-во акций', 'company'=>'имя компаний']
	 */
	function getShareInfo($id){
		try{
			$id = $this->_db->quote($id);
			$sql = "SELECT uc.share_cnt as shareCnt, c.name as company
						FROM user_company uc, company c
						WHERE user_id = $id AND c.id = uc.company_id";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}
}