<?php
	define('SHORTINIT', true);
	require('../../../../../wp-load.php');
	global $wpdb;
	
	$api = 'https://api.openweathermap.org/data/2.5/weather';
	$key = '81a5506dd6a5b5da93a9f33e3dfc4afd';
	
	$cities = $wpdb->get_results("SELECT idCity as id, Name as name FROM wpCities", ARRAY_A);
	foreach($cities as $city) {
		$args = array(
			'appid' => $key,
			'units' => 'metric',
			'q' => $city['name']
		);
		$opts = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $api .'?'. http_build_query($args)
		);
		
		$ch = curl_init(); 			curl_setopt_array($ch, $opts);
		$resp = curl_exec($ch);		curl_close($ch);
		$json = json_decode($resp, true);
		$wpdb->insert('wpWeather',  array(
			'wpCities_idCity' => $city['id'],
			'description' => $json['weather'][0]['description'],
			'temp' => $json['main']['temp'],
			'date' => gmdate('Y-m-d H:i:s', $json['dt'])
		));
		print("<pre>".print_r($json,true)."</pre>");
	}
?>