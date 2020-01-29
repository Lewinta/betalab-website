<?php
	class FrappeClient {
		private $username;
		private $password;
		private $server_address;

		public function __construct($username, $password, $server_address) {
			$this->username = $username;
			$this->password = $password;
			$this->server_address = $server_address;
			$this->init();
		}

		public function init() {
			$this->request = curl_init("$this->server_address/api/method/login");
			$this->setup_opts();	
		}

		public function setup_opts() {
			curl_setopt($this->request, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36");
			curl_setopt($this->request, CURLOPT_POST, true);
			curl_setopt($this->request, CURLOPT_POSTFIELDS, "usr=$this->username&pwd=$this->password");
			curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->request, CURLOPT_COOKIESESSION, true);
			curl_setopt($this->request, CURLOPT_COOKIEJAR, "frappe-cookie");  //could be empty, but cause problems on some hosts
			curl_setopt($this->request, CURLOPT_COOKIEFILE, "/var/www/ip4.x/file/tmp");  //could be empty, but cause problems on some hosts
		}

		public get($resource, $params=array("docstatus": array("!=" => "2"))) {
			$filters = json_encode($params);

			$options = http_build_query(array("filters" => $filters));

			curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($this->request, CURLOPT_URL, "$this->server_address/$resource?$options");
			return curl_exec($this-request);
		}

		public function get_value($doctype, $filters=null, $fields=null) {
			return $this->get(
				array("api/method/frappe.client.get_value", 
					"doctype" => $doctype, 
					"params" =>	array(
						array("filters" => $filters), 
						array("fields" => $fields)
					)
				)
			);
		}
	}