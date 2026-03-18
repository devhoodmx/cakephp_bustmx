(function(window, document, undefined) {
	'use strict';

	// See https://developer.mozilla.org/en-US/docs/Web/Guide/Printing
	var Printer = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			$('body').on('click', '[data-component="printer"]', $.proxy(this._onClick, this));
		},

		print: function(url) {
			var oHiddFrame;

			if (url) {
				oHiddFrame = document.createElement('iframe');

				oHiddFrame.onload = this.configure;
				oHiddFrame.style.visibility = 'hidden';
				oHiddFrame.style.position = 'fixed';
				oHiddFrame.style.right = '0';
				oHiddFrame.style.bottom = '0';
				oHiddFrame.src = url;

				document.body.appendChild(oHiddFrame);
			}
		},

		configure: function () {
			this.contentWindow.__container__ = this;
			this.contentWindow.onbeforeunload = Printer.clean;
			this.contentWindow.onafterprint = Printer.clean;
			this.contentWindow.focus(); // Required for IE
			this.contentWindow.print();
		},

		clean: function () {
			document.body.removeChild(this.__container__);
		},

		_onClick: function(e) {
			var $target = $(e.currentTarget);
			var url = null;

			if ($target.data('url')) {
				url = $target.data('url');
			} else if ($target.attr('href')) {
				url = $target.attr('href');
			}

			e.preventDefault();

			this.print(url);
		}
	};

	Printer.load();

	window.hozen.component.Printer = Printer;
}(window, window.document));
