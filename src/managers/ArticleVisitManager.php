<?php

namespace App\Managers;

use App\Models\ArticleVisit;

/**
 * Class for managing article visits.
 * This class allows to add a visit to an article, and to retrieve the visits of an article.
 * It also allows to check if a user has already visited an article.
 * It uses the ArticleVisit class to represent a visit, and it uses the Database class to interact with the database.
 */

class ArticleVisitManager extends AbstractEntityManager
{
    public function addArticleVisit(ArticleVisit $visit): void
    {
        $sql = "INSERT INTO article_visit 
                (article_id, ip, user_id, visit_date)
                VALUES 
                (:article_id, :ip, :user_id, :visit_date)";

        $this->db->query($sql, [
            'article_id' => $visit->getArticleId(),
            'ip' => $visit->getIp(),
            'user_id' => $visit->getUserId(),
            'visit_date' => $visit->getVisitDate()->format('Y-m-d H:i:s')
        ]);
    }

        /**
     * Retrieve visits for a specific article with its id.
     * @param string $articleId : article's id.
     * @return array : array of ArticleVisit objects.
     */
    public function getArticleVisitsByArticleId(string $articleId): array
    {
        $sql = "SELECT * FROM article_visit WHERE article_id = :article_id";
        $result = $this->db->query($sql, ['article_id' => $articleId]);

        $visits = [];

        while ($row = $result->fetch()) {
            $visits[] = new ArticleVisit($row);
        }

        return $visits;
    }

    public function getByArticleIdAndIp(string $articleId, string $ip): array
    {
        $sql = "SELECT * FROM article_visit 
                WHERE article_id = :article_id AND ip = :ip";

        $result = $this->db->query($sql, [
            'article_id' => $articleId,
            'ip' => $ip
        ]);

        $visits = [];

        while ($row = $result->fetch()) {
            $visits[] = new ArticleVisit($row);
        }

        return $visits;
    }

    public function hasVisited(string $articleId, string $ip): bool
    {
        $sql = "SELECT 1 FROM article_visit 
                WHERE article_id = :article_id AND ip = :ip 
                LIMIT 1";

        $result = $this->db->query($sql, [
            'article_id' => $articleId,
            'ip' => $ip
        ]);

        return (bool) $result->fetch();
    }
}