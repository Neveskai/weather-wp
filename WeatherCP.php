<?php class WeatherCP {
	public function __construct(){
		add_shortcode('weatherCP-temp', array($this, 'temp_widget'));
	}
	
	function read_file($city){
		$file = fopen("../wp-content/plugins/weather-wp/cities/{$city}.json", "r");
		$resp = fread($file, filesize("../wp-content/plugins/weather-wp/cities/{$city}.json"));
		fclose($file);
		return $resp;
	}
	
	function temp_widget($city) {
		$city = isset($attr['city']) ? $attr['city'] : 'aracaju';
		$json = json_decode($this->read_file($city), true);
		return round($json['main']['temp']);
	}
}
$WeatherCP = new WeatherCP();
?>