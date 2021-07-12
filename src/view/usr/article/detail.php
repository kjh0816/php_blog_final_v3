<?php
$meta = [];
$updateDateBits = explode(" ", $article['updateDate']);
$meta['pageGenDate'] = $updateDateBits[0] . 'T' . $updateDateBits[1] . 'Z';
$meta['siteSubject'] = str_replace('"', '＂', $article['title']);
$meta['siteDescription'] = str_replace('"', '＂', mb_substr($article['body'], 0, 100));
$meta['siteDescription'] = str_replace("\n", "", $meta['siteDescription']);
$pageTitleIcon = '<i class="fas fa-newspaper"></i>';
$pageTitle = "게시물 상세내용, ${id}번 게시물";

$body = ToastUiEditor__getSafeSource($article['body']);

$utterancPageIdentifier = "/usr/article/detail?id={$article['id']}";
?>
<?php require_once __DIR__ . "/../head.php"; ?>
<?php require_once __DIR__ . "/../../part/toastUiSetup.php"; ?>


<section class="section-article-menu flex mt-2">
  <div class="container mx-auto flex">
    <a href="list" class="btn btn-link">리스트</a>
    <a href="modify?id=<?=$article['id']?>" class="btn btn-link">수정</a>
    <a class="btn btn-link" onclick="if ( confirm('정말 삭제 하시겠습니까?') == false ) return false;" href="doDelete?id=<?=$article['id']?>">삭제</a>
  </div>
  
</section>
<hr class="ml-4">
<section class="section-article-menu">
  <div class="container mx-auto ml-4">

  <div class="py-5">
            <?php
            $detailUri = "detail?id=${article['id']}";
            $body = ToastUiEditor__getSafeSource($article['body']);
            ?>
            <div>
              <div class="badge badge-primary badge-outline">번호</div>
              <?=$article['id']?>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">제목</div>
              <?=$article['title']?>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">카테고리</div>
              <?=$article['boardName']?>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">작성자</div>
              <?=$article['nickname']?>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">작성날짜</div>
              <?=$article['regDate']?>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">수정날짜</div>
              <?=$article['updateDate']?>
            </div>
            <div class="mt-2">
              <script type="text/x-template"><?=$body?></script>
              <div class="toast-ui-viewer"></div>
            </div>
          </div>
</section>


<section class="section-disqus">
  <div class="container mx-auto">
    <div class="con-pad">
      <style>
      .utterances {
        max-width: 100%;
      }
      </style>
      <script src="https://utteranc.es/client.js"
        repo="kjh0816/b_jihoo_kr_comment"
        issue-term="<?=$utterancPageIdentifier?>"
        theme="github-dark"
        crossorigin="anonymous"
        async>
      </script>
    </div>
  </div>
</section>
<?php require_once __DIR__ . "/../foot.php"; ?>