(function () {
    "use strict";

    // /**
    //  * Back to top button
    //  */
    // // let backtotop = select('.back-to-top')
    // // if (backtotop) {
    // //     const toggleBacktotop = () => {
    // //         if (window.scrollY > 100) {
    // //             backtotop.classList.add('active')
    // //         } else {
    // //             backtotop.classList.remove('active')
    // //         }
    // //     }
    // //     window.addEventListener('load', toggleBacktotop)
    // //     onscroll(document, toggleBacktotop)
    // // }


    /**
     * Scroll with ofset on page load with hash links in the url
     */
    window.addEventListener('load', () => {
        if (window.location.hash) {
            if (select(window.location.hash)) {
                scrollto(window.location.hash)
            }
        }
    });


    /**
     * Menu isotope and filter
     */
    // window.addEventListener('load', () => {
    //     let menuContainer = select('.menu-container');
    //     if (menuContainer) {
    //         let menuIsotope = new Isotope(menuContainer, {
    //             itemSelector: '.menu-item',
    //             layoutMode: 'fitRows'
    //         });

    //         let menuFilters = select('#menu-flters li', true);

    //         on('click', '#menu-flters li', function (e) {
    //             e.preventDefault();
    //             menuFilters.forEach(function (el) {
    //                 el.classList.remove('filter-active');
    //             });
    //             this.classList.add('filter-active');

    //             menuIsotope.arrange({
    //                 filter: this.getAttribute('data-filter')
    //             });

    //         }, true);
    //     }

    // });

    /**
     * chefs slider
     */
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            autoplay: true,
            loop: true,
            margin: 10,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 2
                },

            }
        });
    });


    $('.slideshow').imagesLoaded({ background: true })
        .done(function () {
            // hide loader
            $('.loader').addClass('is-loaded');

            // init variables
            var slideshow = $(".slideshow"),
                navigation = $(".navigation"),
                navigationItem = $(".navigation-item"),
                detailItem = $(".detail-item"),
                rotation,
                type = '_short';

            // prepare letters
            $('.headline').each(function () {
                $(this).html($(this).text().replace(/([^\x00-\x80]|\w)/g, "<span class='letter'>$&</span>"));
            });

            // prepare navigation and set navigation items on the right place
            navigationItem.each(function (index, elem) {
                TweenMax.set(elem, {
                    left: navigation.width() / 2 - navigationItem.width() / 2 - 10,
                    rotation: 90 + (index * 360 / navigationItem.length),
                    transformOrigin: "50% " + navigation.width() / 2 + "px"
                });
                TweenMax.set($(elem).find('.rotate-holder'), {
                    text: String(index * 360 / navigationItem.length)
                });
                TweenMax.set($(elem).find('.background-holder'), {
                    rotation: -90 - (index * 360 / navigationItem.length),
                });
            });

            // set tween values
            function setTweenValues() {
                rotation = Number($(this).find('.rotate-holder').text());
            }

            // do tween
            function doTween(target) {

                var targetIndex = navigationItem.index(target),
                    timeline = new TimelineMax();

                // add/remove class "active" from navigation & detail
                navigationItem.each(function () {
                    $(this).removeClass('active');
                    if ($(this).index() == $(target).index()) {
                        $(this).addClass('active');
                    }
                });
                detailItem.each(function () {
                    $(this).removeClass('active');
                    if ($(this).index() == $(target).index()) {
                        $(this).addClass('active');
                    }
                });

                timeline
                    .to(navigation, 0.6, {
                        rotation: -rotation + type,
                        transformOrigin: "50% 50%",
                        ease: Sine.easeInOut
                    })
                    .staggerTo(navigationItem.find('.background-holder'), 0.6, {
                        cycle: {
                            //function that returns a value
                            rotation: function (index, element) {
                                return -90 - Number($(element).prev('.rotate-holder').text()) + rotation + type;
                            }
                        },
                        transformOrigin: "50% 50%",
                        ease: Sine.easeInOut,
                    }, 0, '-=0.6')
                    .staggerFromTo($('.active').find('.letter'), 0.3, {
                        autoAlpha: 0,
                        x: -100,
                    },
                        {
                            autoAlpha: 1,
                            x: 0,
                            ease: Sine.easeInOut,
                        }, 0.025, '-=0.3')
                    .fromTo($('.active').find('.background'), 0.9, {
                        autoAlpha: 0,
                        x: -100,
                    },
                        {
                            autoAlpha: 1,
                            x: 0,
                            ease: Sine.easeInOut,
                        }, 0.05, '+=0.3');
            }

            // click/hover on items
            navigationItem.on('mouseenter', setTweenValues);
            navigationItem.on('click', function () { doTween($(this)); })

            // on load show slideshow as well as first "active" navigation/detail item
            TweenMax.to(slideshow, 1, { autoAlpha: 1 });
            TweenMax.to($('.active').find('.letter'), 0.7, { autoAlpha: 1, x: 0 });
            TweenMax.to($('.active').find('.background'), 0.7, { autoAlpha: 1, x: 0 });

        });

    // fast fix for resize window and refresh view, attention: not use in production, only for demo purposes!
    (function () {
        var width = window.innerWidth;

        window.addEventListener('resize', function () {
            if (window.innerWidth !== width) {
                window.location.reload(true);
            }
        });
    })();
})()