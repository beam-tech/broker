<?
	/**
	* Класс предназначенный для работы с акциями.
	*/
	class Share{
		/**
		 * @var GameDB $_db - объект GameDB
		 * @var int $_userId - id пользователя
		 * @var int $_companyId - id компании
		 * @var int $_userShareCnt - кол-во акций пользователя
		 * @var int $_compShareCnt - кол-во акций компании
		 * @var int $_userCash - кол-во денег пользователя.
		 * @var int $_compSharePrice - стоимость акции компании.
		 * @var array $_errors - массив с ошибками.
		 * @var array $_errors - массив с хорошими новостями.
		 * 
		 */
		private $_db;
		private $_userId;
		private $_compId;
		private $_userShareCnt;
		private $_compShareCnt;
		private $_userCash;
		private $_compSharePrice;
		private $_errors;
		private $_success;

		function __construct($sdb, $userId, $companyId){
			$this->_db = $sdb;
			$this->_userId = $userId;
			$this->_userShareCnt = $this->_db->getUserShareCnt($userId, $companyId);
			$this->_userCash = $this->_db->getUserCash($userId);
			$this->_compId = $companyId;
			$this->_compShareCnt = $this->_db->getCompShareCnt($companyId);
			$this->_compTotalShareCnt = $this->_db->getCompTotalShareCnt($companyId);
			$this->_compSharePrice = $this->_db->getCompSharePrice($companyId);
			//var_dump($this->_compSharePrice);
		}
		// Возвращает кол-во акций пользователя.
		public function getUserShare(){
			return $this->_userShareCnt;
		}

		/**
		* Возвращает доступное кол-во акций компании;
		*/
		public function getShareCnt(){
			return $this->_compShareCnt;
		}
		/**
		* Возвращает стоимость акции;
		*/
		public function getSharePrice(){
			return $this->_compSharePrice;
		}

		/**
		* Определяет общую стоимость акций для определенной компании.
		*/
		public function getTotalPrice($shareCnt){
			$total = $this->_compSharePrice * $shareCnt;
			return $total;
		}
		public function getErrors(){
			return $this->_errors;	
		}
		public function getSuccess(){
			return $this->_success;
		}

		/**
		 * Производит покупку акций.
		 * @param int $shareCnt - кол-во акций.
		 */
		public function buy($shareCnt){
			if($shareCnt == false or $shareCnt == 0){
				return false;
			}
			if($shareCnt > $this->_compShareCnt){
				$this->_errors = "У компании нет такого количества акций.";
				return false;
			}

			$totalPrice = $this->getTotalPrice($shareCnt);
			if($totalPrice > $this->_userCash){
				$this->_errors = "Недостаточно денег для покупки.";
				return false;
			}

			$sub = $this->_userCash - $totalPrice;
			$subShare = $this->_userShareCnt + $shareCnt;
			$subCompShare = $this->_compShareCnt - $shareCnt;
			$sharePrice = $this->changeSharePrice(0.95, 1.05);
			$this->_db->changeUserCash($this->_userId, $sub);
			$this->_db->setUserShareCnt($this->_userId, $this->_compId, $subShare);
			$this->_db->changeCompShareCnt($this->_compId, $subCompShare);
			$this->_db->changeCompSharePrice($this->_compId, $sharePrice);
			$this->_success = "Вы купили ".$shareCnt." акций общей стоимостью ".$totalPrice."$";
		}
		/**
		 * Производит продажу акций.
		 * @param int $shareCnt - кол-во акций.
		 */
		public function sell($shareCnt){
			if(!$shareCnt == 0){
				if($shareCnt > $this->_userShareCnt){
					$this->_errors = "У Вас нет такого количества акций.";
					return false;
				}
				$totalPrice = $this->getTotalPrice($shareCnt);
				$sum = $this->_userCash + $totalPrice;
				$sumShare = $this->_userShareCnt - $shareCnt;
				$sumCompShare = $this->_compShareCnt + $shareCnt;
				$sharePrice = $this->changeSharePrice(0.95, 1.05);

				$this->_db->changeUserCash($this->_userId, $sum);
				$this->_db->setUserShareCnt($this->_userId, $this->_compId, $sumShare);
				$this->_db->changeCompShareCnt($this->_compId, $sumCompShare);
				$this->_db->changeCompSharePrice($this->_compId, $sharePrice);
				$this->_success = "Продано ".$shareCnt." акций, общей стоимостью ".$totalPrice."$";
			}
			return false;
		}

		/**
		 * Измееняет стоимость акций.
		 *
		 */
		function changeSharePrice($min,$max) {
			$ko = $min + lcg_value() * (abs($max - $min));
			$res = $this->_compSharePrice * $ko;
			return round($res, 2);
		}
		/**
		 * Вычисляет сколько % акций имеют пользователи.
		 *
		 */
		function calcPercent() {
			$per = ($this->_compShareCnt * 100) / $this->_compTotalShareCnt;
			return $per;
		}

	}