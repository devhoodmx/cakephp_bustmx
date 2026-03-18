(function(window, document, undefined) {
	'use strict';

	var InputMask = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;

			$('[data-component="input-mask"]').each(function(i, e) {
				var $node = $(e);

				self.render($node);
			});
		},

		render: function($node) {
			var type = $node.data('type');

			if (type == 'numeral') {
				new Cleave($node[0], {
					numeral: true,
					stripLeadingZeroes: false
				});
			}
		}
	};

	InputMask.load();

	window.hozen.component.InputMask = InputMask;
}(window, window.document));
