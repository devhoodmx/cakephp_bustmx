(function(window, document, undefined) {
	'use strict';

	var Tooltip = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			$('[data-toggle="tooltip"]').tooltip();
		}
	};

	Tooltip.load();

	window.hozen.component.Tooltip = Tooltip;
}(window, window.document));
