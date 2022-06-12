<?php
/*
 * Plugin Name: Winnipeg Address Lookup
 * Description: Use your address to find your ward and school ward Data sourced from City of Winnipeg's Open Data https://data.winnipeg.ca/City-Planning/Addresses/cam2-ii3u
 * Version: 1.0
 * */

function handle_address_lookup_shortcode() {
	    return '<div id="address-lookup-widget"></div>';
}
add_shortcode('address-lookup-widget', 'handle_address_lookup_shortcode');

function address_lookup_enqueue_scripts(){
  //wp_enqueue_script('vue', 'https://unpkg.com/vue@3.2.13/dist/vue.global.prod.js', [], '3');
  wp_enqueue_script('address-lookup-widget', plugin_dir_url( __FILE__ ) . 'js/address_lookup_widget.umd.js', [], '1.0', true);
  wp_enqueue_style('address-lookup-widget-css', plugin_dir_url( __FILE__ ) . 'js/address_lookup_widget.css', [], '1.0');

}

add_action( 'wp_enqueue_scripts', 'address_lookup_enqueue_scripts' );
