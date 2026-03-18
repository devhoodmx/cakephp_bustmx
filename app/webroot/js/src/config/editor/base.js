(function(window, document, undefined) {
	'use strict';

	var _configs = {};

	// Catalogs
	var Dialogs = {
		'table': function(data, editor) {
			var name = data.name;
			var definition = data.definition;
			var infoTab = definition.getContents('info');
			var advancedTab = definition.getContents('advanced');

			// Remove elements
			infoTab.remove('txtCellSpace');
			infoTab.remove('txtCellPad');
			infoTab.remove('txtBorder');
			infoTab.remove('txtHeight');

			// Set default values
			infoTab.get('txtWidth')['default'] = '100%';
			advancedTab.get('advCSSClasses')['default'] = 'table';
		}
	};
	/**
	 * Toolbars configurations
	 *
	 * @type {Object}
	 * @see http://ckeditor.com/latest/samples/plugins/toolbar/toolbar.html
	 */
	var Toolbars = {
		'default': [
			// {name: 'document', groups: [ 'mode'], items: ['Source']},
			{name: 'clipboard', groups: ['clipboard', 'undo'], items: ['PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
			{name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
			{name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
			{name: 'links', items: ['Link', 'Unlink', 'Anchor']},
			{name: 'insert', items: ['Image', 'Embed', 'Table', 'HorizontalRule']},
			{name: 'styles', items: ['Format']},
			{name: 'tools', items: ['Maximize']}
		],
		'basic': [
			{name: 'basicstyles', groups: ['basicstyles'], items: ['Bold', 'Italic']},
			{name: 'paragraph', groups: ['list', 'indent', 'blocks'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
			{name: 'links', items: ['Link', 'Unlink']}
		]
	};

	/**
	 * Proxies CKEDITOR.editor
	 * @type {Object}
	 */
	var EditorProxy = {
		getConfig: function(editor) {
			var element = editor.element,
				conf,
				confKey = 'default';

			if (element.data('config') && _configs[element.data('config')]) {
				confKey = element.data('config');
			}

			return _configs[confKey];
		},

		setElements: function(editor) {
			var conf = this.getConfig(editor),
				rules = {};

			_.each(conf.elements, function(value, key) {
				rules[key] = function(element) {
					if (value['class']) {
						element.attributes['class'] = value['class'];
					}
				};
			});

			editor.dataProcessor.htmlFilter.addRules({elements: rules});
		}
	};

	/**
	 * Configurations dictionary
	 * @type {Object}
	 */
	var Configuration = {
		get: function(id) {
			var conf = _.omit(_.clone(_configs[id]), [
				'elements',
				'dialogs'
			]);

			return conf;
		},

		set: function(id, config) {
			// Define changes to default configuration here instead of config.js
			_.defaults(config, {
				language: hozen.app.locale || 'en',
				customConfig: ''
			});

			_configs[id] = config;
		},

		extend: function(id, config) {
			if (_configs[id]) {
				_.extend(_configs[id], config);
			}
		}
	};

	/**
	 * Fired when a dialog definition is about to be used to create a dialog into
	 * an editor instance. This event makes it possible to customize the definition
	 * before creating it.
	 *
	 * @see http://docs.ckeditor.com/#!/api/CKEDITOR.dialog.definitionObject
	 * @see https://github.com/ckeditor/ckeditor-dev/blob/master/plugins/dialog/samples/dialog.html
	 */
	CKEDITOR.on('dialogDefinition', function(ev) {
		var dialogName = ev.data.name,
			dialogDefinition = ev.data.definition,
			editor = ev.editor,
			conf,
			fn;

		conf = EditorProxy.getConfig(editor);
		fn = conf.dialogs && conf.dialogs[dialogName];
		if (fn && _.isFunction(fn)) {
			fn(ev.data, ev.editor);
		}
	});

	/**
	 * Fired when a CKEDITOR instance is created, fully initialized and ready for interaction.
	 */
	CKEDITOR.on('instanceReady', function(ev) {
		var editor = ev.editor;

		EditorProxy.setElements(editor);
	});


	// Set default configurations
	Configuration.set('default', {
		toolbar: Toolbars['default'],
		format_tags: 'p;h1;h2;h3;h4',
		// contentsCss: [],
		dialogs: Dialogs,
		// Setup content provider. See https://ckeditor.com/docs/ckeditor4/latest/features/media_embed.html
		embed_provider: '/admin/pages/oembed?url={url}&callback={callback}',
		// Adding drag and drop image upload
		uploadUrl: '/admin/images/upload.json'

	});

	Configuration.set('basic', {
		toolbar: Toolbars.basic
	});

	window.hozen.config.editor = {
		Dialogs: Dialogs,
		Toolbars: Toolbars,
		Configuration: Configuration
	};
}(window, window.document));
