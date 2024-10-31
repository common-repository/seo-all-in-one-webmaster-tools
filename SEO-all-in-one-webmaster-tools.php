<?php 
    /*
    Plugin Name: SEO All In One Webmaster Tools
    Plugin URI: https://wordpress.org/plugins/seo-all-in-one-webmaster-tools/
    Description: Try our free SEO All In One white label site report audit tool, generate free PDF report for your site.
    Author: Metric Buzz
    Version: 3.5
    Author URI: http://goo.gl/Jz0HPD
    */

if ( ! defined( 'ABSPATH' ) ) exit;

function seo_aiowt_admin() {
   include('seo_aiowt_import_admin.php');
}

function seo_aiowt_admin_actions() {
    add_menu_page("SEO All In One Webmaster Tools", "SEO All In One Webmaster Tools", 1, "SEOAllInOneWebmasterTools", "seo_aiowt_admin");
}
 
add_action('admin_menu', 'seo_aiowt_admin_actions');


?>
