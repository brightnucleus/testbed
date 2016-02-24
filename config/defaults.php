<?php
/**
 * Bright Nucleus Testbed configuration file
 *
 * @package   BrightNucleus\Testbed
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      https://www.brightnucleus.com/
 * @copyright 2016 Bright Nucleus, Alain Schlesser
 */

namespace BrightNucleus\Testbed;

$dependencies = [
	'styles'   => [ ],
	'scripts'  => [
		[
			'handle'    => 'bn-testing-ace',
			'src'       => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js',
			'deps'      => [ 'jquery' ],
			'ver'       => '1.2.3',
			'in_footer' => true,
			'is_needed' => function ( $context ) { return true; },
			'localize'  => [
				'name' => 'ace_localization',
				'data' => function ( $context ) {
					return [
						'test_localize_data' => 'test_localize_value',
						'context'            => $context,
					];
				},
			],
		],
	],
	'handlers' => [
		'scripts' => 'BrightNucleus\Dependency\ScriptHandler',
		'styles'  => 'BrightNucleus\Dependency\StyleHandler',
	],
];

$shortcodes = [
	'bn_test_shortcode' => [
		'custom_class' => 'BrightNucleus\Shortcode\TemplatedShortcode',
		'template' => [
			'filter_prefix' => 'bn_testbed_shortcodes',
		    'template_directory' => 'templates/bn-testbed-shortcodes',
		],
		'is_needed'    => function ( $context ) { return true; },
		'view'         => BN_TESTBED_DIR . 'views/shortcodes/bn-test-shortcode.php',
		'atts'         => [
			'number' => [
				'validate' => function ( $att ) { return isset( $att ) ? esc_attr( $att ) : null; },
				'default'  => '3',
			],
		],
		'ui'           => [
			'label'         => __( 'Bright Nucleus Testbed - Test Shortcode',
				'bn-testbed' ),
			'listItemImage' => 'dashicons-info',
			'post_type'     => [ 'page' ],
			'is_needed'     => function ( $context ) { return true; },
			'attrs'         => [
				[
					'label'       => __( 'Number',
						'bn-testbed' ),
					'description' => __( 'How many items do you want to have displayed?',
						'bn-testbed' ),
					'attr'        => 'number',
					'type'        => 'number',
					'value'       => '3',
					'meta'        => [
						'min'  => '-1',
						'step' => '1',
					],
				],
			],
		],
	],
];

/*
 * Testbed main settings.
 */
$testbed = [
	'DependencyManager' => $dependencies,
	'ShortcodeManager'  => $shortcodes,
];

return [
	'BrightNucleus' => [
		'Testbed' => $testbed,
	],
];
