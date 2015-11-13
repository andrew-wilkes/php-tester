<?php

include '../before.php';

Tester::describe('Syntax Error Example',
	Tester::describe('hello',
	    Tester::it('should say hello.',
	    	Tester::func('sayHello'),
	    	'hello'
	    )
	),
	true
);

/* Functions to return values for the test inputs */

function sayHello()
{
	return // incomplete statement
}
