<?php

namespace App\Service;

use App\Container\Container;
use App\Repository\ArticleRepository;
use App\Vo\ResultData;

class ArticleService
{
    use Container;

    public function getTotalArticlesCount(): int
    {
        return $this->articleRepository()->getTotalArticlesCount();
    }

    public function getForPrintArticles(): array
    {
        return $this->articleRepository()->getForPrintArticles();
    }

    public function getForPrintArticleById(int $id): array|null
    {
        return $this->articleRepository()->getForPrintArticleById($id);
    }

    public function writeArticle(int $memberId, int $boardId, string $title, string $body): int
    {
        return $this->articleRepository()->writeArticle($memberId, $boardId, $title, $body);
    }

    public function modifyArticle(int $id, string $title, string $body)
    {
        $this->articleRepository()->modifyArticle($id, $title, $body);
    }

    public function deleteArticle(int $id)
    {
        $this->articleRepository()->deleteArticle($id);
    }

    public function getActorCanModify($actor, $article): ResultData
    {
        if ($actor['id'] === $article['memberId']) {
            return new ResultData("S-1", "소유자 입니다.");
        }

        return new ResultData("F-1", "작성자만 게시글을 수정할 수 있습니다.");
    }

    public function getActorCanDelete($actor, $article): ResultData
    {
        if ($actor['id'] === $article['memberId']) {
            return new ResultData("S-1", "소유자 입니다.");
        }

        return new ResultData("F-1", "작성자만 게시글을 삭제할 수 있습니다.");
    }



    
    public function getSearchKeywordAndBoardIdFilteredArticles(string $searchKeyword, int $boardId, bool $paging, int $articleStart, int $itemCountInAPage): array|null{
        return $this->articleRepository()->getSearchKeywordAndBoardIdFilteredArticles($searchKeyword, $boardId, $paging, $articleStart, $itemCountInAPage);
      }
    
      public function getArticleCount(string $searchKeyword, int $boardId): array {
        return $this->articleRepository()->getArticleCount($searchKeyword, $boardId);
      }

    

    // board 파트 (시작)

    public function getForPrintBoards(): array|null{
        return $this->articleRepository()->getForPrintBoards();
      }

    public function getBoardById(int $id): array|null {
        return $this->articleRepository()->getBoardById($id);
    }

    // board 파트 (끝)
}
