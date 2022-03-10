var $ = jQuery
$(document).ready(function() {
    /*========================================================================
      Back to Top button
    /*=======================================================================*/

    // Add the icon button for back to top button.
    $("body.page").append('<a class="top"><i class="fas fa-arrow-up"></i></a>');
    $(".section-inner .post-edit").remove();

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

    /*========================================================================
      Random color
    /*=======================================================================*/
    // $('.menuItem a').each(function() {
    //     var colors = ["e02a3f", "1cb9d8", "35dd5c", "772dff", "11fcd9"];
    //     var randomColor = colors[Math.floor(Math.random()*colors.length)];
    //     $(".link").css({color: "#" + randomColor});
    // });
});