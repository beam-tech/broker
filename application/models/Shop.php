<?
	/**
	* Класс предназначенный для работы с магазином.
	*/
	class Shop{
		/**
		 * @var GameDB $_db - объект GameDB
		 * @var int $_userId - id игрока
		 * 
		 */
		private $_db;
		private $_userId;
		private $_userCash;
		private $_errors;
		private $_success;

		function __construct($sdb, $userId){
			$this->_db = $sdb;
			$this->_userId = $userId;
			$this->_userCash = $this->_db->getUserCash($userId);
		}
		/* совершает покупку */
		public function buy($itemData){
			$sum = $this->getSumPriceOfItems($itemData);
			if($sum > $this->_userCash){
				$this->_errors = "У Вас недостаточно денег";
				return false;
			}
			$sub = $this->_userCash - $sum;
			/* меняем деньги у пользователя*/
			$this->_db->changeUserCash($this->_userId, $sub);
			$Uid = $this->_userId;
			foreach ($itemData as $key => $value) {
				$this->_db->setUserItemCnt($Uid, $value);
			}
			$str = $this->getStringItems($itemData);
			$this->_success = "Приобретено ".$str." , общей стоимостью ".$sum."$";
			return true;
		}
		/* находит сумму общую предмета*/
		public function getSumPriceOfItems($ids){
			$res = array();
			for ($i=0; $i < count($ids) ; $i++) { 
				$res[] = $this->_db->getItemPrice($ids[$i]);
			}
			$sum = array_sum($res);
			return $sum;
		}
		/* возвращает строку купленных предметов*/
		public function getStringItems($ids){
			$res = array();
			for ($i=0; $i < count($ids) ; $i++) { 
				$res[] = $this->_db->getItemName($ids[$i]);
			}
			$str = implode(", ", $res);
			return $str;
		}

		public function getErrors(){
			return $this->_errors;	
		}
		public function getSuccess(){
			return $this->_success;
		}
	}