/* global CKEDITOR */
(function(window, document, undefined) {
	'use strict';

	var Form = {

		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			// Forms
			this.setForms($('form[data-async]'));
			$(document).on('submit', 'form[data-async]', $.proxy(this.onSubmit, this));
		},

		/**
		 * ASYNC FORMS
		 */

		setForms: function(forms) {
			if (forms.length) {
				window.hozen.form.forms = window.hozen.form.forms || {};
			}
		},

		onSubmit: function(e) {
			e.preventDefault();

			var $form = $(e.target);

			if (!$form.data('loading')) {
				$form.data('loading', true);
				$form.addClass('loading');
				$form.find('.error').removeClass('error');
				$form.find('.error-message').remove();

				var settings = {
					type: 'POST',
					url: $form.data('action') || $form.attr('action'),
					success: $.proxy(this.onSubmitSuccess, e.target),
					error: $.proxy(this.onSubmitError, e.target)
				};

				if (window.CKEDITOR && CKEDITOR.instances) {
					for (var instance in CKEDITOR.instances) {
						CKEDITOR.instances[instance].updateElement();
					}
				}

				if (window.FormData) {
					var formData = new FormData($form[0]);

					if (window.hozen.form.forms && window.hozen.form.forms[$form[0].id]) {
						if (window.hozen.form.forms[$form[0].id].fields) {
							var fields = window.hozen.form.forms[$form[0].id].fields;

							for (var field in fields) {
								if (fields.hasOwnProperty(field)) {
									formData.append(field, fields[field]);
								}
							}
						}
					}

					settings.data = formData;
				}

				$.proxy(this.submitData(settings), $form);
			}
		},

		onSubmitSuccess: function(data, status, xhr) {
			var response = $.parseJSON(xhr.responseText),
				redirect = false;

			$(this).removeData('loading');
			$(this).removeClass('loading');
			$(this).addClass('submitted');

			if (typeof(this) == 'object' && this.tagName == 'FORM') {
				$(this).trigger('form:success', [response, $(this)]);

				if ($(this).data('reset')) {
					this.reset();
				}
			}

			if (response.data && response.data.params && response.data.params.redirect) {
				redirect = response.data.params.redirect;
			} else if ($(this).data('redirect')) {
				redirect = $(this).data('redirect');
			}

			if (redirect) {
				window.location.replace(redirect);
			} else if (response.data.items.message) {
				alertify.success(data.data.items.message);
			}
		},

		onSubmitError: function(xhr, status, errors) {
			var response = $.parseJSON(xhr.responseText),
				error = response.error,
				isForm = (typeof(this) == 'object' && this.tagName == 'FORM');

			$(this).removeData('loading');
			$(this).removeClass('loading');

			if (response.layout && response.layout == 'ajax' && response.view && response.view == 'login'){
				$('#LoginModal').modal('show');
			} else {
				if  (isForm) {
					$(this).trigger('form:error', [response, $(this)]);
				}

				if (error.fields && error.fields.length) {
					for (var i in error.fields) {
						if (error.fields.hasOwnProperty(i)) {
							if  (isForm) {
								var field = $(this).find('#' + error.fields[i].key) || $(this).find('#' + error.fields[i].key + '_');
								if (field.length) {
									field.addClass('error');
									var container = field.closest('.input');
									if (container) {
										container.addClass('error');
										$('<div>' + error.fields[i].message + '</div>').appendTo(container).addClass('error-message');
									}
								}
							}
						}
					}
				} else {
					alertify.error(error.message);
				}
			}
		},

		submitData: function(settings) {
			settings = settings || {};
			settings.dataType =  'json';

			if (window.FormData) {
				settings.contentType =  false;
				settings.processData =  false;
				$.ajax(settings);
			} else {
				delete settings.data;
				settings.dataType =  'text/html';
				settings.contentType =  'text/html';
				this.ajaxSubmit(settings);
			}
		}
	};

	Form.load();

	window.hozen.form.Form = Form;

}(window, window.document));
