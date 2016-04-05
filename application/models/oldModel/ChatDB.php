<?
	class ChatDB{
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
	 	 * Сохраняет в БД имя пользователя и оправленное им сообщение.
	 	 * @param array $data - 
	 	 */
		public function saveMsgs(array $data){
			try{
				//var_dump($data);
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
						$row['dt'] = date('d-m-Y H:i:s', $row['dt']);
					}
					$result[] = $row;
				}
				return !empty($result)? $result : false;
			}catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}

	}