(function(window, document, undefined) {
	/* global ace */
	'use strict';

	var _Ace = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var path = '/js/build/vendor/ace';

			ace.config.set('workerPath', path);
			ace.config.set('modePath', path);
			ace.config.set('themePath', path);

			$('[data-component="ace"]').each(function(i, e) {
				var $node = $(e);
				var $editor = $node.find('.editor');
				var $language = $node.find('.language');
				var $value = $node.find('.value');
				var options = {};
				var editor = ace.edit($editor.get(0));

				editor.setTheme('ace/theme/github');
				editor.setValue($value.val());

				editor.getSession().on('change', function(e) {
					$value.val(editor.getValue());
				});

				$language.on('change', function(e) {
					editor.getSession().setMode('ace/mode/' + $language.val());
				}).trigger('change');
			});
		}
	};

	_Ace.load();

	window.hozen.component.Ace = _Ace;
}(window, window.document));
