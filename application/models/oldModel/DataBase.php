<?
	class DataBase{
		const DB_NAME = 'DB.db';
		protected $_db;
		protected static $_instance = null;

 		protected function __construct(){
			if(!is_file(self::DB_NAME)){
				echo 'отсутствует БД!';
				exit;
			}else
				$this->_db = new PDO('sqlite:'.self::DB_NAME);
 		}

 		protected function __clone(){}
 		
 		public static function getInstance(){
			if(!self::$_instance instanceof self)
				self::$_instance = new self;
			return self::$_instance;
		}
		
 		function __destruct(){
 			unset($this->_db);
 		}

		function getUserInfo($name){
			try{
				$sql = "SELECT email, cash, health
							FROM users WHERE name = '$name'";

				$result = $this->_db->query($sql);
				return $result->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}

		function getTopUsers($offset=0,$rows=10){
			try{
				$sql = "SELECT cash, name
							FROM users ORDER BY cash DESC LIMIT {$offset},{$rows}";

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

		function saveToEvents($n, $k, $e, $c, $h, $a, $m){
			echo 1;
			$sql = "INSERT INTO events (name, kind, effect, cash, health, action, msg)
								VALUES( '$n', '$k', '$e', $c, $h, $a, '$m')";
			$result = $this->_db->exec($sql) or $this->_db->errorCode();
			if($result === false)
				return false;
			return true;
		}


		function getEvent($id){
			try{
				$sql = "SELECT name, kind, effect, cash, health, action, msg
							FROM events WHERE id = '$id'";
				$result = $this->_db->query($sql);
				return $result->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}
		
		function getUserPass($name, $pass){
			try{
				$sql = "SELECT * FROM users 
						WHERE name='$name' AND pass='$pass'";

				$result = $this->_db->query($sql);
				return $result->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}


	}