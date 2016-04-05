<?
	/**
	 * Класс для вывода контента.
	 * @var array $data - любые данные.
	 * @var array $errors - данные об ошибках.
	 * @var array $done - данные об успехе.
	 */
	abstract class AFileModel{
		
		/**
		 * Функция для вывода.
		 * @param string $file - имя файла.
		 */
		abstract function render($file);
	}