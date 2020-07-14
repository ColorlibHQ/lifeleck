(function ($) {
  "use strict";
  // menu fixed js code
  $(window).scroll(function () {
    var window_top = $(window).scrollTop() + 1;
    if (window_top > 50) {
      $('.main_menu').addClass('menu_fixed animated fadeInDown');
    } else {
      $('.main_menu').removeClass('menu_fixed animated fadeInDown');
    }
  });
  
  if (document.getElementById('default-select')) {
		$('select').niceSelect();
  }

  
  /*-------------------------------------
  Instagram Photos
  -------------------------------------*/
  function cp_instagram_photos() {
    $('.cp-instagram-photos').each(function(){
        $.instagramFeed({
            'username': $(this).data('username'),
            'container': $(this),
            'display_profile': false,
            'display_biography': false,
            'items': $(this).data('items'),
            'margin': 0
        });
        console.log( $(this) );
    });

  }
  cp_instagram_photos();

  
}(jQuery));