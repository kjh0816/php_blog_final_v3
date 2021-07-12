<?php
$pageTitleIcon = '<i class="fas fa-edit"></i>';
$pageTitle = "게시물 수정, ${id}번 게시물";
?>
<?php require_once __DIR__ . "/../head.php"; ?>
<?php require_once __DIR__ . "/../../part/toastUiSetup.php"; ?>

<section class="secion-article-write">
  <div class="container mx-auto">
    <div class="con-pad">
      <section class="section-article-menu flex mt-2">
        <div class="container mx-auto flex">
          <a href="list" class="btn btn-link">글 리스트</a>
          <a href="detail?id=<?=$id?>" class="btn btn-link">원문</a>
        </div>
      </section>
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
      <div class="container mx-auto">
      <input type="hidden" name="id" value="<?=$article['id']?>"> 
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
      <div class="mt-4">
          <span class="badge badge-primary badge-outline">번호</span>
          <span><?=$article['id']?></span>
        </div>
        <div class="form-control my-4 -ml-1">
        <label class="label">
          <span class="label-text badge badge-primary badge-outline">제목</span>
        </label> 
        <input type="text" placeholder="제목을 입력해주세요." name="title" class="input input-bordered" value="<?=$article['title']?>">
        </div>
        <div>
          <span class="badge badge-primary badge-outline">내용</span>
          
          <script type="text/x-template"><?=ToastUiEditor__getSafeSource($article['body'])?></script>
          <div class="toast-ui-editor input-body"></div>
        </div>
        <div>
        <input type="submit" value="수정 완료"class="btn btn-outline btn-secondary mt-2"></input>
        </div>
    </div>
      </form>
    </div>
  </div>
</section>

<?php require_once __DIR__ . "/../foot.php"; ?>