(function(window, document, undefined) {
	'use strict';

	var hozen = window.hozen;

	var PropertiesPlan = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;
			var key = 'properties-plan';
			var $nodes = $('[data-component="' + key + '"]');

			this.key = key;
			this.data = {};

			if ($nodes.length) {
				this.data = hozen.data.component[key] ? hozen.data.component[key] : {};

				$nodes.each(function(i, e) {
					var $node = $(e);

					self.render($node);
				});
			}
		},

		render: function($component) {
			var key = $component.data('key');
			var properties = {};

			// Properties
			if (this.data[key] !== undefined) {
				properties = this.data[key].properties;
			}

			// Load areas svg
			$component
				.find('.properties-areas')
				.load($component.data('areas'), null, function() {
					// Iterate over all properties
					$(this).find('.property').each(function(index, node) {
						var $property = $(node);
						var propertyKey = $property.data('key');
						var property = properties[propertyKey];

						$property.data('id', property.id);
						$property.addClass(property.status);

						$property.on('click', function(e) {
							$component.trigger('properties-plan.property.click', [$property, property]);
						});
					});
				});
		}
	};

	PropertiesPlan.load();

	window.hozen.component.PropertiesPlan = PropertiesPlan;
}(window, window.document));
