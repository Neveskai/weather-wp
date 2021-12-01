<?php class WeatherCP {
	protected $wpdb;
	
	public function __construct($PDO = null){
		global $wpdb; 
		$this->wpdb =& $wpdb;
		add_shortcode('weatherCP', array($this, 'widget'));
	}
	
	//$wpdb->get_results($query);
	function get_city($city){
		$weather = $this->wpdb->get_row("
			SELECT
				W.temp as temp,
				W.description as description,
				C.Name as name
			FROM wpCities AS C
			JOIN wpWeather AS W ON W.wpCities_idCity = C.idCity 
			WHERE 
				C.Name = '$city'
		", ARRAY_A);
		return $weather;
	}
	
	function get_star(){
		$hour = intval(date('H'));
		if($hour >= 6 && $hour < 17) return 'sun';
		return 'moon';
	}
	
	function get_icon($desc){
		$star = $this->get_star();
		switch($desc){
			case 'clear sky' 		: $icon = "fa-{$star}"; 			break;
			case 'few clouds'		: $icon = "fa-cloud-{$star}"; 		break;
			case 'broken clouds'	: $icon = "fa-cloud-{$star}"; 		break;
			case 'scattered clouds'	: $icon = "fa-cloud"; 				break;
			case 'shower rain'		: $icon = "fa-cloud-{$star}-rain"; 	break;
			case 'rain'				: $icon = "fa-cloud-showers-heavy"; break;
			case 'thunderstorm'		: $icon = "fa-bolt"; 				break;
			case 'mist'				: $icon = "fa-smog"; 				break;
			case 'snow'				: $icon = "fa-snowflake";			break;
		}
		return $icon;
	}
	
	function get_data($unit, $weather){
		switch($unit){
			case 'temp'	: $data = round($weather['temp']); break;
			default 	: $data = 'unit undefined'; break;
		}
		return $data;
	}
	
	function widget($args) {
		$city = isset($args['city']) ? $args['city'] : 'aracaju';
		$unit = isset($args['unit']) ? $args['unit'] : 'temp';
		$weather = json_decode($this->get_city($city), true);
		
		$icon = $this->get_icon($weather['description']);
		$data = $this->get_data($unit, $weather);
		return $this->layout($icon, $data);
	}
	
	function layout($icon, $data) {
		return "
			<div class='weather-widget'>
				<i class='fa {$icon}'></i>
				<span>{$data}</span>
			</div>
		";
	}
	
}
$WeatherCP = new WeatherCP();
?>