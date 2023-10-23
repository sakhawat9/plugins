<?php
 register_setting(
    'blackwebsite_extra_options_group', // Option group
    'blackwebsite_extra_options', // Option name
    array( $this, 'sanitize' ) // Sanitize
);

add_settings_section(
    'blackwebsite_extras_section', // ID
    __('Extra Settings','blackwebsite'), // Title
    array( $this, 'blackwebsite_print_extra_settings' ), // Callback
    'blackwebsite_extra_admin_page' // Page
);

add_settings_field(
    'blackwebsite_cookies',
    __('Want to create a cookie?','blackwebsite'),
    array( $this, 'blackwebsite_cookies_callback' ),
    'blackwebsite_extra_admin_page',
    'blackwebsite_extras_section'
);
add_settings_field(
    'blackwebsite_match_os',
    __('Want to match the OS mode?','blackwebsite'),
    array( $this, 'blackwebsite_match_os_callback' ),
    'blackwebsite_extra_admin_page',
    'blackwebsite_extras_section'
);
add_settings_field(
    'blackwebsite_toggle',
    __('Want to use your own toggle widget or button?','blackwebsite'),
    array( $this, 'blackwebsite_toggle_callback' ),
    'blackwebsite_extra_admin_page',
    'blackwebsite_extras_section'
);