<?php

class VivenioIntegrationSettingsPage
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
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_options_page(
            'Vivenio Einstellungen',
            'Vivenio',
            'manage_options',
            'vivenio-settings',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('vivenio_option_name');
        ?>
        <div class="wrap">
            <h1>Vivenio Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('vivenio_option_group');
                do_settings_sections('vivenio-setting-admin');
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
            'vivenio_option_group', // Option group
            'vivenio_option_name', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Vivenio Einstellungen', // Title
            array($this, 'print_section_info'), // Callback
            'vivenio-setting-admin' // Page
        );

        add_settings_field(
            'eventBaseUrl',
            'Event Base Url',
            array($this, 'eventBaseUrl_callback'),
            'vivenio-setting-admin',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();

        if (isset($input['eventBaseUrl']))
            $new_input['eventBaseUrl'] = sanitize_text_field($input['eventBaseUrl']);

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Hier können Sie die Einstellungen für Vivenio festlegen:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function eventBaseUrl_callback()
    {
        printf(
            '<input type="url" id="eventBaseUrl" name="vivenio_option_name[eventBaseUrl]" value="%s" />',
            isset($this->options['eventBaseUrl']) ? esc_attr($this->options['eventBaseUrl']) : ''
        );
    }
}

if (is_admin()) {
    $vivenio_integration_settings_page = new VivenioIntegrationSettingsPage();
}