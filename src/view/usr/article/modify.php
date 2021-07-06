<?php
$pageTitleIcon = '<i class="fas fa-edit"></i>';
$pageTitle = "게시물 수정, ${id}번 게시물";
?>
<?php require_once __DIR__ . "/../head.php"; ?>
<?php require_once __DIR__ . "/../../part/toastUiSetup.php"; ?>

<section class="secion-article-write">
  <div class="container mx-auto">
    <div class="con-pad">
      <div>
        <a href="list">글 리스트</a>
        <a href="detail?id=<?=$id?>">원문</a>
      </div>
      <hr>
      <script>
      let ArticleDoModify__submitFormDone = false;
      function ArticleDoModify__submitForm(form) {
        if ( ArticleDoModify__submitFormDone ) {
          return;
        }

        form.title.value = form.title.value.trim();

        if ( form.title.value.length == 0 ) {
          alert('제목을 입력해주세요.');
          form.title.focus();

          return;
        }

        const bodyEditor = $(form).find('.input-body').data('data-toast-editor');
        const body = bodyEditor.getMarkdown().trim();
        if (body.length == 0) {
          bodyEditor.focus();
          alert('내용을 입력해주세요.');
          return;
        }

        form.body.value = body;

        form.submit();
        ArticleDoModify__submitFormDone = true;
      }
      </script>
      <form action="doModify" method="POST" onsubmit="ArticleDoModify__submitForm(this); return false;">
      <input type="hidden" name="id" value="<?=$article['id']?>"> 
      <input type="hidden" name="body"> 
      <div>
          <span>번호</span>
          <span><?=$article['id']?></span>
        </div>
        <div>
          <span>제목</span>
          <input required placeholder="제목을 입력해주세요." type="text" name="title" value="<?=$article['title']?>"> 
        </div>
        <div>
          <span>내용</span>
          
          <script type="text/x-template"><?=ToastUiEditor__getSafeSource($article['body'])?></script>
          <div class="toast-ui-editor input-body"></div>
        </div>
        <div>
          <input type="submit" value="글수정">
        </div>
      </form>
    </div>
  </div>
</section>

<?php require_once __DIR__ . "/../foot.php"; ?>