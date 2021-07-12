<?php

namespace App\Controller;

use App\Container\Container;
use App\Controller\Controller;

class UsrArticleController extends Controller
{
    use Container;

    public function actionShowWrite()
    {

         // 사용자가 선택할 수 있는 board 리스트 호출(관리자가 아니면 1번(공지) 게시판에 글 쓸 수 없음.)
        
        $boards = $this->articleService()->getForPrintBoards();


        require_once $this->getViewPath("usr/article/write");
    }

    public function actionDoModify()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);
        $title = getStrValueOr($_REQUEST['title'], "");
        $body = getStrValueOr($_REQUEST['body'], "");

        if (!$id) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        if (!$title) {
            jsHistoryBackExit("제목을 입력해주세요.");
        }

        if (!$body) {
            jsHistoryBackExit("내용을 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        $actorCanModifyRs = $this->articleService()->getActorCanModify($_REQUEST['App__loginedMember'], $article);

        if ($actorCanModifyRs->isFail()) {
            jsHistoryBackExit($actorCanModifyRs->getMsg());
        }

        $this->articleService()->modifyArticle($id, $title, $body);

        jsLocationReplaceExit("detail?id=${id}", "${id}번 게시물이 수정되었습니다.");
    }

    public function actionDoDelete()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);

        if (!$id) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        $actorCanDeleteRs = $this->articleService()->getActorCanDelete($_REQUEST['App__loginedMember'], $article);

        if ($actorCanDeleteRs->isFail()) {
            jsHistoryBackExit($actorCanDeleteRs->getMsg());
        }

        $this->articleService()->deleteArticle($id);

        jsLocationReplaceExit("list", "${id}번 게시물이 삭제되었습니다.");
    }

    public function actionDoWrite()
    {
        $title = getStrValueOr($_REQUEST['title'], "");
        $body = getStrValueOr($_REQUEST['body'], "");
        $boardId = getIntValueOr($_REQUEST['boardId'], 0);

        if (!$title) {
            jsHistoryBackExit("제목을 입력해주세요.");
        }

        if (!$body) {
            jsHistoryBackExit("내용을 입력해주세요.");
        }

        $loginedMemberId = getIntValueOr($_REQUEST['App__loginedMemberId'], 0);
        
        
        
        
        $id = $this->articleService()->writeArticle($loginedMemberId, $boardId, $title, $body);

        jsLocationReplaceExit("detail?id=${id}", "${id}번 게시물이 생성되었습니다.");
    }

    public function actionShowList()
    {
         // 페이지 번호 받아오기 (시작)
       if(isset($_REQUEST["page"])){
        $page = $_REQUEST["page"]; // 하단에서 다른 페이지 클릭하면 해당 페이지 값 가져와서 보여줌
        } else {
        $page = 1; // 게시판 처음 들어가면 1페이지로 시작
        }
      // 페이지 번호 받아오기 (끝)
      // 아래 두 변수는 boardId값이 입력됐을 경우, 값이 바뀜.
    
    $pageTitle = "모든 게시물 리스트";

    // 사용자가 게시물 리스트 조회 시, 선택할 수 있는 게시판 리스트 호출
    
    $boards = $this->articleService()->getForPrintBoards();

//  게시판 선택 시 , 게시판 별 게시물을 불러오고, 미선택 시, 게시물 전체 리스트를 불러옴. (시작)


        //  boardId 필터링 (시작)
        
        if(isset($_REQUEST['boardId'])){
      
            if($_REQUEST['boardId'] != 0){
            
            $boardId = intval($_REQUEST['boardId']);
            
            $board = $this->articleService()->getBoardById($boardId);

                // boardId에 따른 SQL문 추가
                if($board != null){  // boardId에 해당하는 게시판이 존재할 경우
                    $loginPage = true;
                    $pageTitle = "${board['name']} 게시물 리스트";
                }else{
                    $loginPage = true;
                    $pageTitle = "존재하지 않는 카테고리";
                    
                    jsHistoryBackExit("${boardId}번 카테고리는 존재하지 않습니다.");
                    jsLocationReplaceExit("list", "${boardId}번 카테고리는 존재하지 않습니다.");
                }
            }else {
                $boardId = 0;
            }
            }else{
                $boardId = 0;
            }
            //  boardId 필터링 (끝)

            //  searchKeyword 필터링 (시작)        
            if(!empty($_REQUEST['searchKeyword'])){
                $searchKeyword = $_REQUEST['searchKeyword'];
            }else{
                $searchKeyword = "";
            }
            //  searchKeyword 필터링 (끝)
            

            
            // 최종적으로 출력될 게시물들을 카운팅하기 위한 쿼리

            $paging = false; 
            $articleStart = 0;
            $itemCountInAPage = 0;
            $articles = $this->articleService()->getSearchKeywordAndBoardIdFilteredArticles($searchKeyword, $boardId, $paging, $articleStart, $itemCountInAPage);
            
            
           
            
            
              $arrayCount = $this->articleService()->getArticleCount($searchKeyword, $boardId);  // 불러올 게시물 총 갯수 카운트
              $totalRecord = $arrayCount['articleCount'];
              
              
              $itemCountInAPage = 3; // 한 페이지에 보여줄 게시물 개수  >> itemCountInAPage
              $blockCount = 5; // 한 블록에 표시할 페이지 번호 갯수
              $blockNum = ceil($page / $blockCount); // 현재 페이지가 해당하는 블록 
              // 현재 페이지가 5씩 넘어갈 때마다 한 블록씩 넘어간다.
              $blockStart = (($blockNum - 1) * $blockCount) + 1; // 블록 내, 페이지 시작 번호
              // 현재 블록이 1이면, 블록 시작번호 = 1 , 2이면 , 시작번호 = 6
              $blockEnd = $blockStart + $blockCount - 1; // 블록의 마지막 번호
              // 1~5 / 6~10 ...

              $totalPage = ceil($totalRecord / $itemCountInAPage); // 게시물 갯수에 따른 총 페이지 수
              if($blockEnd > $totalPage){
                  $blockEnd = $totalPage; // 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
              }
              $totalBlock = ceil($totalPage / $blockCount); // 블록의 총 개수
              $articleStart = ($page - 1) * $itemCountInAPage; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)

              // 최종적으로 출력될 게시물들을 불러오는 쿼리
              $paging = true;
              $articles = $this->articleService()->getSearchKeywordAndBoardIdFilteredArticles($searchKeyword, $boardId, $paging, $articleStart, $itemCountInAPage);
              

//  게시판 선택 시 , 게시판 별 게시물을 불러오고, 미선택 시, 게시물 전체 리스트를 불러옴. (끝)
        
        $totalCount = $totalRecord;

        require_once $this->getViewPath("usr/article/list");
    }

    public function actionShowDetail()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);

        if ($id == 0) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        require_once $this->getViewPath("usr/article/detail");
    }

    public function actionShowModify()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);

        if ($id == 0) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        $actorCanModifyRs = $this->articleService()->getActorCanModify($_REQUEST['App__loginedMember'], $article);

        if ($actorCanModifyRs->isFail()) {
            jsHistoryBackExit($actorCanModifyRs->getMsg());
        }

        require_once $this->getViewPath("usr/article/modify");
    }

    
}