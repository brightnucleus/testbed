<?php
/**
 * Bright Nucleus Testbed Plugin Class
 *
 * @package   BrightNucleus\Testbed
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      https://www.brightnucleus.com/
 * @copyright 2016 Bright Nucleus, Alain Schlesser
 */

namespace BrightNucleus\Testbed;

use BrightNucleus\Config\ConfigInterface;
use BrightNucleus\Config\ConfigTrait;
use BrightNucleus\Dependency\DependencyManager;
use BrightNucleus\Exception\InvalidArgumentException;
use BrightNucleus\Exception\RuntimeException;
use BrightNucleus\Exception\UnexpectedValueException;
use BrightNucleus\Shortcode\ShortcodeManager;

/**
 * Class Plugin
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Testbed
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class Plugin {

	use ConfigTrait;

	/*
	 * Static instance of the plugin.
	 *
	 * @since 0.1.0
	 *
	 * @var \BrightNucleus\Testbed\Plugin
	 */
	protected static $instance;

	/**
	 * Instantiate a Plugin object.
	 *
	 * Don't call the constructor directly, use the `Plugin::get_instance()`
	 * static method instead.
	 *
	 * @since 0.1.0
	 *
	 * @param ConfigInterface $config Config to parametrize the object.
	 * @throws RuntimeException If the Config could not be parsed correctly.
	 */
	public function __construct( ConfigInterface $config ) {
		$this->processConfig( $config );
	}

	/**
	 * Get a reference to the Plugin instance.
	 *
	 * @since 0.1.0
	 *
	 * @param ConfigInterface $config Optional. Config to parametrize the
	 *                                object.
	 * @return \BrightNucleus\Testbed\Plugin
	 * @throws RuntimeException If the Config could not be parsed correctly.
	 */
	public static function get_instance( ConfigInterface $config = null ) {
		if ( ! self::$instance ) {
			self::$instance = new self( $config );
		}

		return self::$instance;
	}

	/**
	 * Launch the initialization process.
	 *
	 * @since 0.1.0
	 */
	public function run() {
		add_action( 'init', [ $this, 'init_shortcodes' ] );
	}

	/**
	 * Initialize Shortcodes.
	 *
	 * @since 0.1.0
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 * @throws UnexpectedValueException
	 */
	public function init_shortcodes() {

		// Initialize dependencies.
		$dependencies = new DependencyManager(
			$this->config->getSubConfig( 'DependencyManager' )
		);
		// Register dependencies.
		add_action( 'init', [ $dependencies, 'register' ], 99, 1 );

		// Initialize shortcodes.
		$shortcodes = new ShortcodeManager(
			$this->config->getSubConfig( 'ShortcodeManager' ),
			$dependencies
		);
		// Register shortcodes.
		add_action( 'init', [ $shortcodes, 'register' ], 99, 1 );
	}

}
