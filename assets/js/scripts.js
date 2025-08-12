// 

// モバイルメニューの開閉
const toggle = document.getElementById('navToggle');
const nav = document.getElementById('main-navigation');
toggle.addEventListener('click', ()=>{
  const isOpen = nav.classList.toggle('open');
  toggle.setAttribute('aria-expanded', isOpen);
});

// ドロップダウンのモバイル用挙動（タップで開く）
document.querySelectorAll('.has-dropdown > a').forEach(a=>{
  a.addEventListener('click', (e)=>{
    if (window.innerWidth <= 900){
      e.preventDefault();
      const li = a.parentElement;
      li.classList.toggle('open');
    }
  });
});

// キーボードでのアクセス性向上（ESCで閉じる）
document.addEventListener('keydown', (e)=>{
  if (e.key === 'Escape'){
    nav.classList.remove('open');
    toggle.setAttribute('aria-expanded','false');
    document.querySelectorAll('.has-dropdown').forEach(li=>li.classList.remove('open'));
  }
});

  