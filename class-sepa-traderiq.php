<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    sepa-traderiq
 * @subpackage sepa-traderiq/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    sepa-traderiq
 * @subpackage sepa-traderiq/includes
 * @author     Octagon DS
 */
class Sepa_Traderiq {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sepa_Traderiq_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $sepa_traderiq    The string used to uniquely identify this plugin.
	 */
	protected $sepa_traderiq;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SEPA_TRADERIQ_VERSION' ) ) {
			$this->version = SEPA_TRADERIQ_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->sepa_traderiq = 'sepa-traderiq';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sepa_Traderiq_Loader. Orchestrates the hooks of the plugin.
	 * - Sepa_Traderiq_i18n. Defines internationalization functionality.
	 * - Sepa_Traderiq_Admin. Defines all hooks for the admin area.
	 * - Sepa_Traderiq_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sepa-traderiq-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sepa-traderiq-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sepa-traderiq-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sepa-traderiq-public.php';

		$this->loader = new Sepa_Traderiq_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sepa_Traderiq_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sepa_Traderiq_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sepa_Traderiq_Admin( $this->get_sepa_traderiq(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sepa_Traderiq_Public( $this->get_sepa_traderiq(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_sepa_traderiq() {
		return $this->sepa_traderiq;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sepa_Traderiq_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}


function sepa_register_widget() {
	register_widget( 'sepa_traderiq_widget' );
	}

add_action( 'widgets_init', 'sepa_register_widget' );

class sepa_traderiq_widget extends WP_Widget {
	function __construct() {
	parent::__construct(
	// widget ID
	'sepa_traderiq_widget',
	// widget name
	__('Форма оплаты SEPA Traderiq', ' sepa_widget_domain'),
	// widget description
	array( 'description' => __( 'Форма оплаты SEPA Traderiq', 'sepa_widget_domain' ), )
	);
	}

	public function widget( $args, $instance ) {
	$button_pay = isset( $instance['button_pay'] )? $instance['button_pay']: 'Button name';
	$content = isset( $instance['content'] ) ? wpautop( $instance['content']):'Button<br> name';
	$description = isset( $instance['description'] )? $instance['description']: 'Info pay';
	$price = isset( $instance['price'] )? $instance['price']: '';
	$tag_quentn = isset( $instance['tag_quentn'] )? $instance['tag_quentn']: '';

	echo $args['before_widget'];

	?>


<button id="form-popup" class="form-popup"><?php echo $content;?></button>

	<div id="form-container" class="form-container">
		<div class="form-p">
		<script src="https://js.stripe.com/v3/">
			var stripe = Stripe('pk_test_51I5000');
var elements = stripe.elements();
	</script>
			<span id="close-form" class="close-form">&times;</span>
			<form action="<?php echo plugins_url( 'form2.php', __FILE__ ); ?>" class="sr-payment-form" id="payment-form" method="post" enctype="multipart/form-data">
					<div class="tr_head_bg2"></div>
					<div class="top_in"><input name="email" id="email" type="email" placeholder="E-mail" value="" required/></div>
					<div class="tr_grid2">
					<div><input id="accountholder-name" name="Vorname" type="text" placeholder="Vorname" value="" required /></div>
					<div><input name="Nachname" type="text" placeholder="Nachname" value="" required /></div>
					</div>
					<div class="tr_grid3">
					<div><input name="StraßeHausnummer" type="text" placeholder="Straße / Hausnummer" value="" required /></div>
					<div><input name="PLZ" type="text" placeholder="PLZ" value="" required /></div>
					</div>
					<div class="tr_grid3">
					<div><input name="Ort" type="text" placeholder="Ort" value="" required /></div>
					<div><input name="ggfFirma" type="text" placeholder="ggf.Firma" value="" /></div>
					</div>
					<div id="iban-element">
					<input name="IBAN" type="text" placeholder="IBAN" required/>
					</div>

					<input type="hidden" name="amount" value="<?php echo $price;?>"/>
					<input type="hidden" name="description" value="<?php echo $description;?>"/>
					<input type="hidden" name="tag_quentn" value="<?php echo $tag_quentn;?>"/>

          <button class="ss" id="submit-button"><?php echo $button_pay;?></button>
					<div class="tr_foot_bg2" id="mandate-acceptance">
					<span class="tr_foot2">
					Mit Ihrer Anmeldung akzeptieren Sie unsere <a href="https://traderiq.net/agb/" target="_blank"><b>AGB’s</b></a> sowie unsere <a href="https://traderiq.net/widerrufsbelehrung/" target="_blank"><b>Widerrufsbelehrung</b></a><br> und erteilen uns das <a href="https://traderiq.net/sepa-lastschriftmandat/" target="_blank"><b>SEPA-Mandat</b></a>.
       	  </span>
					</div>
        </form>
		</div>
	</div>



	<?php echo $args['after_widget'];
	}

	public function form( $instance ) {
	if ( isset( $instance[ 'button_pay' ] ) )
	$button_pay = $instance[ 'button_pay' ];
	else
	$button_pay = __( 'Button name', 'sepa_widget_domain' );
	if ( isset( $instance[ 'content' ] ) )
	$content = $instance[ 'content' ];
	else
	$content = __( 'Button<br> name', 'sepa_widget_domain' );
	if ( isset( $instance[ 'description' ] ) )
	$description = $instance[ 'description' ];
	else
	$description = __( 'Info pay', 'sepa_widget_domain' );
	if ( isset( $instance[ 'price' ] ) )
	$price = $instance[ 'price' ];
	if ( isset( $instance[ 'tag_quentn' ] ) )
	$tag_quentn = $instance[ 'tag_quentn' ];
	?>
<label for="<?php echo esc_attr( $this->get_field_id( 'content') ); ?>"><?php _e( 'Button name:', 'text_domain' ); ?></label>
	<?php
	printf(
		'<textarea class="widefat" id="%1$s" name="%2$s">%3$s</textarea>',
		$this->get_field_id( 'content' ),
		$this->get_field_name( 'content' ),
		$content
	);
	?>
		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'button_pay') ); ?>"><?php _e( 'Button name form:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_pay') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_pay') ); ?>" type="text" value="<?php echo esc_attr( $button_pay ); ?>" />
    </p>
		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'description') ); ?>"><?php _e( 'Description:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description') ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>" />
    </p>
		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'price') ); ?>"><?php _e( 'Price:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'price') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'price') ); ?>" type="text" value="<?php echo esc_attr( $price ); ?>" />
    </p>
		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'tag_quentn') ); ?>"><?php _e( 'Tag Quentn:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag_quentn') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag_quentn') ); ?>" type="text" value="<?php echo esc_attr( $tag_quentn ); ?>" />
    </p>

	<?php
	}
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['button_pay']     = isset( $new_instance['button_pay'] )? wp_strip_all_tags( $new_instance['button_pay'] ): '';
  $instance['content'] = $new_instance['content'];
	$instance['description']     = isset( $new_instance['description'] )? wp_strip_all_tags( $new_instance['description'] ): '';
	$instance['price']     = isset( $new_instance['price'] )? wp_strip_all_tags( $new_instance['price'] ): '';
	$instance['tag_quentn']     = isset( $new_instance['tag_quentn'] )? wp_strip_all_tags( $new_instance['tag_quentn'] ): '';

	return $instance;
	}
}
