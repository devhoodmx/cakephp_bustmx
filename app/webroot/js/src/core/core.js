(function(window, document, undefined) {
	'use strict';

	var hozen = {
		version: '0.1.0',
		/*
		 * Namespaces
		 */
		form: {}, data: {component: {}}, app: {}, core: {}, controller: {}, view: {}, model: {}, widget: {}, config: {}, locale: {}, lib: {}, template: {}, plugin: {}, component: {}
	};

	hozen.__d = function(domain, msg) {
		var locale = hozen.app.locale;
		var translated;

		if (!hozen.locale[locale] || !hozen.locale[locale][domain]) {
			return null;
		}

		translated = hozen.locale[locale][domain][msg];
		if (!translated) {
			translated = msg;
		}

		return translated;
	};

	window.hozen = hozen;
}(window, this.document));
