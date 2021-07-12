<?php

namespace App\Repository;

class ArticleRepository
{
    public function getTotalArticlesCount(): int
    {
        $sql = DB__secSql();
        $sql->add("SELECT COUNT(*) AS cnt");
        $sql->add("FROM article AS A");
        return DB__getRowIntValue($sql, 0);
    }

    public function getForPrintArticles(): array
    {
        $sql = DB__secSql();
        $sql->add("SELECT A.*");
        $sql->add(", IFNULL(M.nickname, '삭제된사용자') AS extra__writerName");
        $sql->add("FROM article AS A");
        $sql->add("LEFT JOIN `member` AS M");
        $sql->add("ON A.memberId = M.id");
        $sql->add("ORDER BY A.id DESC");
        return DB__getRows($sql);
    }

    public function getForPrintArticleById(int $id): array|null
    {
        $sql = DB__secSql();
        $sql->add("SELECT *");
        $sql->add("FROM article AS A");
        $sql->add("WHERE id = ?", $id);
        return DB__getRow($sql);
    }

    public function writeArticle(int $memberId, int $boardId, string $title, string $body): int
    {
      $sql = DB__secSql();
      $sql->add("INSERT INTO article");
      $sql->add("SET regDate = NOW()");
      $sql->add(", updateDate = NOW()");
      $sql->add(", memberId = ?", $memberId);
      $sql->add(", boardId = ?", $boardId);
      $sql->add(", liked = 0");
      $sql->add(", count = 0");
      $sql->add(", title = ?", $title);
      $sql->add(", `body` = ?", $body);
      $id = DB__insert($sql);
  
      return $id;
    }

    public function modifyArticle(int $id, string $title, string $body)
    {
        $sql = DB__secSql();
        $sql->add("UPDATE article");
        $sql->add("SET updateDate = NOW()");
        $sql->add(", title = ?", $title);
        $sql->add(", `body` = ?", $body);
        $sql->add("WHERE id = ?", $id);
        $id = DB__update($sql);
    }

    public function deleteArticle(int $id)
    {
        $sql = DB__secSql();
        $sql->add("DELETE FROM article");
        $sql->add("WHERE id = ?", $id);
        $id = DB__delete($sql);
    }

    

    

    

    

    public function getSearchKeywordAndBoardIdFilteredArticles(string $searchKeyword, int $boardId, bool $paging, int $articleStart, int $itemCountInAPage): array|null{
    
        $sql = DB__secSql();
        $sql->add("SELECT A.*");
        $sql->add(", B.name `name`");
        $sql->add(", M.nickname `nickname`");
        $sql->add(", (SELECT COUNT(*) FROM reply WHERE relId = A.id) AS `replyCount`");
        $sql->add("FROM board `B`");
        $sql->add("INNER JOIN article `A`");
        $sql->add("ON B.id = A.boardId");
        $sql->add("INNER JOIN `member` `M`");
        $sql->add("ON A.memberId = M.id");
        $sql->add("WHERE 1 = 1");
    
        if($boardId != 0){
          $sql->add("AND A.boardId = ?", $boardId);
        }
    
        if(!empty($searchKeyword)){
          
          $sql->add("AND A.title like ?", "%".$searchKeyword."%");
          $sql->add("OR A.body like ?", "%".$searchKeyword."%");
        }
      
    
        if($paging == true){
          $sql->add("ORDER BY A.id DESC");
          $sql->add("LIMIT ${articleStart}");
          $sql->add(", ${itemCountInAPage}");
        }
        
        
    
        return DB__getRows($sql);
        
        
      }
    
      public function getArticleCount(string $searchKeyword, int $boardId): array{
        $sql = DB__secSql();
        $sql->add("SELECT count(*) AS `articleCount`");
        $sql->add("FROM article");
        $sql->add("WHERE 1 = 1");
    
        if($boardId != 0){
          $sql->add("AND boardId = ?", $boardId);
        }
    
        if(!empty($searchKeyword)){
          $sql->add("AND title like ?", "%".$searchKeyword."%");
          $sql->add("OR `body` like ?", "%".$searchKeyword."%");
        }
    
        
        
        return DB__getRow($sql);
      }


      // board 파트 (시작)
      public function getForPrintBoards(): array {
        $sql = DB__secSql();
        $sql->add("SELECT *");
        $sql->add("FROM board AS B");
        $sql->add("ORDER BY B.id ASC");
        return DB__getRows($sql);
      }

      public function getBoardById(int $id): array|null {
        $sql = DB__secSql();
        $sql->add("SELECT *");
        $sql->add("FROM board");
        $sql->add("WHERE id = ?", $id);
        return DB__getRow($sql);
      }




      
      // board 파트 (끝)
}