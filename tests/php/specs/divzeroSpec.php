<?php

include '../before.php';

Tester::describe('Divide by Zero Error Example',
	Tester::describe('Do Math',
	    Tester::it('should do math.',
	    	Tester::func('doMath'),
	    	4
	    )
	),
	true
);

/* Functions to return values for the test inputs */

function doMath()
{
	$x = 1;
	return $x/0;
}
