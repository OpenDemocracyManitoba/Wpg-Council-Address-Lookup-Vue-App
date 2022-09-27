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
  wp_localize_script(
      'address-lookup-widget',
      'logger_ajax_obj',
      array(
          'ajax_url' => admin_url( 'admin-ajax.php' ),
          'nonce'    => wp_create_nonce( 'logger_ajax_nonce' ),
      )
  );

}

function lookup_log_custom_post_type() {
  register_post_type('wpg_lookup_log_entry',
    array(
      'labels' => array(
          'name'          => __('Lookup Logs', 'textdomain'),
          'singular_name' => __('Lookup Log', 'textdomain'),
      ),
      'description' => 'A lookup entry saved to assist with debugging missed addresses',
      'public'      => false,
      'show_ui'     => true,
      'show_in_menu' => true,
      'has_archive' => true,
    )
  );
}

function save_log_as_posted_data($address) {
  // Gather post data.
  $my_post = array(
      'post_title'    => wp_strip_all_tags($address),
      'post_content'  => '',
      'post_status'   => 'publish',
      'post_author'   => 1,
  );

  // Insert the post into the database.
  wp_insert_post( $my_post );
}

function handle_logged_error_lookup() {
  $address = sanitize_text_field($_POST["address"]);
  save_log_as_posted_data($address);
  return wp_send_json(['status' => 'saved']);
}

add_action( 'wp_enqueue_scripts', 'address_lookup_enqueue_scripts' );

add_action('init', 'lookup_log_custom_post_type');

add_action('wp_ajax_handle_logged_error_lookup', 'handle_logged_error_lookup');
add_action('wp_ajax_nopriv_handle_logged_error_lookup', 'handle_logged_error_lookup');
