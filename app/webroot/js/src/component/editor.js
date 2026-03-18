(function(window, document, undefined) {
	'use strict';

	var Config = hozen.config.editor.Configuration;

	var Editor = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			$('[data-component="editor"]').each(function (i, e) {
				var $node = $(e);
				var data = $node.data();
				var confKey = 'default';
				var validOpts = ['language'];
				var opts;

				if (data.config && Config.get(data.config)) {
					confKey = data.config;
				}

				$node.attr('data-config', confKey);
				// Replace default config. with valid element's options
				opts = _.extend(Config.get(confKey), _.pick(data, validOpts));

				$node.ckeditor(opts);
			});
		}
	};

	Editor.load();

	window.hozen.component.Editor = Editor;
}(window, window.document));
