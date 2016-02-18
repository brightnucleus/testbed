<?php
/**
 * Bright Nucleus Testbed
 *
 * @package   BrightNucleus\Testbed
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      https://www.brightnucleus.com/
 * @copyright 2016 Bright Nucleus, Alain Schlesser
 *
 * @wordpress-plugin
 * Plugin Name: Bright Nucleus Testbed
 * Plugin URI:  https://www.brightnucleus.com/
 * Description: Testing grounds for the different Bright Nucleus components.
 * Version:     0.1.0
 * Author:      Alain Schlesser
 * Author URI:  https://www.alainschlesser.com/
 * Text Domain: bn-testbed
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace BrightNucleus\Testbed;

use BrightNucleus\Config\Config;
use BrightNucleus\Testbed\Plugin as Testbed;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'BN_TESTBED_DIR' ) ) {
	define( 'BN_TESTBED_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Load Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Initialize the plugin.
$config = new Config( include __DIR__ . '/config/defaults.php' );
$prefix = 'BrightNucleus\Testbed';
Testbed::get_instance( $config->getSubConfig( $prefix ) )->run();
