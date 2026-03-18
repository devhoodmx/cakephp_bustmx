/**
 * Media Manager
 */
(function(window, document, undefined) {
	'use strict';
	var Map = {
		load: function() {
			$(document).ready($.proxy(this.init, this));
		},

		init: function() {
			this.initMap($('[data-widget-map]'));
		},

		initMap: function(maps) {
			maps.each(function(index) {
				var lat = $('#' + $(this).data('widget-map-lat'));
				var lng = $('#' + $(this).data('widget-map-lng'));
				var zoom = $('#' + $(this).data('widget-map-zoom'));

				var position = new google.maps.LatLng(Number(lat.val()), Number(lng.val()));

				var map = new google.maps.Map($(this)[0], {
					center: position,
					zoom: Number(zoom.val()),
				});

				var marker = new google.maps.Marker({
					position: position
				});

				marker.setMap(map);

				map.addListener('center_changed', function() {
					lat.val(map.getCenter().lat());
					lng.val(map.getCenter().lng());

					marker.setPosition(map.getCenter());
				});

				map.addListener('zoom_changed', function() {
					zoom.val(map.getZoom());
				});
			});
		}
	};

	window.onMapLoaded = function() {
		Map.load();
	};

	window.hozen.widget.Map = Map;
}(window, window.document));
