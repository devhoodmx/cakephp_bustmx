(function(window, document, undefined) {
	'use strict';

	var AdminAdd = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			$('#form-body .hidden').removeClass('hidden').hide();

			$('#MenuItemType').on('change', $.proxy(this.onItemTypeChange, this));
		},

		onItemTypeChange: function(e) {
			var $target = $(e.currentTarget);
			var $selected = $target.find('option:selected');
			var type = $selected.val();

			if (type == '') {
				$('#form-body .type-input').hide();
			} else {
				$('#form-body .type-input').not('.type-' + type).hide();
				$('.type-' + type).show();
			}
		}
	};

	AdminAdd.load();

	window.hozen.app.AdminAdd = AdminAdd;
}(window, window.document));
