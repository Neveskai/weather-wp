<?php
global $weather_db_version;
$weather_db_version = '1.0.1';

function weather_db_install() {
	global $wpdb;
	global $weather_db_version;

	$sql = "
		CREATE TABLE wpCities (
			idCity INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			Name VARCHAR(50) NULL,
			PRIMARY KEY(idCity)
		);

		CREATE TABLE wpWeather (
			idWeather INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
			wpCities_idCity INTEGER UNSIGNED NOT NULL,
			temp FLOAT NULL,
			description VARCHAR(50) NULL,
			PRIMARY KEY(idWeather),
			INDEX Weather_FKIndex1(wpCities_idCity)
		);
	";
	
	require_once(ABSPATH .'/wp-admin/includes/upgrade.php');
	dbDelta($sql);
	add_option('weather_db_version', $weather_db_version);
}

function weather_db_check() {
   global $weather_db_version;
   if (get_site_option('weather_db_version') != $weather_db_version) { weather_db_install(); }
}

?>