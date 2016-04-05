<?
	/**
	 * Декоратор для вывода.
	 */
	abstract class AFileModelDecorator extends AFileModel{
		public $data = array();
		public $errors = array();
		public $done = array();
		private $_fileModel;
		function __construct(AFileModel $fm){
			$this->_fileModel = $fm;
		}
		function render($file){
//------>	var_dump($this->data);
			$this->_fileModel->render($file);
		}
	}