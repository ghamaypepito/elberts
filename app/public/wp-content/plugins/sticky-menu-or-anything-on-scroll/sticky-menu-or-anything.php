<?php
/*
Plugin Name: Sticky Menu (or Anything!) on Scroll
Plugin URI: https://wordpress.org/plugins/sticky-menu-or-anything-on-scroll/
Description: Pick any element on the page, and it will stick when it reaches the top of the page when you scroll down. Handy for navigation menus, but can be used for any element on the page.
Author: WebFactory Ltd
Author URI: https://www.webfactoryltd.com/
Version: 2.2
*/

defined('ABSPATH') or die('INSERT COIN');


/**
 * === FUNCTIONS ========================================================================================
 */

/**
 * --- TRIGGERED ON ACTIVATION --------------------------------------------------------------------------
 * --- IF DATABASE VALUES ARE NOT SET AT ALL, ADD DEFAULT OPTIONS TO DATABASE ---------------------------
 */
if (!function_exists('sticky_anthing_default_options')) {
	function sticky_anthing_default_options() {
		$versionNum = '2.1.1';
		if (get_option('sticky_anything_options') === false) {
			$new_options['sa_version'] = $versionNum;
			$new_options['sa_element'] = '';
			$new_options['sa_topspace'] = '';
			$new_options['sa_adminbar'] = true;
			$new_options['sa_minscreenwidth'] = '';
			$new_options['sa_maxscreenwidth'] = '';
			$new_options['sa_zindex'] = '';
			$new_options['sa_legacymode'] = false;
			$new_options['sa_dynamicmode'] = false;
			$new_options['sa_debugmode'] = false;
			$new_options['sa_pushup'] = '';
			$new_options['sa_hide_review_notification'] = false;
			add_option('sticky_anything_options',$new_options);
		}
	}
}

/**
 * --- IF DATABASE VALUES EXIST, THEN THIS IS AN UPGRADE, SO CHECK IF NEWER OPTIONS EXIST --------------
 * --- IF NOT, ADD THESE OPTIONS WITH DEFAULT VALUES ---------------------------------------------------
 * --- AND UPDATE VERSION NUMBER FOR SURE --------------------------------------------------------------
 */
if (!function_exists('sticky_anything_update')) {
	function sticky_anything_update() {
		$versionNum = '2.1.1';
		$existing_options = get_option('sticky_anything_options');

		if(!isset($existing_options['sa_minscreenwidth'])) {
			// Introduced in version 1.1
			$existing_options['sa_minscreenwidth'] = '';
			$existing_options['sa_maxscreenwidth'] = '';
		}

		if(!isset($existing_options['sa_dynamicmode'])) {
			// Introduced in version 1.2
			$existing_options['sa_dynamicmode'] = false;
		}

		if(!isset($existing_options['sa_pushup'])) {
			// Introduced in version 1.3
			$existing_options['sa_pushup'] = '';
			$existing_options['sa_adminbar'] = true;
		}

		if(!isset($existing_options['sa_legacymode'])) {
			// Introduced in version 2.0
			// Keep the old/legacy mode, since that mode obviously worked before the upgrade.
			$existing_options['sa_legacymode'] = true;
    }

		$existing_options['sa_version'] = $versionNum;
		update_option('sticky_anything_options',$existing_options);
	}
}


/**
 * --- LOAD MAIN .JS FILE AND CALL IT WITH PARAMETERS (BASED ON DATABASE VALUES) -----------------------
 */
