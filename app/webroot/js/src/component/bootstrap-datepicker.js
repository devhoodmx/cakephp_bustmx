(function(window, document, undefined) {
	'use strict';

	var BootstrapDatepicker = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;

			if ($.fn.datepicker) {
				$('[data-component="bootstrap-datepicker"]').each(function(i, e) {
					var $node = $(e);

					self.render($node);
				});
			}
		},

		render: function($node) {
			$node.datepicker({
				autoclose: true,
				clearBtn: true,
				todayHighlight: true
			});
		}
	};

	BootstrapDatepicker.load();

	window.hozen.component.BootstrapDatepicker = BootstrapDatepicker;
}(window, window.document));
