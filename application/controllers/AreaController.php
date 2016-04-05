<?php
class AreaController implements IController {
		protected $_userData;
		function __construct(){
			if(!Session::exists('user')) {
				header('Location: /404');
			}else{
				$data = Session::get('user');
				//var_dump($data);
				$this->_userData['login'] = $data['login'];
				$id = $this->_userData['id'] = $data['id'];
				/* Обновляет данные о пользователе */
				$this->_userData['point'] = GameDB::getInstance()->getUserPoint($id);
				$this->_userData['events'] = GameDB::getInstance()->getUserEvent($id);
				//var_dump($this->_userData['point']);
			}
		}

	public function indexAction() {
		$fc = FrontController::getInstance();
		/* Инициализация модели */
		$model = new UPFileModel;
		/* Забираем данные о пользователе*/
		$model->data['main'] = $this->_userData;
		$model->data['events'] = $this->_userData['events'];

		$output = $model->render(AREA_FILE);
		$fc->setBody($output);
	}
	/**
	 * Очень сложная для понимания функция.
	 */
	public function companiesAction() {
		$fc = FrontController::getInstance();
		/* Инициализация модели */
		$model = new UPFileModel;
		$cdb = GameDB::getInstance();
		$model->data['main'] = $this->_userData;
		//$model->data['events'] = $this->_userData['events'];


		$data = RequestModel::getPost();
		//var_dump($data);
		if(!empty($data)){
			if(isset($data['comp_id'])) {
				$companyId = $data['comp_id'];
				/* Определяем статус компании */
				$compStatus = $cdb->getCompStatus($companyId);
				/* Формируем инф. о компании */
				$model->data['company'] = $cdb->getCompany($companyId);
				$model->data['company']['id'] = $data['comp_id'];
				$model->data['near_def'] = '';


				if($compStatus != 'defaulter'){
					$userId = $this->_userData['id'];
					/* Объект для акций */
					$share = new Share($cdb, $userId, $companyId);
					// если компания банкрот
					$per = $share->calcPercent();
					if($per < 40){
						$model->data['near_def'] = "на грани банкротства";
					}if ($per < 30) {
						$cdb->doCompDefaulter($companyId);
						header('Location: '.$_SERVER['REQUEST_URI']);
						exit;
					}
					$model->data['shareCnt'] = $share->getUserShare();
					
					include "application/views/area/company.php";
				}else{
					include "application/views/area/company_def.php";
				}
				exit;
			}
		}
		$model->data['company'] = $cdb->getAllCompany();

		$output = $model->render(ALL_COMPANY_FILE);
		
		$fc->setBody($output);
	}

	public function shareAction() {
		$cdb = GameDB::getInstance();
			/* из сессии (id пользователя)*/
		$data = RequestModel::getPost();

		if(!empty($data)){
			if(isset($data['share_cnt']) and $data['comp_id']) {
				$userId = $this->_userData['id'];
				$companyId = abs((int)$data['comp_id']);
				$shareCnt = abs((int)$data['share_cnt']);

				$share = new Share($cdb, $userId, $companyId);

				/* если покупка*/
				if($data['mov'] == 'buy'){
					$share->buy($shareCnt);
				}
				/* если продажа */
				if($data['mov'] == 'sell'){
					$share->sell($shareCnt);
				}
				//стоимость акции
				$sharePrice = $cdb->getCompSharePrice($companyId);
				//общее кол-во акций компании
				$totShare = $cdb->getCompShareCnt($companyId);
				//кол-во акций игрока
				$userShare = $cdb->getUserShareCnt($userId, $companyId);

				/* Если ошибки */
				$err = $share->getErrors();
				if(!is_null($err)){
					$res = array('shareCnt' =>false, 'msg'=>$err);
					die(json_encode($res));
				}
				$succ = $share->getSuccess();
				if(!is_null($succ)){
					$res = array('shareCnt' => $sharePrice, 
								 'totShare' => $totShare,  
								 'userShare'=> $userShare,
								 'msg'=>$succ);
					die(json_encode($res));
				}	
			}
		}	
	}

	public function storageAction() {
		$fc = FrontController::getInstance();
		/* Инициализация модели для вывода*/
		$model = new UPFileModel;
		$model->data['main'] = $this->_userData;
		$model->data['events'] = $this->_userData['events'];

		$model->errors['msgs'] = '';
		$model->done['msgs'] = '';
		$odb = GameDB::getInstance();
		$userId = $this->_userData['id'];
		/* Узнаем сколько в хранилище денег*/
		$dbMoney = $odb->popMoney($userId);
		$cash = $odb->getUserCash($userId);
		$data = RequestModel::getPost();
		/* деньги */
		$money = round($data['money'], 2); 
		if(!empty($data)){
			/* если забираем деньги*/
			if($data['mov']=='pop'){
				if($money > $dbMoney){
					$model->errors['msgs'] = "В хранилище нет таки денег";
				}else{
					$cash = $cash + $money;
					$odb->changeUserCash($userId, $cash);
					$total = $dbMoney - $money;
					$odb->putMoney($userId, $total);
					$model->done['msgs'] = "Вы забрали $money\$";
				}
			/* если вкладываем деньги*/
			}elseif($data['mov']=='put'){
				if($money > $cash){
					$model->errors['msgs'] = "У Вас нет таки денег";
				}else{
					$cash = $cash - $money;
					$odb->changeUserCash($userId, $cash);
					$total = $money + $dbMoney;
					$odb->putMoney($userId, $total);
					$model->done['msgs'] = "Вложено $money\$";
				}
			}
			header('Refresh: 2;url=storage');
		}
		$model->data['money'] = $dbMoney;
		$output = $model->render(STORAGE_FILE);
		$fc->setBody($output);
	}
	public function shopAction() {
		$fc = FrontController::getInstance();
		$idb = GameDB::getInstance();
		/* Инициализация модели для вывода*/
		$model = new UPFileModel;
		/* Забираем данные о пользователе*/
		$model->data['main'] = $this->_userData;
		$model->data['events'] = $this->_userData['events'];

		$model->errors['msgs'] = '';
		$model->done['msgs'] = '';
		$items = $model->data['items'] = $idb->getItems();
		
		$data = RequestModel::getPost();
		if(!empty($data)) {
			$itemData = $data['item_id'];
			$userId = $this->_userData['id'];
			$shop = new Shop($idb, $userId);
			$shop->buy($itemData);
			$model->errors['msgs'] = $shop->getErrors();
			
			$model->done['msgs'] = $shop->getSuccess();
			header('Refresh: 2;url=shop');
		}
		
		$output = $model->render(SHOP_FILE);
		$fc->setBody($output);
	}
	public function workAction() {
		$fc = FrontController::getInstance();
		$idb = GameDB::getInstance();
		/* Инициализация модели для вывода*/
		$model = new UPFileModel;
		/* Забираем данные о пользователе*/
		$model->data['main'] = $this->_userData;
		$model->data['events'] = $this->_userData['events'];

		$output = $model->render(WORK_FILE);
		$fc->setBody($output);
	}
}
