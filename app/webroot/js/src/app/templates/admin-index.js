(function(window, document, undefined) {
	'use strict';

	var AdminIndexApp = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var alertifyTypes = ['log', 'error', 'success'];

			$('#widgets').on('click', '.app-alertify', function(e) {
				var type = alertifyTypes[Math.floor(Math.random() * 3)];

				e.preventDefault();
				alertify[type](type);
			});
		},

		_onClick: function(event) {
		}
	};

	AdminIndexApp.load();

	window.hozen.app.AdminIndexApp = AdminIndexApp;
}(window, window.document));