<?
	/**
	* Класс предназначенный для работы с очками игрока.
	*/
	class Point{
		/**
		 * @var GameDB $_db - объект GameDB
		 * @var int $_userId - id игрока
		 * 
		 */
		private $_db;
		private $_userId;
		private $_enemyId;
		private $_userLogin;
		private $_userCash;
		private $_userHealth;
		private $_errors =  array();
		private $_success = array();
		/* формируем данные */
		function __construct($pdb, $EnemyId, $UserId){
			$this->_db = $pdb;
			$this->_userId = $UserId;
			$this->_enemyId = $EnemyId;
			$this->_userLogin = $this->_db->getUserLogin($EnemyId);
			$data = $this->_db->getUserPoint($this->_userId);
			$this->_userCash = $data['cash'];
			$this->_userHealth = $data['health'];
		}

		public function getErrors(){
			return $this->_errors;	
		}
		public function getSuccess(){
			return $this->_success;
		}
		/** 
		 * Изменяет кол-во денег и шкалу жизней взависимости от предметов.
		 * @param array $items - массив из предметов.
		 * 
		*/
		public function change($items){
			if(!is_array($items)){
				echo 'нету предметов!';
			}
			foreach ($items as $key => $id) {
				$item = $this->_db->getItemPoint($id);
				if($item['effect'] == 'negative'){
					$this->changeHealth($item['health'], -1);
					$this->changeCash($item['cash'] , -1);
					$this->_db->changeUserItemCnt($this->_userId, $id);
					$this->_success[] = "Был использован {$item['name']} ".
							"на игрока {$this->_userLogin}. ".
								"Урон {$item['health']}%, кража {$item['cash']}\$";
				}elseif($item['effect'] == 'positive'){
					$this->changeHealth($item['health'], 1);
					$this->changeCash($item['cash'] , 1);
					$this->_db->changeUserItemCnt($this->_userId, $id);
					$this->_success[] = "Был использован {$item['name']}.".
							" Пополнение {$item['health']}% жизней и бонус {$item['cash']}\$ для игрока {$this->_userLogin}";
				}
			}
		}
		/* Изменяет шкалу жизней.*/
		public function changeHealth($itemHealth, $eff){
			$this->_userHealth = $this->_userHealth + $itemHealth * $eff;
			if($this->_userHealth < 0){

				//userDie();
			}elseif ($this->_userHealth > 100) {
				$this->_userHealth = 100;
			}
			$this->_db->changeUserHealth($this->_enemyId, $this->_userHealth);
		}
		/* Изменяет шкалу жизней.*/
		public function changeCash($itemCash, $eff){
			$this->_userCash = $this->_userCash + $itemCash * $eff;
			if($this->_userCash < 0){
				//userDie();
			}
			$this->_db->changeUserCash($this->_enemyId, $this->_userCash);

		}
		
		
	}