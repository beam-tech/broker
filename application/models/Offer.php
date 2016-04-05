<?
	class Bank{
		private $_db;
		private $_userId;

		function __construct($bdb, $uId){
			$this->_db = $_db;
			$this->_userId = $_uId;
		}

		public function OfferExist(){
			$data = $this->_db->getUserOffer($this->_userId);
		}
	}