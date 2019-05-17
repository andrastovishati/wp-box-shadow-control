/**
 * WP Customze Control: Box Shadow Control.
 * You can use it in your wordpress theme, or plugin.
 *
 * @copyright Copyright (c) 2019 / Andras Tovishati
 * @license https://opensource.org/licenses/MIT
 */

(function($, Customize) {

	"use strict";

	Customize.TABoxShadowControl = Customize.Control.extend({

		/**
		 * Set Up JS.
		 *
		 * @since 1.0.0
		 */

		ready:function() {
			var control = this;
			var scene = control._scene();
			var light = scene.find('svg.light');
			var color = $(control.container).find('input[data-key=color]');
			var param = $(control.container).find('label input.param');
			control._setDraggable(light);
			control._setColorPicker(color);
			control._addShadowToReceiver();
			control._positioningLight();
			param.each(function() {
				$(this).on('change input', function() {
					control._saveValues();
					control._addShadowToReceiver();
					control._positioningLight();
				});
			});
		},

		/**
		 * Returns jQuery selector that includes lightbulb and shadow receiver.
		 * We call it scene.
		 *
		 * @return object
		 * @since 1.0.0
		 */

		_scene:function() {
			var control = this;
			var container = control.container;
			var scene = $(container).find('.' + control.params.type + '-scene');
			return scene;
		},

		/**
		 * Set up lightbulb draggable.
		 *
		 * @param object elem - jQuery selector
		 * @since 1.0.0
		 */

		_setDraggable:function(elem) {
			var control = this;
			elem.draggable({
				containment:control._scene(),
				drag:function(e, ui) {
					var scene = control._scene();
					var hOffset = ui.position.left - (scene.width() / 2);
					var vOffset = ui.position.top - (scene.height() / 2);
					var hOffset = - hOffset;
					var vOffset = - vOffset;
					var h_offset = $(control.container).find('input[data-key=h_offset]');
					var v_offset = $(control.container).find('input[data-key=v_offset]');
					h_offset.val(hOffset).trigger('change');
					v_offset.val(vOffset).trigger('change');
				}
			});
		},

		/**
		 * Set up color picker.
		 *
		 * @param object elem jQuery selector
		 * @since 1.0.0
		 */

		_setColorPicker:function(elem) {
			elem.wpColorPicker();
		},

		/**
		 * Get each values from inputs.
		 *
		 * @return object
		 * @since 1.0.0
		 */

		_getValues:function() {
			var control = this;
			var container = control.container;
			var datas = {};
			$(control.container).find('label input.param').each(function() {
				var key = $(this).data('key');
				var value = $(this).val();
				datas[key] = value;
			});
			return datas;
		},

		/**
		 * Save each values.
		 *
		 * @since 1.0.0
		 */

		_saveValues:function() {
			var control = this;
			var datas = control._getValues();
			control.setting.set(datas);
		},

		/**
		 * Positioning svg.light by 'h_offset', and 'v_offset' input.
		 *
		 * @since 1.0.0
		 */

		_positioningLight:function() {
			var control = this;
			var scene = control._scene();
			var values = control._getValues();
			var hOffset = parseInt(- values.h_offset) + (scene.width() / 2);
			var vOffset = parseInt(- values.v_offset) + (scene.height() / 2);
			var light = scene.find('svg.light');
			light[0].style.cssText = 'position: relative; left: '+hOffset+'px; top: '+vOffset+'px;';
		},

		/**
		 * Add box-shadow css to shadow receiver.
		 *
		 * @since 1.0.0
		 */

		_addShadowToReceiver:function() {
			var control = this;
			var scene = control._scene();
			var receiver = scene.find('.shadow-receiver');
			var values = control._getValues();
			var hOffset = values['h_offset'];
			var vOffset = values['v_offset'];
			var blur = values['blur'];
			var color = values['color'];
			receiver.css('box-shadow', hOffset + 'px ' + vOffset + 'px ' + blur + 'px ' + color);
		}

	});

	Customize.controlConstructor['ta_box_shadow'] = Customize.TABoxShadowControl.extend({});

})(jQuery, wp.customize);
