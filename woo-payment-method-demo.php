<?php
/**
 * Woo Shipping Method Demo (by DeveloperHero.net)
 *
 * @author      M Yakub Mizan
 * @license     GPL-2.0+
 *
 * Plugin Name: Woo Shipping Method Demo
 * Plugin URI:  https://developerhero.net/woo-shipping-method-demo
 * Description: Woo Shipping Method Demo
 * Version:     1.0.2
 * Author:      M Yakub Mizan
 * Author URI:  https://developerhero.net
 * Text Domain: wooship
 *
 * WC tested up to: 3.5
 *
 * Tested up to: 5
 *
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('WOOSHIP_NAME', 'Woo Shipping Method Demo');
define('WOOSHIP_VERSION', '1.0.0');

require_once "includes/class.wooship.shipping.method.php";

class WOOSHIP_Main {

	protected static $_instance = null;

	/**
	** Ensures only one single instance is available
	**/
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {
		if (is_admin()) //include only if in admin
		{
			require_once "includes/class.wooship.settings.section.php";

		}
	}
}

WOOSHIP_Main::instance();