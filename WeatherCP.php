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
	
	function widget($args) {
		$city = isset($args['city']) ? $args['city'] : 'aracaju';
		$unit = isset($args['unit']) ? $args['unit'] : 'temp';
		$json = json_decode($this->read_file($city), true);
		
		switch($unit){
			case 'temp': return round($json['main']['temp']); break;
		}
		return 'unit undefined';
	}
}
$WeatherCP = new WeatherCP();
?>