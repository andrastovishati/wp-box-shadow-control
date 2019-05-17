# wordpress box-shadow control
Extending the worrdpress customizer with a box-shadow control.

## Installation

First, you have to change the path of js, and css files in the 'class-ta-customize-shadow-control.php' at the 'enqueue' function.

```php

// There are three place you have to change paths.

public function enqueue(){
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style(
			'ta-customize-shadow-control',
			'/path-to-your-theme-or-plugin/src/ta-customize-shadow-control.css' // Change it with your own directory!
		);
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script(
			'wp-color-picker-alpha',
			'/path-to-your-theme-or-plugin/libs/wp-color-picker-alpha.min.js', // Change it with your own directory!
			array('wp-color-picker')
		);
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script(
			'ta-customize-shadow-control',
			'/path-to-your-theme-or-plugin/src/ta-customize-shadow-control.js', // Change it with your own directory!
			array(
				'jquery',
				'jquery-ui-draggable',
				'wp-color-picker'
			),
			'',
			true
		);
	}

```

...and then you can add this class to your customize register.

```php

add_action('customize_register', function($wp_customize){

	// first step: load class

	require_once '/path-to-your-theme-or-plugin/class-ta-customize-shadow-control.php'; // Change it with your own directory!

	// second step: register control type

	$wp_customize->register_control_type('TA_Customize_Box_Shadow_Control');

	// ...then add settings, and defaults

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

	// and finally: add control

	$wp_customize->add_control(
		new TA_Customize_Box_Shadow_Control(
			$wp_customize,
			'shadows',
			array(
				'label' => __('Shadows', 'your-textdomain'),
				'settings' => 'shadows',
				'section' => 'shadows',
				'blur_min' => 0, // min value of blur slider (default: 0)
				'blur_max' => 40 // max value of blur slider (default: 20)
			)
		)
	);


});

```

## Output

You will get an associative array that you can use for example:

```php

add_action('wp_enqueue_scripts', function(){

	$styles = '';

	$shadows = get_theme_mod('shadows');
	$h_offset = $shadows['h_offset'];
	$v_offset = $shadows['v_offset'];
	$blur = $shadows['blur'];
	$color = $shadows['color'];

	$styles .= ".your-css-class{box-shadow:{$h_offset}px {$v_offset}px {$blur}px {$color};}";

	wp_add_inline_style('your-stylesheet', $styles);

});

```

... and if you use 'transport' => 'postMessage', think about the output as an array as well. For example:

```javascript

wp.customize('shadows', function(value) {
	value.bind(function(newVal) {
		var hOffset = newVal['h_offset'];
		var vOffset = newVal['v_offset'];
		var blur = newVal['blur'];
		var color = newVal['color'];
		$('.your-css-class').css('box-shadow', hOffset + 'px ' + vOffset + 'px ' + blur + 'px ' + color);
	});
});

```
