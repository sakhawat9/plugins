<?php
class Slider_Setting
{
    private $options;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'admin_setting_menu'));
        add_action('admin_init', array($this, 'page_init'));
    }

    public function admin_setting_menu()
    {
        add_submenu_page('edit.php?post_type=bootstrap_slider', __('setting', 'bootstrap-carousel-slider'), __('setting', 'bootstrap-carousel-slider'), 'manage_options', 'slider-setting', array($this, 'setting_submenu_callback'));
    }
    public function setting_submenu_callback()
    {
        $this->options = get_option('carousel_slider_settings');
?>

        <div class="wrap">
            <h2><?php __('setting', 'bootstrap-carousel-slider') ?></h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('slider_options_settings');
                do_settings_sections('slider_carousel');

                submit_button();
                ?>
            </form>
        </div>

<?php
    }
    public function page_init()
    {
        register_setting(
            'slider_options_settings', // Option group
            'carousel_slider_settings', // Options name
            array($this, 'sanitize') // sanitize
        );

        add_settings_section(
            'slider_settings_behaviour', // ID
            __('Custom Position', 'blackwebsite'), // Title
            array($this, 'slider_settings_behaviour_header'), // Callback
            'slider_carousel' // Page
        );

        add_settings_field(
            'blackwebsite_bottom', // ID
            __('Bottom Position', 'blackwebsite'), // Title
            array($this, 'interval_callback'), // Callback
            'slider_carousel', // Page
            'slider_settings_behaviour' // Section
        );
        add_settings_field(
            'showtitle', // ID
            __('Show Slide Titles?', 'bootstrap-carousel-slider'), // Title
            array($this, 'showtitle_callback'), // Callback
            'slider_carousel', // Page
            'slider_settings_behaviour' // Section
        );
        add_settings_field(
            'showcations', // ID
            __('Show Slide Captions?', 'bootstrap-carousel-slider'), // Title
            array($this, 'showcations_callback'), // Callback
            'slider_carousel', // Page
            'slider_settings_behaviour' // Section
        );
        add_settings_field(
            'showindicators', // ID
            __('Show Slide indicators?', 'bootstrap-carousel-slider'), // Title
            array($this, 'showindicators_callback'), // Callback
            'slider_carousel', // Page
            'slider_settings_behaviour' // Section
        );
        add_settings_field(
            'twbs', // ID
            __('Show Slide prev/next?', 'bootstrap-carousel-slider'), // Title
            array($this, 'twbs_callback'), // Callback
            'slider_carousel', // Page
            'slider_settings_behaviour' // Section
        );
    }

    public function slider_settings_behaviour_header()
    {
        print "Enter your settings below:";
    }

    public function interval_callback()
    {
        printf(
            '<input type="text" id="interval" placeholder="32px" name="carousel_slider_settings[interval]" value="%s" />',
            isset($this->options['interval']) ? $this->options['interval'] : "",
        );
    }
    public function showtitle_callback()
    {
        if (isset($this->options['showtitle']) && $this->options['showtitle'] == 'false') {
            $slider_showtitle_t = '';
            $slider_showtitle_f = ' selected="selected"';
        } else {
            $slider_showtitle_t = ' selected="selected"';
            $slider_showtitle_f = '';
        }
        print '<select id"showtitle" name="carousel_slider_settings[showtitle]">
        <option value="true"' . $slider_showtitle_t . '>' . __('Show', 'bootstrap-carousel-slider') . '</option>
        <option value="false"' . $slider_showtitle_f . '>' . __('Hide', 'bootstrap-carousel-slider') . '</option>
        </select>';
    }
    public function showcations_callback()
    {
        if (isset($this->options['showcations']) && $this->options['showcations'] == 'false') {
            $slider_showcations_t = '';
            $slider_showcations_f = ' selected="selected"';
        } else {
            $slider_showcations_t = ' selected="selected"';
            $slider_showcations_f = '';
        }
        print '<select id"showcations" name="carousel_slider_settings[showcations]">
        <option value="true"' . $slider_showcations_t . '>' . __('Show', 'bootstrap-carousel-slider') . '</option>
        <option value="false"' . $slider_showcations_f . '>' . __('Hide', 'bootstrap-carousel-slider') . '</option>
        </select>';
    }
    public function showindicators_callback()
    {
        if (isset($this->options['showindicators']) && $this->options['showindicators'] == 'false') {
            $slider_showindicators_t = '';
            $slider_showindicators_f = ' selected="selected"';
        } else {
            $slider_showindicators_t = ' selected="selected"';
            $slider_showindicators_f = '';
        }
        print '<select id"showindicators" name="carousel_slider_settings[showindicators]">
        <option value="true"' . $slider_showindicators_t . '>' . __('Show', 'bootstrap-carousel-slider') . '</option>
        <option value="false"' . $slider_showindicators_f . '>' . __('Hide', 'bootstrap-carousel-slider') . '</option>
        </select>';
    }
    public function twbs_callback()
    {
        if (isset($this->options['twbs']) && $this->options['twbs'] == 'false') {
            $slider_twbs_t = '';
            $slider_twbs_f = ' selected="selected"';
        } else {
            $slider_twbs_t = ' selected="selected"';
            $slider_twbs_f = '';
        }
        print '<select id"twbs" name="carousel_slider_settings[twbs]">
        <option value="true"' . $slider_twbs_t . '>' . __('Show', 'bootstrap-carousel-slider') . '</option>
        <option value="false"' . $slider_twbs_f . '>' . __('Hide', 'bootstrap-carousel-slider') . '</option>
        </select>';
    }
}

if (is_admin()) {
    $slider_setting = new Slider_Setting();
}
