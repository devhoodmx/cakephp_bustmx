(function (window, document, undefined) {
    'use strict';

    var HomeApp = {
        load: function () {
            $(document).ready($.proxy(this.init, this));

        },

        init: function () {
           
            this.swiperServices();
            this.swiperBriefcase();
            this.playVideoProject();
        },
        swiperServices:function(){
            var swiper = new Swiper(".swiper-services", {
                slidesPerView: "auto",
                spaceBetween: 0,
                breakpoints: {
                    1500: {
                       slidesPerView:5,
                    },
                },
                
            });

            $(document).on('scroll resize', $.proxy(this.servicesScroll, this));
            this.servicesScroll();
        },

        servicesScroll: function(e) {
            var $cards = $('.card-service'),
                scrollTop = $(window).scrollTop(),
                scrollHeight = window.innerHeight,
                scrollWidth = $(window).width(),
                scrollBottom = scrollTop + scrollHeight,
                $container = $('.section-services .container-cards'),
                containerTop = $container.offset().top - 160,
                cardTop,
                pills,
                margin = 0,
                maxMargin,
                accumulatedMargin = 0;

            $cards.each(function(index){
                pills = $(this).find('.container-pills');

                if (scrollWidth >= 1200) {
                    margin = 0;
                    cardTop = $(this).offset().top - 200;
                } else {
                    margin = 0; //scrollHeight - 160 - ((scrollHeight - 160) / 5) - (((scrollHeight - 160) / 5) * index);
                    cardTop = $(this).offset().top - 160 - (index * ((scrollHeight - 160) / 5));
                    maxMargin = scrollHeight - 160 - ((scrollHeight - 160) / 5) - (((scrollHeight - 160) / 5) * index);
                }
                
                if (scrollTop >= cardTop) {
                    $(this).addClass('active-card');

                    if (scrollWidth >= 1200) {
                    } else {
                        margin = (cardTop - containerTop - accumulatedMargin);

                        if (margin > maxMargin) {
                            margin = maxMargin;
                        }
                    }
                   
                    if (margin < 0) {
                        margin = 0;
                    }
                    
                } else {
                    if ($(this).offset().top > scrollBottom) {
                        $(this).removeClass('active-card');
                    }
                }

                pills.css('transform', 'translate3D(0, -' + margin + 'px, 0)');

                accumulatedMargin += scrollHeight - 160 - ((scrollHeight - 160) / 5) - (((scrollHeight - 160) / 5) * index);
            });
        },

        swiperBriefcase: function () {
            var swiper = new Swiper(".swiper-briefcase", {
                slidesPerView: 1,
                spaceBetween: 10,
                                
                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
                on: {
                    init: function () {
                        if (window.innerWidth >= 992) {
                            // Agrega la clase 'margen-superior' al segundo slide
                            var secondSlide = this.slides[1];
                            secondSlide.classList.add('margen-superior');
                        } else {
                            if ($(this.slides[0]).find('video').length > 0) {
                                $(this.slides[0]).find('video').trigger('play');
                            }
                        }
                    },
                    slideChange: function () {
                        if (window.innerWidth >= 992) {

                            for (var i = 0; i < this.slides.length; i++) {
                                this.slides[i].classList.remove('margen-superior');
                            }

                            // Agrega la clase 'margen-superior' al segundo slide después del activo
                            var nextIndex = (this.activeIndex + 1) % this.slides.length;
                            this.slides[nextIndex].classList.add('margen-superior');
                        } else {
                            for (var i = 0; i < this.slides.length; i++) {
                                if ($(this.slides[i]).find('video').length > 0) {
                                    $(this.slides[i]).find('video').trigger('pause');
                                }
                            }

                            if ($(this.slides[this.activeIndex]).find('video').length > 0) {
                                $(this.slides[this.activeIndex]).find('video').trigger('play');
                                $(this.slides[this.activeIndex]).find('video')[0].muted = false;
                            }
                        }
                    },
                },
            });

        },
        playVideoProject: function () {

            const videos = document.querySelectorAll('.video-project');
            let previewTimeout = null;

            videos.forEach(element => {
                element.addEventListener('mouseover', () => {
                    if (window.innerWidth >= 992) {
                        element.play();
                        element.muted = false;
                    }
                   
                });
                element.addEventListener('mouseout', () => {
                    element.pause();
                    element.muted = true;
                });
            });


        },
    };

    HomeApp.load();

    window.hozen.app.HomeApp = HomeApp;
}(window, window.document));