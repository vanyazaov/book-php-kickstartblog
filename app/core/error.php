<?php

namespace Core;

defined('APP_PATH') or die('No direct script access.');

class Error 
{
    // Создаём карту соответствия кодов и имён
    protected static $errorLevelMap = [
        E_ERROR             => 'E_ERROR',
        E_WARNING           => 'E_WARNING',
        E_PARSE             => 'E_PARSE',
        E_NOTICE            => 'E_NOTICE',
        E_CORE_ERROR        => 'E_CORE_ERROR',
        E_CORE_WARNING      => 'E_CORE_WARNING',
        E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
        E_USER_ERROR        => 'E_USER_ERROR',
        E_USER_WARNING      => 'E_USER_WARNING',
        E_USER_NOTICE       => 'E_USER_NOTICE',
        E_STRICT            => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED        => 'E_DEPRECATED',
        E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
        E_ALL               => 'E_ALL'
    ];
	/**
	 * Обрабатывает исключение и выводит отчёт о нём.
	 *
	 * @param  Exception  $exception
	 * @return void
	 */
	public static function exception($exception)
	{
	    // Логируем ошибку
	    static::log($exception);
	    
        // Если включено детальное отображение ошибок, мы просто форматируем исключение
		// в простое сообщение об ошибке и показываем его на экране. 
		if (APP_CONFIG_ERROR_DETAIL)
		{
			echo "<html><h2>Необработанное исключение</h2>
				  <h3>Сообщение:</h3>
				  <pre>".$exception->getMessage()."</pre>
				  <h3>Местоположение:</h3>
				  <pre>".$exception->getFile()." на линии ".$exception->getLine()."</pre>
				  <h3>Стек вызовов:</h3>
				  <pre>".$exception->getTraceAsString()."</pre></html>";
		}
		else
		{
			// Устанавливаем код ответа HTTP 500
			http_response_code(500);
			
			// Выводим простое сообщение
			echo 'Внутренняя ошибка сервера';
		}
        // Завершаем выполнение с кодом ошибки
		exit(1);
	}
	
	/**
	 * Обрабатывает нативную ошибку PHP как ErrorException.
	 *
	 * @param  int     $code
	 * @param  string  $error
	 * @param  string  $file
	 * @param  int     $line
	 * @return void
	 */
	public static function native($code, $error, $file, $line)
	{
	    // Если ошибка подавлена оператором "@", игнорируем её.
		if (error_reporting() === 0) return;

		// Для ошибки PHP мы создадим ErrorException и затем передадим это
		// исключение в метод exception, который создаст простое представление
		// (view) с деталями исключения. Класс ErrorException встроен в PHP
		// для преобразования нативных ошибок в Исключения (Exceptions).
		$exception = new \ErrorException($error, $code, 0, $file, $line);

		// Если код ошибки находится в списке игнорируемых, просто логируем её
		// и завершаем работу метода, не выводя ошибку на экран.
		if (defined('APP_CONFIG_ERROR_IGNORE')) {
		    $app_error_ignore = explode(',', APP_CONFIG_ERROR_IGNORE);
		    
		    if (in_array(static::$errorLevelMap[$code], $app_error_ignore))
		    {
			    return static::log($exception);

			    return true;
		    }		    
		}

		
        // Передаём исключение в основной обработчик для отображения пользователю.
		static::exception($exception);
	}
	
	/**
	 * Обрабатывает событие завершения работы PHP.
	 *
	 * @return void
	 */
	public static function shutdown()
	{
		// Если произошла фатальная ошибка, которую мы ещё не обработали,
		// мы создадим ErrorException и передадим его обработчику исключений,
		// так как эта ошибка не была обработана обработчиком ошибок.
		if ( ! is_null($error = error_get_last()))
		{
			extract($error, EXTR_SKIP);

			static::exception(new \ErrorException($message, $type, 0, $file, $line));
		}
	}
	
	/**
	 * Логирование исключения.
	 *
	 * @param  Exception  $exception
	 * @return void
	 */
	public static function log($exception)
	{
		if (APP_CONFIG_ERROR_LOG)
		{
		    $message = date('[Y-m-d H:i:s] ') . $exception->getMessage() .": ". $exception->getFile() . " ". $exception->getLine().PHP_EOL;
			file_put_contents(APP_CONFIG_ERROR_LOG_FILE, $message, FILE_APPEND);
		}
	}

}
