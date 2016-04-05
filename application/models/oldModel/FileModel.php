<?php
class FileModel{
	public $name = '';
	public $data = array();

	public $errors= array();
	public $done = array();
	
	function __construct($name=''){
		$this->name = $name;
	}
	public function render($file) {
		/* $file - */
		ob_start();
		include('bootstrap/header.php');	
		include($file);	
		include('bootstrap/footer.php');	
		return ob_get_clean();
	}

/*	public function tableDrawBody($arr){
			echo '<tbody>';
			foreach ($arr as $tr) {
				echo '<tr>';
					foreach ($tr as $td){
						echo '<td>'.$td.'</td>';
					}
				echo '</tr>';
			}
			echo '</tbody>';
		}

	public function drawTable(){
		if(sizeof($this->_head)!= sizeof(current($this->_body))) {
			echo 'извините, не могу нарисовать';
			exit;
		}
		echo '<table border="1">';
		$this->tableDrawHead($this->_head);
		$this->tableDrawBody($this->_body);
		echo '</table>';
	}*/
}