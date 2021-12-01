<?php class WeatherCP {
	protected $wpdb;
	
	public function __construct(){
		global $wpdb; 
		$this->wpdb =& $wpdb;
		add_shortcode('weatherCP', array($this, 'widget'));
	}
	
	function get_city($city){
		$wpdb = $this->wpdb;
		$arr = $wpdb->get_row("
			SELECT
				W.temp as temp,
				W.description as description,
				C.Name as name,
				EXTRACT(HOUR FROM W.date) as hour
			FROM wpCities AS C
			JOIN wpWeather AS W ON W.wpCities_idCity = C.idCity 
			WHERE 
				C.Name = '$city'
			ORDER BY W.idWeather DESC 
			LIMIT 1
		", ARRAY_A );
		return $arr;
	}
	
	function get_star($hour){
		if($hour >= 6 && $hour < 18) return 'sun';
		return 'moon';
	}
	
	function get_icon($desc, $star){
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
		
	function widget($args) {
		$city = isset($args['city']) ? $args['city'] : 'aracaju';
		$unit = isset($args['unit']) ? $args['unit'] : 'temp';
		$arr  = $this->get_city($city);
		
		return $this->layout(
			$this->get_icon($arr['description'], $this->get_star($json['hour'])), 
			$arr[$unit]
		);
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