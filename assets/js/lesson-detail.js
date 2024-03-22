tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: "#00859C",
        orange: "#FAA332",
        standard: "#1B61F9",
        green: "#5BC04E",
        yellow: "#FBBC16",
      },
    },
  },
};

$(document).ready(function () {
    
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    $('.icon-notification,.notification .close-button').on('click', function () {
        $('.notification').toggle();

    });
    jQuery('.rs-slider').each(function (e, i) {
        let prev = jQuery(this).find('.prev-ar').eq(0);
        let next = jQuery(this).find('.next-ar').eq(0);
        let number = $(this).data('key');
        let dot = $(this).find('.dot').eq(0);
        let slider = $(this).find('.ss-slider').eq(0);
        slider.slick({
            infinite: false,
            slidesToShow: number,
            slidesToScroll: number,
            arrows: true,
            dots: true,
            prevArrow: prev,
            nextArrow: next,
            appendDots: dot,
            // autoplay: true,
            // autoplaySpeed: 2000,
            infinite: true,

        });



    });

    $('.mark-read').on('click', function () {

        $.ajax({
            url: aj_object.ajaxurl, // WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'mark_read', // The AJAX action name

                // Additional data to send if needed
            },
            success: function (response) {
                // Handle the AJAX response

                $('.msg').removeClass('msg-0').addClass('msg-1');
                $('.icon-notification span').html(0);
            },
            error: function (xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    });

});

$(document).click(function (event) {
  const notification = $('.notification');
  const iconnotification = $('.icon-notification');
  const targetElement = event.target;

  // Check if the clicked element is not inside the panel
  if (!notification.is(targetElement) && !iconnotification.is(targetElement) && notification.has(targetElement).length === 0 && iconnotification.has(targetElement).length === 0) {
    // Hide the panel

    if (notification.css('display') !== 'none') {
      notification.hide();
    }
  }
});

$('.item-menu.has-sub-menu').on('click', function () {
  var menu = $(this);
  menu.toggleClass('active-sub');
});