<?php

class Tester
{
	public $base_uri;
	public $files = [];
	public $responses = [];

	public static $result; // Placeholder for result captured by mock class such as a file save method

	public function __construct($uri = '')
	{
		if (empty($uri))
		{
			$conf = file_get_contents('../karma.conf.js');
			preg_match('/(http.+)test\./', $conf, $matches);
			$uri = $matches[1];
		}
		
		$this->base_uri = $uri;

		$this->doTests();
	}

	public function getSpecFileNames()
	{
		$this->files = glob('specs/*Spec.php');
	}

	public function getResponse($uri, $method = 'curl')
	{
		switch ($method)
		{
			case 'curl':
				$ch = curl_init($uri);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response = trim(curl_exec($ch));
				curl_close($ch);
				break;

			default:
				$response = file_get_contents($uri);
				break;
		}

		return $response;
	}

	public function getResponses()
	{
		foreach ($this->files as $fn)
		{
			$response = $this->getResponse($this->base_uri . $fn);

			if (strpos($response, 'describe(') === false)
				$response = $this->describe('PHP Error', $this->it($fn, self::clean($response)));

			$this->responses[] = $response;
		}
	}

	public function outputResponses()
	{
		// Concatenate the responses JSON, put some white space between them, and output to the requesting client as text content
		echo implode($this->responses, "\n\n");
	}

	public function doTests()
	{
		$this->getSpecFileNames();

		$this->getResponses();

		$this->outputResponses();
	}

	public static function describe($method_name, $nested_code, $root = false)
	{
		$js = '';

		if ($root)
			$js = "console.log('$method_name');\n";

		$js .= "describe('$method_name', function() { $nested_code });\n";

		if ($root)
			echo $js;
		else
			return $js;
	}

	public static function it($should, $expect, $to_equal = '')
	{
		return "it('$should', function() { expect('$expect').toEqual('$to_equal'); });\n";
	}

/**
*	This method executes a function that is passed by name with optional parameters and returns a value
*	It serves to avoid breaking the Javascript by not allowing PHP script output to directly merge with the overall output buffer content
*	If the function normally returns a value then this value is returned unless unexpected output to the buffer is encountered
*	In the event of unexpected output such as echo or print_r statements, then this content is returned
*	And, all content is cleaned up so as not to break the Javascript
*	For anything other than simple string results of tests, this function should be used in conjunction with test result producing functions
*/
	public static function func($func, $params = null)
	{
		ob_start();
		$result = $func($params);
		$content = ob_get_contents();
		if ( ! empty($content))
			$result = $content;
		ob_end_clean();
		return self::clean($result);
	}

	public static function clean($txt)
	{
		return preg_replace('/[\r\n]/', '', addslashes(strip_tags($txt)));
	}

	public static function bool_to_string($v)
	{
		return $v ? 'true' : 'false';
	}
}
