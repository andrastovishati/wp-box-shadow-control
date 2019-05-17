<?php

/**
 * WP Customze Control: Box Shadow Control.
 * You can use it in your wordpress theme, or plugin.
 *
 * @copyright Copyright (c) 2019 / Andras Tovishati
 * @license https://opensource.org/licenses/MIT
 */

class TA_Customize_Box_Shadow_Control extends WP_Customize_Control {

	/**
	 * The type of control.
	 *
	 * @var string
	 * @access public
	 * @since 1.0.0
	 */

	public $type = 'ta_box_shadow';

	/**
	 * The min value of the blur slider.
	 *
	 * @var int
	 * @access private
	 * @since 1.0.0
	 */

	private $blur_min;

	/**
	 * The max value of the blur slider.
	 *
	 * @var int
	 * @access private
	 * @since 1.0.0
	 */

	private $blur_max;

	/**
	 * Constructor.
	 */

	public function __construct($manager, $id, $args = array()){
		parent::__construct($manager, $id, $args);
		$this->blur_min = !empty($args['blur_min']) ? $args['blur_min'] : 0;
		$this->blur_max = !empty($args['blur_max']) ? $args['blur_max'] : 20;
	}

	/**
	 * Make this function empty (but it does need to exist to override the default one).
	 *
	 * @see WP_Customize_Control::render_content()
	 * @since 1.0.0
	 */

	public function render_content(){}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 * SVG 'lightbulb' path is a fontawesome icon. (c) https://fontawesome.com/
	 *
	 * @see WP_Customize_Control::content_template()
	 * @since 1.0.0
	 */

	public function content_template(){
		?>
		<label class="customize-control-title">{{data.label}}</label>
		<# if (data.description) { #>
		<p class="customize-control-description">{{data.description}}</p>
		<# } #>
		<div class="{{{data.type}}}-scene">
			<svg class="light" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path d="M96.06 454.35c.01 6.29 1.87 12.45 5.36 17.69l17.09 25.69a31.99 31.99 0 0 0 26.64 14.28h61.71a31.99 31.99 0 0 0 26.64-14.28l17.09-25.69a31.989 31.989 0 0 0 5.36-17.69l.04-38.35H96.01l.05 38.35zM0 176c0 44.37 16.45 84.85 43.56 115.78 16.52 18.85 42.36 58.23 52.21 91.45.04.26.07.52.11.78h160.24c.04-.26.07-.51.11-.78 9.85-33.22 35.69-72.6 52.21-91.45C335.55 260.85 352 220.37 352 176 352 78.61 272.91-.3 175.45 0 73.44.31 0 82.97 0 176zm176-80c-44.11 0-80 35.89-80 80 0 8.84-7.16 16-16 16s-16-7.16-16-16c0-61.76 50.24-112 112-112 8.84 0 16 7.16 16 16s-7.16 16-16 16z"/></svg>
			<div class="shadow-receiver"></div>
		</div>
		<strong class="customize-control-description"><?php _e('Offsets:', 'your-textdomain'); ?></strong>
		<label class="customize-control-description"><?php _e('Horizontal:', 'your-textdomain'); ?>
			<input type="number" class="param" data-key="h_offset" value="{{{data.h_offset}}}">
		</label>
		<label class="customize-control-description"><?php _e('Vertical:', 'your-textdomain'); ?>
			<input type="number" class="param" data-key="v_offset" value="{{{data.v_offset}}}">
		</label>
		<label class="customize-control-description"><?php _e('Blur:', 'your-textdomain'); ?>
			<input type="range" class="param" data-key="blur" min="{{{data.blur_min}}}" max="{{{data.blur_max}}}" value="{{{data.blur}}}">
		</label>
		<label class="customize-control-description"><?php _e('Color:', 'your-textdomain'); ?>
			<input type="text" class="param" data-key="color" data-alpha="true" value="{{{data.color}}}">
		</label>
		<?php
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 * @since 1.0.0
	 */

	public function to_json(){
		parent::to_json();
		$this->json['defaults'] = $this->setting->default;
		$values = $this->value();
		$this->json['h_offset'] = $values['h_offset'];
		$this->json['v_offset'] = $values['v_offset'];
		$this->json['blur'] = $values['blur'];
		$this->json['color'] = $values['color'];
		$this->json['blur_min'] = $this->blur_min;
		$this->json['blur_max'] = $this->blur_max;
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 1.0.0
	 */

	public function enqueue(){
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style(
			'ta-customize-shadow-control',
			get_template_directory_uri() . '/src/ta-customize-shadow-control.css' // Change it with your own directory!
		);
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script(
			'wp-color-picker-alpha',
			get_template_directory_uri() . '/libs/wp-color-picker-alpha.min.js', // Change it with your own directory!
			array('wp-color-picker')
		);
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script(
			'ta-customize-shadow-control',
			get_template_directory_uri() . '/src/ta-customize-shadow-control.js', // Change it with your own directory!
			array(
				'jquery',
				'jquery-ui-draggable',
				'wp-color-picker'
			),
			'',
			true
		);
	}

}



?>