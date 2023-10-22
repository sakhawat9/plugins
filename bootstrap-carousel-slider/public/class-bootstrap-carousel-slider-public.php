<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sakhawat.vercel.app
 * @since      1.0.0
 *
 * @package    Bootstrap_Carousel_Slider
 * @subpackage Bootstrap_Carousel_Slider/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bootstrap_Carousel_Slider
 * @subpackage Bootstrap_Carousel_Slider/public
 * @author     SH Shakib <imshshakib2001@gmail.com>
 */
class Bootstrap_Carousel_Slider_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;


		add_action('plugins_loaded', array($this, 'bootstrap_carousel_textdomain'));
		add_action('wp_enqueue_scripts', array($this, 'bootstrap_carousel_frontend_assets'));

		add_shortcode('bootstrap_carousel', array($this, 'bootstrap_carousel_shortcode'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bootstrap_Carousel_Slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bootstrap_Carousel_Slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bootstrap-carousel-slider-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bootstrap_Carousel_Slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bootstrap_Carousel_Slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bootstrap-carousel-slider-public.js', array('jquery'), $this->version, false);
	}

	public function bootstrap_carousel_shortcode()
	{

		ob_start();

		$admin_data = get_option('carousel_slider_settings');

		print_r($admin_data);
		$showtitle = $admin_data['showtitle'];
		$showcations = $admin_data['showcations'];
		$showindicators = $admin_data['showindicators'];
		$twbs = $admin_data['twbs'];

?>
		<div id="carouselExampleIndicators" class="carousel slide">
			<?php if ($showindicators === "true") : ?>
				<div class="carousel-indicators">
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
				</div>
			<?php endif; ?>
			<div class="carousel-inner">
				<?php
				$args = array(
					'post_type' => 'bootstrap_slider',
					'posts_per_page' => -1, // Number of posts per page
				);
				$query = new WP_Query($args);

				if ($query->have_posts()) :
					$index = 0;
					while ($query->have_posts()) : $query->the_post();

				?>
						<div class="carousel-item <?php echo esc_attr($index == 0) ? 'active' : ''; ?>">
							<img src="<?php the_post_thumbnail_url() ?>" class="d-block w-100" alt="...">
							<?php if ($showtitle === "true" || $showcations === "true") : ?>
								<div class="carousel-caption d-none d-md-block">
									<?php if (get_the_title() && $showtitle === "true") {
										echo '<h3>' . get_the_title() . '</h3>';
									} ?>
									<?php if (get_the_content() && $showcations === "true") {
										echo get_the_content();
									} ?>
								</div>
							<?php endif; ?>
						</div>
				<?php
						$index++;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
			<?php if ($twbs === "true") : ?>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
				</button>
			<?php endif; ?>
		</div>
<?php
		return ob_get_clean();
	}

	public function bootstrap_carousel_frontend_assets()
	{
		wp_enqueue_style('bootstrap-css', plugin_dir_url(__FILE__) . "css/bootstrap.min.css", null, BOOTSTRAP_CAROUSEL_SLIDER_VERSION);

		wp_enqueue_script('jquery'); // Enqueue jQuery
		wp_enqueue_script('bootstrap-js', plugin_dir_url(__FILE__) . "js/bootstrap.min.js", array('jquery'), BOOTSTRAP_CAROUSEL_SLIDER_VERSION, true);
	}

	public function bootstrap_carousel_textdomain()
	{
		load_plugin_textdomain('bootstrap_carousel', false, dirname(__FILE__) . "/languages");
	}
}
