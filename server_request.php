<?php
	header("Content-Type: application/json");

	$paciente = $_GET["paciente"];
	$from_date = $_GET["from_date"];
	$to_date = $_GET["to_date"];
	$doctor = $_GET["doctor"];

	$base_string = "cd /var/www/html/frappe && python result_list.py";

	if ($paciente) {
		$base_string .= " --patient=$paciente";
	}

	if ($from_date) {
		$base_string .= " --from_date=$from_date";
	}

	if ($to_date) {
		$base_string .= " --to_date=$to_date";
	}

	if ($doctor) {
		$base_string .= " --doctor=$doctor";
	}

	$response = exec($base_string);

	if ($response != "None") {
		echo ($response);
	} else {
		header("Content-Type: text/html");
		echo ("<h1>No matches</h1>");
	}
