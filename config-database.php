<?php
global $weather_db_version;
$weather_db_version = '1.0.3';

function weather_db_install() {
	global $wpdb;
	global $weather_db_version;

	$sql = "
		CREATE TABLE wpCities (
			idCity INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			Name VARCHAR(50) NULL,
			active TINYINT(1) UNSIGNED NULL,
			PRIMARY KEY(idCity)
		);

		CREATE TABLE wpWeather (
			idWeather INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			wpCities_idCity INTEGER UNSIGNED NOT NULL,
			temp FLOAT NULL,
			description VARCHAR(50) NULL,
			date TIMESTAMP NULL,
			PRIMARY KEY(idWeather),
			INDEX Weather_FKIndex1(wpCities_idCity)
		);
	";
	
	require_once(ABSPATH .'/wp-admin/includes/upgrade.php');
	dbDelta($sql);
	add_option('weather_db_version', $weather_db_version);
	add_weather_initial_data();
}

function add_weather_initial_data(){
	global $wpdb;
	
	$city = array(
		idCity => 1,
		Name => 'aracaju',
	);
	$weather = array(
		wpCities_idCity => 1,
		description => 'clear sky',
		idWeather => 1,
		temp => 27
	);
	$wpdb->insert('wpCities', $city);
	$wpdb->insert('wpWeather', $weather);
}

function weather_db_check() {
   global $weather_db_version;
   if (get_site_option('weather_db_version') != $weather_db_version) weather_db_install();
}
?>