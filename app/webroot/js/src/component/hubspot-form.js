(function(window, document, undefined) {
	/* global hbspt */
	'use strict';

	var HubSpotForm = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;

			$('[data-component="hubspot-form"]').each(function(i, e) {
				var $node = $(e);

				self.render($node);
			});
		},

		render: function($node) {
			var id = Math.random().toString(36).substr(2, 10);
			var _class = 'hubspot-form-' + id;

			$node.addClass(_class);

			hbspt.forms.create({
				portalId: $node.data('portalId'),
				formId: $node.data('formId'),
				target: '.' + _class,
				onFormReady: function ($form) {
				}
			});
		}
	};

	HubSpotForm.load();

	window.hozen.component.HubSpotForm = HubSpotForm;
}(window, window.document));
