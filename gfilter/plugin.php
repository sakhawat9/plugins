<?php

/**
 * Plugin Name:       Gfilter With Loadmore
 * Plugin URI:        https://sakhawat.vercel.app/
 * Description:       Gfilter With Loadmore.
 * Version:           1.0.0
 * Author:            SH Shakib
 * Author URI:        https://sakhawat.vercel.app/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gfilter
 * Domain Path:       /languages
 */

/** Gfilter version  */
define('GFILTER_VERSION', '1.0.0');

/** Gfilter directory path  */
define('GFILTER_HELPER_DIR', trailingslashit(plugin_dir_path(__FILE__)));

/** Gfilter includes directory path  */
define('GFILTER_HELPER_INCLUDES_DIR', trailingslashit(GFILTER_HELPER_DIR . 'includes'));

class OurGfilterPlugin
{
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'gfilter_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'gfilter_frontend_assets'));

        add_shortcode('gfilter', array($this, 'gfilter_shortcode'));

    }

    public function gfilter_shortcode()
    {
        ob_start();
?>
        <div class="section bg-white pt-2 pb-2 text-center" data-aos="fade">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="gfilter-nav">
                            <ul class="gfilter-filter text-center">
                                <li class="active"><a href="#" data-filter="*"> All</a></li>
                                <?php
                                $category = get_terms('category', array('hide_empty' => true));

                                foreach ($category as $w_cat) :
                                    echo '<li><a href="#" data-filter=".' . $w_cat->slug . '-' . $w_cat->term_id . '">' . $w_cat->name . '</a></li>';
                                endforeach;
                                ?>
                            </ul>
                        </div>

                        <div class="row gfilter-grid gfilter-gallery grid-4 gutter">

                            <?php
                            $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => -1, // Number of posts per page
                            );
                            $query = new WP_Query($args);

                            if ($query->have_posts()) :
                                while ($query->have_posts()) : $query->the_post();
                                    $terms = get_the_terms(get_the_ID(), 'category');
                                    $cat = array();
                                    $id = '';
                                    if ($terms) {
                                        foreach ($terms as $term) {
                                            $cat[] = $term->name . ' ';
                                            $slug = $term->slug;
                                            $id  .= ' ' . $term->slug . '-' . $term->term_id;
                                        }
                                    }
                            ?>

                                    <div class="gfilter-item col-md-4 <?php echo esc_attr($id); ?>">
                                        <div class="gfilter-item-content">
                                            <img src="<?php the_post_thumbnail_url() ?>" alt="">
                                            <div class="gfilter-hover-title">
                                                <div class="gfilter-content">
                                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                    <div class="gfilter-category">
                                                        <span><?php echo $slug; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
        return ob_get_clean();
    }

    public function gfilter_frontend_assets()
    {
        wp_enqueue_style('gfilter-bootstrap', plugin_dir_url(__FILE__) . "assets/css/bootstrap.css", null, GFILTER_VERSION);
        wp_enqueue_style('gfilter-css', plugin_dir_url(__FILE__) . "assets/css/gfilter.css", null, GFILTER_VERSION);

        wp_enqueue_script('jquery'); // Enqueue jQuery
        wp_enqueue_script('gfilter-bootstrap-js', plugin_dir_url(__FILE__) . "assets/js/bootstrap.min.js", array('jquery'), GFILTER_VERSION, true);
        wp_enqueue_script('isotope-js', plugin_dir_url(__FILE__) . "assets/js/isotope.pkgd.min.js", array('jquery'), GFILTER_VERSION, true);
        wp_enqueue_script('gfilter-js', plugin_dir_url(__FILE__) . "assets/js/gfilter.js", array('jquery', 'isotope-js'), GFILTER_VERSION, true);
    }

    public function gfilter_textdomain()
    {
        load_plugin_textdomain('gfilter', false, dirname(__FILE__) . "/languages");
    }
}

new OurGfilterPlugin();
