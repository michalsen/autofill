<?php
/*
Plugin Name: Autofill
Plugin URI: http://localhost
Description: Autofilling Wordpress content since 1975.
Version:     1
Author: Eric L. Michalsen
Author URI:
Text Domain: wporg
Domain Path: /languages
License:     GPL2

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


include_once( 'includes/admin/class-autofill-admin.php' );



//[punchgroove]
function autofill_search(){
  include( 'includes/autofill.tpl.php' );
  return $form;

}

add_shortcode('autofill', 'autofill_search');

