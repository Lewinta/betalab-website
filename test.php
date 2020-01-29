<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	class Fruit {
		private $fruit_name;

		function __construct($fruit_name) {
			$this->fruit_name = $fruit_name;
		}

		function print_fruit_name() {
			echo "$this->fruit_name";
		}
	}

	$obj = new Fruit("Apple");
	$obj->print_fruit_name();