<?
	class UserModel{
		/**
		 * @var array $_data - массив с данными из POST.
		 * @var array $_errors - массив с ошибками.
		 * @var object $_db - здесь будет храниться объект БД.
		 */
		private $_data = array();
		private $_errors = array();
		private $_db;

		/**
		 * @param GameDB $gdb - объект GameDB.
		 * @param array $data - массив с данными.
		 */
		function __construct(GameDB $gdb, array $data){
			$this->_db = $gdb;
			unset($data['mov']);
			$this->_data = $data;
			$this->_data['id'] = $this->getId();
			$this->_data['role'] = $this->getRole();
			$this->_data['info'] = $this->getInfo();
			//$this->_data['info']['datetime'] = $this->getDate();
			$this->_data['info']['status'] = $this->getStatus();
		}

		public function getLogin(){
			return $this->_data['login'];
		}
		public function getId(){
			$login = $this->_data['login'];
			return $this->_db->getUserId($login);
		}
		public function getRole(){
			$id = $this->getId();
			return $this->_db->getUserRole($id);
		}
		public function getInfo(){
			$id = $this->getId();
			return $this->_db->getUserInfo($id);
		}
		public function getData(){
			return $this->_data;
		}
		public function getDate(){
			$id = $this->getId();
			return $this->_db->getUserDate($id);
		}
		public function getStatus(){
			$id = $this->getId();
			return $this->_db->getUserStatus($id);
		}
		
		/**
		 * Проверяет данные из масива $_data, если один из элементов false возвращает false, иначе true.
		 * @return bool
		 */
		private function validate(){
			foreach ($this->_data as $key => $value) {
				if($value == false)
					return false;
			}
			return true;
		}


		/**
		 * возвращает SHA1-хэш строку
		 * @param string $string - строка, которую необходимо зашифровать
		 * @param string $salt - соль
		 * @param string $numOfIter - кол-во итераций
		 *
		 * @return string $string хэш строка
		 */
		public function getHash($string, $salt, $numOfIter = 1){
			for ($i = 0; $i < $numOfIter; $i++)
				$string = sha1($string . $salt);
			return $string;
		}
		/**
		 * Возвращает сгенерированную соль
		 * @param $n - кол-во символов	
		 *
		 * @return string $salt - соль
		 */
		public function getSalt($n = 11){
			mb_internal_encoding("UTF-8");
			$salt = str_replace('=', '', base64_encode(md5(microtime())));
			$salt = mb_substr($salt, 1, $n);
			return $salt;
		}

		/**
		 * Проверяет существование юзера под указанным логином и паролем.
		 * Если он существует вернет true иначе false.
		 *
		 * @return bool
		 */
		public function Authorized(){
			if(!$this->validate()){
				$this->_errors[] = "Неверный логин или пароль";
				return false;
			}else{
				$login = $this->_data['login'];
				/* находим id пользователя */
				$userId = $this->getId();
				/* если что-то не так */
				if(is_null($userId)){
					$this->_errors[] = "Неверный логин или пароль";
					return false;
				}
				/* забираем пароль и соль пользователя по id */
				$data = $this->_db->getUserPassSalt($userId);
				$salt = $data['salt'];
				/* формируем хэш - пароль пользователя*/
				$password = $this->getHash($this->_data['password'], $salt);
				/* совпадает? */
				if($data['password'] === $password){
					return true;
				}else{
					$this->_errors[] = "Неверный логин или пароль";
					return false;
				}
			}
		}

		/* Перенапрвляет в зависимости от  роли. */
		public function Redirect(){
			if(!isset($this->_data)){
				echo "Данных о пользователе нет";
				return false;
			}
			if($this->_data['role'] == 'user'){
				header("Location: /{$this->_data['role']}/show/name/{$this->_data['login']}");
			}
			elseif ($this->_data['role'] == 'admin'){
				header("Location: /{$this->_data['role']}");
			}
		}


		/**
		 * Если все хорошо возвращает true.
		 *
		 * @return bool
		 */
		public function Registered(){
			if(!$this->checkLogin()){
				return false;
			}
			if(!$this->checkEmail()){
				return false;
			}
			if(!$this->checkPass()){
				return false;
			}
			return true;
		}
		/* чекает email*/
		public function checkEmail(){
			if($this->_data['email'] === ''){
				$this->_errors[] = "Поле для email пустое";
				return false;
			}
			if((strlen($this->_data['email'])) > 100){
				$this->_errors[] = "email превышает 100 символов.";
				return false;
			}
			
			if($this->_data['email'] == false){
				$this->_errors[] = "Некорректный email";
				return false;
			}
			if(!is_null($this->_db->getEmail($this->_data['email']))){
				$this->_errors[] = "Такой email уже зарегистрирован.";
				return false;
			}
			return true;
		}
		/* чекает login*/
		public function checkLogin(){
			if($this->_data['login'] == ''){
				$this->_errors[] = "Поле для логина пустое";
				return false;
			}

			if(!is_null($this->_db->getUserId($this->_data['login']))){
				$this->_errors[] = "Такой логин уже зарегистрирован.";
				return false;
			}

			if((strlen($this->_data['login'])) > 100 ){
				$this->_errors[] = "Логин превышает 100 символов";
				return false;
			}

			if((strlen($this->_data['login'])) < 3 ){
				$this->_errors[] = "Логин слишком маленький";
				return false;
			}
			
			if((strlen($this->_data['login'])) == false ){
				$this->_errors[] = "Некорректный логин";
				return false;
			}
			return true;
		}

		/* чекает password*/
		public function checkPass(){
			if($this->_data['password'] == ''){
				$this->_errors[] = "Поле для пароля пустое";
				return false;
			}
			if((strlen($this->_data['password'])) > 100 ){
				$this->_errors[] = "Пароль превышает 100 символов";
				return false;
			}

			if((strlen($this->_data['password'])) < 2 ){
				$this->_errors[] = "Пароль слишком маленький";
				return false;
			}
			
			if((strlen($this->_data['password'])) == false ){
				$this->_errors[] = "Некорректный пароль";
				return false;
			}
			return true;
		}

		/* создает игрока */
		public function createPlayer(){
			/*наделяем атрибутами*/
			$this->_data['role'] = 'user';
			$salt = $this->_data['salt'] = $this->getSalt();
			$pass = $this->_data['password'];
			/*хэшируем*/
			$this->_data['password'] = $this->getHash($pass, $salt);
			$this->_db->createUser($this->_data);
		}
		/* возвращает информацию о ошибках*/
		public function getErrors(){
			return $this->_errors;
		}


		public static function sendMail($email){
			$to = $email; // this is your Email address
		    $from = "lunetcool@gmail.com"; // this is the sender's Email address
		    $subject = "Form submission";
		    $message = "Спасибо" . "\n\n";

		    $headers = "From:" . $from;
		    mail($to,$subject,$message,$headers);
		}
	}