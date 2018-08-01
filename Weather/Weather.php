<?php
/**
 * Date: 23/07/2018
 * Time: 17:10
 */

namespace Weather;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Weather
{
    private $options;

    public function __construct($name = "")
    {
        $this->options = [
            'base_dir' => __DIR__,
            'name' => $name
        ];
    }

    /**
     * @return Weather
     */
    public function init()
    {
        add_action( 'widgets_init', function(){
            register_widget( 'Weather\widget\WeatherWidget' );
        });

        if( is_admin() )
            $settings_page = new SettingsPage();

        return $this;
    }
}