<?php namespace Core;

// Определяем константы, которые понадобятся в движке
define('EXT', '.php');

// Подключаем классы и файлы, которые не могут быть загружены автозагрузчиком, так как нужны ему самому.
require SYS_PATH.'helpers'.EXT;
require SYS_PATH.'autoloader'.EXT;

// Регистрируем метод «load» автозагрузчика в стеке автозагрузчика.
spl_autoload_register(array('Core\\Autoloader', 'load'));

// Регистрируем псевдонимы для системных классов, чтобы упросить их использование в проекте
Autoloader::$aliases = array('Autoloader' => 'Core\\Autoloader');
