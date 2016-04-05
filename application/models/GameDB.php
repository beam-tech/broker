<?php
/**
 * Be careful Singleton!
 * Основной класс для взаимодействия с БД игры. 
 */
class GameDB {
	/**
	 * @var array $option - доп. опции для PDO
	 * @var const string CONF_FILE - имя конфигурационного файла
	 * @var string $params - параметры конфигурационного файла ['dsn'-соединение к MySQL БД , 'user'-имя пользователя, 'pass'- пароль пользователя]
	 * @var object $_db - здесь будет храниться объект 'GameDB'
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

########################### Методы для работы с таблицей 'users'###########################
	/**
	 * возвращает id юзера по логину
	 * @param string $login - имя юзера
	 * 
	 * @return string - роль
	 */
	public function getUserId($login){
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
	 */
	public function getUserLogin($id){
		try{
			$id = abs((int)$id);
			$sql = "SELECT `login`
						FROM `users` WHERE `id` = ".$this->_db->quote($id);
			$stmt = $this->_db->query($sql);
			$login = $stmt->fetch(PDO::FETCH_ASSOC);
			return $login['login'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * возвращает role юзера по id
	 * @param int $id - имя юзера
	 * 
	 * @return string - роль
	 */
	public function getUserRole($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `role`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			$role = $stmt->fetch(PDO::FETCH_ASSOC);
			return $role['role'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * возвращает role юзера по id
	 * @param int $id - имя юзера
	 * 
	 * @return string - роль
	 */
	public function getUserDate($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `datetime`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			$dt = $stmt->fetch(PDO::FETCH_ASSOC);
			return $dt['datetime'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * возвращает role юзера по id
	 * @param int $id - имя юзера
	 * 
	 * @return string - роль
	 */
	public function getUserStatus($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `status`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			$st = $stmt->fetch(PDO::FETCH_ASSOC);
			return $st['status'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * возвращает email 
	 * @return string - email
	 */
	public function getEmail($email){
		try{
			$sql = "SELECT *
						FROM `users` WHERE `email` =".$this->_db->quote($email);
			$stmt = $this->_db->query($sql);
			$email = $stmt->fetch(PDO::FETCH_ASSOC);
			return $email['email'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * возвращает cash юзера по id
	 * @param int $id - имя юзера
	 * 
	 * @return int - кол-во денежных единиц.
	 */
	public function getUserCash($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `cash`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			$cash = $stmt->fetch(PDO::FETCH_ASSOC);
			return (float)$cash['cash'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * возвращает password, salt, cash
	 * @param string $id - id юзера
	 * 
	 * @return array - массив вида [ 'password'=>'...', 'salt=>'...'];
	 */
	public function getUserPassSalt($id){
		try{
			$id =$this->_db->quote($id);
			$sql = "SELECT `password`, `salt`
						FROM `users` WHERE `id` = $id";
			$stmt = $this->_db->query($sql);
			return $stmt->fetch(PDO::FETCH_ASSOC);
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
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}catch(Exception $e){
			die($e->__toString());
		}
	}

	/**
	 * Возвращает логины топ пользователей по cash.
	 *
	 * @param int $offset - текущая запись.
	 * @param int $rows - кол-во записей.
	 */
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
			die($e->getMessage());
		}
	}

	/**
	 * 
	 * @param int $id - id пользователя.
	 * @param int $cash - кол-во денежных единиц.
	 */
	public function changeUserCash($id, $cash){
		try{
			$sql = "UPDATE `users`
						SET `cash` = :cash WHERE `id` = :id;";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':id', $id, PDO::PARAM_INT, 11);
			$stmt -> bindParam(':cash', $cash, PDO::PARAM_INT, 11);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * 
	 * @param int $id - id пользователя.
	 * @param int $healtg - кол-во жизней.
	 */
	public function changeUserHealth($id, $health){
		try{
			$sql = "UPDATE `users`
						SET `health` = :health WHERE `id` = :id;";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':id', $id, PDO::PARAM_INT, 11);
			$stmt -> bindParam(':health', $health, PDO::PARAM_INT, 11);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * возвращает point
	 */
	public function getUserPoint($id){
		try{
			$sql = "SELECT health, cash
						FROM users WHERE id = ".$this->_db->quote(abs((int)$id));
			//var_dump(expression)
			$stmt = $this->_db->query($sql);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$result['health'] = (int) $result['health'];
			$result['cash'] = (float) $result['cash'];
			return $result;
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Возвращает все пользователей.
	 */
	function getAllUsers(){
		try{
			$sql = "SELECT `cash`, `login`
						FROM `users` ORDER BY `cash` DESC";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	/**
	 * возвращает true, если email есть, иначе false. 
	 * @return string - email
	 */
	public function emailExists($email){
		try{
			$sql = "SELECT id FROM `users` WHERE email = :em";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':em', $email, PDO::PARAM_STR, 128);
			$stmt -> execute(array(':em' => $email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!$row){
				return false;
			}else{
				return true;
			}
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
########################### Методы для работы с таблицей 'msgs'############################
	/**
 	 * Сохраняет в БД имя пользователя и оправленное им сообщение.
 	 * @param array $data - массив вида ['msg'=>'здесь сообщение', 'name'=>'имя пользователя']
 	 *
 	 */
	public function saveMsgs(array $data){
		try{
			if(empty($data))
				throw new Exception("Засада, данные не пришли!");
			$sql = "INSERT INTO `msgs` (name, msg)
								VALUES (:name, :msg);";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':msg', $data['msg'], PDO::PARAM_STR, 40);
			$stmt -> bindParam(':name', $data['name'], PDO::PARAM_STR, 11);
			$stmt -> execute($data);
		}catch(PDOException $e){
			die($e->__toString());
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

	/**
 	 * Производит выборку из БД:
 	 * 		- имя 
 	 *		- сообщение
 	 *		- время
	 *
 	 * @return array - массив тиз имени, сообщение и времени отправки.
 	 */
	function getMsgs($offset=0,$rows=10){
		try{
			$sql = "SELECT name, msg, UNIX_TIMESTAMP(datetime) as dt
						FROM msgs ORDER BY id DESC LIMIT {$offset},{$rows}";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if (isset($row['dt'])){
					$row['dt'] = (string)date('d-m-Y H:i:s', $row['dt']);
				}
				$result[] = $row;
			}
			return !empty($result)? $result : false;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}
#--------------------- Методы для работы с таблицей '_events'--------------------------
	/**
 	 * Сохраняет в БД событие.
 	 * @param array $data - массив из элементов события.
 	 */
	public function _saveEvent(array $data){
		try{
			//var_dump($data);
			if(empty($data))
				throw new Exception("Засада, данные не пришли!");
			$sql = "INSERT INTO `events` (name, kind, effect, cash, health, action, msg)
								VALUES (:name, :kind, :effect, :cash, :health, :action, :msg);";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':name', $data['name'], PDO::PARAM_STR, 25);
			$stmt -> bindParam(':kind', $data['kind'], PDO::PARAM_STR, 25);
			$stmt -> bindParam(':effect', $data['effect'], PDO::PARAM_STR, 25);
			$stmt -> bindParam(':cash', $data['name'], PDO::PARAM_INT, 25);
			$stmt -> bindParam(':health', $data['health'], PDO::PARAM_INT, 25);
			$stmt -> bindParam(':action', $data['action'], PDO::PARAM_INT, 25);
			$stmt -> bindParam(':msg', $data['msg'], PDO::PARAM_STR, 100);
			$stmt -> execute($data);
		}catch(PDOException $e){
			die($e->__toString());
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

	/**
 	 * Производит выборку из БД событий:
 	 * 		- имя 
 	 *		- вид
 	 *		- эффект
 	 *		- ...
	 *
 	 * @return array - массив из элементов события
 	 */
	function _getEvents($offset=0,$rows=10){
		try{
			$sql = "SELECT `id`, `name`, `kind`, `effect`, `cash`, `health`, `action`, `msg` 
						FROM `events` LIMIT {$offset},{$rows}";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}


	/**
 	 * Удаляет из БД событие.
 	 * @param int $id - id события
 	 * 
 	 * @return int $result - кол-во удаленных строк
 	 */
	public function deleteEvent($id){
		try{
			//var_dump($id);
			$id = $this->_db->quote($id);
			$sql = "DELETE FROM `events` 
							WHERE `id`=$id";
			$result = $this->_db->exec($sql) or $this->_db->errorCode();
			return $result;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
 	 * Удаляет в БД события.
 	 * @param array $arr - массив из id событий
 	 *
 	 * @return int $sum - кол-во удаленных строк
 	 */
	public function deleteEvents($arr){
		try{
			$data = $arr['event_id'];
			if(!is_array($data))
				throw new Exception("Ошибка в полученных данных(нужен масиив из id событиq)");
			$sum = 0;
			for ($i=0; $i < sizeof($data); $i++) { 
				$sum += $this->deleteEvent($data[$i]);
			}
			return $sum;
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
########################### Методы для работы с таблицей 'company'#########################
	/**
 	 * Производит выборку из БД(таблица company):
 	 * 		- имя 
 	 *		- дивиденды
 	 *		- кол-во акций
 	 *		- цена акций
	 *
 	 * @return array - массив из имени, сообщение и времени отправки.
 	 */
	function getAllCompany($offset=0,$rows=10){
		try{
			$sql = "SELECT `id`, `name`, `status`, `dividends`, `total_share_cnt`, `share_cnt`, `share_price`, `img`
						FROM `company` LIMIT {$offset},{$rows}";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->__toString());
		}
	}


	/**
 	 * Производит выборку из БД(таблица company):
 	 * 		- имя 
 	 *		- дивиденды
 	 *		- кол-во акций
 	 *		- цена акций
	 *
 	 * @return array - массив тиз имени, сообщение и времени отправки.
 	 */
	function getCompany($id){
		try{
			$id = $this->_db->quote($id);
			$sql = "SELECT `name`, `status`, `dividends`,  `total_share_cnt`, `share_cnt`, `share_price`, `img`
						FROM `company` 
						WHERE id = $id";
			$stmt = $this->_db->query($sql);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $e){
			echo $e->__toString();
			return false;
		}
	}
	/**
	 * Возвращает доступное кол-во акций.
	 * @param int $companyId - id компании.
	 */
	public function getCompShareCnt($companyId){
		try{
			$Cid = $this->_db->quote($companyId);
			$sql = "SELECT share_cnt
							FROM company
							WHERE id = $Cid;";
			$stmt = $this->_db->query($sql);
			$shareCnt = $stmt->fetch(PDO::FETCH_ASSOC);
			if(is_null($shareCnt['share_cnt'])) {
				return 0;
			}
			return (int)$shareCnt['share_cnt'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Возвращает общее кол-во акций.
	 * @param int $companyId - id компании.
	 */
	public function getCompTotalShareCnt($companyId){
		try{
			$companyId = abs((int) $companyId);
			$sql = "SELECT total_share_cnt
							FROM company
							WHERE id = ".$this->_db->quote($companyId);
			$stmt = $this->_db->query($sql);
			$shareTCnt = $stmt->fetch(PDO::FETCH_ASSOC);
			return (int)$shareTCnt['total_share_cnt'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Возвращает стоимость акций.
	 * @param int $companyId - id компании.
	 */
	public function getCompSharePrice($companyId){
		try{
			$Cid = $this->_db->quote($companyId);
			$sql = "SELECT share_price
							FROM company
							WHERE id = $Cid;";
			$stmt = $this->_db->query($sql);
			$sharePrice = $stmt->fetch(PDO::FETCH_ASSOC);
			if(is_null($sharePrice['share_price'])) {
				return 0;
			}
			return (float)$sharePrice['share_price'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Изменяет кол-во акций определенной компании.
	 * @param int $id - id компании
	 * @param int $shareCnt - кол-во акций.
	 */
	public function changeCompShareCnt($id, $shareCnt){
		try{
			$sql = "UPDATE `company`
						SET `share_cnt` = :s_cnt WHERE `id` = :id;";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':id', $id, PDO::PARAM_INT, 11);
			$stmt -> bindParam(':s_cnt', $shareCnt, PDO::PARAM_INT, 11);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}

	/**
	 * Изменяет стоимость акций определенной компании.
	 * @param int $id - id компании
	 * @param int $sharePrice - кол-во акций.
	 */
	public function changeCompSharePrice($id, $sharePrice){
		try{
			$sql = "UPDATE `company`
						SET `share_price` = :s_pr WHERE `id` = :id;";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':id', $id, PDO::PARAM_INT, 11);
			$stmt -> bindParam(':s_pr', $sharePrice, PDO::PARAM_INT, 11);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Возвращает статус компании.
	 * @param int $companyId - id компании.
	 */
	public function getCompStatus($companyId){
		try{
			$companyId = abs((int) $companyId);
			$sql = "SELECT status
							FROM company
							WHERE id =".$this->_db->quote($companyId);
			$stmt = $this->_db->query($sql);
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			return $status['status'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/* Делает компанию банкротом*/
	public function doCompDefaulter($companyId){
		try{
			$companyId = abs((int) $companyId);
			$sql = "UPDATE `company`
						SET `status` = 'defaulter' WHERE `id` = :id";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':id', $companyId, PDO::PARAM_INT, 11);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
########################### Методы для работы с таблицей 'user_company'####################
	/**
	 * возвращает информацию пользователе.
	 * @param string $id - id юзера
	 * 
	 * @return array - массив вида ['shareCnt'=>'...', 'company'=>'...', 'health=>'...'......];
	 */
	public function getUserInfo($id){
		try{
			$result = array();
			$id = $this->_db->quote($id);
			$sql = "SELECT health, cash, status
						FROM users WHERE id = $id";
			$stmt = $this->_db->query($sql);
			$result['point'] = $stmt->fetch(PDO::FETCH_ASSOC);

			$sql = "SELECT datetime
						FROM users WHERE id = $id";
			$stmt = $this->_db->query($sql);
			$dt = $stmt->fetch(PDO::FETCH_ASSOC);
			$result['datetime'] = $dt['datetime'];


			$sql = "SELECT uc.share_cnt as shareCnt, c.name as company
						FROM user_company uc, company c
						WHERE user_id = $id AND c.id = uc.company_id";
			$stmt = $this->_db->query($sql);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result['companies'][] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * не рабочая
	 */
	function _saveUserCompany($data){
		try{
			if(empty($data))
				throw new Exception("Засада, данные не пришли!");
			$sql = "INSERT INTO user_company (user_id, company_id, share_cnt)
							VALUES (:id_u, :id_c, :s_cnt) ON DUPLICATE KEY
							UPDATE share_cnt = share_cnt + ";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':id_u', $data['user_id'], PDO::PARAM_INT, 11);
			$stmt -> bindParam(':id_c', $data['company_id'], PDO::PARAM_INT, 11);
			$stmt -> bindParam(':s_cnt', $data['share_cnt'], PDO::PARAM_INT, 11);
			$stmt = $this->_db->query($sql);
		}catch(PDOException $e){
			die($e->getMessage());
		}catch(Exception $e){
			die($e->getMessage());
		}
	}


	/**
	 * Возвращает кол-во акций.
	 * @param int $userId - id пользователя.
	 * @param int $companyId - id компании.
	 */
	public function getUserShareCnt($userId, $companyId){
		try{
			$Uid = $this->_db->quote($userId);
			$Cid = $this->_db->quote($companyId);
			$sql = "SELECT share_cnt
							FROM user_company
							WHERE user_id = $Uid AND company_id = $Cid;";
			$stmt = $this->_db->query($sql);
			$shareCnt = $stmt->fetch(PDO::FETCH_ASSOC);
			if(is_null($shareCnt['share_cnt'])) {
				return 0;
			}
			return (int)$shareCnt['share_cnt'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	 * Если запись в бд существует, то перезаписывает данные, если записи нет до добавляет ее.
	 * @param int $userId - id польщователя.
	 * @param int $companyId - id компании.
	 * @param int $shareCnt - кол-во акций.
	 */
	public function setUserShareCnt($userId, $companyId, $shareCnt){
		try{
			$sql = "INSERT INTO `user_company`(user_id, company_id, share_cnt)
						VALUES (:u_id, :c_id, :s_cnt) ON DUPLICATE KEY
						UPDATE `share_cnt` = VALUES(share_cnt);";
			$stmt = $this->_db->prepare($sql);
		    $stmt->bindParam(':u_id', $userId , PDO::PARAM_INT, 11);
			$stmt->bindParam(':c_id', $companyId, PDO::PARAM_INT, 11);
			$stmt->bindParam(':s_cnt', $shareCnt , PDO::PARAM_INT, 11);
			$stmt->execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Ощищает данные котрые ноль.
	 */
	public function CleanUserComp(){
		try{
			$sql = "DELETE FROM user_company WHERE share_cnt = 0;";
			$stmt = $this->_db->query($sql);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
#####################################bank################################################
	/**
	 * Ложит деньги в банк.
	 */
	public function putMoney($id, $money){
		try{
			$sql = "INSERT INTO `bank`(user_id, user_money)
						VALUES (:u_id, :u_m) ON DUPLICATE KEY
						UPDATE `user_money` = VALUES(user_money)";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':u_id', $id, PDO::PARAM_INT, 11);
			$stmt -> bindParam(':u_m', $money, PDO::PARAM_INT, 11);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 *
	 */
	public function popMoney($userId){
		try{
			$sql = "SELECT user_money FROM bank
						WHERE user_id = ".$this->_db->quote((int)abs($userId));
			$stmt = $this->_db->query($sql);
			$money = $stmt->fetch(PDO::FETCH_ASSOC);
			return (float)$money['user_money'];
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
########################### Методы для работы с таблицей 'items'###########################
	/**
 	 * Производит выборку вещей.
 	 *
 	 * @return array - массив из элементов вещей
 	 */
	function getItems($offset=0,$rows=10){
		try{
			$result = array();
			$sql = "SELECT `id`, `name`, `effect`, `cash`, `health`, `price` 
						FROM `items` LIMIT {$offset},{$rows}";
			$stmt = $this->_db->query($sql);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if(isset($row['cash'])) {
					$row['cash'] = (float)$row['cash'];
				}if(isset($row['health'])) {
					$row['health'] = (float)$row['health'];
				}if(isset($row['price'])) {
					$row['price'] = (float)$row['price'];
				}
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Возвращает стоимость предмета.
	 * @param int $companyId - id предмета.
	 */
	public function getItemPrice($itemId){
		try{
			$Iid = abs((int)$itemId);
			$sql = "SELECT price
							FROM items
							WHERE id =".$this->_db->quote($Iid);
			$stmt = $this->_db->query($sql);
			$price = $stmt->fetch(PDO::FETCH_ASSOC);
			return (float)$price['price'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Возвращает имя предмета.
	 * @param int $companyId - id предмета.
	 */
	public function getItemName($itemId){
		try{
			$Iid = abs((int)$itemId);
			$sql = "SELECT name
							FROM items
							WHERE id =".$this->_db->quote($Iid);
			$stmt = $this->_db->query($sql);
			$name = $stmt->fetch(PDO::FETCH_ASSOC);
			return $name['name'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
 	 * Производит частичную выборку вещей.
 	 */
	function getItemPoint($id){
		try{
			$result = array();
			$sql = "SELECT `name`, `effect`, `cash`, `health` 
						FROM `items` WHERE id=".$id;
			$stmt = $this->_db->query($sql);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if(isset($row['cash'])) {
					$row['cash'] = (float)$row['cash'];
				}if(isset($row['health'])) {
					$row['health'] = (float)$row['health'];
				}
				$result['point'] = $row;
			}
			return $result['point'];
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
########################### Методы для работы с таблицей 'user_items'###########################
	/**
	 * Если запись в бд существует, то пезаписывает данные, если записи нет до добавляет ее.
	 * @param int $userId - id польщователя.
	 * @param int $companyId - id компании.
	 * @param int $shareCnt - кол-во акций.
	 */
	public function setUserItemCnt($userId, $itemId){
		try{
			$sql = "INSERT INTO `user_items`(user_id, item_id, item_cnt)
						VALUES (:u_id, :i_id, 1) ON DUPLICATE KEY
						UPDATE `item_cnt` = item_cnt + 1;";
			$stmt = $this->_db->prepare($sql);
		    $stmt->bindParam(':u_id', $userId , PDO::PARAM_INT, 11);
			$stmt->bindParam(':i_id', $itemId, PDO::PARAM_INT, 11);
			//$stmt->bindParam(':i_cnt', $itemCnt , PDO::PARAM_INT, 11);
			$stmt->execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}

	/**
	 * Возвращает id предмета, его кол-во и имя определенного пользователя.
	 * @param int $userId - id пользователя.
	 */
	public function getUserItems($userId){
		try{
			$userId = abs((int)$userId);
			$sql = "SELECT item_id, item_cnt, i.name
						FROM user_items, items i
						WHERE user_id = $userId and item_id = i.id";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Изменяет кол-во предметов пользователя
	 * @param int $userId - id пользователя.
	 * @param int $itemId - id предмета..
	 */
	public function changeUserItemCnt($userId, $itemId){
		try{
			$sql = "UPDATE `user_items`
						SET `item_cnt` = `item_cnt` - 1
						WHERE `user_id` = :u_id AND `item_id` = :i_id;";
			$stmt = $this->_db->prepare($sql);
		    $stmt->bindParam(':u_id', $userId , PDO::PARAM_INT, 11);
			$stmt->bindParam(':i_id', $itemId, PDO::PARAM_INT, 11);
			$stmt->execute();
			$sql = $sql = "DELETE FROM user_items WHERE item_cnt <= 0;";
			$stmt = $this->_db->query($sql);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
########################### Методы для работы с таблицей 'events'###########################
	/**
 	 * Сохраняет в БД имя пользователя и событие.
 	 * @param int $userId - id пользователя.
 	 * @param string $msg - событие.
 	 *
 	 */
	public function saveEvent($userId, $msg){
		try{
			$userId = abs((int)$userId);
			$sql = "INSERT INTO `events` (user_id, msg)
								VALUES (:u_id, :msg);";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':u_id', $userId, PDO::PARAM_INT, 11);
			$stmt -> bindParam(':msg', $msg, PDO::PARAM_STR, 255);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}

	/**
	 * Возвращает события
	 */
	public function getUserEvent($userId){
		try{
			$userId = abs((int)$userId);
			$sql = "SELECT msg FROM events
								WHERE user_id = ".$this->_db->quote($userId);
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->__toString());
		}
	}

########################### Методы для работы с таблицей 'feedback'###########################
	public function saveFeedback($msg){
		try{
			$sql = "INSERT INTO `feedback` (msg)
								VALUES (:msg);";
			$stmt = $this->_db->prepare($sql);
			$stmt -> bindParam(':msg', $msg, PDO::PARAM_STR, 255);
			$stmt -> execute();
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
	/**
	 * Возвращает события
	 */
	public function getFeedbackMsgs($offset=0,$rows=10){
		try{
			$sql = "SELECT id, msg FROM feedback ORDER BY id DESC LIMIT {$offset},{$rows}";
			$stmt = $this->_db->query($sql);
			$result = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}catch(PDOException $e){
			die($e->__toString());
		}
	}
}