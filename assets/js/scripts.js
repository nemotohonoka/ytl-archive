// header toggle
$(function(){
  var state = false;
  var scrollpos;
 
  $('#nav-toggle').on('click', function(){
    if(state == false) {
      scrollpos = $(window).scrollTop();
      $('body').addClass('fixed').css({'top': -scrollpos});
      $('#global-header').addClass('open');
      state = true;
    } else {
      $('body').removeClass('fixed').css({'top': 0});
      window.scrollTo( 0 , scrollpos );
      $('#global-header').removeClass('open');
      state = false;
    }
  });
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

// スライダー
new Swiper('.nested-slider-h', {  
  loop: false, 
  nested: true,    
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: ".parent-navi-next",
    prevEl: ".parent-navi-prev",
  },
})
new Swiper('.nested-slider-child', {
  // loop: true,
  nested: true, 
  loop: true,
  speed: 2000,
  autoplay: {
    delay: 2000,
  },
  effect: 'fade',
  fadeEffect: {           
    crossFade: true
  },

  pagination: {
    type: 'progressbar',
    el: '.swiper-child-pagination',
    clickable: true,
  },
}) 

// エントリーボタン 追従・途中削除
jQuery(function() {
  var footer = $('#global-footer').innerHeight(); // footerの高さを取得
  window.onscroll = function () {
    var point = window.pageYOffset; // 現在のスクロール地点 
    var docHeight = $(document).height(); // ドキュメントの高さ
    var dispHeight = $(window).height(); // 表示領域の高さ

    if(point > docHeight-dispHeight-footer){ // スクロール地点>ドキュメントの高さ-表示領域-footerの高さ
      $('#entry-button').addClass('is-hidden'); //footerより下にスクロールしたらis-hiddenを追加
    }else{
      $('#entry-button').removeClass('is-hidden'); //footerより上にスクロールしたらis-hiddenを削除
    }
  };
});

// バツボタン
document.getElementById('close-btn').addEventListener('click', function() {
  document.getElementById('entry-button').style.display = 'none';
});

  