if (!function_exists('load_sticky_anything')) {
    function load_sticky_anything() {

		$options = get_option('sticky_anything_options');
		$versionNum = $options['sa_version'];

		// Main jQuery plugin file
			if($options['sa_debugmode']==true){
	    		wp_register_script('stickyAnythingLib', plugins_url('/assets/js/jq-sticky-anything.js', __FILE__), array( 'jquery' ), $versionNum);
	    	} else {
	    		wp_register_script('stickyAnythingLib', plugins_url('/assets/js/jq-sticky-anything.min.js', __FILE__), array( 'jquery' ), $versionNum);
	    	}
	    	wp_enqueue_script('stickyAnythingLib');

		// Set defaults for by-default-empty elements (because '' does not work with the JQ plugin)
		if (!$options['sa_topspace']) {
			$options['sa_topspace'] = '0';
		}

		if (!$options['sa_minscreenwidth']) {
			$options['sa_minscreenwidth'] = '0';
		}

		if (!$options['sa_maxscreenwidth']) {
			$options['sa_maxscreenwidth'] = '999999';
		}

		// If empty, set to 1 - not to 0. Also, if set to "0", keep it at 0.
		if (strlen($options['sa_zindex']) == "0") {		// LENGTH is 0 (not the actual value)
			$options['sa_zindex'] = '1';
		}

		$script_vars = array(
		      'element' => $options['sa_element'],
		      'topspace' => $options['sa_topspace'],
		      'minscreenwidth' => $options['sa_minscreenwidth'],
		      'maxscreenwidth' => $options['sa_maxscreenwidth'],
		      'zindex' => $options['sa_zindex'],
		      'legacymode' => $options['sa_legacymode'],
		      'dynamicmode' => $options['sa_dynamicmode'],
		      'debugmode' => $options['sa_debugmode'],
		      'pushup' => $options['sa_pushup'],
		      'adminbar' => $options['sa_adminbar']
		);

		wp_enqueue_script('stickThis', plugins_url('/assets/js/stickThis.js', __FILE__), array( 'jquery' ), $versionNum, true);
		wp_localize_script( 'stickThis', 'sticky_anything_engage', $script_vars );

    }
}


/**
 * --- ADD LINK TO SETTINGS PAGE TO SIDEBAR ------------------------------------------------------------
 */
if (!function_exists('sticky_anything_menu')) {
    function sticky_anything_menu() {
		add_options_page( 'Sticky Menu (or Anything!) Configuration', 'Sticky Menu (or Anything!)', 'manage_options', 'stickyanythingmenu', 'sticky_anything_config_page' );
    }
}


/**
 * --- ADD LINK TO SETTINGS PAGE TO PLUGIN ------------------------------------------------------------
 */
if (!function_exists('sticky_anything_settings_link')) {
function sticky_anything_settings_link($links) {
  $settings_link = '<a href="options-general.php?page=stickyanythingmenu">Settings</a>';
  array_unshift($links, $settings_link);
  return $links;
}
}


/**
 * --- THE WHOLE ADMIN SETTINGS PAGE -------------------------------------------------------------------
 */
