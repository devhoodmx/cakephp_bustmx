(function(window, document, undefined) {
	'use strict';

	var AdminIndex = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			$('#logs-catalogue').on('click', '.toggle', $.proxy(this._onToggle, this));
		},

		_onToggle: function (event) {
			var $target = $(event.currentTarget);
			var data = $target.data();

			event.preventDefault();

			$('#log-' + data.id).toggle('fast', function() {
				if ($(this).attr('data-mode') == 'hidden') {
					$(this).attr('data-mode', 'shown');
					$target.html('<i class="fas fa-chevron-up"></i>');
				} else {
					$(this).attr('data-mode', 'hidden');
					$target.html('<i class="fas fa-chevron-down"></i>');
				}
			});
		}
	};

	AdminIndex.load();

	window.hozen.app.AdminIndex = AdminIndex;
}(window, window.document));
