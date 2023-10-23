<?php 
register_setting(
    'blackwebsite_predefine_options_group', // Option group
    'blackwebsite_predefine_options', // Option name
    array( $this, 'sanitize' ) // Sanitize
);

add_settings_section(
    'blackwebsite_predefine_section', // ID
    __('Pre-Defined Positions','blackwebsite'), // Title
    array( $this, 'blackwebsite_print_positions_section_info' ), // Callback
    'blackwebsite_predefine_admin_page' // Page
);

add_settings_field(
    'blackwebsite_left_bottom',
    __('Bottom Left','blackwebsite'),
    array( $this, 'blackwebsite_left_bottom_callback' ),
    'blackwebsite_predefine_admin_page',
    'blackwebsite_predefine_section'
);
add_settings_field(
    'blackwebsite_right_bottom',
    __('Bottom Right','blackwebsite'),
    array( $this, 'blackwebsite_right_bottom_callback' ),
    'blackwebsite_predefine_admin_page',
    'blackwebsite_predefine_section'
);