if (!function_exists('sticky_anything_config_page')) {
	function sticky_anything_config_page() {
	// Retrieve plugin configuration options from database
	$sticky_anything_options = get_option( 'sticky_anything_options' );
	?>

	<div id="sticky-anything-settings-general" class="wrap">
		<h2><?php _e('Sticky Menu (or Anything!) Settings','sticky-menu-or-anything-on-scroll'); ?></h2>

		<p><?php _e('Pick any element on your page, and it will stick when it reaches the top of the page when you scroll down. Usually handy for navigation menus, but can be used for any (unique) element on your page.','sticky-menu-or-anything-on-scroll'); ?></p>
<?php
  if (!empty($sticky_anything_options['sa_element']) && empty($sticky_anything_options['sa_hide_review_notification'])) {
    $dismiss_url = add_query_arg(array('action' => 'sticky_hide_review_notification', 'redirect' => urlencode($_SERVER['REQUEST_URI'])), admin_url('admin.php'));
    $dismiss_url = wp_nonce_url($dismiss_url, 'sticky_hide_review_notification');
?>
    <div class="notice-info notice notice-rate"><p><strong>Help us keep Sticky Menu updated &amp; free!</strong></p>
  <p>Glad to see Sticky is helping you make things stick 😎<br>Please help other users learn about Sticky by rating it. It takes only a few clicks but it keeps the plugin free, updated and supported! <b>Thank you!</b></p>
  <p><a href="https://wordpress.org/support/plugin/sticky-menu-or-anything-on-scroll/reviews/#new-post" class="button button-primary" target="_blank">I want to rate &amp; keep Sticky Menu free!</a> &nbsp; <a href="<?php echo $dismiss_url; ?>">I already rated it</a></p>
  </div>
<?php
  }
?>
		<div class="main-content">

			<?php
				if ( isset( $_GET['tab'] )) {
					$activeTab = $_GET['tab'];
				} else {
					$activeTab = 'main';
				}
			?>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab <?php if ($activeTab == 'main') { echo 'nav-tab-active'; } ?>" href="#main"><?php _e('Basic settings','sticky-menu-or-anything-on-scroll'); ?></a>
				<a class="nav-tab <?php if ($activeTab == 'advanced') { echo 'nav-tab-active'; } ?>" href="#advanced"><?php _e('Advanced settings','sticky-menu-or-anything-on-scroll'); ?></a>
				<a class="nav-tab <?php if ($activeTab == 'faq') { echo ' nav-tab-active'; } ?>" href="#faq"><?php _e('FAQ/Troubleshooting','sticky-menu-or-anything-on-scroll'); ?></a>
			</h2>

			<br>

			<?php

				$warnings = false;

				if ( isset( $_GET['message'] )) {
					if ($_GET['message'] == '1') {
						echo '<div id="message" class="fade updated"><p><strong>'.__('Settings Updated.','sticky-menu-or-anything-on-scroll').'</strong></p></div>';
					}
				}

				if ( isset( $_GET['message'] )) {
					if ($sticky_anything_options['sa_element'] == '') {
						$warnings = true;
					}
				}

				if ( (!is_numeric(@$sticky_anything_options['sa_topspace'])) && (@$sticky_anything_options['sa_topspace'] != '')) {
					// Top space is not empty and has bad value
					$warnings = true;
				}

				if ( (!is_numeric($sticky_anything_options['sa_minscreenwidth'])) && ($sticky_anything_options['sa_minscreenwidth'] != '')) {
					// Minimum width is not empty and has bad value
					$warnings = true;
				}

				if ( (!is_numeric($sticky_anything_options['sa_maxscreenwidth'])) && ($sticky_anything_options['sa_maxscreenwidth'] != '')) {
					// Maximum width is not empty and has bad value
					$warnings = true;
				}

				if ( ($sticky_anything_options['sa_minscreenwidth'] != '') && ($sticky_anything_options['sa_maxscreenwidth'] != '') && ( ($sticky_anything_options['sa_minscreenwidth']) >= ($sticky_anything_options['sa_maxscreenwidth']) ) ) {
					// Minimum width is larger than the maximum width
					$warnings = true;
				}

				if ((!is_numeric(@$sticky_anything_options['sa_zindex'])) && (@$sticky_anything_options['sa_zindex'] != '')) {
					// Z-index is not empty and has bad value
					$warnings = true;
				}

				// IF THERE ARE ERRORS, SHOW THEM
				if ( $warnings == true ) {
					echo '<div id="message" class="error"><p><strong>'.__('Please review the current settings:','sticky-menu-or-anything-on-scroll').'</strong></p>';
					echo '<ul style="list-style-type:disc; margin:0 0 20px 24px;">';

					if ($sticky_anything_options['sa_element'] == '') {
						echo '<li>'.__('<b>Sticky Element</b> is a required field. If you do not want anything sticky, consider disabling the plugin.','sticky-menu-or-anything-on-scroll').'</li>';
					}

					if ( (!is_numeric($sticky_anything_options['sa_topspace'])) && ($sticky_anything_options['sa_topspace'] != '')) {
						echo '<li>'.__('<b>Top Position</b> has to be a number (do not include "px" or "pixels", or any other characters).','sticky-menu-or-anything-on-scroll').'</li>';
					}

					if ( (!is_numeric($sticky_anything_options['sa_minscreenwidth'])) && ($sticky_anything_options['sa_minscreenwidth'] != '')) {
						echo '<li>'.__('<b>Minimum Screen Width</b> has to be a number (do not include "px" or "pixels", or any other characters).','sticky-menu-or-anything-on-scroll').'</li>';
					}

					if ( (!is_numeric($sticky_anything_options['sa_maxscreenwidth'])) && ($sticky_anything_options['sa_maxscreenwidth'] != '')) {
						echo '<li>'.__('<b>Maximum Screen Width</b> has to be a number (do not include "px" or "pixels", or any other characters).','sticky-menu-or-anything-on-scroll').'</li>';
					}

					if ( ($sticky_anything_options['sa_minscreenwidth'] != '') && ($sticky_anything_options['sa_maxscreenwidth'] != '') && ( ($sticky_anything_options['sa_minscreenwidth']) >= ($sticky_anything_options['sa_maxscreenwidth']) ) ) {
						echo '<li>'.__('MAXIMUM screen width has to have a larger value than the MINIMUM screen width.','sticky-menu-or-anything-on-scroll').'</li>';
					}

					if ((!is_numeric($sticky_anything_options['sa_zindex'])) && ($sticky_anything_options['sa_zindex'] != '')) {
						echo '<li>'.__('<b>Z-Index</b> has to be a number (do not include any other characters).','sticky-menu-or-anything-on-scroll').'</li>';
					}

					echo '</ul></div>';
				}

			?>

			<div class="tabs-content">

				<form method="post" action="admin-post.php">

					<div class="tab-content tab-sticky-main <?php if ($activeTab != 'main') {echo 'hide';} ?>">

						<input type="hidden" name="action" value="save_sticky_anything_options" />
						<!-- Adding security through hidden referrer field -->
						<?php wp_nonce_field( 'sticky_anything' ); ?>

						<table class="form-table">

							<tr>
								<th scope="row"><label for="sa_element"><?php _e('Sticky Element:','sticky-menu-or-anything-on-scroll'); ?> (required)</label> <span tooltip="<?php _e('The element that needs to be sticky once you scroll. This can be your menu, or any other element like a sidebar, ad banner, etc. Make sure this is a unique identifier.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></span></th>
								<td>
									<input type="text" id="sa_element" name="sa_element" value="<?php
										if (@$sticky_anything_options['sa_element'] != '#NO-ELEMENT') {
											echo esc_html( @$sticky_anything_options['sa_element'] );
										}
									?>"/> <em><?php _e('(choose ONE element, e.g. <strong>#main-navigation</strong>, OR <strong>.main-menu-1</strong>, OR <strong>header nav</strong>, etc.)','sticky-menu-or-anything-on-scroll'); ?></em>
								</td>
							</tr>


							<tr>
								<th scope="row"><label for="sa_topspace"><?php _e('Space between top of page and sticky element: (optional)','sticky-menu-or-anything-on-scroll'); ?></label> <span tooltip="<?php _e('If you don\'t want the element to be sticky at the very top of the page, but a little lower, add the number of pixels that should be between your element and the \'ceiling\' of the page.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="number" id="sa_topspace" name="sa_topspace" value="<?php echo esc_html( @$sticky_anything_options['sa_topspace'] ); ?>" style="width:80px;" /> pixels
								</td>
							</tr>

							<tr>
								<th scope="row"><?php _e('Check for Admin Toolbar:','sticky-menu-or-anything-on-scroll'); ?> <span tooltip="<?php _e('If the sticky element gets obscured by the Administrator Toolbar for logged in users (or vice versa), check this box.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="checkbox" id="sa_adminbar" name="sa_adminbar" <?php if ($sticky_anything_options['sa_adminbar']  ) echo ' checked="checked" ';?> />
									<label for="sa_adminbar"><strong><?php _e('Move the sticky element down a little if there is an Administrator Toolbar at the top (for logged in users).','sticky-menu-or-anything-on-scroll'); ?></strong></label>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="sa_minscreenwidth"><?php _e('Do not stick element when screen is smaller than: (optional)','sticky-menu-or-anything-on-scroll'); ?></label> <span tooltip="<?php _e('Sometimes you do not want your element to be sticky when your screen is small (responsive menus, etc). If you enter a value here, your menu will not be sticky when your screen width is smaller than his value.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="number" id="sa_minscreenwidth" name="sa_minscreenwidth" value="<?php echo esc_html( $sticky_anything_options['sa_minscreenwidth'] ); ?>" style="width:80px;" /> pixels
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="sa_maxscreenwidth"><?php _e('Do not stick element when screen is larger than: (optional)','sticky-menu-or-anything-on-scroll'); ?></label> <span tooltip="<?php _e('Sometimes you do not want your element to be sticky when your screen is large (responsive menus, etc). If you enter a value here, your menu will not be sticky when your screen width is wider than this value.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="number" id="sa_maxscreenwidth" name="sa_maxscreenwidth" value="<?php echo esc_html( $sticky_anything_options['sa_maxscreenwidth'] ); ?>" style="width:80px;" /> pixels
								</td>
							</tr>

						</table>

					</div>

					<div class="tab-content tab-sticky-advanced <?php if ($activeTab != 'advanced') {echo 'hide';}?>">

						<input type="hidden" name="action" value="save_sticky_anything_options" />
						<!-- Adding security through hidden referrer field -->
						<?php wp_nonce_field( 'sticky_anything' ); ?>

						<table class="form-table">

							<tr>
								<th scope="row"><label for="sa_zindex"><?php _e('Z-index: (optional)','sticky-menu-or-anything-on-scroll'); ?></label> <span tooltip="<?php _e('If there are other elements on the page that obscure/overlap the sticky element, adding a Z-index might help. If you have no idea what that means, try entering 99999.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="number" id="sa_zindex" name="sa_zindex" value="<?php echo esc_html( @$sticky_anything_options['sa_zindex'] ); ?>" style="width:80px;" />
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="sa_pushup"><?php _e('Push-up element (optional):','sticky-menu-or-anything-on-scroll'); ?></label> <span tooltip="<?php _e('If you want your sticky element to be \'pushed up\' again by another element lower on the page, enter it here. Make sure this is a unique identifier.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="text" id="sa_pushup" name="sa_pushup" value="<?php
										if ($sticky_anything_options['sa_pushup'] != '#NO-ELEMENT') {
											echo esc_html( $sticky_anything_options['sa_pushup'] );
										}
									?>"/> <em><?php _e('(choose ONE element, e.g. <strong>#footer</strong>, OR <strong>.widget-bottom</strong>, etc.)','sticky-menu-or-anything-on-scroll'); ?></em>
								</td>
							</tr>

							<tr>
								<th scope="row"><!-- <span class="new"><?php _e('NEW!','sticky-menu-or-anything-on-scroll'); ?></span>--> <?php _e('Legacy mode:','sticky-menu-or-anything-on-scroll'); ?> <span tooltip="<?php _e('If you upgraded from an earlier version and it always worked before, use legacy mode to keep using the old method.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="checkbox" id="sa_legacymode" name="sa_legacymode" <?php if ($sticky_anything_options['sa_legacymode'] == true ) echo ' checked="checked" ';?> />
									<label for="sa_legacymode"><strong><?php _e('Legacy Mode (only recommended if you upgraded from earlier version).','sticky-menu-or-anything-on-scroll'); ?></strong></label>
									<p class="description"><?php _e('In version 2.0, a new/better method for making elements sticky was introduced. However, if you upgraded this plugin from an earlier version, and the old method always worked for you, there is no need to use the new method and you should keep this option checked.<br>More information about this setting can be found in the <a href="#faq" class="faq">FAQ</a>.','sticky-menu-or-anything-on-scroll'); ?></p>
								</td>
							</tr>

							<tr id="row-dynamic-mode" <?php if ($sticky_anything_options['sa_legacymode'] == false ) echo 'class="disabled-feature"';?>>
								<th scope="row"><div class="showhide" <?php if ($sticky_anything_options['sa_legacymode'] == false ) echo 'style="display:none;"';?>><?php _e('Dynamic mode:','sticky-menu-or-anything-on-scroll'); ?> <span tooltip="<?php _e('When Dynamic Mode is OFF, a cloned element will be created upon page load. If this mode is ON, a cloned element will be created every time your scrolled position hits the \'sticky\' point (option available in Legacy Mode only).','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></div></th>
								<td><div class="showhide" <?php if ($sticky_anything_options['sa_legacymode'] == false ) echo 'style="display:none;"';?>>
									<input type="checkbox" id="sa_dynamicmode" name="sa_dynamicmode" <?php if ($sticky_anything_options['sa_dynamicmode']  ) echo ' checked="checked" ';?> />
									<label for="sa_dynamicmode"><strong><?php _e('If the plugin doesn\'t work in your theme (often the case with responsive themes), try it in Dynamic Mode.','sticky-menu-or-anything-on-scroll'); ?></strong></label>
									<p class="description"><?php _e('NOTE: this is not a \'Magic Checkbox\' that fixes all problems. It simply solves some issues that frequently appear with some responsive themes, but doesn\'t necessarily work in ALL situations.','sticky-menu-or-anything-on-scroll'); ?></p>
									</div>
								</td>
							</tr>

							<tr>
								<th scope="row"><?php _e('Debug mode:','sticky-menu-or-anything-on-scroll'); ?> <span tooltip="<?php _e('When Debug Mode is on, error messages will be shown in your browser\'s console when the element you selected either doesn\'t exist, or when there are more elements on the page with your chosen selector.','sticky-menu-or-anything-on-scroll'); ?>"><span class="dashicons dashicons-editor-help"></span></a></th>
								<td>
									<input type="checkbox" id="sa_debugmode" name="sa_debugmode" <?php if (@$sticky_anything_options['sa_debugmode']  ) echo ' checked="checked" ';?> />
									<label for="sa_debugmode"><strong><?php _e('Log plugin errors in browser console','sticky-menu-or-anything-on-scroll'); ?></strong></label>
									<p class="description"><?php _e('This will help debugging the plugin in case of problems. Do NOT check this option in production environments.','sticky-menu-or-anything-on-scroll'); ?></p>
								</td>
							</tr>

						</table>

					</div>

					<div class="tab-content tab-sticky-main tab-sticky-advanced <?php if (($activeTab != 'main') && ($activeTab != 'advanced')) {echo 'hide';} ?>">

						<input type="hidden" name="sa_tab" value="<?php echo $activeTab ?>">

						&nbsp;<br><input type="submit" value="<?php _e('Save Changes','sticky-menu-or-anything-on-scroll'); ?>" class="button-primary"/>

					</div>

				</form>

				<div class="tab-content tab-sticky-faq <?php if ($activeTab != 'faq') {echo 'hide';} ?>">
					<?php include 'assets/faq.php'; ?>
				</div>

			</div>

		</div>


      <?php
      if (empty($sticky_anything_options['sa_hide_review_notification'])) {
        echo '<div class="main-sidebar">';
        include 'assets/sidebar.php';
        echo '</div>';
      }
       ?>

	</div>

	<?php
	}
}


