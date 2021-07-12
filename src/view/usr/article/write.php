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
      <form action="doWrite" method="POST" class="mt-10" onsubmit="ArticleDoWrite__submitForm(this); return false;">
        <input type="hidden" name="body">
        <div>
        <span class="badge badge-primary badge-outline">카테고리 선택</span>
        <select required name="boardId" class="btn-outline btn-primary font-bold">
        <?php foreach($boards as $board){?>
        <?php if($memberId == 1){?>
        <option value="<?=$board['id']?>"><?=$board['name']?></option>
        <?php }else{ ?>
        <?php if($board['id'] != 1){?>
        <option value="<?=$board['id']?>"><?=$board['name']?></option>

        <?php }}?>
        <?php }?>
        </select>
        
        </div>
        <div class="form-control my-10">
        <label class="label">
          <span class="label-text badge badge-primary badge-outline">제목</span>
        </label> 
        <input type="text" placeholder="제목을 입력해주세요." name="title" class="input input-bordered">
        </div>  


        <div>
          <span class="badge badge-primary badge-outline">내용</span>

          <script type="text/x-template"></script>
          <div class="toast-ui-editor input-body"></div>
        </div>
        <div>
        <input type="submit" value="작성 완료"class="btn btn-outline btn-secondary mt-2"></input> 
          
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . "/../foot.php"; ?>