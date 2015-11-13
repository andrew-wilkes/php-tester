<?php

include 'config.php';

include 'testerClass.php';

register_shutdown_function('shutdown_handler');

function shutdown_handler()
{

	$error = error_get_last();

	if (isset($error))
	{
		ob_clean();

		exit ($error['message'] . " on line: " . $error['line']);
    }

}

ob_start();
