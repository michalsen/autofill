<?php

   // TO CHANGE!
   require_once( "../../../../../wp-config.php" );

/**
 *  Dropdown autofill off the text input
 *
 */

if (strlen($_REQUEST['filtervalue']) > 0) {
  global $wpdb;
  $query = 'SELECT name FROM ' . $wpdb->prefix . 'terms WHERE name like "%' . $_REQUEST['filtervalue'] . '%" ORDER BY NAME DESC';
  $results = $wpdb->get_results($query);

  $dropdown = '';
  foreach ($results as $key => $value) {
    $dropdown .= '<option value="' . $value->name . '">' . $value->name . '</option>';
  }

  echo $dropdown;


}
