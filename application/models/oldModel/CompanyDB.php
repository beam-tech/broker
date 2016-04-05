<?
/**
 * Be careful singleton!
 * Класс для взаимодействия с БД (с таблицей `company`)
 */
	class CompanyDB{
		/**
		 * @var array $option - доп. опции для PDO
		 * @var const string CONF_FILE - имя конфигурационного файла
		 * @var string $params - параметры конфигурационного файла ['dsn'-соединение к MySQL БД , 'user'-имя пользователя, 'pass'- пароль пользователя]
		 * @var object $_db - здесь будет хранить объект 'GameDB'
		 * @var object $_instance - инстанс объекта 'CompanyDB'
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
	 	 * Производит выборку из БД(таблица company):
	 	 * 		- имя 
	 	 *		- дивиденды
	 	 *		- кол-во акций
	 	 *		- цена акций
		 *
	 	 * @return array - массив тиз имени, сообщение и времени отправки.
	 	 */
		function getAllCompany($offset=0,$rows=10){
			try{
				$sql = "SELECT `id`, `name`, `dividends`, `share_cnt`, `share_price`
							FROM `company` LIMIT {$offset},{$rows}";
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
				$sql = "SELECT `name`, `dividends`, `share_cnt`, `share_price`
							FROM `company` 
							WHERE id = $id";
				$stmt = $this->_db->query($sql);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
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

		/**
		 *
		 */
		function saveUserCompany($data){
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
	}