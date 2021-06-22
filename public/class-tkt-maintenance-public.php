<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Maintenance
 * @subpackage Tkt_Maintenance/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, short name of the plugin. Equeues styles and scripts, sets HTTP headers,
 * gets and loads Maintenance Template, maybe dequeues scripts and styles.
 *
 * @package    Tkt_Maintenance
 * @subpackage Tkt_Maintenance/public
 * @author     bedas <hello@tukutoi.com>
 */
class Tkt_Maintenance_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The shortname of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_short    The shortname of this plugin, used for function prefix and option prefix.
	 */
	private $plugin_short;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $options    The Plugin Options, santized and escaped.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $plugin_short      The shortname of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $plugin_short, $version ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_short = $plugin_short;
		$this->version = $version;

		$this->options = new Tkt_Options( $this->plugin_name, $this->plugin_short );

	}

	/**
	 * Set HTTP headers.
	 *
	 * @since    1.0.0
	 */
    private function set_headers(){

    	$protocol = 'HTTP/1.0';
 
	    if ( $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
	        $protocol = 'HTTP/1.1';
	    }
 		
 		$message = !empty( $this->options->get_options()[ $this->plugin_short . '_http_header' ] ) ? $this->options->get_options()[ $this->plugin_short . '_http_header' ] : '503 Service Unavailable';
 		$status = !empty( $this->options->get_options()[ $this->plugin_short . '_http_status' ] ) ? $this->options->get_options()[ $this->plugin_short . '_http_status' ] : 503;
 		$retry = !empty( $this->options->get_options()[ $this->plugin_short . '_retry_after' ] ) ? $this->options->get_options()[ $this->plugin_short . '_retry_after' ] : 3600;

	    header( $protocol . ' ' . $message, true, $status );
	    header( 'Retry-After: ' .  $retry );

    }
    
	/**
	 * Load the Maintenance template.
	 *
	 * @since    1.0.0
	 */
	private function load_template(){

		$template_path = apply_filters( $this->plugin_short .'_template_path', plugin_dir_path( __FILE__ ) . 'partials/tkt-maintenance-public-display.php' );

    	require_once( $template_path );

    }

    /**
	 * Render the Maintenance template.
	 *
	 * @since    1.0.0
	 */
    private function run_maintenance_mode(){

    	$this->set_headers();
	    $this->load_template();
	    die();

    }

    /**
	 * Check if WP Login URL is called.
	 *
	 * @since    1.0.0
	 */
    private function is_wplogin(){

	   	if( stripos($_SERVER["SCRIPT_NAME"], strrchr( wp_login_url(), '/' ) ) !== false){
	   		return true;
	   	}

	   	return false;

	}

	/**
	 * Enqueue the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if( !is_user_logged_in() && !$this->is_wplogin() && $this->options->get_options()[ $this->plugin_short . '_active' ] == 1 ){

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tkt-maintenance-public.css', array(), $this->version, 'all' );

		}

	}

	/**
	 * Enqueue the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if( !is_user_logged_in() && !$this->is_wplogin() && $this->options->get_options()[ $this->plugin_short . '_active' ] == 1 ){

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tkt-maintenance-public.js', array( 'jquery' ), $this->version, true );

			//@since 2.0.0
			if( $this->options->get_options()[ $this->plugin_short . '_time' ] != '' ){

				$data = 'var time = \'' . $this->options->get_options()[ $this->plugin_short . '_time' ] . '\'';
	            wp_add_inline_script( $this->plugin_name, $data, 'before' );

	        }

	    }
		

	}

	/**
	 * Remove the stylesheets and scripts if necessary.
	 *
	 * @since    1.0.0
	 */
	public function maybe_dequeue_styles_and_scripts() {

		if( !is_user_logged_in() && !$this->is_wplogin() && $this->options->get_options()[ $this->plugin_short . '_dequeue_styles_scripts' ] == 1 && $this->options->get_options()[ $this->plugin_short . '_active' ] == 1 ){

  			global $wp_scripts;
  			global $wp_styles;

  			$wp_scripts->queue = array( $this->plugin_name );
  			$wp_styles->queue = array( $this->plugin_name );

  		}

	}

	/**
	 * Run the Maintenance Mode.
	 *
	 * @since    1.0.0
	 */
    public function maybe_run_maintenance_mode(){

    	if (  !is_user_logged_in() && !$this->is_wplogin() && $this->options->get_options()[ $this->plugin_short . '_active' ] == 1 ) {
    		
    		$this->run_maintenance_mode();
    		
    	}

    }

}
