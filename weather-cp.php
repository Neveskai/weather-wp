<?php
/**
 * Plugin Name: WeatherCP
 * Plugin URI: https://boacomunicacao.net/
 * Description: Plugin de Indices Climaticos
 * Version: 1.0.0
 * Author: Wendell S. Neves
 * Author URI: https://boacomunicacao.net/
 */

define('whs_plugin_bname', plugin_basename(__FILE__));
include 'config-database.php';
include 'src/WeatherCP.php';
include 'config-page.php';