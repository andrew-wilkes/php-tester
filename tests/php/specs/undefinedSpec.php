<?php

include '../before.php';

Tester::describe('Undefined Variable Example',
	Tester::describe('__construct',
	    Tester::it('should construct.',
	    	Tester::func('construct'),
	    	''
	    )
	).
	Tester::describe('hello',
	    Tester::it('should say hello.',
	    	Tester::func('sayHello'),
	    	'hello'
	    )
	),
	true
);

/* Functions to return values for the test inputs */

function construct()
{
	return $unknown_var;
}

function sayHello()
{
	return 'hello';
}
