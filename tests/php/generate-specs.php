<?php
/**
* Generates template code for test Spec files for every PHP source file that needs to be tested.
*/
?><html>
<head>
<style>
body {
	background-color: #111;
	font-family: Arial, Helvetica, sans-serif;
	color: #f60;
}
h2 {color: #09f;}
tt {color: #0f0;}
i {color: #0cf;}
</style></head><body>
<h2>Generated Test Spec Files</h2>
<pre><?php

include 'config.php';

$existing_files = array_map('basename', glob(SPEC_PATH . '*Spec.php'));

$existing_files[] = 'indexSpec.php';

$source_files = glob($php_source_file_matching_pattern);

foreach ($source_files as $key => $source_file) {

	$functions = [];

	$spec_fn = str_replace('.', 'Spec.', basename($source_file));

	if ( ! in_array($spec_fn, $existing_files))
	{
		$name = ucfirst(str_replace('Spec.php', '', $spec_fn));
		$lower_case_name = strtolower($name);

		$code = file_get_contents($source_file);

		// Search for static methods
		preg_match_all('/static function (\w+)\(/', $code, $matches);

		$static_methods = array_values($matches[1]);

		// Search for all functions
		preg_match_all('/ function (\w+)\(/', $code, $matches);

		// Start generating the source code to run the tests under PHP and output the results as Javascript code
		$test_code = "<?php

include '../before.php';

include '../$source_file';

Tester::describe('$name Tests',";

		foreach ($matches[1] as $method)
		{
			$fname = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', ltrim($method, '_')))));
			
			$should = trim(str_replace('_', ' ', $method));

			// Detect a static or dynamic method
			$method_prefix = '$' . $lower_case_name . '->';
			if (in_array($method, $static_methods))
				$method_prefix = $name . '::';

			$functions[$fname] = $method_prefix . $method;

			$test_code .= "
	Tester::describe('$method',
	    Tester::it('should $should.',
	    	Tester::func('$fname'),
	    	''
	    ).
	    Tester::it('should ',
	    	Tester::func('$fname'),
	    	''
	    ).
	    Tester::it('should ',
	    	Tester::func('$fname'),
	    	''
	    )
	).";
		}

		$test_code = rtrim($test_code, '.') . ",
	true
);

/* Functions to return values for the test inputs */

function construct()
{
	\$$lower_case_name = new $name();
}
";

		foreach($functions as $fname => $method)
		{
			if ('construct' != $fname)
				$test_code .= "
function $fname()
{
	\$$lower_case_name = new $name();

	\$result = $method();

	return \$result;
}
";
		}

		file_put_contents(SPEC_PATH . $spec_fn, $test_code);
		echo "$spec_fn\n";
	}
}

echo "\n<tt>Done";
