jQuery(document).ready(function($) {


    $(window).stellar();
    var links = $('.navigation').find('li');
    slide = $('.slide');
    button = $('.button');
    mywindow = $(window);
    htmlbody = $('html,body');
    slide.waypoint(function(event, direction) {

        dataslide = $(this).attr('data-slide');
        if (direction === 'down') {
            $('.navigation li[data-slide="' + dataslide + '"]').addClass('active').prev().removeClass('active');
        }
        else {
            $('.navigation li[data-slide="' + dataslide + '"]').addClass('active').next().removeClass('active');
        }

    });
    mywindow.scroll(function() {
        if (mywindow.scrollTop() == 0) {
            $('.navigation li[data-slide="1"]').addClass('active');
            $('.navigation li[data-slide="2"]').removeClass('active');
        }
    });
    function goToByScroll(dataslide) {
        htmlbody.animate({
            scrollTop: $('.slide[data-slide="' + dataslide + '"]').offset().top
        }, 2000, 'easeInOutQuint');
    }



    links.click(function(e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });
    button.click(function(e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });
});
function subscribe() {
    try {
        $.ajax({
            type: "POST",
            url: "./controllers/request/subscribeRequest.php",
            data: {"email": $("#mail").val(), "request": "subscribe"},
            dataType: "json",
            async: false,
            success: function(data, status, xhr) {
                //gestione success
                alert(data.status);
            },
            error: function(data, status, xhr) {
                var response = JSON.parse(data.responseText);        
                alert(response.status);
            }
        });

    } catch (err) {
        window.console.error("sendRequest | An error occurred - message : " + err.message);
    }
}
