<?php class WeatherCP {
	public function __construct(){
		add_shortcode('weatherCP', array($this, 'widget'));
	}
	
	function read_file($city){
		$file = fopen("../wp-content/plugins/weather-wp/cities/{$city}.json", "r");
		$resp = fread($file, filesize("../wp-content/plugins/weather-wp/cities/{$city}.json"));
		fclose($file);
		return $resp;
	}
	
	function get_star(){
		$hour = intval(date('H'));
		if($hour >= 6 && $hour < 17) return 'sun';
		return 'moon';
	}
	
	function get_icon($desc){
		$star = $this->get_star();
		switch($desc){
			case 'clear sky' 			: $icon = "fa-{$star}"; 				break;
			case 'few clouds'			: $icon = "fa-cloud-{$star}"; 		break;
			case 'broken clouds'		: $icon = "fa-cloud-{$star}"; 		break;
			case 'scattered clouds'	: $icon = "fa-cloud"; 					break;
			case 'shower rain'		: $icon = "fa-cloud-{$star}-rain"; 	break;
			case 'rain'					: $icon = "fa-cloud-showers-heavy"; break;
			case 'thunderstorm'		: $icon = "fa-bolt"; 					break;
			case 'mist'					: $icon = "fa-smog"; 					break;
			case 'snow'					: $icon = "fa-snowflake";				break;
		}
		return $icon;
	}
	
	function get_data($unit, $json){
		switch($unit){
			case 'temp'	: $data = round($json['main']['temp']); 	break;
			default 		: $data = 'unit undefined'; 					break;
		}
		return $data;
	}
	
	function widget($args) {
		$city = isset($args['city']) ? $args['city'] : 'aracaju';
		$unit = isset($args['unit']) ? $args['unit'] : 'temp';
		$json = json_decode($this->read_file($city), true);
		
		$icon = $this->get_icon($json['weather'][0]['description']);
		$data = $this->get_data($unit, $json);
		return "<i class='fa {$icon}'>{$data}</i>";
	}
	
}
$WeatherCP = new WeatherCP();
?>