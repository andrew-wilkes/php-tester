<?php

include 'config.php';

include 'testerClass.php';

spl_autoload_register('mock_class_autoloader');

register_shutdown_function('shutdown_handler');

ob_start();


/* The callback functions that are referenced above */

function mock_class_autoloader($class)
{
   	include MOCK_PATH . $class . '.php';
}

function shutdown_handler()
{

	$error = error_get_last();

	if (isset($error))
	{
		ob_clean();

		exit ($error['message'] . " on line: " . $error['line']);
    }

}
