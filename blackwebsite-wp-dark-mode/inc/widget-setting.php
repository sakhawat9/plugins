<?php 
register_setting(
    'blackwebsite_widget_options_group', // Option group
    'blackwebsite_widget_options', // Option name
    array( $this, 'sanitize' ) // Sanitize
);
add_settings_section(
    'blackwebsite_widget_section', // ID
    __('Widget Settings','blackwebsite'), // Title
    array( $this, 'blackwebsite_print_main_section_info' ), // Callback
    'blackwebsite_settings_widget_admin_page' // Page
);

add_settings_field(
    'blackwebsite_button_dark',
    __('Button Dark','blackwebsite'),
    array( $this, 'blackwebsite_button_dark_callback' ),
    'blackwebsite_settings_widget_admin_page',
    'blackwebsite_widget_section'
);
add_settings_field(
    'blackwebsite_button_light',
    __('Button Light','blackwebsite'),
    array( $this, 'blackwebsite_button_light_callback' ),
    'blackwebsite_settings_widget_admin_page',
    'blackwebsite_widget_section'
);
add_settings_field(
    'blackwebsite_button_size',
    __('Button Size','blackwebsite'),
    array( $this, 'blackwebsite_button_size_callback' ),
    'blackwebsite_settings_widget_admin_page',
    'blackwebsite_widget_section'
);
add_settings_field(
    'blackwebsite_icon_size',
    __('Icon Size','blackwebsite'),
    array( $this, 'blackwebsite_icon_size_callback' ),
    'blackwebsite_settings_widget_admin_page',
    'blackwebsite_widget_section'
);