jQuery(document).ready(function ($) {
    $(window).scroll(function() {
        if ($(window).scrollTop() > 50)
            $('#header_main').addClass("header--border");
        else
            $('#header_main').removeClass("header--border");
    });
});