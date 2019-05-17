<?php

/**
 * WP Customze Control: Box Shadow Control.
 * This is an example file to show how you can use this api.
 *
 * @copyright Copyright (c) 2019 / Andras Tovishati
 * @license https://opensource.org/licenses/MIT
 */

add_action('customize_register', function($wp_customize){

	// load class

	require_once get_template_directory() . '/src/class-ta-customize-shadow-control.php'; // Change it with your own directory!

	// register control type

	$wp_customize->register_control_type('TA_Customize_Box_Shadow_Control');

	// add section

	$wp_customize->add_section(
		'shadows',
		array(
			'title' => __('Shadows', 'your-textdomain'),
			'priority' => 40
		)
	);

	// add setting, and defaults

	$wp_customize->add_setting(
		'shadows',
		array(
			'default' => array(
				'h_offset' => '5', // horizontal offset in px
				'v_offset' => '5', // vertical offset in px
				'blur' => '1', // blur in px
				'color' => 'rgba(0, 0, 0, .9)' // color
			),
			//'transport' => 'postMessage' // optional
		)
	);

	// add control

	$wp_customize->add_control(
		new TA_Customize_Box_Shadow_Control(
			$wp_customize,
			'shadows',
			array(
				'label' => __('Shadows', 'your-textdomain'),
				'settings' => 'shadows',
				'section' => 'shadows',
				'blur_min' => 0, // min value of blur slider
				'blur_max' => 40 // max value of blur slider
			)
		)
	);


});



?>