<?php
/*
Plugin Name: 	Plugin 01
Plugin URI: 	https://sakhawat.vercel.app
Description: 	Plugin 01.
Author: 		SH Shakib
Version: 		1.0.0
Author URI: 	https://sakhawat.vercel.app
Requirements:   PHP 5.4 or above, WordPress 5.0 or above.
License:        GPL-2.0+
Text Domain:    plugin-01
Domain Path:    /languages
*/

add_action('plugin_loaded', function() {
    load_plugin_textdomain('new-plugin', false, dirname(__FILE__)."/language");
});

function new_features($content) {

    $strip = strip_tags($content);
    $wordc = str_word_count($strip);

    $wordc = 1000;

    $read_min = floor($wordc / 200);
    $read_se = floor($wordc % 200 / (200 / 60));

    $tag = apply_filters('new_plugin_tags', 'h3');
    $label = apply_filters('new_plugin_label', 'Reading Time');

    $post_type = get_post_type(get_the_ID());

    $post_type_filter = apply_filters('post_type_change', array());
    if(in_array($post_type, $post_type_filter)) {
        return $content;
    }
    
    $content .= sprintf('<%s>%s: min: %s Second: %s </%s>', $tag, $label, $read_min, $read_se, $tag);
    return $content;
}
add_filter('the_content', 'new_features');


?>