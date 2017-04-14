<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


global $jal_db_version;
$jal_db_version = '1.0';



class AutoFill_Admin {

  public function __construct() {

    add_action('init', array( $this, 'wp_autofill_admin_init'));
    add_action('init', array( $this, 'admin_scripts_style'));
    //add_action('admin_menu', array( $this, 'admin_menu'));

  }

  public function admin_scripts_style() {
              wp_enqueue_script('jquery');
              wp_enqueue_script('autofillJS',"/wp-content/plugins/autofill/assets/js/autofill.js" );
              wp_enqueue_script('autofillJS');
              wp_enqueue_style('autofillCSS',"/wp-content/plugins/autofill/assets/css/autofill.css" );
              wp_enqueue_style('autofillCSS');
  }


  public function admin_menu() {
    $page = add_management_page('Auto Fill', 'Auto Fill ', 'manage_options', 'autofill', array( $this,'wp_autofill_settings_page'));
  }


  function wp_autofill_admin_init() {
    if(is_admin()){

    }
  }

  public function wp_autofill_settings_page(){
    include('functions.php');
  }


}


return new autofill_Admin();



// function autofill_install() {
//   global $wpdb;
//   global $jal_db_version;

//   $table_name = $wpdb->prefix . 'autofill';

//   $charset_collate = $wpdb->get_charset_collate();

//   $sql = "CREATE TABLE $table_name (
//     id mediumint(9) NOT NULL AUTO_INCREMENT,
//     time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
//     name tinytext NOT NULL,
//     shortcode text NOT NULL,
//     code text NOT NULL,
//     PRIMARY KEY  (id)
//   ) $charset_collate;";

//   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//   dbDelta( $sql );

//   add_option( 'jal_db_version', $jal_db_version );
// }


function getOptions($tax) {

  switch ($tax) {
    case 'Categories':
      $data = array('vimeo-videos');
      break;
    default:
      $data = array('vimeo-tag');
      break;
  }

 $args = array(
     'hide_empty' => 0
 );

 $terms = get_terms($data, $args);
 $options  = '<option value="">' . $tax . '</option>';
 $empty_terms=array();

  foreach( $terms as $term ){
          $options .= '<option value="' . $term->slug  . '">' . $term->name . ' (' . $term->count . ')' . '</option>';
  }

  return $options;
}

