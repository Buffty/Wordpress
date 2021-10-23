<?php
/*
Plugin Name: Personalización de tema
Description: Plugin personalizado para la personalización del tema.
Version: 1.0.0
Author: Salva Alcover Fuster
License: GPLv2
Text domain: custom_plugin
*/

defined('ABSPATH') or die("Por aquí no es...");
define('INNOVANT_SHOP_PLUGIN',plugin_dir_path(__FILE__));


// SHORTCODES 
require_once('functions/shortcodes.php');
require_once('functions/posts.php');

// REGISTRO DE ASSETS
function custom_assets() {
    wp_enqueue_script('jquery');
    wp_register_script('custom_plugin',plugins_url('/assets/js/utils.js',__FILE__));
    wp_localize_script( 'custom_plugin', 'ajax_public',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script('custom_plugin');
}

function insert_custom_css(){
    wp_register_style('custom_plugin_css',plugins_url('/assets/css/style.css' ,__FILE__));
    wp_enqueue_style( 'custom_plugin_css' );
}

// INSERT PARTE PÚBLICA
add_action('wp_enqueue_scripts','custom_assets');
add_action('wp_enqueue_scripts','insert_custom_css');

// INSERT PARTE ADMINISTRATIVA
add_action("admin_enqueue_scripts", "custom_assets");
add_action("admin_enqueue_scripts", "insert_custom_css");

