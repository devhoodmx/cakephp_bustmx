(function(window, document, undefined) {
	'use strict';

	var Chosen = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;
			$('[data-component="chosen"]').each(function(i, e) {
				var $node = $(e);

				self.render($node);
			});
		},

		render: function($node) {
			var options = {
				width: $node.data('width') ? $node.data('width') : '100%',
				inherit_select_classes: true,
				search_contains: true
			};

			if ($node.data('search') !== undefined) {
				options.disable_search = !$node.data('search');
			}
			if ($node.data('search-contains') !== undefined) {
				options.search_contains = !!$node.data('search-contains');
			}

			if (this.isBrowserSupported()) {
				$node.removeClass('form-control');
			}

			$node.chosen(options);
		},

		// Extracted from chosen source code
		isBrowserSupported: function() {
			if ('Microsoft Internet Explorer' === window.navigator.appName) {
				return document.documentMode >= 8;
			}

			if (/iP(od|hone)/i.test(window.navigator.userAgent) || /IEMobile/i.test(window.navigator.userAgent) || /Windows Phone/i.test(window.navigator.userAgent) || /BlackBerry/i.test(window.navigator.userAgent) || /BB10/i.test(window.navigator.userAgent) || /Android.*Mobile/i.test(window.navigator.userAgent)) {
				return false;
			}

			return true;
		}
	};

	Chosen.load();

	window.hozen.component.Chosen = Chosen;
}(window, window.document));
