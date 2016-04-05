<?	
	/**
	 * Класс для вывода со стилями плюс панель игрока.
	 */
	class UPFileModel extends AFileModel{
		function render($file){
			ob_start();
			include('bootstrap/header.php');
			include('application/views/panel.php');
			include($file);
			include('bootstrap/footer.php');	
			return ob_get_clean();
		}
	}