(function(window, document, undefined) {
	'use strict';
	
	var AnonymousView = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},
		
		init: function() {
		}
	};
	
	AnonymousView.load();
	
	window.hozen.view.AnonymousView = AnonymousView;
}(window, window.document));