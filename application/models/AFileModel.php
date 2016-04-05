<?php
	/**
	 * Класс для вывода контента.
	 * @var array $data - массив для любых данных.
	 * @var array $errors - массив для ошибок.
	 * @var array $done - массив для успешных данных.
	*/
	abstract class AFileModel{
		public $data = array();
		public $errors= array();
		public $done = array();
		/*
		 Фукция для вывода.
		*/
		abstract function render($file);
	}