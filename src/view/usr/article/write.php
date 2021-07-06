<?php
$pageTitleIcon = '<i class="fas fa-pen"></i>';
$pageTitle = "게시물 작성";
?>
<?php require_once __DIR__ . "/../head.php"; ?>
<?php require_once __DIR__ . "/../../part/toastUiSetup.php"; ?>

<section class="secion-article-write">
  <div class="container mx-auto">
    <div class="con-pad">
      <script>
      let ArticleDoWrite__submitFormDone = false;
      function ArticleDoWrite__submitForm(form) {
        if ( ArticleDoWrite__submitFormDone ) {
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
        ArticleDoWrite__submitFormDone = true;
      }
      </script>
      <form action="doWrite" method="POST" onsubmit="ArticleDoWrite__submitForm(this); return false;">
        <input type="hidden" name="body">
        <div>
          <span>제목</span>
          <input placeholder="제목을 입력해주세요." type="text" name="title"> 
        </div>
        <div>
          <span>내용</span>

          <script type="text/x-template"></script>
          <div class="toast-ui-editor input-body"></div>
        </div>
        <div>
          <input type="submit" value="글작성">
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . "/../foot.php"; ?>