(function(window, document, undefined) {
	'use strict';

	var Nav = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;

			this.navLinks = {};

			$('[data-component="nav"]').each(function(i, e) {
				var $node = $(e);

				// Track links
				if ($node.data('track')) {
					$node.find('> .nav-item > .nav-link').each(function(index, link) {
						var $link = $(link);
						var linkKey = '';

						// Same page anchor links
						if ($link.prop('hash') != '' &&
							$link.prop('pathname') == window.location.pathname) {
							linkKey = $link.prop('hash');

							if (!(linkKey in self.navLinks)) {
								self.navLinks[linkKey] = [];
							}

							self.navLinks[linkKey].push($link);
						}
					});
				}
			});

			self.updateNavState();

			window.addEventListener('hashchange', function(event) {
				self.updateNavState();
			});
		},

		updateNavState: function() {
			if (window.location.hash in this.navLinks) {
				this.navLinks[window.location.hash].forEach(function($link) {
					$link.closest('.nav-list').find('> .nav-item').removeClass('active');
					$link.parent().addClass('active');
				});
			}
		}
	};

	Nav.load();

	window.hozen.component.Nav = Nav;
}(window, window.document));
