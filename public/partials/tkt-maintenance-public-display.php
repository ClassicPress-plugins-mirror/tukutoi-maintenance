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
<html>

    <head>

        <title><?php bloginfo( 'name', 'display' ) ?></title>

        <?php wp_head();?>

        <style>

            .bgimg {
                background-image: url( <?php echo $options[ $this->plugin_short . '_image' ] ?> );
            }

            <?php echo $options[ $this->plugin_short . '_css'  ]; ?>

        </style>

    </head>

    <body>

        <div class="bgimg">

            <div class="topleft">

                <img src="<?php echo $options[ $this->plugin_short . '_logo' ] ?>"/>

            </div>

            <div class="middle">

                <h1><?php echo $options[ $this->plugin_short . '_header' ]; ?></h1>
                <hr>
                <p id="timer" style="font-size:30px"></p>

            </div>

            <div class="bottomleft">

                <p><?php echo $options[ $this->plugin_short . '_footer' ]; ?></p>

            </div>

        </div>

        <?php 

            if( $options[ $this->plugin_short . '_time' ] != '' ){
                ?><script type="text/javascript">var time = '<?php echo $options[ $this->plugin_short . '_time' ]; ?>'</script><?php
            }

            wp_footer();

            if( $options[ $this->plugin_short . '_js' ] != '' ){
                echo $options[ $this->plugin_short . '_js' ];
            }

        ?>

    </body>
    
</html>