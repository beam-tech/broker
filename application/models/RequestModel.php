<?
/**
 * Класс для обработки запросов.
 */
	class RequestModel{
		static $post;

		public static function shapePOST(){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				foreach($_POST as $key=>$value){
					$filter = self::choiceFilter($key);
					self::$post[$key] = $filter($value);
				}
			}
		}

		/**
		 * Проверяет данные из масива $post, если один из элементов false возвращает false, иначе true.
		 * @return bool
		 */
		public static function validate(){
			foreach (self::$post as $key => $value) {
				if($value == false)
					return false;
			}
			return true;
		}

		/**
		 * Взависимости от входящих данных возвращает функцию-фильт.
		 * @param string $data - данные.
		 *
		 * @return string|bool
		 */
		public static function choiceFilter($data){
			switch ($data) {
				case 'login':
					return function($str){
						if(!preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,11}$/',$str))
							return false;
						return $str;
					};
					break;
				case 'password':
					return function($str){
						if(!preg_match('/^[a-zA-Z0-9]{1,40}$/',$str))
							return false;
						return $str;
					};
					break;
				case 'email':
					return function($str){
						if(!preg_match('/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/', $str))
							return false;
						return $str;
					};
					break;
				case 'event_id':
					return function(array $arr){
						foreach($arr as $k => $v) { 
							$data[] = (int)trim(strip_tags($v));
						}
						return $data;
					};
					break;
				case 'item_id':
					return function(array $arr){
						foreach($arr as $k => $v) { 
							$data[] = abs((int)trim(strip_tags($v)));
						}
						return $data;
					};
					break;
				case 'share_cnt':
					return function($str){
						if(!preg_match('/^[0-9]{1,11}$/',$str))
							return false;
						return (int)$str;
					};
					break;
				case 'money':
					return function($str){
						$str = trim(strip_tags($str));
						return abs((float)$str);
					};
					break;
				default:
					return function($str){
						$str = trim(strip_tags($str));
						return $str;
					};
					break;
			}
		}
		/* фильтрует и возвращает POST*/
		public static function getPost() {
			self::shapePOST(); // формиреум массив
			return self::$post;
		}

		public function headers(){
			
		}
	}