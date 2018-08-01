<?php
/*
    Plugin Name: Weather plugin
    Plugin URI:
    description: It creates a widget that add the weather to your wordpress website
    Version: 1.1
    Author: Alessandro Battaglia
    Author URI:
    License: GPL2
    Date: 31/07/2018
    Time: 12:09
*/

require __DIR__ . '/vendor/autoload.php';

$weather = new Weather\Weather("Weather plugin");
$weather->init();

?>