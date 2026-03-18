/**
 * Media Manager
 */
 /* global Dropzone */
(function(window, document, undefined) {
	'use strict';

	var _config = {
		dropZone: {
			url: '/admin/media/add',
			paramName: 'data[Media][media]',
			maxFiles: 300,
			uploadMultiple: true,
			clickable: false,
			parallelUploads: 1,
			autoProcessQueue: true,
			// Thumbnail
			thumbnailWidth: 160,
			thumbnailHeight: 120,
			// Errors
			dictInvalidFileType: 'Tipo de archivo inválido',
			dictFileTooBig: 'El archivo está muy pesado',
			dictResponseError: 'server-error',
			dictMaxFilesExceeded: 'El número máximo de archvos para subir de golpe es de 300',
			// Fallback
			fallback: $.proxy(
				function(){
					$(this.element).removeClass('media-drop');
				},
				this
			),
			forceFallback: false, // TEST
			// Preview
			previewTemplate:
				"<div class='media-item media-loading' dz-preview>" +

					"<div class='media-actions btn-group'>" +
						"<a href='#' class='btn btn-xs btn-danger app-media-cancel'><i class='fa fa-times'></i></a>" +
					"</div>" +

					"<div class='media-thumbnail'>" +
						"<img data-dz-thumbnail />" +
						"<div class='load-bar'>" +
							"<div class='load-progress' data-dz-uploadprogress></div>" +
						"</div>" +
					"</div>" +

					"<div class='media-data'>" +
						"<span class='media-name' data-dz-name></span>" +
						"<span class='media-size' data-dz-size></span>" +
						"<span class='media-file-error' data-dz-errormessage></span>" +
					"</div>" +
				"</div>"
		}
	};

	var MediaManager = {
		load: function() {
			if (hozen.app.dropZoneUrl) {
				_config.dropZone.url = hozen.app.dropZoneUrl;
			}

			$(document).ready($.proxy(this.init, this));
			$(document).on('click', '.app-media-preview', this.onMediaPreview);
			$(document).on('click', '.app-media-share', $.proxy(this.onMediaShare, this));
			$(document).on('form:success', '#MediaChangeShareKeyForm', $.proxy(this.onMediaShareKeySubmit, this));


			$(document).on('click', '.app-media-attributes', $.proxy(this.onMediaAttributes, this));
			$(document).on('form:success', '#MediaAdminAttributeForm', $.proxy(this.onMediaAttributesSubmit, this));

			$(document).on('toggle:success', $.proxy(this.onToggleSuccess, this));
		},

		onToggleSuccess: function(e, response) {
			if (response.data.items.field != undefined && response.data.items.field == 'shared') {
				var $modal = $('#media-share-modal'),
					$content = $modal.find('.modal-body');

				$content.html('');

				if (response.data.items != undefined && response.data.items.modal != undefined && response.data.items.modal != null) {
					$content.html(response.data.items.modal);
				}

				if (response.data.items.value) {
					$('.media-item[data-id="' + response.data.items.id + '"]').addClass('shared');
				} else {
					$('.media-item[data-id="' + response.data.items.id + '"]').removeClass('shared');
				}
			}
		},

		onMediaPreview: function(e) {
			e.preventDefault();

			var $target = $(e.target).closest('.app-media-preview'),
				$modal = $('#media-preview-modal'),
				$image = $modal.find('#image-area');

			$image.html('<img src="' + $target.data('preview') + '">');

			$modal.modal('show');
		},

		onMediaShareKeySubmit: function(e, response) {
			if (response.data.items != undefined && response.data.items.modal != undefined && response.data.items.modal != null) {
				var $modal = $('#media-share-modal'),
					$content = $modal.find('.modal-body');

				$content.html('');
				$content.html(response.data.items.modal);
			}
		},

		onMediaAttributesSubmit: function(e, response) {
			var $modal = $('#media-attribute-modal'),
				$content = $modal.find('.modal-body'),
				name;

			$modal.modal('hide');
			$content.html('');

			if (response.data.items.name != undefined) {
				name = response.data.items.name;
				$('.media-item[data-id="' + response.data.items.id + '"] .media-data').data('media-name', name);
				$('.media-item[data-id="' + response.data.items.id + '"] .media-data .media-name').html(name);
				$('.media-item[data-id="' + response.data.items.id + '"] .media-data .media-name-textarea').html(name);
			}
		},

		onMediaAttributes: function(e) {
			e.preventDefault();

			var $target = $(e.target).closest('.app-media-attributes'),
				$media = $target.closest('[data-model="Media"]'),
				$mediaId = $media.data('id'),
				$mediaUrl = $media.data('url');

			$.ajax({
				type: 'GET',
				url: $mediaUrl + '/attribute/' + $mediaId,
				dataType: 'json',
				error: this.onAttributeError,
				complete: this.onAttributeComplete
			});
		},

		onAttributeComplete: function(data, status, xhr) {
			var response = $.parseJSON(data.responseText),
				$modal = $('#media-attribute-modal'),
				$content = $modal.find('.modal-body');

			$content.html('');

			if (response.data.items != undefined && response.data.items.modal != undefined && response.data.items.modal != null) {
				$content.html(response.data.items.modal);
			}

			window.hozen.component.Editor.init();

			$modal.modal('show');
		},

		onAttributeError: function(xhr, text, errorThrown) {
			$('#media-attribute-modal').modal('hide');
		},

		onMediaShare: function(e) {
			e.preventDefault();

			var $target = $(e.target).closest('.app-media-share'),
				$media = $target.closest('[data-model="Media"]'),
				$mediaId = $media.data('id'),
				$mediaUrl = $media.data('url');

			$.ajax({
				type: 'GET',
				url: $mediaUrl + '/share/' + $mediaId,
				dataType: 'json',
				error: this.onShareError,
				complete: this.onShareComplete
			});
		},

		onShareComplete: function(data, status, xhr) {
			var response = $.parseJSON(data.responseText),
				$modal = $('#media-share-modal'),
				$content = $modal.find('.modal-body');

			$content.html('');

			if (response.data.items != undefined && response.data.items.modal != undefined && response.data.items.modal != null) {
				$content.html(response.data.items.modal);
			}

			$modal.modal('show');
		},

		onShareError: function(xhr, text, errorThrown) {
			var $modal = $('#media-share-modal'),
				$content = $modal.find('.modal-body');

			$modal.modal('hide');
			$content.html('');
		},

		init: function() {
			this.zones = {};
			var $dropZones = $('[data-media]');

			if (!$dropZones.length) {
				return;
			}

			$dropZones.on('click', '.app-media-editable .media-data', $.proxy(this.onMediaNameClick, this));
			$dropZones.on('blur', '.media-name-textarea', $.proxy(this.onMediaNameBlur, this));
			$dropZones.on('keydown', '.media-name-textarea', $.proxy(this.onMediaNameEnter, this));

			$('body').on('click', '.media-item .media-fullscreen', $.proxy(this.videoFullScreen, this));
			$('body').on('click', '.media-control', $.proxy(this.toggleMedia, this));
			$('body').on('play', '.media-player', $.proxy(this.mediaPlayed, this));
			$('body').on('pause', '.media-player', $.proxy(this.mediaPaused, this));

			_config.dropZone.init = function() {
				var self = this;

				this.on('dragover', function(e) {
					$(self.element).addClass('media-hover');
				});

				this.on('dragleave', function(e) {
					$(self.element).removeClass('media-hover');
				});

				this.on('drop', function(e) {
					$(self.element).removeClass('media-hover');
					self.previousId = null;
				});


				this.on('selectedfiles', function(files) {
					if (!self.options.uploadMultiple) {
						if (files.length == 1) {
							self.removeAllFiles(true);
							self.multipleFileUpload = false;
						} else {
							self.multipleFileUpload = true;
						}
					}
				});

				this.on('addedfile', function(file) {
					$(self.element).find('.media-drop-item').removeClass('media-error');

					$(file.previewElement).on('click', '.app-media-cancel', function(e) {
						e.preventDefault();
						self.removeFile(file);
					});

					var mediaName = $(self.previewsContainer).data('name'),
						mediaMultiple = $(self.previewsContainer).data('name'),
						formats = window.hozen.config.media[mediaName],
						extension = file.name.split('.').pop();

					if (formats && extension) {
						if (!formats[extension.toLowerCase()] || formats[extension.toLowerCase()] != 'image') {
							$(file.previewElement).find('[data-dz-thumbnail]').replaceWith("<i class='fa fa-" + (formats[extension.toLowerCase()] ? formats[extension.toLowerCase()] : "file") + "' data-dz-thumbnail></i>");
							$(file.previewElement).data('prev', self.previousId);
						}
					}

					if (!self.options.uploadMultiple) {
						$(self.element).find('.media-loaded').hide();
					}

					if (self.previousId) {
						$(self.element).find('.media-item[data-id="' + self.previousId + '"]').hide();
						$(self.previewsContainer).find('.media-item[data-id="' + self.previousId + '"]').after($(file.previewElement));
					} else {
						$(self.previewsContainer).find('.media-drop-item').after($(file.previewElement));
					}
				});

				this.on('removedfile', function(file) {
					if (!this.options.autoProcessQueue && file.accepted) {
						var $form = $(self.element).closest('form');

						if ($form && window.hozen.form.forms && window.hozen.form.forms[$form.attr('id')] && window.hozen.form.forms[$form.attr('id')].fields && window.hozen.form.forms[$form.attr('id')].fields[self.options.paramName + '[media]']) {
							delete window.hozen.form.forms[$form.attr('id')].fields[self.options.paramName + '[media]'];
							delete window.hozen.form.forms[$form.attr('id')].fields[self.options.paramName + '[model]'];
							delete window.hozen.form.forms[$form.attr('id')].fields[self.options.paramName + '[collection]'];
						}
					}

					if (!self.options.uploadMultiple) {
						$(self.element).find('.media-loaded').show();
					}

					var previousId = $(file.previewElement).data('prev');

					if (previousId != undefined) {
						$(self.element).find('.media-loaded[data-id="' + previousId + '"]').show();
					}
				});

				this.on('success', function(file) {
					var response = $.parseJSON(file.xhr.response),
						item = response.data.element.mediaItem;

					if (!self.options.uploadMultiple) {
						$(self.element).find('.media-loaded').remove();
					}

					if (self.options.uploadMultiple && response.data.items.previousId != undefined) {
						$('.media-item[data-model="Media"][data-id="' + response.data.items.previousId + '"]').replaceWith(item);
					} else {
						$(item).insertBefore(file.previewElement);
					}

					self.removeFile(file);

					$(document).trigger('media:success', response.data.items.media.Media);
				});

				this.on('error', function(file, error, xhr) {
					$(file.previewElement).removeClass('media-loading');
					$(file.previewElement).addClass('media-error');

					alertify.error(error);
				});

				this.on('maxfilesexceeded', function(file) {
					if (!self.options.uploadMultiple) {
						self.removeFile(file);
					}
				});


			};

			$dropZones.each($.proxy(function(index, element) {
				var config = {};

				_.defaults(config, _config.dropZone);
				// cochinet's mess
				var parentId = 0;
				var clickableString = '';

				config.dictFileTooBig = config.dictFileTooBig + '<br><small><strong>(Máximo ' +  $(element).data('readable-size') + ')</strong></small>';

				if ($(element).closest('[data-model]').attr('data-id') !== undefined && $(element).closest('[data-model]').attr('data-id').length > 0) {
					parentId = $(element).closest('[data-model]').attr('data-id');
					clickableString = "[data-id='" + parentId + "'] " + '#' + $(element).closest('.media-dropzone').attr('id') + ' .media-drop-item';
				}

				if (parentId) {
					config.clickable = clickableString;
				} else {
					config.clickable = '#' + $(element).closest('.media-dropzone').attr('id') + ' .media-drop-item';
				}
				// end of chochinet's mess for clickable rows.

				var $modelContainer = $(element).closest('[data-model]'),
					identifier = $modelContainer.data('model'),
					$form = $(element).closest('form[data-async]');

				if ($modelContainer.data('id')) {
					identifier += '-' + $modelContainer.data('id');
				}

				if ($(element).data('collection')) {
					identifier += '-' + $(element).data('collection');
				}

				if ($(element).data('multiple') == '0') {
					config.maxFiles = 1;
					config.uploadMultiple = false;

					if (!$modelContainer.data('id')) {
						config.autoProcessQueue = false;
						config.paramName = $(element).data('field');
					}
				}

				if ($(element).data('size')) {
					config.maxFilesize = $(element).data('size');
				}

				if ($(element).data('drop')) {

					if (!config.uploadMultiple) {
						config.accept = function(file, done) {
							if (this.multipleFileUpload) {
								done(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}", this.options.maxFiles));
								return this.emit("maxfilesexceeded", file);
							} else {
								if (!config.autoProcessQueue) {
									var $form = $(element).closest('form[data-async]'),
									$modelContainer = $(element).closest('[data-model]');

									if ($form) {
										window.hozen.form.forms = window.hozen.form.forms || {};
										window.hozen.form.forms[$form.attr('id')] = window.hozen.form.forms[$form.attr('id')] || {};
										window.hozen.form.forms[$form.attr('id')].fields = window.hozen.form.forms[$form.attr('id')].fields || {};
										window.hozen.form.forms[$form.attr('id')].fields[config.paramName + '[media]'] = file;
										window.hozen.form.forms[$form.attr('id')].fields[config.paramName + '[model]'] = $modelContainer.data('model');
										window.hozen.form.forms[$form.attr('id')].fields[config.paramName + '[collection]'] = $(element).data('collection');

										if (this.previousId) {
											window.hozen.form.forms[$form.attr('id')].fields[config.paramName + '[previous_id]'] = this.previousId;
										}
									}
								}

								return done();
							}
						};
					}

					if ($(element).data('extensions')) {
						config.acceptedFiles = '.' + $(element).data('extensions').replace(/\,/g, ',.');
						config.acceptedFiles += ',' + config.acceptedFiles.toUpperCase();
					}

					this.zones[identifier] = new Dropzone(element, config);

					this.zones[identifier].on('sending', function(file, xhr, formData) {
						formData.append('data[Media][model]', $modelContainer.data('model'));
						formData.append('data[Media][collection]', $(element).data('collection'));

						if (this.previousId) {
							formData.append('data[Media][previous_id]', this.previousId);
						}

						if ($modelContainer.data('id')) {
							formData.append('data[Media][foreign_key]', $modelContainer.data('id'));
						}
					});

					if (this.zones[identifier].hiddenFileInput) {
						$(element).on('click', '.media-edit', $.proxy(
							function(e) {
								e.preventDefault();
								this.previousId = $(e.target).closest('[data-model]').data('id');
								this.hiddenFileInput.click();
							},
							this.zones[identifier]
						));

						$(element).on('click', '.media-drop-item', $.proxy(
							function(e) {
								this.previousId = null;
							},
							this.zones[identifier]
						));
					}
				}

				if ($form) {
					$form.on('form:error', function(e, response) {
						var error = response.error;
						$(element).find('.media-drop-item').removeClass('media-error');

						if (error.fields && error.fields.length) {
							for (var i in error.fields) {
								if (error.fields.hasOwnProperty(i) && 'data[' + error.fields[i].domain + ']' == config.paramName) {
									$(element).find('.media-item').addClass('media-error');
								}
							}
						}
					});

					$form.on('reset', $.proxy(function() {
						if ($(element).data('drop')) {
							this.zones[identifier].removeAllFiles(true);
						}
						$(element).find('.media-drop-item').removeClass('media-error');
						$(element).find('.media-item').remove();
					}, this));
				}
			}, this));

		},

		videoFullScreen: function(e) {
			var $target = $(e.target),
				$player = $target.closest('.media-item').find('video'),
				video = $player[0];

			if (video.requestFullscreen) {
				video.requestFullscreen();
			} else if (video.mozRequestFullScreen) {
				video.mozRequestFullScreen();
			} else if (video.webkitRequestFullscreen) {
				video.webkitRequestFullscreen();
			}

			$('.media-player').trigger('pause');

			$player.trigger('play');
		},

		toggleMedia: function(e) {
			var $target = $(e.target),
				$item = $target.closest('.media-item'),
				$player = $item.find('.media-player');

			if ($player[0].paused) {
				$player.trigger('play');
			} else {
				$player.trigger('pause');
			}
		},

		mediaPlayed: function (e) {
			var $target = $(e.target),
				$control = $target.closest('.media-item').find('.media-control');

			$('.media-player').addClass('stopped');
			$target.removeClass('stopped');

			$('.media-player.stopped').trigger('pause');
			$('.media-player.stopped').each($.proxy(function(e) {
				this.mediaPaused(this);
			}, this));

			$control.find('.play-action').addClass('hidden');
			$control.find('.pause-action').removeClass('hidden');

			if (!$target.hasClass('played')) {
				$target.on('ended', $.proxy(this.mediaEnded, this));
			}
			$target.addClass('played');
		},

		mediaPaused: function (e) {
			var $target = $(e.target),
				$control = $target.closest('.media-item').find('.media-control');

			$control.find('.play-action').removeClass('hidden');
			$control.find('.pause-action').addClass('hidden');
		},

		mediaEnded: function(e) {
			var $target = $(e.target);
			this.mediaPaused(e);
		},


		onMediaNameClick: function(e) {
			var $data = $(e.target).closest('.media-data'),
				$spans = $data.find('span'),
				$textarea = $data.find('textarea');

			$spans.hide();
			$textarea.show().focus();
		},

		onMediaNameEnter: function(e) {
			if (e.which == 13) {
				e.preventDefault();
				$(e.target).blur();
			}
		},

		onMediaNameBlur: function(e) {
			var $data = $(e.target).closest('.media-data'),
				$spans = $data.find('span'),
				$name = $data.find('span.media-name'),
				$textarea = $data.find('textarea');

			$spans.show();
			$textarea.hide();

			if ($textarea.val() != $data.data('media-name')) {
				$name.html($textarea.val());
				$data.data('media-name', $textarea.val());

				var settings = {
					type: 'POST',
					url: _config.dropZone.url.replace('/add', '/change_name/') + $data.closest('[data-model]').data('id'),
					data: {Media: {name: $textarea.val()}},
					success: $.proxy(this.onMediaNameSuccess, $data),
					error: $.proxy(this.onMediaNameError, $data),
					dataType: 'json'
				};

				$.ajax(settings);
			}
		},

		onMediaNameError: function(xhr, status, errors) {
			var response = $.parseJSON(xhr.responseText),
				error = response.error;

			if (error.message) {
				alertify.error(error.message);
			}
		},

		onMediaNameSuccess: function(data, status, xhr) {
			var response = $.parseJSON(xhr.responseText);

			if (response.data.items.message) {
				alertify.success(data.data.items.message);
			}
		}
	};

	MediaManager.load();

	window.hozen.widget.MediaManager = MediaManager;
}(window, window.document));
