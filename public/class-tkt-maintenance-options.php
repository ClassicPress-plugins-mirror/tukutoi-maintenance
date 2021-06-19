<?php

/**
 * Get the Plugin Options.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Maintenance
 * @subpackage Tkt_Maintenance/public
 */

/**
 * Small helper class to get the Plugin Options.
 *
 * Defines the plugin name, gets and escapes Plugin options.
 *
 * @package    Tkt_Maintenance
 * @subpackage Tkt_Maintenance/public
 * @author     bedas <hello@tukutoi.com>
 */
class Tkt_Options {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name     The name of the plugin.
	 * @param    string    $plugin_short    The shortname of this plugin, used for function prefix and option prefix.
	 */
	public function __construct( $plugin_name, $plugin_short ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_short = $plugin_short;

	}

	private function set_options(){

		$options = array(
			$this->plugin_short . '_active'	=> get_option( $this->plugin_short . '_active', 0 ),
			$this->plugin_short . '_dequeue_styles_scripts'	=> get_option( $this->plugin_short . '_dequeue_styles_scripts', 0 ),
			$this->plugin_short . '_js' 	=> stripslashes( htmlspecialchars_decode( get_option( $this->plugin_short . '_js', '' ) ) ),
			$this->plugin_short . '_css' 	=> stripslashes( htmlspecialchars_decode( get_option( $this->plugin_short . '_css', '' ) ) ),
			$this->plugin_short . '_logo' 	=> esc_url( get_option( $this->plugin_short . '_logo', '' ) ),
			$this->plugin_short . '_footer' => esc_html( get_option( $this->plugin_short . '_footer', '' ) ),
			$this->plugin_short . '_header' => esc_html( get_option( $this->plugin_short . '_header', '' ) ),
			$this->plugin_short . '_http_header' => esc_html( get_option( $this->plugin_short . '_http_header', '' ) ),
			$this->plugin_short . '_http_status' => get_option( $this->plugin_short . '_http_status', '' ),
			$this->plugin_short . '_retry_after' => get_option( $this->plugin_short . '_retry_after', '' ),
			$this->plugin_short . '_time' 	=> esc_html( get_option( $this->plugin_short . '_time', '' ) ),
			$this->plugin_short . '_image' 	=> esc_url( get_option( $this->plugin_short . '_image', '' ) ),
		);

		return $options;

    }

    public function get_options(){

    	return $this->set_options();

    }

}
