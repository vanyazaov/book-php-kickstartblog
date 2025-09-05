<?php namespace Core;

/**
* Определяем константы, которые понадобяться в движке
*/
define('EXT', '.php');

/**
* Подключаем классы, которые не могут быть загружены автозагрузчиком, так как нужны ему самому.
*/
require SYS_PATH.'helpers'.EXT;
require SYS_PATH.'autoloader'.EXT;

/**
* Регистрируем метод «load» автозагрузчика в стеке автозагрузчика.
*/
spl_autoload_register(array('Core\\Autoloader', 'load'));
