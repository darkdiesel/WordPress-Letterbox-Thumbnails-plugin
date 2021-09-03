<?php
/**
 * LetterBox Thumbnails Main Class
 *
 * @class    LetterboxThumbnails
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails
 */
class LetterboxThumbnails {

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * @var LetterboxThumbnails The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * @var LetterboxThumbnails_Plugin class instance
	 */
	public $plugin = null;

	/**
	 * @var LetterboxThumbnails_Functions class instance
	 */
	public $functions = null;

	/**
	 * LetterboxThumbnails constructor.
	 */
	function __construct() {
		if ( defined( 'LETTERBOX_THUMBNAILS_VERSION' ) ) {
			$this->version = LETTERBOX_THUMBNAILS_VERSION;
		} else {
			$this->version = '2.0.1';
		}

		$this->define_constants();
		$this->includes();
		$this->init_hooks();
		$this->set_locale();
	}

	/**
	 * Initialization function to hook into the WordPress init action
	 *
	 * Instantiates the class on a global variable and sets the class, actions
	 * etc. up for use.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Load Constants
	 *
	 * Convenience function to load the constants files for
	 * the activation and construct
	 */
	private function define_constants() {
		if ( ! defined( 'LETTERBOX_THUMBNAILS_PATH' ) ) {
			define( 'LETTERBOX_THUMBNAILS_PATH', dirname( LETTERBOX_THUMBNAILS_PLUGIN_FILE ) . '/' );
		}

		if ( ! defined( 'LETTERBOX_THUMBNAILS_TEMPLATES_PATH' ) ) {
			define( 'LETTERBOX_THUMBNAILS_TEMPLATES_PATH', LETTERBOX_THUMBNAILS_PATH . 'templates/' );
		}

		if ( ! defined( 'LETTERBOX_THUMBNAILS_URL' ) ) {
			define( 'LETTERBOX_THUMBNAILS_URL', plugin_dir_url( LETTERBOX_THUMBNAILS_PLUGIN_FILE ) . '/' );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		include_once LETTERBOX_THUMBNAILS_PATH . 'includes/class-letterbox-thumbnails-plugin.php';
		include_once LETTERBOX_THUMBNAILS_PATH . '/includes/class-letterbox-thumbnails-functions.php';
		include_once LETTERBOX_THUMBNAILS_PATH . 'includes/class-letterbox-thumbnails-image-editor.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		include_once LETTERBOX_THUMBNAILS_PATH . 'includes/class-letterbox-thumbnails-i18n.php';

		if ( $this->is_request( 'admin' ) ) {
			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			include_once LETTERBOX_THUMBNAILS_PATH . 'includes/admin/class-letterbox-thumbnails-admin.php';
		}

		$this->plugin    = new LetterboxThumbnails_Plugin();
		$this->functions = new LetterboxThumbnails_Functions();
	}

	/**
	 * Add in various hooks
	 *
	 * Place all add_action, add_filter, add_shortcode hook-ins here
	 */
	private function init_hooks() {
		add_filter( 'plugin_action_links_' . plugin_basename( LETTERBOX_THUMBNAILS_PLUGIN_FILE ), array(
			__CLASS__,
			'plugin_action_links'
		), 10, 2 );

		add_filter( 'plugin_row_meta', array(
			__CLASS__,
			'plugin_row_meta'
		), 10, 4 );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the LetterboxThumbnails_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.1
	 * @access   private
	 */
	private function set_locale() {
		add_action( 'plugins_loaded', array('LetterboxThumbnails_i18n', 'load_plugin_textdomain') );
	}

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	static function plugin_action_links( $links ) {
		array_unshift( $links, sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=letterbox-thumbnails-settings' ), __( 'Settings', LetterboxThumbnails()->plugin->get_txt_domain() ) ) );

		return $links;
	}

	static function plugin_row_meta( $links, $file ) {
		if ( plugin_basename( __FILE__ ) === $file ) {
			$links[] = sprintf( '<a target="_blank" href="%s">%s</a>', esc_url( 'http://www.donationalerts.ru/r/dark_diesel' ), __( 'Donate', LetterboxThumbnails()->plugin->get_txt_domain() ) );
		}

		return $links;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
