<?php function toastsi_update(){ $items_json = $_POST['json']; update_option('toastsi-json', $items_json); die();}
add_action( 'wp_ajax_toastsi_update', 'toastsi_update' );
add_action( 'wp_ajax_nopriv_toastsi_update', 'toastsi_update' ); ?>