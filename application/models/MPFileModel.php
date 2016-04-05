<?php
	/**
	 * Класс для вывода со стилями.
	 */
	class MPFileModel extends AFileModel{
		function render($file){
			ob_start();
			include('bootstrap/header.php');	
			include($file);
			include('bootstrap/footer.php');	
			return ob_get_clean();
		}
	}
