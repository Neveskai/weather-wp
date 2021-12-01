<?php
	$api = 'https://api.openweathermap.org/data/2.5/weather';
	$key = '81a5506dd6a5b5da93a9f33e3dfc4afd';
	$cities = ['aracaju'];
	
	foreach($cities as $city) {
		$args = array(
			appid => $key,
			units => 'metric',
			q => $city
		);
		$opts = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $api .'?'. http_build_query($args)
		);
		
		$ch = curl_init(); 			curl_setopt_array($ch, $opts);
		$resp = curl_exec($ch);		curl_close($ch);
		$file = fopen("../cities/{$city}.json", "w");
		fwrite($file, $resp);
		fclose($file);
		echo $resp;
	}
?>