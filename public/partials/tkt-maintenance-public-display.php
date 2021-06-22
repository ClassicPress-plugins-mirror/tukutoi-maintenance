<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Maintenance
 * @subpackage Tkt_Maintenance/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php 
//All options are escapted and defaulted already, see Tkt_Maintenance_Public::get_options()
$options = new Tkt_Options( 'tkt-maintenance', 'tkt_mtn' ); 
$options = $options->get_options();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php wp_head();?>

        <style>

            /*There is no other way to load a Dynamic URL saved in WordPress Options into CSS*/
            .tkt-maintenance-bgimg {
                background-image: url( <?php echo $options[ $this->plugin_short . '_image' ] ?> );
            }

        </style>

    </head>

    <body class="tkt-maintenance">

        <div class="tkt-maintenance-bgimg">

            <div class="tkt-maintenance-topleft">

                <img src="<?php echo $options[ $this->plugin_short . '_logo' ] ?>"/>

            </div>

            <div class="tkt-maintenance-middle">

                <h1><?php echo $options[ $this->plugin_short . '_header' ]; ?></h1>
                <hr class="tkt-maintenance">
                <p id="tkt-maintenance-timer"></p>

            </div>

            <div class="tkt-maintenance-bottomleft">

                <p><?php echo $options[ $this->plugin_short . '_footer' ]; ?></p>

            </div>

        </div>

        <?php 

            wp_footer();

        ?>

    </body>
    
</html>