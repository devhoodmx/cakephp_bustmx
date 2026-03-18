(function(window, document, undefined) {
	'use strict';

	var Template = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;

			$('[data-component="template"]').each(function(i, e) {
				var $node = $(e);

				self.render($node);
			});
		},

		render: function($node) {
		}
	};

	Template.load();

	window.hozen.component.Template = Template;
}(window, window.document));
