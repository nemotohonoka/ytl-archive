document.addEventListener('DOMContentLoaded', function() {
  const navToggle = document.getElementById('nav-toggle');

  navToggle.addEventListener('click', function() {
    navToggle.classList.toggle('open');
  });
});

$(function () {
  // 親メニューにhover
  $('.parent-menu').hover(
    function () {
      $(this).next('.children-menu').addClass('active');
    },
    function () {
      $(this).next('.children-menu').removeClass('active');
    }
  );

  // 子メニューにhover
  $('.children-menu').hover(
    function () {
      $(this).addClass('active');
    },
    function () {
      $(this).removeClass('active');
    }
  );
});

// element fade-in
$(function(){
  $(window).scroll(function (){
      $('.fadein').each(function(){
          var elemPos = $(this).offset().top;
          var scroll = $(window).scrollTop();
          var windowHeight = $(window).height();
          if (scroll > elemPos - windowHeight){
              $(this).addClass('slidein');
          }
      });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  new Swiper('.my-medical-swiper', {
      slidesPerView: 1.3,
      spaceBetween: 30,
      loop: true,
      centeredSlides: true,

      // ナビゲーションはスライド内に配置
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },

      breakpoints: {
          768: { slidesPerView: 2 },
          480: { slidesPerView: 1 },
      }
  });
});