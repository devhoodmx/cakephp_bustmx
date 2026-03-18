(function (window, document, undefined) {
    'use strict';

    var ContactApp = {
        load: function () {
            $(document).ready($.proxy(this.init, this));

        },

        init: function () {
 
        },

    };

    ContactApp.load();

    window.hozen.app.ContactApp = ContactApp;
}(window, window.document));