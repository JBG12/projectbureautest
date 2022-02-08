var $ = jQuery
$(document).ready(function() {
    /*========================================================================
      Back to Top button
    /*=======================================================================*/

    // Add the icon button for back to top.
    $("body").append('<a class="top"><i class="fas fa-arrow-up"></i></a>');

    // Check if the user is scrolled down a bit.
    $(window).scroll(function ScrollUp() {
        if ($(this).scrollTop() > 150) {
            $(".top").css({opacity: "1", pointerEvents: "auto"});
        } else {
            $(".top").css({opacity: "0", pointerEvents: "none"});
        }
    });
    // send to top //
    $(".top").click(function() { 
        $("html").animate({ scrollTop: 0 }, 300);
    });

});