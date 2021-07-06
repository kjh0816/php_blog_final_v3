<?php
$pageTitleIcon = '<i class="fas fa-list"></i>';
// $pageTitle = "모든 게시물 리스트";
?>
<?php require_once __DIR__ . "/../head.php"; ?>
<?php require_once __DIR__ . "/../../part/toastUiSetup.php"; ?>

<!-- 사용자가 게시판 선택 (시작) -->
<section class="section-article-menu mt-5 ml-10">
  <div class="container mx-auto">
  <form action="list" method="POST">
  <div>
<span>
검색어: 
<input placeholder="검색 내용을 적어주세요." type="search" name="searchKeyword" class="text-center badge badge-outline">
</span>
</div>
<div class="">
<span class="mr-4">카테고리: </span>
<select class="article-list-choose-board btn-outline btn-primary" name="boardId">
<option value="0" class="text-pink-500">카테고리 선택</option>
<?php foreach($boards as $board){?>
    <option value="<?=$board['id']?>"><?=$board['name']?></option>
<?php }?>
</select>
<input type="submit" value="검색" class="ml-4 btn btn-outline btn-primary">
</div>
</form>
  </div>
</section>



<br>



<!-- 사용자가 게시판 선택 (끝) -->

<?php if ( $isLogined ) { ?>

<section class="section-article-menu">
  <div class="container mx-auto">
    <a href="write" class="btn btn-link">글 작성</a>
  </div>
</section>
<hr>

<?php } ?>

<section class="section-articles mt-4">
  <div class="container mx-auto">
    <div class="con-pad">

      <div>
        <div class="badge badge-primary badge-outline">게시물 수</div>
        <?=$totalCount?>
      </div>

      <hr class="mt-4">

      <div>
        <?php foreach ( $articles as $article ) { ?>
          <div class="py-5">
            <?php
            $detailUri = "detail?id=${article['id']}";
            $body = ToastUiEditor__getSafeSource($article['body']);
            ?>
            <div>
              <div class="badge badge-primary badge-outline">번호</div>
              <a href="<?=$detailUri?>"><?=$article['id']?></a>
            </div>
            <div class="mt-2">
              <div class="badge badge-primary badge-outline">제목</div>
              <a href="<?=$detailUri?>"><?=$article['title']?></a>
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
          <hr>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<!-- 페이징 부분 (시작)-->
<nav  class="page-items-cover">
                    <ul  class="page-items flex">
                        <?php
                            if ($page <= 1){
                                // 빈 값
                            } else {
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=1&boardId=$boardId&searchKeyword=$searchKeyword' aria-label='Previous'><b style='color:blue;'>처음</b></a></li>";
                            }
                            
                            if ($page <= 1){
                                // 빈 값
                            } else {
                                $pre = $page - 1;
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=$pre&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'>◀이전</b></a></li>";
                            }
                            
                            for($i = $blockStart; $i <= $blockEnd; $i++){
                                if($page == $i){
                                    echo "<li class='page-item cell-left'><a disabled><b style='color: black; font-size:20px;'> $i </b></a></li>";
                                } else {
                                    echo "<li class='page-item cell-left'><a href='/usr/article/list?page=$i&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'> ($i) </b></a></li>";
                                }
                            }
                            
                            if($page >= $totalPage){
                                // 빈 값
                            } else {
                                $next = $page + 1;
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=$next&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'> 다음▶</b></a></li>";
                            }
                            
                            if($page >= $totalPage){
                                // 빈 값
                            } else {
                                echo "<li class='page-item cell-left'><a class='page-link' href='/usr/article/list?page=$totalPage&boardId=$boardId&searchKeyword=$searchKeyword'><b style='color:blue;'>마지막</b></a>";
                            }
                        ?>                                        
                    </ul>                                                                  
                </nav>               
            </div>                                            
        </div>                                                                    
    </div>

<!-- 페이징 부분 (끝)-->

<?php require_once __DIR__ . "/../foot.php"; ?>
