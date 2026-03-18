(function(window, document, undefined) {
	'use strict';
	
	var TemplateView = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},
		
		init: function() {
		}		
	};
	
	TemplateView.load();
	
	window.hozen.view.Template = TemplateView;
}(window, window.document));