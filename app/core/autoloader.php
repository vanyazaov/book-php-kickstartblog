<?php

namespace Core;

defined('APP_PATH') or die('No direct script access.');

/**
 * Класс для автоматической загрузки классов (Autoloader) по стандарту PSR-0.
 * Поддерживает регистронезависимую загрузку и работу с пространствами имен.
 */
class Autoloader
{
	/**
	 * Массив псевдонимов для классов зарегистрированные в автозагрузке
	 *
	 * @var array
	 */
	public static $aliases = array();
    /**
     * Массив директорий для поиска классов в соответствии с PSR-0
     *
     * @var array
     */
    public static $psr = array();

    /**
     * Основной метод загрузки классов. Вызывается автоматически при использовании spl_autoload_register
     *
     * @param string $class Имя класса для загрузки (с пространством имен)
     * @return void
     */
    public static function load($class)
    {
        // Первым делом проверяем, не зарегистрирован ли алиас для этого класса
        // Алиасы позволяют использовать короткие имена вместо полных путей
        if (isset(static::$aliases[$class])) {
            // Создаем псевдоним: оригинальный класс будет доступен под запрошенным именем
			class_alias(static::$aliases[$class], $class);
			return; // Выходим, так как алиас создан - дальнейшая загрузка не нужна
		}
		
        static::load_psr($class);
    }
    
    /**
     * Преобразует имя класса в путь к файлу и пытается найти его в зарегистрированных директориях
     *
     * @param string $class Имя класса для загрузки
     * @return bool|null Возвращает true если файл был успешно загружен, иначе null
     */
    protected static function load_psr($class)
    {
        // Преобразуем пространства имен и подчеркивания в путь директорий
        $file = str_replace(array('\\', '_'), '/', $class);
        $directories = static::$psr;
        
        // Ищем файл в каждой зарегистрированной директории
        foreach ($directories as $directory)
        {
            // Первая попытка: регистронезависимый поиск (нижний регистр)
            if (file_exists($path = $directory.strtolower($file).EXT))
            {
                return require $path;
            }
            // Вторая попытка: точное совпадение регистра
            elseif (file_exists($path = $directory.$file.EXT))
            {
                return require $path;
            }
        }
    }
    
    /**
     * Регистрирует одну или несколько директорий для поиска классов по PSR-0
     *
     * @param string|array $directory Путь(и) к директориям для поиска классов
     * @return void
     */
    public static function psr($directory)
    {
        // Форматируем переданные директории и объединяем с существующими
        $directories = static::format($directory);
        static::$psr = array_unique(array_merge(static::$psr, $directories));
    }
    
    /**
     * Форматирует переданные директории: приводит к массиву и добавляет разделитель в конец
     *
     * @param string|array $directories Директория(и) для форматирования
     * @return array Отформатированный массив директорий
     */
    protected static function format($directories)
    {
        return array_map(function($directory)
        {
            // Убеждаемся, что в конце пути есть разделитель директорий
            return rtrim($directory, DS).DS;
        
        }, (array) $directories); // Приводим к массиву, если передана строка
    }
}
