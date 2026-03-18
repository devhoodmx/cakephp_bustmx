(function(window, document, undefined) {
	'use strict';
	
	// Libs
	var hozen = window.hozen;

	// Classes
	var BlackHole = hozen.widget.BlackHole;
	
	// Constants
	var ENERGY = 1;
		
	var TemplateApp = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},
		
		init: function() {
		},
		
		_onClick: function(event) {
		}
	};
	
	TemplateApp.load();
	
	window.hozen.app.TemplateApp = TemplateApp;
}(window, window.document));