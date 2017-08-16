<?php
/**
* Plugin Name: Sedoo iFrame plugin
* Description: Plugin d'ajout d'iframe. ciblage possible de pages spécifiques de l'iframe via variables GET
* Version: 0.1.1
* Author: Pierre Vert
* Author URI: http://www.sedoo.fr
* GitHub Plugin URI: https://github.com/sedoo/sedoo-wppl-iframe
* GitHub Branch: master
*/

/*********************
* Shortcode d'ajouter une iframe
* Attributs possibles height, width, src
*/

function sedoo_wppl_iframe_shortcode( $atts ) {
    // begin output buffering
    // ob_start();
    
    $default_attributes = array(
        'src'           => 'default URL',
        'width'         => '100%',
        'height'        => '1000px'
      );

    // Attributes
    $atts = shortcode_atts($default_attributes , $atts);

    return '<iframe src="'. $atts['src'] .'" width="'. $atts['width'] .'" height="'. $atts['height'] .'"></iframe>';
    // end output buffering, grab the buffer contents, and empty the buffer
    // return ob_get_clean();
}

// Register the Shortcode
function sedoo_wppl_iframe_register_shortcodes() {
    
        add_shortcode( 'sedoo_iframe', 'sedoo_wppl_iframe_shortcode' );
    
    }
add_action( 'init', 'sedoo_wppl_iframe_register_shortcodes');

/***************************************************************
* ajout du bouton dans TinyMCE
*
*/

function sedoo_wppl_iframe_register_button( $buttons ) {
    array_push( $buttons, "|", "iframes" );
    return $buttons;
}
// ajout du script js pour le bouton dans TinyMCE
function sedoo_wppl_iframe_add_plugin( $plugin_array ) {
    $plugin_array['iframe'] = plugin_dir_url( __FILE__ ) . 'js/sedoo-wppl-iframe-shortcode.js';
    return $plugin_array;
}

function sedoo_wppl_iframe_shortcode_button() {

    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    if ( get_user_option('rich_editing') == 'true' ) {
        add_filter( 'mce_external_plugins', 'sedoo_wppl_iframe_add_plugin' );
        add_filter( 'mce_buttons', 'sedoo_wppl_iframe_register_button' );
    }

}

add_action('init', 'sedoo_wppl_iframe_shortcode_button');