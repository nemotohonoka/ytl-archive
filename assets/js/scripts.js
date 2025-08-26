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

window.addEventListener('load', function () {
  const slider = document.querySelector('.video-slider');
  slider.style.visibility = 'visible';

  new Swiper('.video-slider', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.video-pagination',
      clickable: true,
    },
    breakpoints: {
      640: { 
        slidesPerView: 2.2, 
        spaceBetween: 40, 
        centeredSlides: true 
      },
      1024: { 
        slidesPerView: 3.2,
        spaceBetween: 50,
        centeredSlides: true 
      },
    }
  });
});

document.querySelectorAll('.swiper-slide').forEach(slide => {
  slide.addEventListener('click', () => {
    const link = slide.getAttribute('data-link');
    if (link) {
      window.location.href = link;
    }
  });
});


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

document.addEventListener('DOMContentLoaded', function() {
  // 初期表示する親カテゴリー
  const initialParent = 'parent01';

  // 親タブの見た目を active に
  const parentTab = document.querySelector(`.tab-button[data-parent="${initialParent}"]`);
  if (parentTab) parentTab.classList.add('active');

  // 初回は parent01 の子ボタンを表示
  const childWrapper = document.querySelector(`.child-buttons[data-parent="${initialParent}"]`);
  if (childWrapper) childWrapper.style.display = 'flex';

  // 親タブクリック時の切り替え
  document.querySelectorAll('.tab-button').forEach(button => {
      button.addEventListener('click', function() {
          const parent = this.getAttribute('data-parent');
          document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
          this.classList.add('active');

          document.querySelectorAll('.child-buttons').forEach(cb => cb.style.display = 'none');
          const childDiv = document.querySelector(`.child-buttons[data-parent="${parent}"]`);
          if (childDiv) childDiv.style.display = 'flex';
      });
  });
});

