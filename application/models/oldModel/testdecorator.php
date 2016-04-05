<?
	/**
	 * Класс для вывода контента.
	 * @var array $data - любые данные.
	 * @var array $errors - данные об ошибках.
	 * @var array $done - данные об успехе.
	 */
	abstract class AFileModel{
		public $data = array();
		public $errors= array();
		public $done = array();
		/**
		 * Функция для вывода.
		 * @param string $file - имя файла.
		 */
		abstract function render($file) {}
	}


	/**
	 * Декоратор для вывода.
	 */
	abstract class AFileModelDecorator extends AFileModel{
		private $_fileModel;
		function __construct(AFileModel $fm){
			$this->_fileModel = $fm;
		}
		function render($file){
			$this->_fileModel->render($file);
		}
	}
	/**
	 * Класс для вывода со стилями плюс панель игрока.
	 */
	class UPFileModelDecorator extends AFileModelDecorator{
		function render($file){
			ob_start();
			include('bootstrap/header.php');
			include('application/views/panel.php');
			parent::render($file);
			include('bootstrap/footer.php');	
			return ob_get_clean();
		}
	}
	/**
	 * Класс для вывода со стилями.
	 */
	class MPFileModelDecorator extends AFileModelDecorator{
		function render($file){
			ob_start();
			include('bootstrap/header.php');	
			parent::render($file);
			include('bootstrap/footer.php');	
			return ob_get_clean();
		}
	}


	$fm1 = new FileModel();
	$fm1->render('ass.txt');

	$fm = new FileModel;

	$fm->render('ass,tx');
	output buffer 