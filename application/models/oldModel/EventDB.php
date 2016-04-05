<?
	class EventDB{
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
	 	
	 	/* Возвращает инстанс */
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
	 	 * Сохраняет в БД событие.
	 	 * @param array $data - массив из элементов события.
	 	 */
		public function saveEvent(array $data){
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
	 	 * Производит выборку из БД(таблица events):
	 	 * 		- имя 
	 	 *		- сообщение
	 	 *		- время
		 *
	 	 * @return array - массив тиз имени, сообщение и времени отправки.
	 	 */
		function getEvents($offset=0,$rows=10){
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
				echo $e->getMessage();
				return false;
			}
		}


		/**
	 	 * Удаляет из БД событие.
	 	 * @param int $id - id события
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
				die($e->__toString());
			}
		}

		/**
	 	 * Удаляет в БД события.
	 	 * @param array $arr - массив из id событий
	 	 */
		public function deleteEvents($arr){
			$data = $arr['event_id'];
			if(!is_array($data))
				throw new Exception("Ошибка данных(нужен массив)");
			$sum = 0;
			try{
				for ($i=0; $i < sizeof($data); $i++) { 
					$sum += $this->deleteEvent($data[$i]);
				}
				return $sum;
			}catch(Exception $e){
				$e->getMessage();
				return false;
			}
		}
	}