if (!function_exists('sticky_anything_admin_init')) {
	function sticky_anything_admin_init() {
		add_action( 'admin_post_save_sticky_anything_options', 'process_sticky_anything_options' );
	}
}

/**
 * --- PROCESS THE SETTINGS FORM AFTER SUBMITTING ------------------------------------------------------
 */
if (!function_exists('process_sticky_anything_options')) {
	function process_sticky_anything_options() {

		if ( !current_user_can( 'manage_options' ))
			wp_die( 'Not allowed');

		check_admin_referer('sticky_anything');
		$options = get_option('sticky_anything_options');

		foreach ( array('sa_element') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_topspace') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_minscreenwidth') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_maxscreenwidth') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_zindex') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_pushup') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_adminbar') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = true;
			} else {
				$options[$option_name] = false;
			}
		}

		foreach ( array('sa_legacymode') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = true;
			} else {
				$options[$option_name] = false;
			}
		}

		foreach ( array('sa_dynamicmode') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = true;
			} else {
				$options[$option_name] = false;
			}
		}

		foreach ( array('sa_debugmode') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = true;
			} else {
				$options[$option_name] = false;
			}
		}

		foreach ( array('sa_tab') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		$tabValue = $_POST['sa_tab'];

		update_option( 'sticky_anything_options', $options );
 		wp_redirect( add_query_arg(
 			array('page' => 'stickyanythingmenu', 'message' => '1', 'tab' => $tabValue),
 			admin_url( 'options-general.php' )
 			)
 		);

		exit;
	}
}


