<?
	/**
	 * Класс для вывода со стилями плюс панель игрока.
	 */
	class UPFileModelDecorator extends AFileModelDecorator{
		function render($file){
			ob_start();
			include('bootstrap/header.php');
			include('application/views/panel.php');
//------>	var_dump($this->data);
			parent::render($file);
			include('bootstrap/footer.php');
			return ob_get_clean();
		}
	}