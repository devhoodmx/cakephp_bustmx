(function (window, document, undefined) {
    'use strict';

    var VideosApp = {
        load: function () {
            $(document).ready($.proxy(this.init, this));

        },

        init: function () {
            $('video').on('play', $.proxy(this.mediaPlayed, this));
            this.initFilters();
        },

        mediaPlayed: function (e) {
            var $target = $(e.target);

            $('video').addClass('stopped');
            $target.removeClass('stopped');

            $('video.stopped').trigger('pause');
        },

        initFilters: function () {
            var $filters = $('.btn-filter');

            if (!$filters.length) return;

            $filters.on('click', function () {
                var filter = $(this).data('filter');

                $filters.removeClass('active');
                $(this).addClass('active');

                if (filter === 'all') {
                    $('.project-item').removeClass('project-hidden');
                } else {
                    $('.project-item').each(function () {
                        var categoryData = $(this).data('category').toString();
                        var categories = categoryData ? categoryData.split(',') : [];
                        var match = filter === 'none' ? categories.length === 0 : categories.indexOf(filter.toString()) !== -1;
                        $(this).toggleClass('project-hidden', !match);
                    });
                }

                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
            });
        },
    };

    VideosApp.load();

    window.hozen.app.VideosApp = VideosApp;
}(window, window.document));
