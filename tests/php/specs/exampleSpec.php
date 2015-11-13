<?php

include '../before.php';

include '../../../src/php/example.php';

Tester::describe('Example Tests',
	Tester::describe('__construct',
	    Tester::it('should construct.',
	    	Tester::func('construct'),
	    	''
	    )
	).
	Tester::describe('square',
	    Tester::it('should square a number.',
	    	Tester::func('square'),
	    	4
	    )
	).
	Tester::describe('add_two',
	    Tester::it('should add two to a number.',
	    	Tester::func('addTwo'),
	    	5
	    )
	).
	Tester::describe('positive',
	    Tester::it('should detect a positive number.',
	    	Tester::func('positive'),
	    	true
	    ).
		Tester::it('should detect a negative number.',
	    	Tester::func('negative'),
	    	'true' // Demonstrate a failure
	    )
	),
	true
);

/* Functions to return values for the test inputs */

function construct()
{
	$example = new Example();
}

function square()
{
	$example = new Example();

	return $example->square(2);
}

function addTwo()
{
	return Example::add_two(3);
}

function positive()
{
	return Example::positive(6);
}

function negative()
{
	return Tester::bool_to_string(Example::positive(-1));
}
