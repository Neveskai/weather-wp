<?php class Weather_CP {
	protected $wpdb;
	
	public function __construct(){
		global $wpdb; 
		$this->wpdb =& $wpdb;
	}
	
	function _main($args) {
		date_default_timezone_set('America/Sao_Paulo');
		$city = isset($args['city']) ? $args['city'] : 'aracaju';
		$unit = isset($args['unit']) ? $args['unit'] : 'temp';
		$arr  = $this->getCity($city);
		
		if($arr == null) {
			$json = $this->fetchCityWeather($city);
			if(!$json) return $this->widget('', 'cidade não encontrada');
			$arr = $this->insertCity($city, $json);
		} else {
			$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($arr['time']);
			if($diff >= 1800) {
				$json = $this->fetchCityWeather($city);
				$this->insertCityWeather($json, $arr['id']);
				$arr['description'] = $json['weather'][0]['description'];
				$arr['temp'] = $json['main']['temp'];
				$arr['hour'] = date('H');
			}
		}
		return $this->widget(
			$this->weatherIcon($arr['description'], $arr['hour']), 
			$arr[$unit]
		);
	}
	
	// Class City
	function getCity($city){
		$arr = $this->wpdb->get_row("
			SELECT
				C.idCity as id,
				W.temp as temp,
				W.description as description,
				C.Name as name,
				EXTRACT(HOUR FROM W.date) as hour,
				W.date as time
			FROM wpCities AS C
			JOIN wpWeather AS W ON W.wpCities_idCity = C.idCity 
			WHERE 
				C.Name = '$city'
			ORDER BY W.idWeather DESC 
			LIMIT 1
		", ARRAY_A );
		return $arr;
	}
	
	function insertCity($city, $json){
		$this->wpdb->insert('wpCities', array(
			Name => $city
		));
		$id = $this->wpdb->insert_id;
		$this->insertCityWeather($json, $id);
		return $this->getCity($city);
	}
	// Class City
	
	function fetchCityWeather($city){
		$api = 'https://api.openweathermap.org/data/2.5/weather';
		$key = '81a5506dd6a5b5da93a9f33e3dfc4afd';
		
		$args = array(
			'appid' => $key,
			'units' => 'metric',
			'q' => $city
		);
		$opts = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $api .'?'. http_build_query($args)
		);
		
		$ch = curl_init(); 			curl_setopt_array($ch, $opts);
		$resp = curl_exec($ch);		curl_close($ch);
		$json = json_decode($resp, true);
		if($json['cod'] == '404') return false;
		return $json;
	}
	
	function insertCityWeather($json, $cityID){
		date_default_timezone_set('America/Sao_Paulo');
		$this->wpdb->insert('wpWeather', array(
			'wpCities_idCity' => $cityID,
			'description' => $json['weather'][0]['description'],
			'temp' => $json['main']['temp'],
			'date' => date('Y-m-d H:i:s')
		));
	}
	
	function weatherIcon($desc, $hour){
		$star = 'moon'; if($hour >= 6 && $hour < 18) $star = 'sun';
		switch($desc){
			case 'clear sky' 		: $icon = "fa-{$star}"; 				break;
			case 'few clouds'		: $icon = "fa-cloud-{$star}"; 		break;
			case 'broken clouds'	: $icon = "fa-cloud-{$star}"; 		break;
			case 'scattered clouds': $icon = "fa-cloud-{$star}"; 		break;
			case 'shower rain'	: $icon = "fa-cloud-{$star}-rain"; 	break;
			case 'rain'				: $icon = "fa-cloud-showers-heavy"; break;
			case 'thunderstorm'	: $icon = "fa-bolt"; 					break;
			case 'mist'				: $icon = "fa-smog"; 					break;
			case 'snow'				: $icon = "fa-snowflake";				break;
		}
		return $icon;
	}
	
	function widget($icon, $data) {
		$data = round($data);
		return "
			<div class='weather-widget'>
				<i class='fa {$icon}'></i>
				<span>{$data}<sup>o</sup></span>
			</div>
		";
	}
	
}
$WeatherCP = new Weather_CP();
?>