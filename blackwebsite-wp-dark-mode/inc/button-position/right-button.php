<?php 
$blackwebsite_custom_js = "
var options = {
    bottom: '{$blackwebsite_bottom}', // default: '32px'
    right: '{$blackwebsite_right}', // default: '32px'
    left: 'unset', // default: 'unset'
    time: '{$blackwebsite_time}', // default: '0.3s'
    buttonColorDark: '{$blackwebsite_widget_options['blackwebsite_button_dark']}',  // default: '#100f2c'
    buttonColorLight: '{$blackwebsite_widget_options['blackwebsite_button_light']}', // default: '#fff'
    saveInCookies: {$blackwebsite_cookies}, // default: true
    autoMatchOsTheme: {$blackwebsite_match_os}, // default: true
    label: '🌓', // default: ''
}
 {$blackwebsite_toggle}
 ";
$blackwebsite_layer_css = "
.darkmode-layer--button{
    bottom: '{$blackwebsite_bottom}',
    right: '{$blackwebsite_right}',
    left: 'unset'
}
";