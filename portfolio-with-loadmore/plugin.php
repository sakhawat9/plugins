<?php

/**
 * Plugin Name:       Portfolio With Loadmore
 * Plugin URI:        https://sakhawat.vercel.app/
 * Description:       Portfolio With Loadmore.
 * Version:           1.0.0
 * Author:            SH Shakib
 * Author URI:        https://sakhawat.vercel.app/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       portfolio
 * Domain Path:       /languages
 */

/** Portfolio version  */
define('PORTFOLIO_VERSION', '1.0.0');

/** Portfolio directory path  */
define('PORTFOLIO_HELPER_DIR', trailingslashit(plugin_dir_path(__FILE__)));

/** Portfolio includes directory path  */
define('PORTFOLIO_HELPER_INCLUDES_DIR', trailingslashit(PORTFOLIO_HELPER_DIR . 'includes'));

class OurPortfolioPlugin {

    public function __construct() {
        add_action('plugins_loded', array($this, 'portfolio_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'portfolio_fontend_assets'));

        add_shortcode('portfolio', array($this, 'portfolio_shortcode'));

        add_action('wp_ajax_loadmore', array($this, 'load_ajax_data'));
        add_action('wp_ajax_nopriv_loadmore', array($this, 'load_ajax_data'));

        $this->load_include();
    }

    private function load_include() {
        include PORTFOLIO_HELPER_INCLUDES_DIR . 'custom-post.php';
    }

    public function load_ajax_data() {


        $args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => $_POST['postNumber'],
            'paged' => $_POST['page'] + 1
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
                <div class="portfolio-item <?php echo esc_attr($id); ?>">
                    <a href="<?php the_permalink(); ?>" class="portfolio-image popup-gallery" title="Bread">
                        <img src="<?php the_post_thumbnail_url() ?>" alt="">
                        <div class="portfolio-hover-title">
                            <div class="portfolio-content">
                                <h4><?php the_title(); ?></h4>
                                <div class="portfolio-category">
                                    <span><?php echo $slug; ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
    }

    public function portfolio_shortcode() {
        ob_start();
        ?>

        <div class="section bg-white pt-2 pb-2 text-center" data-aos="fade">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <ul class="portfolio-filter text-center">
                                <li class="active"><a href="#" data-filter="*"> All</a></li>
                                <?php
                                $category = get_terms('category', array('hide_empty' => true));

                                foreach ($category as $w_cat) :
                                    echo '<li><a href="#" data-filter=".' . $w_cat->slug . '-' . $w_cat->term_id . '">' . $w_cat->name . '</a></li>';
                                endforeach;
                                ?>

                            </ul>
                        </div>

                        <div class="portfolio-grid portfolio-gallery grid-4 gutter">

                            <?php

                            $args = array(
                                'post_type' => 'portfolio',
                                'posts_per_page' => 2,
                            );
                            $query = new WP_Query($args);

                            wp_localize_script(
                                'portfolio-js',
                                'galleryloadajax',
                                array(
                                    'action_url' => admin_url('admin-ajax.php'),
                                    'current_page' => (get_query_var('paged')) ? get_query_var('paged') : 1,
                                    'posts' => json_encode($query->query_vars),
                                    'max_pages' => $query->max_num_pages,
                                    'postNumber' => 2,
                                    'col' => 3,
                                    'btnLabel' => esc_html__('Load More', 'textdomain'),
                                    'btnLodingLabel' => esc_html__('Loading....', 'textdomain'),
                                )
                            );

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

                                    <div class="portfolio-item <?php echo esc_attr($id); ?>">
                                        <a href="<?php the_permalink(); ?>" class="portfolio-image popup-gallery" title="Bread">
                                            <img src="<?php the_post_thumbnail_url() ?>" alt="">
                                            <div class="portfolio-hover-title">
                                                <div class="portfolio-content">
                                                    <h4><?php the_title(); ?></h4>
                                                    <div class="portfolio-category">
                                                        <span><?php echo $slug; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                                echo '<span class="dataload"></span>';
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="portfolio--footer">
            <div class="load-more-btn">
                <a class="btn loadAjax btn-default"><?php esc_html_e('Load More', 'porfolio'); ?></a>
            </div>
        </div>

<?php
        return ob_get_clean();
    }

    public function portfolio_fontend_assets() {
        wp_enqueue_style('portfolio-bootstrap', plugin_dir_url(__FILE__) . "assets/css/bootstrap.css", null, PORTFOLIO_VERSION);
        wp_enqueue_style('portfolio-css', plugin_dir_url(__FILE__) . "assets/css/portfolio.css", null, PORTFOLIO_VERSION);

        wp_enqueue_script('portfolio-bootstrap-js', plugin_dir_url(__FILE__) . "assets/js/bootstrap.min.js", array('jquery'), PORTFOLIO_VERSION, true);
        wp_enqueue_script('isotope-js', plugin_dir_url(__FILE__) . "assets/js/isotope.pkgd.min.js", array('jquery'), PORTFOLIO_VERSION, true);
        wp_enqueue_script('portfolio-js', plugin_dir_url(__FILE__) . "assets/js/portfolio.js", array('jquery', 'isotope-js'), PORTFOLIO_VERSION, true);
    }

    public function portfolio_textdomain() {
        load_plugin_textdomain('portfolio', false, dirname(__FILE__) . "/languages");
    }
}

new OurPortfolioPlugin();
