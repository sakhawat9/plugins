<?php
/*
Plugin Name: BlackWebsite Wp Dark Mode
description: wp dark mode control
Version: 1.0.0
Author: SH Shakib
Author URI: https://sakhawat.vercel.app/
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:blackwebsite
Domain Path:/language
*/

// Version constant
if (!defined('BLACKWEBSITE_VERSION')) {
    define('BLACKWEBSITE_VERSION', '1.0.1');
}

// Plugin dir path constant
if (!defined('BLACKWEBSITE_DIR_PATH')) {
    define('BLACKWEBSITE_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));
}

class BlackWebsiteSetting {

    public function __construct() {
        add_action('plugins_loaded', array($this, 'blackwebsite_load_textdomian'));

        add_action('admin_menu', array($this, 'blackwebsite_setting_page'));

        add_action('admin_init', array($this, 'blackwebsite_init_page'));
        add_action('activated_plugin', array($this, 'activated_plugin'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_link'));

        add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
    }


    public function blackwebsite_load_textdomian() {
        load_plugin_textdomain('blackwebsite', false, dirname(__FILE__) . "/language");
    }

    public function activated_plugin($plugin) {
        if (plugin_basename(__FILE__) == $plugin) {
            wp_redirect(admin_url('admin.php?page=blackwebsite_admin_setting_page&tab=custom_position'));
            die();
        }
    }

    public function plugin_action_link($link) {
        $setting = sprintf("<a href='%s'>%s</a>", admin_url('admin.php?page=blackwebsite_admin_setting_page&tab=custom_position'), __('Settings', 'blackwebsite'));
        array_push($link, $setting);
        return $link;
    }

    public function plugin_row_meta($link, $plugin) {
        if (plugin_basename(__FILE__) == $plugin) {
            $setting = sprintf("<a href='%s'>%s</a>", esc_url('https://github.com'), __('Git Rep', 'blackwebsite'));
            array_push($link, $setting);
        }

        return $link;
    }

    public function blackwebsite_setting_page() {
        add_menu_page(
            __('BlackWebsite', 'blackwebsite'),
            __('BlackWebsite', 'blackwebsite'),
            'manage_options',
            'blackwebsite_admin_setting_page',
            array($this, 'blackwebsite_admin_page'),
        );
    }

    public function blackwebsite_admin_page() {
        //echo "Setting Page";
        $this->options = get_option('blackwebsite_options');
        $this->widgetOption = get_option('blackwebsite_widget_options');
        $this->predefineOption = get_option('blackwebsite_predefine_options');
        $this->extraOption = get_option('blackwebsite_extra_options');
?>        

        <div class="wrap blackwebsite-wrap">
            <div id="icon-themes" class="icon32"></div>
            <h2>BlackWebsite Setting</h2>
            <?php settings_errors(); ?>
            <?php
            $active_tab = '';
            if (isset($_GET['tab'])) {
                $active_tab = $_GET['tab'];
            } // end if
            ?>
            <h2 class="nav-tab-wrapper blackwebsite-admin-setting">
                <a href="?page=blackwebsite_admin_setting_page&tab=custom_position" class="nav-tab <?php echo $active_tab == 'custom_position' ? 'nav-tab-active' : ''; ?>">Custom Position</a>

                <a href="?page=blackwebsite_admin_setting_page&tab=pre_defined_positions" class="nav-tab <?php echo $active_tab == 'pre_defined_positions' ? 'nav-tab-active' : ''; ?>">Pre-Defined Positions</a>

                <a href="?page=blackwebsite_admin_setting_page&tab=widget_settings" class="nav-tab <?php echo $active_tab == 'widget_settings' ? 'nav-tab-active' : ''; ?>">Widget Settings</a>

                <a href="?page=blackwebsite_admin_setting_page&tab=extra_settings" class="nav-tab <?php echo $active_tab == 'extra_settings' ? 'nav-tab-active' : ''; ?>">Extra Settings</a>
            </h2>

            <form method="post" action="options.php" class="blackwebsite-form">
                <?php
                if ($active_tab == 'custom_position') {
                    settings_fields('blackwebsite_main_options_group');
                    do_settings_sections('blackwebsite_settings_admin_page');
                    submit_button();
                } elseif ($active_tab == 'pre_defined_positions') {
                    settings_fields('blackwebsite_predefine_options_group');
                    do_settings_sections('blackwebsite_predefine_admin_page');
                    submit_button();
                } elseif ($active_tab == 'widget_settings') {
                    settings_fields('blackwebsite_widget_options_group');
                    do_settings_sections('blackwebsite_settings_widget_admin_page');
                    submit_button('Setting Submit');
                } elseif ($active_tab == 'extra_settings') {
                    settings_fields('blackwebsite_extra_options_group');
                    do_settings_sections('blackwebsite_extra_admin_page');
                    submit_button();
                } else {
                    settings_fields('blackwebsite_main_options_group');
                    do_settings_sections('blackwebsite_settings_admin_page');
                    submit_button();
                }
                ?>
            </form>
        </div>

<?php
    }

    public function blackwebsite_init_page() {
        /* Position  Setting Start */
        require_once BLACKWEBSITE_DIR_PATH . 'inc/position-setting.php';
        /* Position  Setting End */

        /* widget  Setting Start */
        require_once BLACKWEBSITE_DIR_PATH . 'inc/widget-setting.php';
        /* widget Setting End */

        /* Pre Define Setting Start */
        require_once BLACKWEBSITE_DIR_PATH . 'inc/predefine-setting.php';
        /* Pre Define Setting End */

        /* Extra Setting Start */
        require_once BLACKWEBSITE_DIR_PATH . 'inc/extra-setting.php';
        /* Extra Setting End */
    }

    public function sanitize($input) {
        $new_input = array();
        print_r($input);
        if (isset($input['blackwebsite_time']))
            $new_input['blackwebsite_time'] = sanitize_text_field($input['blackwebsite_time']);

        if (isset($input['blackwebsite_right']))
            $new_input['blackwebsite_right'] = sanitize_text_field($input['blackwebsite_right']);

        if (isset($input['blackwebsite_bottom']))
            $new_input['blackwebsite_bottom'] = sanitize_text_field($input['blackwebsite_bottom']);

        if (isset($input['blackwebsite_left']))
            $new_input['blackwebsite_left'] = sanitize_text_field($input['blackwebsite_left']);

        if (isset($input['blackwebsite_button_dark']))
            $new_input['blackwebsite_button_dark'] = sanitize_text_field($input['blackwebsite_button_dark']);

        if (isset($input['blackwebsite_button_light']))
            $new_input['blackwebsite_button_light'] = sanitize_text_field($input['blackwebsite_button_light']);

        if (isset($input['blackwebsite_icon_size']))
            $new_input['blackwebsite_icon_size'] = sanitize_text_field($input['blackwebsite_icon_size']);

        if (isset($input['blackwebsite_button_size']))
            $new_input['blackwebsite_button_size'] = sanitize_text_field($input['blackwebsite_button_size']);

        if (isset($input['blackwebsite_only_posts']))
            $new_input['blackwebsite_only_posts'] = absint($input['blackwebsite_only_posts']);

        if (isset($input['blackwebsite_left_bottom']))
            $new_input['blackwebsite_left_bottom'] = absint($input['blackwebsite_left_bottom']);

        if (isset($input['blackwebsite_right_bottom']))
            $new_input['blackwebsite_right_bottom'] = absint($input['blackwebsite_right_bottom']);

        if (isset($input['blackwebsite_match_os']))
            $new_input['blackwebsite_match_os'] = absint($input['blackwebsite_match_os']);

        if (isset($input['blackwebsite_cookies']))
            $new_input['blackwebsite_cookies'] = absint($input['blackwebsite_cookies']);

        if (isset($input['blackwebsite_toggle']))
            $new_input['blackwebsite_toggle'] = absint($input['blackwebsite_toggle']);

        return $new_input;
    }

    public function blackwebsite_print_main_section_info() {
        echo 'Enter Your Settings Options:';
    }

    public function blackwebsite_print_positions_section_info() {
        print 'Choose the position that you prefer:';
    }
    public function blackwebsite_print_extra_settings() {
        echo '<p>The cookies will allow the plugin to keep the dark mode active if the user enabled it previously.</p>
              <p>The match OS will allow the plugin to activate dark mode if the OS or browser are in Dark Mode</p>
              <p>Want to use your own widget or element as toggle? mark the last checkbox with the label <strong>Want to use your own toggle widget or button?</strong>, then add the class <strong><i>darkmode-enable</i></strong> to the element that you want to use as toggle.</p>';
    }

    // Position setting
    public function blackwebsite_bottom_callback() {
        printf(
            '<input type="text" id="blackwebsite_bottom" placeholder="32px" name="blackwebsite_options[blackwebsite_bottom]" value="%s" />',
            isset($this->options['blackwebsite_bottom']) ? esc_attr($this->options['blackwebsite_bottom']) : ''
        );
    }

    public function blackwebsite_right_callback() {
        printf(
            '<input type="text" id="blackwebsite_right" name="blackwebsite_options[blackwebsite_right]" placeholder="32px" value="%s" />',
            isset($this->options['blackwebsite_right']) ? esc_attr($this->options['blackwebsite_right']) : ''
        );
    }
    public function blackwebsite_left_callback() {
        printf(
            '<input type="text" id="blackwebsite_left" placeholder="32px" name="blackwebsite_options[blackwebsite_left]" value="%s" />',
            isset($this->options['blackwebsite_left']) ? esc_attr($this->options['blackwebsite_left']) : ''
        );
    }
    public function blackwebsite_only_posts_callback() {
        $only_post = isset($this->options['blackwebsite_only_posts']);
        printf(
            '<input type="checkbox" id="blackwebsite_only_posts" name="blackwebsite_options[blackwebsite_only_posts]" value="1"' . checked(1, $only_post, false) . ' />',
            isset($this->options['blackwebsite_only_posts']) ? esc_attr($this->options['blackwebsite_only_posts']) : ''
        );
    }
    public function blackwebsite_time_callback() {
        printf(
            '<input type="text" id="blackwebsite_time" placeholder="0.3s" name="blackwebsite_options[blackwebsite_time]" value="%s" />',
            isset($this->options['blackwebsite_time']) ? esc_attr($this->options['blackwebsite_time']) : ''
        );
    }

    /* widget input field start */
    public function blackwebsite_button_dark_callback()  {
        printf(
            '<input type="color" id="blackwebsite_button_dark" name="blackwebsite_widget_options[blackwebsite_button_dark]" value="%s" />',
            isset($this->widgetOption['blackwebsite_button_dark']) ? esc_attr($this->widgetOption['blackwebsite_button_dark']) : ''
        );
    }
    public function blackwebsite_button_light_callback() {
        printf(
            '<input type="color" id="blackwebsite_button_light" name="blackwebsite_widget_options[blackwebsite_button_light]" value="%s" />',
            isset($this->widgetOption['blackwebsite_button_light']) ? esc_attr($this->widgetOption['blackwebsite_button_light']) : ''
        );
    }
    public function blackwebsite_button_size_callback() {
        printf(
            '<input type="range" min="60" max="150" step="5" id="blackwebsite_button_size" name="blackwebsite_widget_options[blackwebsite_button_size]" value="%s" />',
            isset($this->widgetOption['blackwebsite_button_size']) ? esc_attr($this->widgetOption['blackwebsite_button_size']) : ''
        );
    }
    public function blackwebsite_icon_size_callback() {
        printf(
            '<input type="range" min="30" max="100" step="10" id="blackwebsite_icon_size" name="blackwebsite_widget_options[blackwebsite_icon_size]" value="%s" />',
            isset($this->widgetOption['blackwebsite_icon_size']) ? esc_attr($this->widgetOption['blackwebsite_icon_size']) : ''
        );
    }

    // Predefine setting
    public function blackwebsite_left_bottom_callback() {
        printf(
            '<input type="checkbox" id="blackwebsite_left_bottom" name="blackwebsite_predefine_options[blackwebsite_left_bottom]" value="1"' . checked(1, isset($this->predefineOption['blackwebsite_left_bottom']), false) . ' />',
            isset($this->predefineOption['blackwebsite_left_bottom']) ? esc_attr($this->predefineOption['blackwebsite_left_bottom']) : ''
        );
    }
    public function blackwebsite_right_bottom_callback() {
        printf(
            '<input type="checkbox" id="blackwebsite_right_bottom" name="blackwebsite_predefine_options[blackwebsite_right_bottom]" value="1"' . checked(1, isset($this->predefineOption['blackwebsite_right_bottom']), false) . ' />',
            isset($this->predefineOption['blackwebsite_right_bottom']) ? esc_attr($this->predefineOption['blackwebsite_right_bottom']) : ''
        );
    }

    // Extra setting
    public function blackwebsite_cookies_callback() {
        printf(
            '<input type="checkbox" id="blackwebsite_cookies" name="blackwebsite_extra_options[blackwebsite_cookies]" value="1"' . checked(1, isset($this->extraOption['blackwebsite_cookies']), false) . ' />',
            isset($this->extraOption['blackwebsite_cookies']) ? esc_attr($this->extraOption['blackwebsite_cookies']) : ''
        );
    }
    public function blackwebsite_match_os_callback() {
        printf(
            '<input type="checkbox" id="blackwebsite_match_os" name="blackwebsite_extra_options[blackwebsite_match_os]" value="1"' . checked(1, isset($this->extraOption['blackwebsite_match_os']), false) . ' />',
            isset($this->extraOption['blackwebsite_match_os']) ? esc_attr($this->extraOption['blackwebsite_match_os']) : ''
        );
    }
    public function blackwebsite_toggle_callback() {
        printf(
            '<input type="checkbox" id="blackwebsite_toggle" name="blackwebsite_extra_options[blackwebsite_toggle]" value="1"' . checked(1, isset($this->extraOption['blackwebsite_toggle']), false) . ' />',
            isset($this->extraOption['blackwebsite_toggle']) ? esc_attr($this->extraOption['blackwebsite_toggle']) : ''
        );
    }
}

function blackwebsite_enqueues() {
    $blackwebsite_options = get_option('blackwebsite_options');
    $blackwebsite_widget_options = get_option('blackwebsite_widget_options');

    wp_enqueue_script('blackwebsite_script', plugin_dir_url(__FILE__) . 'js/blackwebsite.js', array(), '1.0', 'true');
    wp_enqueue_style('blackwebsite_style', plugin_dir_url(__FILE__) . 'css/blackwebsite.css');
    $blackwebsite_custom_css = ".darkmode-toggle>img{
            width: {$blackwebsite_widget_options['blackwebsite_icon_size']}px !important;
            height:{$blackwebsite_widget_options['blackwebsite_icon_size']}px !important;
        }
        .darkmode-toggle {
            width:{$blackwebsite_widget_options['blackwebsite_button_size']}px !important;
            height:{$blackwebsite_widget_options['blackwebsite_button_size']}px !important;
        }

        ";
    wp_add_inline_style('blackwebsite_style', $blackwebsite_custom_css);
}
function admin_blackwebsite_enqueues(){
    wp_enqueue_style('blackwebsite_admin_style', plugin_dir_url(__FILE__) . 'css/admin.css');
}
function blackwebsite_position(){
    $blackwebsite_options = get_option('blackwebsite_options');
    $blackwebsite_widget_options = get_option('blackwebsite_widget_options');
    $blackwebsite_predefine_options = get_option('blackwebsite_predefine_options');
    $blackwebsite_extra_options = get_option('blackwebsite_extra_options');

    // variables
    $blackwebsite_left_bottom = isset($blackwebsite_predefine_options['blackwebsite_left_bottom']) ? $blackwebsite_predefine_options['blackwebsite_left_bottom'] : "";
    $blackwebsite_right_bottom = isset($blackwebsite_predefine_options['blackwebsite_right_bottom']) ? $blackwebsite_predefine_options['blackwebsite_right_bottom'] : "";
    $blackwebsite_cookies = isset($blackwebsite_extra_options['blackwebsite_cookies']) ? $blackwebsite_extra_options['blackwebsite_cookies'] : "";

    //Extra options
    if ($blackwebsite_cookies == 1) {
        $blackwebsite_cookies = "true";
    } else {
        $blackwebsite_cookies = "false";
    }
    if (isset($blackwebsite_extra_options['blackwebsite_match_os']) == 1) {
        $blackwebsite_match_os = "true";
    } else {
        $blackwebsite_match_os = "false";
    }
    if (isset($blackwebsite_extra_options['blackwebsite_toggle']) == 1) {
        $blackwebsite_toggle = "const darkmode = new Darkmode(options);";
    } else {
        $blackwebsite_toggle = "const darkmode = new Darkmode(options); darkmode.showWidget();";
    }

    // Custom Position
    $blackwebsite_options['blackwebsite_bottom'] !== '' ? $blackwebsite_bottom = $blackwebsite_options['blackwebsite_bottom'] : $blackwebsite_bottom = '32px';
    $blackwebsite_options['blackwebsite_right'] !== '' ? $blackwebsite_right = $blackwebsite_options['blackwebsite_right'] : $blackwebsite_right = '32px';
    $blackwebsite_options['blackwebsite_left'] !== '' ? $blackwebsite_left = $blackwebsite_options['blackwebsite_left'] : $blackwebsite_left = '32px';
    $blackwebsite_options['blackwebsite_time'] !== '' ? $blackwebsite_time = $blackwebsite_options['blackwebsite_time'] : $blackwebsite_time = '0.3s';

    if ($blackwebsite_left_bottom == '1') {
        require_once BLACKWEBSITE_DIR_PATH . 'inc/button-position/left-button.php';
    } elseif ($blackwebsite_right_bottom == '1') {
        require_once BLACKWEBSITE_DIR_PATH . 'inc/button-position/right-button.php';
    } else {
        require_once BLACKWEBSITE_DIR_PATH . 'inc/button-position/defult-button.php';
    }

    wp_add_inline_style('blackwebsite_style', $blackwebsite_layer_css);
    wp_add_inline_script('blackwebsite_script', $blackwebsite_custom_js);
}
function blackwebsite_init() {
    $blackwebsite_options = get_option('blackwebsite_options');

    if (isset($blackwebsite_options['blackwebsite_only_posts']) == '1') {
        if (is_single()) {
            add_action('wp_enqueue_scripts', 'blackwebsite_enqueues');
            add_action('wp_enqueue_scripts', 'blackwebsite_position');
        }
    } else {
        add_action('wp_enqueue_scripts', 'blackwebsite_enqueues');
        add_action('wp_enqueue_scripts', 'blackwebsite_position');
    }
}
$blackwebsite_options = get_option('blackwebsite_options');
if (is_admin()) {
    $blackwebsite_settings = new BlackWebsiteSetting();
    add_action('admin_enqueue_scripts', 'admin_blackwebsite_enqueues');
} else {
    add_action('wp', 'blackwebsite_init');
}
