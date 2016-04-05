<?
	/**
	* 
	*/
	class UserPanelModel extends FileModel{
		public function render($file) {
			/* $file - */
			ob_start();
			include('bootstrap/header.php');
			echo <<<HTML
			
HTML;
			include($file);	
			include('bootstrap/footer.php');	
			return ob_get_clean();
		}
	}