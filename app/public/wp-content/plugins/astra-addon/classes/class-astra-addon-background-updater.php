<?php
/**
 * Astra Addon Batch Update
 *
 * @package     Astra Addon
 * @since       2.1.3
 */

if ( ! class_exists( 'Astra_Addon_Background_Updater' ) ) {

	/**
	 * Astra_Addon_Background_Updater Class.
	 */
	class Astra_Addon_Background_Updater {

		/**
		 * Background update class.
		 *
		 * @var object
		 */
		private static $background_updater;

		/**
		 * DB updates and callbacks that need to be run per version.
		 *
		 * @var array
		 */
		private static $db_updates = array(
			'2.2.0' => array(
				'astra_addon_page_builder_button_color_compatibility',
			),
		);

		/**
		 *  Constructor
		 */
		public function __construct() {

			// Addon Updates.
			if ( is_admin() ) {
				add_action( 'admin_init', array( $this, 'install_actions' ) );
			} else {
				add_action( 'wp', array( $this, 'install_actions' ) );
			}

			// Core Helpers - Batch Processing.
			require_once ASTRA_EXT_DIR . 'classes/library/batch-processing/wp-async-request.php';
			require_once ASTRA_EXT_DIR . 'classes/library/batch-processing/wp-background-process.php';
			require_once ASTRA_EXT_DIR . 'classes/library/batch-processing/class-wp-background-process-astra-addon.php';

			self::$background_updater = new WP_Background_Process_Astra_Addon();
		}

		/**
		 * Install actions when a update button is clicked within the admin area.
		 *
		 * This function is hooked into admin_init to affect admin and wp to affect the frontend.
		 *
		 * @since 2.1.3
		 * @return void
		 */
		public function install_actions() {

			if ( true === $this->is_new_install() ) {
				self::update_db_version();
				return;
			}

			$customizer_options = get_option( 'astra-settings' );

			$is_queue_running = ( isset( $customizer_options['is_addon_queue_running'] ) && '' !== $customizer_options['is_addon_queue_running'] ) ? $customizer_options['is_addon_queue_running'] : false;

			if ( $this->needs_db_update() && ! $is_queue_running ) {
				$this->update();
			} else {
				if ( ! $is_queue_running ) {
					self::update_db_version();
				}
			}

		}

		/**
		 * Is this a brand new addon install?
		 *
		 * @since 2.1.3
		 * @return boolean
		 */
		private function is_new_install() {

			// Get auto saved version number.
			$saved_version = Astra_Addon_Update::astra_addon_stored_version();

			if ( false === $saved_version ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Is a DB update needed?
		 *
		 * @since 2.1.3
		 * @return boolean
		 */
		private function needs_db_update() {

			$updates = $this->get_db_update_callbacks();

			if ( empty( $updates ) ) {
				return false;
			}

			$customizer_options = get_option( 'astra-settings' );

			$addon_auto_version = ( isset( $customizer_options['astra-addon-auto-version'] ) && '' !== $customizer_options['astra-addon-auto-version'] ) ? $customizer_options['astra-addon-auto-version'] : null;

			return ! is_null( $addon_auto_version ) && version_compare( $addon_auto_version, max( array_keys( $updates ) ), '<' );
		}

		/**
		 * Is the DB update needed?
		 *
		 * @since 2.2.0
		 * @return boolean
		 */
		private function is_db_updated() {
			$customizer_options = get_option( 'astra-settings' );

			$addon_auto_version = ( isset( $customizer_options['astra-addon-auto-version'] ) && '' !== $customizer_options['astra-addon-auto-version'] ) ? $customizer_options['astra-addon-auto-version'] : null;

			return version_compare( $addon_auto_version, ASTRA_EXT_VER, '=' );
		}

		/**
		 * Get list of DB update callbacks.
		 *
		 * @since 2.1.3
		 * @return array
		 */
		public function get_db_update_callbacks() {
			return self::$db_updates;
		}

		/**
		 * Push all needed DB updates to the queue for processing.
		 */
		private function update() {

			$current_db_version = Astra_Addon_Update::astra_addon_stored_version();

			error_log( 'Astra Addon: Batch Process Started!' );
			if ( count( $this->get_db_update_callbacks() ) > 0 ) {
				foreach ( $this->get_db_update_callbacks() as $version => $update_callbacks ) {
					if ( version_compare( $current_db_version, $version, '<' ) ) {
						foreach ( $update_callbacks as $update_callback ) {
							error_log( sprintf( 'Astra Addon: Queuing %s - %s', $version, $update_callback ) );

							self::$background_updater->push_to_queue( $update_callback );
						}
					}
				}

				$customizer_options = get_option( 'astra-settings' );

				// Get all customizer options.
				$version_array = array(
					'is_addon_queue_running' => true,
				);

				// Merge customizer options with version.
				$astra_options = wp_parse_args( $version_array, $customizer_options );

				update_option( 'astra-settings', $astra_options );

				self::$background_updater->push_to_queue( 'update_db_version' );
			} else {
				self::$background_updater->push_to_queue( 'update_db_version' );
			}
			self::$background_updater->save()->dispatch();
		}

		/**
		 * Update DB version to current.
		 *
		 * @param string|null $version New Astra addon version or null.
		 */
		public static function update_db_version( $version = null ) {

			do_action( 'astra_addon_update_before' );

			// Get auto saved version number.
			$saved_version = Astra_Addon_Update::astra_addon_stored_version();

			if ( false === $saved_version ) {

				// Get all customizer options.
				$customizer_options = get_option( 'astra-settings' );

				// Get all customizer options.
				/* Add Current version constant "ASTRA_EXT_VER" here after 1.0.0-rc.9 update */
				$version_array = array(
					'astra-addon-auto-version' => ASTRA_EXT_VER,
				);
				$saved_version = ASTRA_EXT_VER;

				// Merge customizer options with version.
				$astra_options = wp_parse_args( $version_array, $customizer_options );

				// Update auto saved version number.
				update_option( 'astra-settings', $astra_options );
			}

			// If equals then return.
			if ( version_compare( $saved_version, ASTRA_EXT_VER, '=' ) ) {
				do_action( 'astra_addon_update_after' );
				// Get all customizer options.
				$customizer_options = get_option( 'astra-settings' );

				// Get all customizer options.
				$options_array = array(
					'is_addon_queue_running' => false,
				);

				// Merge customizer options with version.
				$astra_options = wp_parse_args( $options_array, $customizer_options );

				// Update auto saved version number.
				update_option( 'astra-settings', $astra_options );
				return;
			}

			// Refresh Astra Addon CSS and JS Files on update.
			Astra_Minify::refresh_assets();

			$astra_addon_version = ASTRA_EXT_VER;

			// Get all customizer options.
			$customizer_options = get_option( 'astra-settings' );

			// Get all customizer options.
			$options_array = array(
				'astra-addon-auto-version' => $astra_addon_version,
				'is_addon_queue_running'   => false,
			);

			// Merge customizer options with version.
			$astra_options = wp_parse_args( $options_array, $customizer_options );

			// Update auto saved version number.
			update_option( 'astra-settings', $astra_options );

			error_log( 'Astra Addon: DB version updated!' );

			// Update variables.
			Astra_Theme_Options::refresh();

			do_action( 'astra_addon_update_after' );
		}
	}
}


/**
 * Kicking this off by creating a new instance
 */
new Astra_Addon_Background_Updater;
