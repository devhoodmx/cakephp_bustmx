(function(window, document, undefined) {
	'use strict';
	
	var AuthenticatedView = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},
		
		init: function() {
		}
	};
	
	AuthenticatedView.load();
	
	window.hozen.view.AuthenticatedView = AuthenticatedView;
}(window, window.document));