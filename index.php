<?php
error_reporting(-1);
/* Пути по-умолчанию для поиска файлов */
set_include_path(get_include_path()
					.PATH_SEPARATOR.'application/controllers'
					.PATH_SEPARATOR.'application/models'
					.PATH_SEPARATOR.'application/views');

/* Имена файлов: views */
require_once 'libs/data_views.php';

/* Автозагрузчик классов */
function my_autoload($class){
	require_once $class.'.php';
}
spl_autoload_register("my_autoload");

Session::init();
/* Инициализация и запуск FrontController */
$front = FrontController::getInstance();

/* Разруливает */
$front->route();

/* Вывод данных */
echo $front->getBody();

/*echo "<pre>";
var_dump($_COOKIE);
var_dump($_SESSION);
echo "</pre>";*/
