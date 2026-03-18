(function(window, document, undefined) {
	'use strict';

	var CheckboxTree = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;

			$('[data-component="checkbox-tree"]').each(function(i, e) {
				var $node = $(e);

				// Toggle all checkboxes
				$node.on('change', '.checkbox-toggle-all', function(e) {
					var $checkboxes = $node.find('.checkbox-groups input[type=checkbox]');

					self.check($checkboxes, this.checked);
				});

				// Toggle checkboxes from a category
				$node.on('change', '.checkbox-category input[type=checkbox]', function(e) {
					var $checkbox = $(e.currentTarget);
					var $checkboxes = $checkbox.closest('.checkbox-group').find('.checkboxes input[type=checkbox]');

					self.check($checkboxes, this.checked);
				});

				// Toggle children
				$node.on('change', '.checkbox-section > .checkbox input[type=checkbox]', function(e) {
					var $checkbox = $(e.currentTarget);
					var $checkboxes = $checkbox.closest('.checkbox-section').find('.checkbox-section input[type=checkbox]');

					self.check($checkboxes, this.checked);
				});
			});
		},

		check: function($checkboxes, checked) {
			return $checkboxes.not(':disabled').prop('checked', checked);
		}
	};

	CheckboxTree.load();

	window.hozen.component.CheckboxTree = CheckboxTree;
}(window, window.document));

