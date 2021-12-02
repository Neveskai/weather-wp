<?php
/**
 * Plugin Name: WeatherCP
 * Plugin URI: https://boacomunicacao.net/
 * Description: Plugin de Indices Climaticos
 * Version: 1.0.0
 * Author: Wendell S. Neves
 * Author URI: https://boacomunicacao.net/
 */
 
date_default_timezone_set('America/Sao_Paulo');
define('whs_plugin_bname', plugin_basename(__FILE__));
include 'config-database.php';
include 'config-page.php';
include 'src/WeatherCP.php';

register_activation_hook(__FILE__, 'weather_db_check');