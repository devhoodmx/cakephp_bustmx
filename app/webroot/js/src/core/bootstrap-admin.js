/* global ClipboardJS */
(function(window, document, undefined) {
	'use strict';

	/* global Sortable */

	var hozen = window.hozen;
	var __d = hozen.__d;

	var BootstrapAdmin = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;

			// Nav
			$('#doc-navbar-toggle').on('click', function (params) {
				$('body').toggleClass('doc-nav-open');
			});

			// Sortable
			const draggableClass = 'item-draggable';

			// Add a class to sortable items. Sortable doesn't support setting attribute selectors for draggable
			document.querySelectorAll('[data-sortable]').forEach((node) => {
				node.classList.add(draggableClass);
			});

			// Create Sortable lists
			document.querySelectorAll('[data-sortable-container]').forEach((node) => {
				new Sortable(node, {
					animation: 150,
					draggable: `.${draggableClass}`,
					swapThreshold: 0.65,
					onEnd: $.proxy(this.onSortEnd, this)
				});
			});

			//Delete
			$('body').on('click', 'a[data-delete]', $.proxy(this.renderModal, this, this.deleteRequest));

			//Toggle Field
			$('body').on('click', 'a[data-toggle-field]', $.proxy(this.renderToggleModal, this, this.toggleFieldRequest));

			//Checkbox Enabled Fields
			$('body input[data-enable]').each($.proxy(function(i, e) {
				this.setEnablerCheckbox(e);
			}, this));

			$('body').on('change', 'input[data-enable]', $.proxy(this.onEnablerCheckboxChange, this));

			$('body input[data-show]').each($.proxy(function(i, e) {
				this.setShowCheckbox(e);
			}, this));

			$('body').on('change', 'input[data-show]', $.proxy(this.onShowCheckboxChange, this));

			$('body').on('click', '[data-clipboard]', function(e) { e.preventDefault(); });

			new ClipboardJS('[data-clipboard]', {
				text: function(trigger) {
					var text = '',
						clipboard = $(trigger).data('clipboard'),
						type = clipboard.substring(0, 1),
						$element;


					if (type == '$') {
						if (clipboard == '$') {
							$element = $(trigger);
						} else {
							$element = $(clipboard.substring(1));
						}

						if ($element.prop('nodeName') == 'INPUT' || $element.prop('nodeName') == 'TEXTAREA') {
							text = $element.val();
						} else {
							text = $element.html();
						}
					} else {
						text = $(trigger).attr(clipboard);
					}

					alertify.success('El ' + (text.substring(0,4) == 'http' ? 'enlace' : 'texto') + ' ha sido copiado');

					return text;
				}
			});

			$(document).on('submit', 'form:not([data-async])', $.proxy(this.checkAuthentication, this));
			$('#UserExpiredLoginForm').on('form:success', $.proxy(this.renewedAuthentication, this));
		},

		renewedAuthentication: function(e) {
			$('#LoginModal').modal('hide');
		},

		checkAuthentication: function(e) {
			var $target = $(e.target);

			if (!$target.data('authenticated')) {
				e.preventDefault();

				var settings = {
					type: 'POST',
					url: '/admin',
					success: $.proxy(this.authenticated, e),
					error: $.proxy(this.unauthenticated, e)
				};

				this.makeRequest(settings, e);
			}
		},

		authenticated: function(e) {
			var $target = $(this.target);
			$target.data('authenticated', true);
			$target.trigger(this.type);
			$target.data('authenticated', false);
		},

		unauthenticated: function(xhr, status, errors) {
			var response = $.parseJSON(xhr.responseText),
				$target = $(this.target);

			if (response.layout && response.layout == 'ajax' && response.view && response.view == 'login'){
				$('#LoginModal').modal('show');
			} else {
				$target.data('authenticated', true);
				$target.trigger(this.type);
				$target.data('authenticated', false);
			}
		},

		renderToggleModal: function (acceptFunction, e) {
			e.preventDefault();
			e.stopPropagation();

			var $target = $(e.currentTarget);

			if ($target.data('direct')) {
				$.proxy(acceptFunction, this, $target)();
			} else {
				this.renderModal(acceptFunction, e);
			}
		},

		renderModal: function(acceptFunction, e) {
			e.preventDefault();
			e.stopPropagation();

			var $target = $(e.currentTarget);
			var $modalWindow = $('#modalWindow');
			var $modalAcceptBtn = $modalWindow.find('#success-url');
			var modalBody = $target.data('dialog');
			var modalTitle = $target.data('title');
			var acceptBtnTitle = $target.data('dialogAccept');
			var resourceName = $target.closest('[data-name]').data('name');

			modalBody = modalBody.replace('%s', '<b>' + resourceName + '</b>');

			$modalWindow.find('h4.modal-title').html(modalTitle);
			$modalWindow.find('.modal-body').html(modalBody);

			if ($target.attr('data-delete')) {
				acceptBtnTitle = acceptBtnTitle || __d('default', 'delete');

				$modalAcceptBtn.attr('class', 'btn btn-danger');
			} else {
				$modalAcceptBtn.attr('class', 'btn btn-primary');
			}

			$modalAcceptBtn.text(acceptBtnTitle || __d('default', 'accept'));

			// Events
			$modalAcceptBtn.unbind();
			$modalAcceptBtn.bind('click', $.proxy(acceptFunction, this, $target));
			$modalWindow.unbind('keydown.enter');
			$modalWindow.bind('keydown.enter', $.proxy(this.onEnterPressInModal, this));

			// Open modal
			$modalWindow.modal({keyboard: true});
		},

		onEnterPressInModal: function(e) {
			e.stopPropagation();
			if(e.which == 13) {
				$('#modalWindow').find('#success-url').trigger('click');
			}
		},

		makeRequest: function(settings, e) {
			settings.type = settings.type || 'POST';
			settings.dataType = settings.dataType || 'json';
			settings.error = settings.error || this.onRequestError;
			settings.complete = settings.complete || this.onRequestComplete;

			if (typeof settings.url !== undefined) {
				$.ajax(settings);
			}
		},

		deleteRequest: function ($target) {
			var $model = $target.closest('[data-model]'),
				settings = {
					url: $model.data('url') + '/delete/' + $model.data('id'),
					success: $.proxy(this.onDeleteRequestSuccess, $target)
				};

			$.proxy(this.makeRequest, this, settings)();
		},

		toggleFieldRequest: function ($target) {
			var $model = $target.closest('[data-model]'),
				settings = {},
				data = {},
				dataVar = 'data[' + $model.data('model') + ']';

			data[dataVar + '[field]'] = $target.data('toggle-field');
			data[dataVar + '[value]'] = $target.data('toggle-value');

			settings.url = $model.data('url') + '/toggle_field/' + $model.data('id');
			settings.success = $.proxy(this.onToggleFieldRequestSuccess, $target);
			settings.data = data;

			$.proxy(this.makeRequest, this, settings)();
		},

		onDeleteRequestSuccess: function(data, status, xhr) {
			var response = $.parseJSON(xhr.responseText),
				redirect = false;

			if (response.data && response.data.params && response.data.params.redirect) {
				redirect = response.data.params.redirect;
			} else if ($(this).data('redirect')) {
				redirect = $(this).data('redirect');
			}

			if (redirect) {
				window.location.replace(redirect);
			} else {
				$('[data-model="' + response.data.items.model + '"][data-id="' + response.data.items.id +'"]').remove();
				$('[data-parent-model="' + response.data.items.model + '"][data-parent-id="' + response.data.items.id +'"]').remove();

				alertify.success(data.data.items.message);
			}
		},

		onToggleFieldRequestSuccess: function(data, status, xhr) {
			var response = $.parseJSON(xhr.responseText);
			var item = response.data.items;
			var fieldKey = item.field.replace(/\_/g, '-');
			var $items = $('[data-model="' + item.model + '"][data-id="' + item.id +'"]');
			var icon = 'fa icon-' + (item.value ? '' : 'not-') + fieldKey;
			var $toggles = $.merge(
					$items.find('[data-toggle-field="' + item.field + '"]'),
					$('[data-model="' + item.model + '"][data-id="' + item.id +'"][data-toggle-field="' + item.field + '"]')
				);

			$items
				.toggleClass('state-' + fieldKey, item.value)
				.toggleClass('state-not-' + fieldKey, !item.value);

			$toggles
				.data('dialog', item.dialog)
				.data('title', item.title)
				.data('toggle-value', item.value ? 0 : 1)
				.attr('data-toggle-value', item.value ? 0 : 1)
				.attr('title', item.title)
				.find("[class*='icon-']").attr('class', icon)
				.closest('a')
				.find('.btn-text').html(item.title);

			if (item.siblings) {
				var $siblings = $items.siblings('[data-model]');
				var siblingIcon = 'fa icon' + (item.siblings.value ? '' : '-not') + '-' + fieldKey;

				$siblings
					.removeClass('state-' + fieldKey)
					.addClass('state-not-' + fieldKey)
					.find('[data-toggle-field="' + item.field + '"]')
					.data('dialog', item.siblings.dialog)
					.data('title', item.siblings.title)
					.data('toggle-value', item.siblings.value ? 0 : 1)
					.attr('data-toggle-value', item.siblings.value ? 0 : 1)
					.attr('title', item.siblings.title)
					.find("[class*='icon-']").attr('class', siblingIcon)
					.closest('a')
					.find('.btn-text').html(item.siblings.title);
			}

			alertify.success(item.message);


			$(document).trigger('toggle:success', response);
		},

		onRequestComplete: function(){
			$('#modalWindow').modal('hide');
		},

		onRequestError: function(xhr, text, errorThrown) {
			var response = $.parseJSON(xhr.responseText),
				error = response.error;

			if (error) {
				alertify.error(error.message);
			}
		},

		// Sortable
		onSortEnd: function(evt) {
			var $item = $(evt.item);
			var $modelContainer = $item.closest('[data-model]'),
				url = $modelContainer.data('url') + '/move/' + $modelContainer.data('id'),
				prevPosition = evt.oldIndex,
				currPosition = evt.newIndex,
				$sibling = null;

			if (prevPosition != currPosition) {
				if (prevPosition > currPosition) {
					$sibling = $item.next('[data-model]');
				} else {
					$sibling = $item.prev('[data-model]');
				}

				if ($sibling.length) {
					var dataVar = 'data[' + $sibling.data('model') + ']',
						data = {};

					data[dataVar + '[replace_id]'] = $sibling.data('id');

					$.ajax({
						dataType: 'json',
						type: 'POST',
						url: url,
						data: data,
						error: this.onRequestError
					});
				}
			}
		},

		onEnablerCheckboxChange: function(e) {
			this.setEnablerCheckbox(e.target);
		},

		setEnablerCheckbox: function(input) {
			var $input = $(input);

			if (typeof $input.data('enable')) {
				var inputIsChecked = $input.is(':checked');
				var inputIsDesabling = typeof $input.data('inverse') === 'undefined' ? !inputIsChecked : inputIsChecked;
				var $enabledInputs = $('[data-enabled-by=' + $input.data('enable') + ']');

				$enabledInputs.each(function(i, e) {
					var $enabledInput = $(this);
					var disableThisInput = typeof $enabledInput.data('inverse') !== 'undefined' ? !inputIsDesabling : inputIsDesabling;
					$enabledInput.attr('disabled', disableThisInput);

					if (disableThisInput) {
						if ($enabledInput.attr('type') != 'checkbox') {
							$enabledInput.val('').trigger('change');
						} else {
							$enabledInput.prop('checked', false).trigger('change');
						}
					}
				});
			}
		},

		onShowCheckboxChange: function(e) {
			this.setShowCheckbox(e.target);
		},

		setShowCheckbox: function(input) {
			var $input = $(input);

			if (typeof $input.data('show')) {
				var inputIsChecked = $input.is(':checked');
				var inputIsDesabling = typeof $input.data('inverse') === 'undefined' ? !inputIsChecked : inputIsChecked;
				var $showedInputs = $('[data-showed-by=' + $input.data('show') + ']');

				$showedInputs.each(function(i, e) {
					var $showedInput = $(this);
					var disableThisInput = typeof $showedInput.data('inverse') !== 'undefined' ? !inputIsDesabling : inputIsDesabling;
					$showedInput.attr('disabled', disableThisInput);

					if (disableThisInput) {
						if ($showedInput.data('reset') === undefined || $showedInput.data('reset')) {
							if ($showedInput.attr('type') != 'checkbox') {
								//$showedInput.val('').trigger('change');
							} else {
								$showedInput.prop('checked', false).trigger('change');
							}
						}

						$showedInput.closest('.input').addClass('hidden');
					} else {
						$showedInput.closest('.input').removeClass('hidden');
					}
				});
			}
		}
	};

	BootstrapAdmin.load();
}(window, window.document));
