(function () {
	/* global grecaptcha */
	'use strict';

	var Recaptcha = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			$('[data-component="recaptcha"]').each(function(i, e) {
				var $node = $(e);
				var theme = $node.data('theme');
				var options = {};

				options.sitekey = $node.data('sitekey');
				options.theme = theme ? theme : 'light';

				$node.data('captha-id', grecaptcha.render(e, options));
			});
		},

		reset: function(form) {
			$(form).find('[data-component="recaptcha"]').each(function(i, e) {
				grecaptcha.reset($(e).data('captha-id'));
			});
		}
	};

	window.onRecaptchaLoaded = function() {
		Recaptcha.load();
	};

	window.hozen.component.Recaptcha = Recaptcha;
}(window, window.document));
