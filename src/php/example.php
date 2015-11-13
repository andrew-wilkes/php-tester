<?php

class Example
{
	public function __construct()
	{
	}

	public function square($x)
	{
		return $x * $x;
	}

	public static function add_two($x)
	{
		return $x + 2;
	}

	public static function positive($x)
	{
		return $x >= 0;
	}
}
