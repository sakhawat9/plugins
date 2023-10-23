<?php
register_setting(
    'blackwebsite_main_options_group', // Option group
    'blackwebsite_options', // Option name
    array( $this, 'sanitize' ) // Sanitize
);

add_settings_section(
    'blackwebsite_main_section', // ID
    'Custom Position', // Title
    array( $this, 'blackwebsite_print_main_section_info' ), // Callback
    'blackwebsite_settings_admin_page' // Page
);


add_settings_field(
    'blackwebsite_bottom', // ID
    __( 'Bottom Position', 'blackwebsite' ),// Title
    array( $this, 'blackwebsite_bottom_callback' ), // Callback
    'blackwebsite_settings_admin_page', // Page
    'blackwebsite_main_section' // Section
);

add_settings_field(
    'blackwebsite_right',
    __('Right Position','blackwebsite'),
    array( $this, 'blackwebsite_right_callback' ),
    'blackwebsite_settings_admin_page',
    'blackwebsite_main_section'
);

add_settings_field(
    'blackwebsite_left',
    __('Left Position','blackwebsite'),
    array( $this, 'blackwebsite_left_callback' ),
    'blackwebsite_settings_admin_page',
    'blackwebsite_main_section'
);

add_settings_field(
    'blackwebsite_only_posts',
    'Show in posts only',
    array( $this, 'blackwebsite_only_posts_callback' ),
    'blackwebsite_settings_admin_page',
    'blackwebsite_main_section'
);

add_settings_field(
    'blackwebsite_time',
    'Time',
    array( $this, 'blackwebsite_time_callback' ),
    'blackwebsite_settings_admin_page',
    'blackwebsite_main_section'
);