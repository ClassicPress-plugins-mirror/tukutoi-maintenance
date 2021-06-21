<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Maintenance
 * @subpackage Tkt_Maintenance/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin settings, enqueues scripts required for settings.
 *
 * @package    Tkt_Maintenance
 * @subpackage Tkt_Maintenance/admin
 * @author     bedas <hello@tukutoi.com>
 */
class Tkt_Maintenance_Admin {

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
	 * The shortname of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_short    The shortname of this plugin, used for function prefix and option prefix.
	 */
	private $plugin_short;

	/**
	 * The Settings section name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $settings    The settings name of this plugin.
	 */
	private $settings;

	/**
	 * The slug-name of the settings page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $section   The slug-name of the settings page on which to show the sections.
	 */
	private $section;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $plugin_short, $version ) {

		$this->plugin_name 	= $plugin_name;
		$this->plugin_short = $plugin_short;
		$this->version 		= $version;

		$this->settings 	= $this->plugin_short . '_setting_section';
		$this->section 		= 'reading';

	}

	/**
	 * Callback to register the Settings Sections for this Plugin
	 *
	 * @since    1.0.0
	 */
	private function register_settings() {

		add_settings_section(
			$this->settings,
		    __( 'TukuToi Maintenance Settings', 'tkt-maintenance' ),
		    array( $this, 'setting_section_cb' ),
		    $this->section
		);

		add_settings_field(
		    $this->plugin_short . '_active',
		    __( 'Activate maintenance mode', 'tkt-maintenance' ),
		    array( $this, 'active_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_dequeue_styles_scripts',
		    __( 'Activate maintenance mode', 'tkt-maintenance' ),
		    array( $this, 'dequeue_styles_scripts' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_js',
		    __( 'Add Custom JS', 'tkt-maintenance' ),
		    array( $this, 'custom_js_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_css',
		    __( 'Add Custom CSS', 'tkt-maintenance' ),
		    array( $this, 'custom_css_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_logo',
		    __( 'Add Custom Logo', 'tkt-maintenance' ),
		    array( $this, 'logo_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_footer',
		    __( 'Add Custom Footer Text', 'tkt-maintenance' ),
		    array( $this, 'footer_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_header',
		    __( 'Add Custom Header Text', 'tkt-maintenance' ),
		    array( $this, 'header_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_http_header',
		    __( 'Add Custom HTTP Header Message', 'tkt-maintenance' ),
		    array( $this, 'http_header_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_http_status',
		    __( 'Add Custom HTTP Status Code', 'tkt-maintenance' ),
		    array( $this, 'http_status_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_retry_after',
		    __( 'Add Custom Timeout to retry Crawling', 'tkt-maintenance' ),
		    array( $this, 'retry_after_cb' ),
		    $this->section,
		    $this->settings
	  	);


	  	add_settings_field(
		    $this->plugin_short . '_time',
		    __( 'Add Custom End Time', 'tkt-maintenance' ),
		    array( $this, 'time_cb' ),
		    $this->section,
		    $this->settings
	  	);

	  	add_settings_field(
		    $this->plugin_short . '_image',
		    __( 'Add Custom Background Image', 'tkt-maintenance' ),
		    array( $this, 'image_cb' ),
		    $this->section,
		    $this->settings
	  	);

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_active', 
	    	array( 
	    		'type' => 'number', 
	    		'sanitize_callback' => array( 
	    			$this, 
	    			'validate_number' 
	    		) 
	    	)
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_dequeue_styles_scripts', 
	    	array( 
	    		'type' => 'number', 
	    		'sanitize_callback' => array( 
	    			$this, 
	    			'validate_number' 
	    		) 
	    	)
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_js', 
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_html' 
	    	)
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_css', 
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_html'  
	    	)
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_logo', 
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_url_raw'  
	    	)
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_footer',
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_html'
	    	) 
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_header',
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_html' 
	    	) 
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_http_header',
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_html' 
	    	) 
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_http_status',
	    	array( 
	    		'type' => 'number', 
	    		'sanitize_callback' => array( 
	    			$this, 
	    			'validate_number' 
	    		)
	    	) 
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_retry_after',
	    	array( 
	    		'type' => 'number', 
	    		'sanitize_callback' => array( 
	    			$this, 
	    			'validate_number' 
	    		) 
	    	) 
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_time',
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_html'
	    	)
	    );

	    register_setting( 
	    	$this->section, 
	    	$this->plugin_short . '_image', 
	    	array( 
	    		'type' => 'string', 
	    		'sanitize_callback' => 'esc_url_raw' 
	    	)
	    );

	}

	/**
	 * Callback to register Setting Sections of this Plugin
	 *
	 * @since    1.0.0
	 */
	public function setting_section_cb() {

		echo '<p>'. __( 'Configure and activate maintenance mode.', 'tkt-maintenance' ) .'</p>';

	}

  	/**
	 * Callback to activate Maintenance Mode.
	 *
	 * @since    1.0.0
	 */
	public function active_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Check to activate maintenance mode', 'tkt-maintenance' ) .'</span></legend><label for="'. $this->plugin_short . '_active"><input name="'. $this->plugin_short . '_active" id="'. $this->plugin_short . '_active" type="checkbox" value="1" ' . checked( 1, get_option( $this->plugin_short . '_active' ), false ) . ' />'. __( 'Check to activate maintenance mode', 'tkt-maintenance' ) .'</label></fieldset>';

	} 

	/**
	 * Callback to Dequeue all styles and scripts.
	 *
	 * @since    1.0.0
	 */
	public function dequeue_styles_scripts() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Check to dequeue all styles and scripts during maintenance mode', 'tkt-maintenance' ) .'</span></legend><label for="'. $this->plugin_short . '_dequeue_styles_scripts"><input name="'. $this->plugin_short . '_dequeue_styles_scripts" id="'. $this->plugin_short . '_dequeue_styles_scripts" type="checkbox" value="1" ' . checked( 1, get_option( $this->plugin_short . '_dequeue_styles_scripts' ), false ) . ' />'. __( 'Check to dequeue all styles and scripts during maintenance mode', 'tkt-maintenance' ) .'</label></fieldset>';

	} 

	/**
	 * Callback to add custom JS.
	 *
	 * @since    1.0.0
	 */
	public function custom_js_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add Custom JS to add to the maintenance mode page', 'tkt-maintenance' ) .'</span></legend><textarea name="'. $this->plugin_short . '_js" id="'. $this->plugin_short . '_js" cols="40" rows="5">' . stripslashes( get_option( $this->plugin_short . '_js' ) ) . '</textarea><p class="description">'. __( 'Add Custom JS to add to the maintenance mode page', 'tkt-maintenance' ) .'</p></fieldset>';

	} 

	/**
	 * Callback to add custom CSS.
	 *
	 * @since    1.0.0
	 */
	public function custom_css_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add Custom CSS to add to the maintenance mode page ', 'tkt-maintenance' ) .'</span></legend><textarea name="'. $this->plugin_short . '_css" id="'. $this->plugin_short . '_css" cols="40" rows="5">' . stripslashes( get_option( $this->plugin_short . '_css' ) ) . '</textarea><p class="description">'. __( 'Add Custom CSS to add to the maintenance mode page', 'tkt-maintenance' ) .'</p></fieldset>';

	}  

	/**
	 * Callback to add custom Logo Image URL.
	 *
	 * @since    1.0.0
	 */
	public function logo_cb() {

		echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Enter an URL or Upload an Image for the Logo', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_logo" id="'. $this->plugin_short . '_logo" type="text" size="36" value="' . esc_url_raw( get_option( $this->plugin_short . '_logo' ) ) . '" /><input id="'. $this->plugin_short . '_logo_button" class="button" type="button" value="Upload Image" /><p class="description">'. __( 'Enter an URL or Upload an Image for the Logo', 'tkt-maintenance' ) .'</p></fieldset>';

	} 
	
	/**
	 * Callback to add custom Footer Text.
	 *
	 * @since    1.0.0
	 */
	public function footer_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add your own Footer Text', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_footer" id="'. $this->plugin_short . '_footer" type="text" value="' . sanitize_text_field( get_option( $this->plugin_short . '_footer' ) ) . '" /><p class="description">'. __( 'Add your own Footer Text', 'tkt-maintenance' ) .'</p></fieldset>';

	}

	/**
	 * Callback to add custom Header Text.
	 *
	 * @since    1.0.0
	 */
	public function header_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add your own Header Text', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_header" id="'. $this->plugin_short . '_header" type="text" value="' . sanitize_text_field( get_option( $this->plugin_short . '_header' ) ) . '" /><p class="description">'. __( 'Add your own Header Text', 'tkt-maintenance' ) .'</p></fieldset>';

	} 

	/**
	 * Callback to add custom HTTP Header Message.
	 *
	 * @since    1.0.0
	 */
	public function http_header_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add a Custom HTTP Header Message', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_http_header" id="'. $this->plugin_short . '_http_header" type="text" value="' . sanitize_text_field( get_option( $this->plugin_short . '_http_header' ) ) . '" /><p class="description">'. __( 'Add a Custom HTTP Header Message', 'tkt-maintenance' ) .'</p></fieldset>';

	} 

	/**
	 * Callback to add custom Header Status.
	 *
	 * @since    1.0.0
	 */
	public function http_status_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add a Custom HTTP Status', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_http_status" id="'. $this->plugin_short . '_http_status" type="text" value="' . get_option( $this->plugin_short . '_http_status' ) . '" /><p class="description">'. __( 'Add a Custom HTTP Status', 'tkt-maintenance' ) .'</p></fieldset>';

	} 

	/**
	 * Callback to add custom Retry After Timeout.
	 *
	 * @since    1.0.0
	 */
	public function retry_after_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add a Custom Timeout for Crawlers to Retry after X Seconds', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_retry_after" id="'. $this->plugin_short . '_retry_after" type="text" value="' . get_option( $this->plugin_short . '_retry_after' ) . '" /><p class="description">'. __( 'Add a Custom Timeout for Crawlers to Retry after X Seconds', 'tkt-maintenance' ) .'</p></fieldset>';

	} 

	/**
	 * Callback to add custom Countdown Time.
	 *
	 * @since    1.0.0
	 */
	public function time_cb() {

	  	echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Add your own Countdown End Time', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_time" id="'. $this->plugin_short . '_time" type="text" value="' . sanitize_text_field ( get_option( $this->plugin_short . '_time' ) ) . '" /><p class="description">'. __( 'Add your own Countdown End Time. Any valid JS <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date#examples"><code>Date()</code></a> format accepted.', 'tkt-maintenance' ) .'</p></fieldset>';

	}  

	/**
	 * Callback to add custom Background Image URL.
	 *
	 * @since    1.0.0
	 */
	public function image_cb() {

		echo '<fieldset><legend class="screen-reader-text"><span>'. __( 'Enter an URL or Upload an Image for the Background', 'tkt-maintenance' ) .'</span></legend><input name="'. $this->plugin_short . '_image" id="'. $this->plugin_short . '_image" type="text" size="36" value="' . esc_url_raw( get_option( $this->plugin_short . '_image' ) ) . '" /><input id="'. $this->plugin_short . '_image_button" class="button" type="button" value="Upload Image" /><p class="description">'. __( 'Enter an URL or Upload an Image for the Background', 'tkt-maintenance' ) .'</p></fieldset>';

	}

	/**
	 * Register the JavaScript for the admin-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$screen = get_current_screen();

		if ( 'options-reading' === $screen->base ){

			wp_enqueue_media();
	        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tkt-maintenance-admin.js', array( 'jquery' ), $this->version, false );

	    }

	}

	/**
	 * Callback to validate Number and checkbox values (1 or 0).
	 *
	 * @since    1.0.0
	 */
	public function validate_number( $input ){

		if( $input == 1 ) 
			return 1;
		if( is_numeric($input) )
			return $input;
		if( empty($input) )
			return '';

		return 0;

	}


	/**
	 * Public callback to register the Settings Sections for this Plugin
	 *
	 * @since    1.0.0
	 */
	public function init_settings(){

		if( is_admin() && ( current_user_can( 'manage_options' ) || current_user_can( 'manage_network_options' ) ) )
			$this->register_settings();

	}

}
