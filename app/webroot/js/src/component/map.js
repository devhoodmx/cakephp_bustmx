(function(window, document, undefined) {
	'use strict';

	var hozen = window.hozen;
	var config = hozen.config.map || {};

	var Map = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			var self = this;
			var $nodes = $('[data-component="map"]');

			this.maps = {};
			this.data = {};

			if ($nodes.length) {
				var prevMarker;

				this.data = hozen.data.component.map ? hozen.data.component.map : {};

				$(document.body).on('click', '.map-component-marker', function(e) {
					var $node = $(e.currentTarget);
					var map;
					var marker;

					if ($node.data('map') && $node.data('marker') !== undefined) {
						map = self.maps[$node.data('map')];

						if (map) {
							marker = map.markers[$node.data('marker')];

							if (marker) {
								if (prevMarker) {
									prevMarker.setAnimation(null);
								}

								prevMarker = marker;
								map.map.setCenter(marker.getPosition());
								marker.setAnimation(google.maps.Animation.BOUNCE);

								// Stop animation after x seconds
								window.setTimeout(function() {
									marker.setAnimation(null);
								}, 2 * 1000);
							}
						}
					}
				});

				$nodes.each(function(i, e) {
					var $map = $(e);

					self.maps[$map.data('key')] = {
						'$node': $map,
						map: null,
						markers: {}
					};

					self.render($map);
				});
			}
		},

		render: function($map) {
			var key = $map.data('key');
			var map;
			var mapOpts = {};
			var pos;
			var zoom = $map.data('zoom');
			var marker;
			var markerOpts = {};
			var locations = [];

			// Set width & height
			if ($map.data('width') !== undefined) {
				$map.width($map.data('width'));
			}
			if ($map.data('height') !== undefined) {
				$map.height($map.data('height'));
			}

			// Map options
			mapOpts = {
				zoom: zoom
			};

			// Controls
			if ($map.data('controls') !== undefined) {
				var all = ['zoom', 'mapType', 'scale', 'streetView', 'rotate', 'fullscreen'];
				var controls = $map.data('controls');

				if (!controls) {
					mapOpts.disableDefaultUI = true;
				} else {
					if (Array.isArray(controls)) {
						all.forEach(function (control) {
							mapOpts[control + 'Control'] = controls.indexOf(control) != -1 ? true : false;
						});
					}
				}
			}
			// Type
			if ($map.data('type') !== undefined) {
				mapOpts.mapTypeId = $map.data('type');
			}
			// Map styles
			if (config.styles) {
				mapOpts.styles = config.styles;
			}
			// Locations
			if (this.data[key] !== undefined && Array.isArray(this.data[key].locations)) {
				locations = this.data[key].locations;
			}

			// Create map
			map = new google.maps.Map($map[0], mapOpts);
			this.maps[key].map = map;

			if (locations.length) {
				var bounds = new google.maps.LatLngBounds();
				var location;
				var markerKey;
				var infoWindow = new google.maps.InfoWindow();

				for (var index = 0; index < locations.length; index++) {
					location = locations[index];
					marker = this.createMarker({
						map: map,
						latitude: location.lat,
						longitude: location.lng,
						icon: $map.data('icon'),
						title: location.title
					});
					markerKey = location.key === undefined ? index : location.key;
					pos = marker.getPosition();

					// Info window
					if (location.info) {
						marker.addListener('click', (function(marker, location) {
							return function() {
								infoWindow.setContent(location.info);
								infoWindow.open(map, marker);
							};
						})(marker, location));
					}

					this.maps[key].markers[markerKey] = marker;

					// Extend bounds
					bounds.extend(pos);
				}

				if (zoom) {
					// Set zoom after fitting bounds
					google.maps.event.addListenerOnce(map, 'zoom_changed', function () {
						map.setZoom(zoom);
					});
				}

				// Automatically center the map fitting all markers on the screen
				map.fitBounds(bounds);
			} else {
				marker = this.createMarker({
					map: map,
					latitude: $map.data('latitude'),
					longitude: $map.data('longitude'),
					icon: $map.data('icon')
				});
				this.maps[key].markers = {1: marker};

				// Center map
				map.setCenter(marker.getPosition());
			}
		},

		createMarker: function(data) {
			var marker;
			var pos;
			var opts = {};

			// Position
			pos = new google.maps.LatLng(data.latitude, data.longitude);

			// Options
			opts = {
				position: pos,
				map: data.map
			};

			// Icon
			if (data.icon !== undefined && data.icon) {
				opts.icon = data.icon;
			}
			// Title
			if (data.title !== undefined && data.title) {
				opts.title = data.title;
			}

			// Create marker
			marker = new google.maps.Marker(opts);

			return marker;
		}
	};

	window.onMapLoaded = function() {
		Map.load();
	};

	window.hozen.component.Map = Map;
}(window, window.document));

