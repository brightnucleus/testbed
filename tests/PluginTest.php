<?php
/**
 * Bright Nucleus Testbed PluginTest Class
 *
 * @package   BrightNucleus\Testbed
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      https://www.brightnucleus.com/
 * @copyright 2016 Bright Nucleus, Alain Schlesser
 */

namespace BrightNucleus\Testbed;

use BrightNucleus\Config\Config;
use BrightNucleus\Testbed\Plugin as Testbed;

class PluginTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @covers BrightNucleus\Testbed\Plugin::__construct
	 * @covers BrightNucleus\Testbed\Plugin::get_instance
	 */
	public function testGetInstance() {
		define( 'BN_TESTBED_DIR', __DIR__ . '/..' );
		$config = new Config( include BN_TESTBED_DIR . '/config/defaults.php' );
		$prefix = 'BrightNucleus\Testbed';
		$plugin = Testbed::get_instance( $config->getSubConfig( $prefix ) );
		$this->assertNotNull( $plugin );
		$this->assertInstanceOf( 'BrightNucleus\Testbed\Plugin', $plugin );
	}

	/**
	 * @covers BrightNucleus\Testbed\Plugin::get_instance
	 * @covers BrightNucleus\Testbed\Plugin::run
	 */
	public function testRunInstance() {
		$plugin = Testbed::get_instance();
		$plugin->run();
		$this->assertTrue( true );
	}
}
