<?php /*
   Plugin Name: Sticky Anything
   Plugin URI:
   description: Easily make elements on your site sticky.
   Version: 2.0.2
   Author: Toast Plugins
   Author URI: https://www.toastplugins.co.uk/
   */ ?>
<?php include dirname(__FILE__) . '/frontend/frontend-script.php'; ?>
<?php include dirname(__FILE__) . '/backend/backend.php'; ?>
<?php include dirname(__FILE__) . '/backend/functions.php'; ?>
<?php function toastsi_enqueue_backend_scripts(){
if($_GET['page'] == 'toast_sticky_items'):
wp_enqueue_style('toastsi_backend_styles', plugin_dir_url(__FILE__).'/backend/style.css', array(), null);
wp_enqueue_script('toastsi_backend_script', plugin_dir_url(__FILE__).'/backend/script.js', array('jquery'), null);
endif;
} ?>
<?php add_action('admin_enqueue_scripts', 'toastsi_enqueue_backend_scripts'); ?>