<?php
	//initial request with login data

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://app.laboratoriobetalab.com/api/method/login');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "usr=Administrator&pwd=P@ssword2017");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'frappe-cookie');  //could be empty, but cause problems on some hosts
	curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //could be empty, but cause problems on some hosts

	$answer = curl_exec($ch);

	if (curl_error($ch)) {
		echo curl_error($ch);
	}

	//another request preserving the session

	$filters = json_encode(array('module' => 'Consultas'));
	// check if $filters invalid
	$data = array(
		'doctype' => 'DocType', 
		'filters' => $filters, 
		'fields' => 'name', 
		'limit_page_length' => 0
	);

	$q = http_build_query($data);

	curl_setopt($ch, CURLOPT_URL, 'http://app.laboratoriobetalab.com/api/method/frappe.client.get_list?' . $q);
	curl_setopt($ch, CURLOPT_POST, false);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, "");

	$answer = curl_exec($ch);

	if (curl_error($ch)) {
		echo curl_error($ch);
	}

	echo $answer;