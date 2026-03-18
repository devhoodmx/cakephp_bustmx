(function(window, document, undefined) {
	'use strict';

	// Libs
	var hozen = window.hozen;

	var AdminIndexApp = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			$('.menu-panel .menu').each(function(index, node) {
				Sortable.create(node, {
					onUpdate: function (event) {
						var $node = $(event.item);

						$.ajax({
							url: hozen.app.baseURL + 'admin/menu_items/move/' + $node.data('id') + '/' + event.newIndex,
							dataType: 'json'
						});
					}
				});
			});
		}
	};

	AdminIndexApp.load();

	window.hozen.app.AdminIndexApp = AdminIndexApp;
}(window, window.document));
