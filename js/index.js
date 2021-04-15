function genericCarousel(selector, options = {}) {
    if (Object.keys(options).length <= 0) {
        options = {
            autoplay: true,
            lazyLoad: true,
            loop: true,
            margin: 40,
            responsiveClass: true,
            autoHeight: true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            nav: false,
            center: true,
            items: 1,
            autoplayHoverPause: true
        }
    }
    var owl = $(`${selector}`);
    owl.owlCarousel({ ...options });

    $('.play').on('click', function () {
        owl.trigger('play.owl.autoplay', [1000])
    })
    $('.stop').on('click', function () {
        owl.trigger('stop.owl.autoplay')
    })
}

jQuery(function () {
    // index carousel
    genericCarousel(".mainWrapper-carousel");

    // profile dropdown
    jQuery("body").on("click", ".userAvatar-image", function(e) {
        jQuery(".customDropdown").find(".customDropdown-list").toggleClass("active");
    })
})