<?php
/**
 * Date: 01/08/2018
 * Time: 08:32
 */

namespace Weather;

class SettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Weather settings',
            'Weather settings',
            'manage_options',
            'weather-setting',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'weather' );
        ?>
        <div class="wrap">
            <h1>Weather settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'weather_option_group' );
                do_settings_sections( 'weather-setting' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'weather_option_group', // Option group
            'weather', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'weather_setting_section_location_id', // ID
            'Weather location', // Title
            array( $this, 'print_section_info' ), // Callback
            'weather-setting' // Page
        );

        add_settings_field(
            'location', // ID
            'Location', // Title
            array( $this, 'location_callback' ), // Callback
            'weather-setting', // Page
            'weather_setting_section_location_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     *
     * @return array
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['location'] ) )
            $new_input['location'] = sanitize_text_field( $input['location'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function location_callback()
    {
        printf(
            '<input type="text" id="location" name="weather[location]" value="%s" />',
            isset( $this->options['location'] ) ? esc_attr( $this->options['location']) : ''
        );
    }
}