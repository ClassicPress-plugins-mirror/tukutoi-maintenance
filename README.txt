=== Plugin Name ===
Contributors: bedas
Donate link: https://www.tukutoi.com/
Tags: maintenance, under development, coming soon
Requires at least: 4.9
Tested up to: 5.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enable and Control a Custom Maintenance Mode for your WordPress Website.

== Description ==

TukuToi Maintenance allows you to setup and control a Custom "Under Maintenance" or "Comins Soon" Screen for your WordPress Website.

The Plugin is lightweight and has a Settings Screen allowing you to control all aspects of the Maintenance Screen from the WordPress backend.

You will be able to control the image (or color) of the Maintenance Screen, add a CountDown and a Custom Heading, as well as a Custom message to the screen.
You can control the request status (defaults to 401 temporarily unavailable) and the time for when the site will be back.
This is useful to tell Crawling bots when to start re-crawling your website.

== Installation ==

1. Upload the Plugin files to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Setup and control the Settings in the native WordPress Settings > Maintenance Menu.

== Frequently Asked Questions ==

= How big should the Image used for the Maintenance Screen be? =

It should ideally be 1200px by 700px.


= How big should the Logo Image used for the Maintenance Screen be? =

It should ideally be at least 300px square.

= Can I still access the WP Admin when activating the Maintenance Mode? =

Of course! You will have to navigate to the native `/wp-login.php` URL of your website and will be able to login.
For Administrators, the Front End will not show the Maintenance Mode. It will continue to show your website, in order to allow you to control your development.

= Can I Fully Customize the Maintenance Mode Template? =

Of course! You can either use the Plugin settings to customize the template, or, you can also load your 100% custom PHP template, if you wish. To do so, just pass your Custom PHP template to the `tkt_mtn_template_path` filter which the plugin provides.

Example (assuming you store the template in your Theme's `template-parts/post/` folder):
```
add_filter( 'tkt_mtn_template_path', 'load_my_own_template', 10, 1 );
function load_my_own_template( $template_path ){

	$template_path = get_template_directory() .'/template-parts/post/custm_template.php';//Load your own template.

	return $template_path;

}
```

You can take a look at the Plugin's Template in `tkt-maintenance/public/partials/tkt-maintenance-public-display.php` file to get a kickstart for your own Template.

== Screenshots ==

1. Custom Error Code and Message Settings
2. Custom Error Code and Message
3. Customized Maintenance Mode Template
4. Plugin Settings filled in
5. Plugin Settings on Install

== Changelog ==

= 1.0.0 =
* Initial release.