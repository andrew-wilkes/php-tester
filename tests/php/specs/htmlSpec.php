<?php

include '../before.php';

Tester::describe('Capture HTML Example',
	Tester::describe('Do HTML',
	    Tester::it('should output code.',
	    	Tester::func('html'),
	    	'Some text'
	    )
	),
	true
);

/* Functions to return values for the test inputs */

function html()
{
	echo "<p>Some text</p>";
}
