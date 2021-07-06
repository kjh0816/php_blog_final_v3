<?php
$pageTitleIcon = '<i class="fas fa-user-plus"></i>';
$pageTitle = "회원가입";
?>
<?php require_once __DIR__ . "/../head.php"; ?>

<section class="section-join">
  <div class="container mx-auto">
    <form action="doJoin" method="POST">
      <div>
        <span>로그인아이디</span>
        <input required placeholder="로그인아이디를 입력해주세요." type="text" name="loginId">
      </div>
      <div>
        <span>로그인비밀번호</span>
        <input required placeholder="로그인비밀번호를 입력해주세요." type="password" name="loginPw">
      </div>
      <div>
        <span>로그인비밀번호 확인</span>
        <input required placeholder="로그인비밀번호를 입력해주세요." type="password" name="loginPwConfirm">
      </div>
      <div>
        <input type="submit" value="가입">
      </div>
    </form>
  </div>
</section>

<?php require_once __DIR__ . "/../foot.php"; ?>