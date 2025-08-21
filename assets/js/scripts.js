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

window.addEventListener('load', function () {
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
      640: {
        slidesPerView: 2.3,
      },
      1024: {
        slidesPerView: 3.2,
        spaceBetween: 50,
        // centeredSlides: false,
      },
    }
  });
});


// jQuery(function($) {

//   // 親タブをクリック
//   $(document).on('click', '.tab-button', function() {
//     var parentSlug = $(this).data('parent');

//     // 子カテゴリー取得（スキル研修以外）
//     if (parentSlug !== 'parent03') {
//       $.post(videoLibraryAjax.ajaxurl, {
//         action: 'get_child_terms',
//         parent: parentSlug
//       }, function(response) {
//         $('#child-filters').html(response);
//         $('#video-library-results').html(''); // 初期化
//       });
//     } else {
//       // スキル研修(parent03)は子なし → 直接動画取得
//       $.post(videoLibraryAjax.ajaxurl, {
//         action: 'get_videos',
//         term: parentSlug
//       }, function(response) {
//         $('#child-filters').html(''); // 子ボタン非表示
//         $('#video-library-results').html(response);
//       });
//     }
//   });

//   // 子カテゴリークリック
//   $(document).on('click', '.child-button', function() {
//     var termSlug = $(this).data('term');

//     $.post(videoLibraryAjax.ajaxurl, {
//       action: 'get_videos',
//       term: termSlug
//     }, function(response) {
//       $('#video-library-results').html(response);
//     });
//   });

// });


jQuery(function($){

  // Ajax URLは wp_localize_script で渡している videoLibrary.ajaxurl を使用
  var ajaxurl = videoLibrary.ajaxurl;

  // 親タブクリック
  $('.tab-button').on('click', function(){
      var parent = $(this).data('parent');

      // 親タブのアクティブ切替
      $('.tab-button').removeClass('active');
      $(this).addClass('active');

      // 子ボタン表示
      $('.child-buttons').hide();
      $('.child-buttons[data-parent="'+parent+'"]').show();

      // 子ボタンがなければすぐ投稿取得
      if($('.child-buttons[data-parent="'+parent+'"]').length === 0){
          fetch_posts(parent, 'all');
      }
  });

  // 子ボタンクリック
  $(document).on('click', '.child-button', function(){
      var parent = $(this).closest('.child-buttons').data('parent');
      var term   = $(this).data('term');

      // 子ボタンのアクティブ切替
      $(this).siblings().removeClass('active');
      $(this).addClass('active');

      fetch_posts(parent, term);
  });

  // 投稿取得
  function fetch_posts(parent, term){
      $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: {
              action: 'fetch_video_library',
              parent: parent,
              term: term
          },
          success: function(res){
              $('#video-library-results').html(res);
          }
      });
  }

});

jQuery(function($){

  // Ajax URL
  var ajaxurl = videoLibrary.ajaxurl;

  // ---------------------------
  // ページロード時に LocalStorage を確認
  // ---------------------------
  var filter = JSON.parse(localStorage.getItem('videoLibraryFilter'));
  if(filter) {
      var parent = filter.parent;
      var term   = filter.term;

      // 親タブアクティブ
      $('.tab-button').removeClass('active');
      $('.tab-button[data-parent="'+parent+'"]').addClass('active');

      // 子ボタン表示＆アクティブ
      $('.child-buttons').hide();
      $('.child-buttons[data-parent="'+parent+'"]').show();
      $('.child-button').removeClass('active');
      $('.child-button[data-term="'+term+'"]').addClass('active');

      // Ajax で投稿取得
      fetch_posts(parent, term);

      // 一度使ったら削除
      localStorage.removeItem('videoLibraryFilter');
  }

  // ---------------------------
  // 親タブクリック
  // ---------------------------
  $('.tab-button').on('click', function(){
      var parent = $(this).data('parent');

      $('.tab-button').removeClass('active');
      $(this).addClass('active');

      $('.child-buttons').hide();
      $('.child-buttons[data-parent="'+parent+'"]').show();

      if($('.child-buttons[data-parent="'+parent+'"]').length === 0){
          fetch_posts(parent, 'all');
      }
  });

  // ---------------------------
  // 子ボタンクリック
  // ---------------------------
  $(document).on('click', '.child-button', function(){
      var parent = $(this).closest('.child-buttons').data('parent');
      var term   = $(this).data('term');

      $(this).siblings().removeClass('active');
      $(this).addClass('active');

      fetch_posts(parent, term);
  });

  // ---------------------------
  // 投稿取得 Ajax
  // ---------------------------
  function fetch_posts(parent, term){
      $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: {
              action: 'fetch_video_library',
              parent: parent,
              term: term
          },
          success: function(res){
              $('#video-library-results').html(res);
          }
      });
  }

  // ---------------------------
  // 別ページ「もっと見る」ボタン用
  // ---------------------------
  $('.button-more').on('click', function(){
      var parent = $(this).data('parent'); // 例: parent01
      var child  = $(this).data('child');  // 例: child01

      // LocalStorage に保存
      localStorage.setItem('videoLibraryFilter', JSON.stringify({ parent: parent, term: child }));

      // 動画ライブラリページへ遷移
      window.location.href = '/video-library/'; // 遷移先URLに置き換えてください
  });

});

