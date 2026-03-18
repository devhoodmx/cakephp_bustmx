(function (window, document, undefined) {
	'use strict';

	var AdminLoginApp = {
		load: function () {
			$(document).ready($.proxy(this.init, this));
		},

		init: function () {
			$.getJSON('https://media.affenbits.com/', function(data) {
				if (data.data && data.data.items.length) {
					var items = data.data.items;
					var rand = Math.floor(Math.random() * items.length);
					var url = items[rand].Media.url;

					$('html').css('backgroundImage', 'url(' + url + ')');
				}
			});
		}
	};

	AdminLoginApp.load();

	window.hozen.app.AdminLoginApp = AdminLoginApp;
}(window, window.document));
