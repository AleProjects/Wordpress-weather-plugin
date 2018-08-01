<?php
/**
 * Date: 31/07/2018
 * Time: 11:19
 */

namespace Weather\widget;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Weather\utility\Weather;

class WeatherWidget extends \WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'WeatherWidget',
            'description' => 'The weather widget',
        );
        parent::__construct( 'weather_widget', 'Weather', $widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $weather = get_option('weather', ['location' => 'milano, it']);
        $location = $weather['location'];

        $data = (new Weather($location))->getRequest();

        $location = $data['query']['results']['channel']['location'];
        $forecast = $data['query']['results']['channel']['item']['forecast'];
        $todayForecast = $forecast[0];

        echo 'Today the weather in ' . $location['city'] . ' (' . $location['country'] . ') is ' . $todayForecast['text'] . '.';
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
    }
}