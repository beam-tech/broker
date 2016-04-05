<?
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