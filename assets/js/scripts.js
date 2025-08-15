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