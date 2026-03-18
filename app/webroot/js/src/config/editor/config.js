(function(window, document, undefined) {
	'use strict';

	var conf = hozen.config.editor,
		Toolbars = conf.Toolbars,
		Dialogs = conf.Dialogs,
		Configuration = conf.Configuration;

	Configuration.extend('default', {
		removeButtons: 'Anchor',
		contentsCss: ''
	});
}(window, window.document));
