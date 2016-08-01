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
use BrightNucleus\Exception\BadMethodCallException;
use BrightNucleus\Exception\InvalidArgumentException;
use BrightNucleus\Exception\OutOfRangeException;
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
	 * Launch the initialization process.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'init', [ $this, 'init_shortcodes' ] );
	}

	/**
	 * Initialize Shortcodes.
	 *
	 * @since 0.1.0
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 * @throws UnexpectedValueException
	 * @throws BadMethodCallException
	 * @throws OutOfRangeException
	 */
	public function init_shortcodes() {

		// Initialize dependencies.
		$dependencies = new DependencyManager(
			$this->config->getSubConfig( 'DependencyManager' ),
			false // Don't enqueue all dependencies immediately.
		);
		// Register dependencies.
		add_action( 'init', [ $dependencies, 'register' ], 99, 1 );

		// Initialize shortcodes.
		$shortcodes = new ShortcodeManager(
			$this->config->getSubConfig( 'ShortcodeManager' ),
			$dependencies
		);
		// Register shortcodes.
		add_action( 'init',
			function () use ( &$shortcodes ) { $shortcodes->register( [ 'data_passed_from' => 'Plugin_class' ] ); },
			99 );
	}
}
