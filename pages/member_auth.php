<?php /*
Template Name:ログイン・会員登録
*/ ?>


<?php get_header(); ?>

<main>
  <section id="library-section-title">
    <h2>ログイン・新規会員登録</h2>
  </section>

  <div class="container">
		<section id="contact-message">
			<h3>本サイトの資材は、製薬企業等の会員様限定で提供しております。</h3>
			<p>コンテンツをご覧になるには、ログインまたは新規会員登録をお願いいたします。</p>
		</section>


    <div class="auth-page">
      <div class="login-box">
        <h4>ログイン<span>会員登録されている方</span></h4>
        <?php
        wp_login_form([
          'redirect'       => home_url(), // ログイン後にリダイレクトする先
          'label_username' => 'ユーザー名',
          'label_password' => 'パスワード',
          'label_remember' => 'ログイン状態を保存する',
          'label_log_in'   => 'ログイン',
        ]);
        ?>
      </div>

      <div class="register-box">
        <h4>ログイン<span>会員登録されていない方</span></h4>
        <p>
          本サイトでは、製薬企業等のご担当者様に向けて、限定コンテンツをご提供しています。
          <span>詳細な資材の閲覧には、会員登録（審査制）が必要です。</span>
        </p>

        <?php if (is_user_logged_in()) : ?>
          <!-- ログイン済みならクリックでメッセージ -->
          <button type="button" class="register-link" onclick="alert('ログイン済みです');">
            会員登録はこちら
          </button>
        <?php else : ?>
          <!-- 未ログインなら会員登録ページへ -->
          <a class="register-link" href="<?php echo esc_url(wp_registration_url()); ?>">
            会員登録はこちら
          </a>
        <?php endif; ?>
      </div>
    </div>


  </div>

</main>

<?php get_footer(); ?>