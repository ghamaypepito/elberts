<?php

class BrizyPro_Admin_License {

	const LICENSE_META_KEY = 'brizy-license-key';

	/**
	 * @var Brizy_TwigEngine
	 */
	public $twig;

	/**
	 * @return BrizyPro_Admin_License
	 * @throws Exception
	 */
	public static function _init() {

		static $instance;

		return $instance ? $instance : $instance = new self( );
	}

	public function getCurrentLicense() {
		return Brizy_Editor_Project::get()->getMetaValue( self::LICENSE_META_KEY );
	}

	protected function updateLicense( $licenseKey ) {
		Brizy_Editor_Project::get()->setMetaValue( self::LICENSE_META_KEY, $licenseKey );
		Brizy_Editor_Project::get()->save();
	}

	protected function removeLicense() {
		Brizy_Editor_Project::get()->removeMetaValue( self::LICENSE_META_KEY );
		Brizy_Editor_Project::get()->save();
	}


	/**
	 * BrizyPro_Admin_License constructor.
	 *
	 * @param Brizy_Editor_Project $project
	 *
	 * @throws Exception
	 */
	private function __construct( ) {

		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'actionRegisterLicensePage' ), 11 );
		} else {
			add_action( 'admin_menu', array( $this, 'actionRegisterLicensePage' ), 11 );
		}


		if ( isset( $_REQUEST['brz-action'] ) && $_REQUEST['brz-action'] == 'activate' && isset( $_REQUEST['code'] ) && isset( $_REQUEST['key'] ) ) {
			add_action( 'admin_init', array( $this, 'handleKeyActivation' ), 10 );
		}

		if ( isset( $_REQUEST['brz-action'] ) && $_REQUEST['brz-action'] == 'deactivate' && isset( $_REQUEST['code'] ) && isset( $_REQUEST['key'] ) ) {
			add_action( 'admin_init', array( $this, 'handleKeyDeactivation' ), 10 );
		}

		add_action( 'custom_menu_order', array( $this, 'changeMenuItemOrder' ) );

		$this->twig = Brizy_TwigEngine::instance( BRIZY_PRO_PLUGIN_PATH . "/admin/views/" );
	}

	public function changeMenuItemOrder() {
		global $submenu;

		$find_page = 'brizy-settings';
		$find_sub  = 'brizy-pro-license';
		$license   = null;
		foreach ( $submenu as $page => &$items ) {
			if ( $page == $find_page ) {
				foreach ( $items as $order => &$meta ) {
					if ( $meta[2] == $find_sub ) {
						$license = $submenu[ $page ][ $order ];
						unset( $submenu[ $page ][ $order ] );
					};
				};

				if ( $license ) {
					$submenu[ $page ][] = $license;
				}
			};
		};
	}

	public function actionRegisterLicensePage() {
		add_submenu_page(
			is_multisite() ? BrizyPro_Admin_WhiteLabel::network_menu_slug() : Brizy_Admin_Settings::menu_slug(),
			__( 'License','brizy-pro' ),
			__( 'License','brizy-pro' ),
			is_multisite() ? 'manage_network' : 'manage_options',
			is_multisite() ? self::network_menu_slug() : self::menu_slug(),
			array(
				$this,
				'render'
			) );
	}

	public function render() {
		$licenseData   = $this->getCurrentLicense();

		if ( is_multisite() ) {
			$menu_page_url = network_admin_url( 'admin.php?page=' . self::network_menu_slug(), false );
		} else {
			$menu_page_url = menu_page_url( self::menu_slug(), false );
		}


		$data = BrizyPro_Config::getLicenseActivationData();

		$data['request'] = array( 'domain' => home_url() );

		$data['redirect'] = add_query_arg( 'brz-action', $licenseData ? 'deactivate' : 'activate', $menu_page_url );;

		// prepare license
		$key = $licenseData['key'];
		if ( $key ) {
			$l = strlen( $licenseData['key'] );
			$t = str_repeat( '*', $l - 6 );

			$key = substr( $licenseData['key'], 0, 3 ) . $t . substr( $licenseData['key'], $l - 3, 3 );
		}

		$context = array(
			'nonce'        => wp_nonce_field( 'validate-license', '_wpnonce', true, false ),
			'action'       => $licenseData ? BrizyPro_Config::DEACTIVATE_LICENSE : BrizyPro_Config::ACTIVATE_LICENSE,
			'submit_label' => $licenseData ? esc_html__( 'Deactivate', 'brizy-pro' ) : __( 'Activate', 'brizy-pro' ),
			'license'      => $key,
			'licenseFull'  => $licenseData['key'],
			'licensed'     => $licenseData ? true : false,
			'message'      => isset( $_REQUEST['messsage'] ) ? $_REQUEST['messsage'] : null,
			'data'         => $data
		);

		echo $this->twig->render( 'license.html.twig', $context );
	}

	public function handleKeyActivation() {
		// handle key activation
		if ( $_GET['brz-action'] == 'activate' ) {

			if ( is_multisite() ) {
				$pageUrl = network_admin_url( 'admin.php?page=' . self::network_menu_slug(), false );
			} else {
				$pageUrl = menu_page_url( self::menu_slug(), false );
			}

			if ( $_REQUEST['code'] == 'ok' ) {
				$data        = BrizyPro_Config::getLicenseActivationData();
				$data['key'] = $_REQUEST['key'];
				$this->updateLicense( $data );
				Brizy_Admin_Flash::instance()->add_success( esc_html__( $_REQUEST['message'], 'brizy-pro' ) );
			} else {
				Brizy_Admin_Flash::instance()->add_error( esc_html__( $_REQUEST['message'], 'brizy-pro' ) );
			}

			wp_redirect( $pageUrl );
			exit;
		}
	}

	public function handleKeyDeactivation() {
		// handle key activation
		if ( $_GET['brz-action'] == 'deactivate' ) {

			if ( is_multisite() ) {
				$pageUrl = network_admin_url( 'admin.php?page=' . self::network_menu_slug(), false );
			} else {
				$pageUrl = menu_page_url( self::menu_slug(), false );
			}

			if ( $_REQUEST['code'] == 'ok' || $_REQUEST['code'] == 'no_activation_found' || $_REQUEST['code'] == 'no_reactivation_allowed' || $_REQUEST['code'] == 'license_not_found' ) {
				Brizy_Admin_Flash::instance()->add_success( esc_html__( $_REQUEST['message'], 'brizy-pro' ) );
			} else {
				Brizy_Admin_Flash::instance()->add_error( esc_html__( $_REQUEST['message'], 'brizy-pro' ) );
			}

			$this->removeLicense();

			wp_redirect( $pageUrl );
			exit;
		}
	}

	public static function menu_slug() {
		return 'brizy-pro-license';
	}

	public static function network_menu_slug() {
		return 'network-brizy-pro-license';
	}
}