/**
 * --- ADD THE .CSS AND .JS TO ADMIN MENU --------------------------------------------------------------
 */
if (!function_exists('sticky_anything_styles')) {
	function sticky_anything_styles($hook) {
		if ($hook != 'settings_page_stickyanythingmenu') {
			return;
		}

		wp_register_script('stickyAnythingAdminScript', plugins_url('/assets/js/sticky-anything-admin.js', __FILE__), array( 'jquery' ), '2.1.1');
		wp_enqueue_script('stickyAnythingAdminScript');

		wp_register_style('stickyAnythingAdminStyle', plugins_url('/assets/css/sticky-anything-admin.css', __FILE__) );
	    wp_enqueue_style('stickyAnythingAdminStyle');
	}
}

/**
   * Helper function for adding plugins to featured list
   *
   * @return array
   */
  function sticky_featured_plugins_tab($args)
  {
    add_filter('plugins_api_result', 'sticky_plugins_api_result', 10, 3);

    return $args;
  } // sticky_featured_plugins_tab


  /**
   * Add single plugin to featured list
   *
   * @return object
   */
  function sticky_add_plugin_featured($plugin_slug, $res)
  {
    // check if plugin is already on the list
    if (!empty($res->plugins) && is_array($res->plugins)) {
      foreach ($res->plugins as $plugin) {
        if (is_object($plugin) && !empty($plugin->slug) && $plugin->slug == $plugin_slug) {
          return $res;
        }
      } // foreach
    }

    $plugin_info = get_transient('wf-plugin-info-' . $plugin_slug);

    if (!$plugin_info) {
      $plugin_info = plugins_api('plugin_information', array(
        'slug'   => $plugin_slug,
        'is_ssl' => is_ssl(),
        'fields' => array(
          'banners'           => true,
          'reviews'           => true,
          'downloaded'        => true,
          'active_installs'   => true,
          'icons'             => true,
          'short_description' => true,
        )
      ));
      if (!is_wp_error($plugin_info)) {
        set_transient('wf-plugin-info-' . $plugin_slug, $plugin_info, DAY_IN_SECONDS * 7);
      }
    }

    if (!empty($res->plugins) && is_array($res->plugins) && $plugin_info && is_object($plugin_info)) {
      array_unshift($res->plugins, $plugin_info);
    }

    return $res;
  } // sticky_add_plugin_featured


  /**
   * Add plugins to featured plugins list
   *
   * @return object
   */
  function sticky_plugins_api_result($res, $action, $args)
  {
    remove_filter('plugins_api_result', 'sticky_plugins_api_result', 10, 3);

    $res = sticky_add_plugin_featured('wp-external-links', $res);
    $res = sticky_add_plugin_featured('wp-force-ssl', $res);
    $res = sticky_add_plugin_featured('eps-301-redirects', $res);

    return $res;
  } // sticky_plugins_api_result


  function sticky_hide_review_notification() {
    if (false == wp_verify_nonce(@$_GET['_wpnonce'], 'sticky_hide_review_notification')) {
      wp_die('Please click back, reload the page and try again.');
    }

    $sticky_anything_options = get_option( 'sticky_anything_options' );
    $sticky_anything_options['sa_hide_review_notification'] = true;
    update_option('sticky_anything_options', $sticky_anything_options);

    if (!empty($_GET['redirect'])) {
      wp_safe_redirect(esc_url($_GET['redirect']));
    } else {
      wp_safe_redirect(admin_url('options-general.php?page=stickyanythingmenu'));
    }

    exit;
  } // sticky_hide_review_notification

/**
 * === HOOKS AND ACTIONS AND FILTERS AND SUCH ==========================================================
 */

$plugin = plugin_basename(__FILE__);

register_activation_hook( __FILE__, 'sticky_anthing_default_options' );
add_action('init','sticky_anything_update',1);
add_action('wp_enqueue_scripts', 'load_sticky_anything');
add_action('admin_menu', 'sticky_anything_menu');
add_action('admin_init', 'sticky_anything_admin_init' );
add_action('admin_enqueue_scripts', 'sticky_anything_styles' );
add_filter("plugin_action_links_$plugin", 'sticky_anything_settings_link' );
add_filter('install_plugins_table_api_args_featured', 'sticky_featured_plugins_tab');
add_action('admin_action_sticky_hide_review_notification', 'sticky_hide_review_notification');
