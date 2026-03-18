(function (window, document, undefined) {
    'use strict';

    var VideosApp = {
        load: function () {
            $(document).ready($.proxy(this.init, this));

        },

        init: function () {
            $('video').on('play', $.proxy(this.mediaPlayed, this));           
        },

        mediaPlayed: function (e) {
            var $target = $(e.target);

            $('video').addClass('stopped');
            $target.removeClass('stopped');

            $('video.stopped').trigger('pause');
        },
    };

    VideosApp.load();

    window.hozen.app.VideosApp = VideosApp;
}(window, window.document));