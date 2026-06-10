<?php

require_once __DIR__ . '/ArticleVisit.php';

// This is a repository. 
// TODO : Mettre ce code dans un dossier Repository pour respecter les bonnes pratiques.
// TODO : Ajouter le count pour récupérer le nombre de visites d'article pour un article donné.
// TODO : penser à ne pas ajouter une visite d'article si l'utilisateur a déjà visité l'article dans les dernières 24h.
/**
 * Class for managing article visits.
 * This class allows to add a visit to an article, and to retrieve the visits of an article.
 * It also allows to check if a user has already visited an article.
 * It uses the ArticleVisit class to represent a visit, and it uses the Database class to interact with the database.
 */
class ArticleVisitManager extends AbstractEntityManager {
    
    /**
     * Add an article visit
     * @param ArticleVisit $articleVisit : the visit to add.
     * @return void
     */
    public function addArticleVisit(string $articleId, string $ip, ?string $userId = null): void
    {   
        $date = new DateTime();
        $visit = new ArticleVisit(
            $articleId,
            $ip,
            $date,
            $userId ?? null
        );

        $createTableArticleVisitSQL = "CREATE TABLE IF NOT EXISTS article_visit (
            id INT AUTO_INCREMENT PRIMARY KEY,
            article_id VARCHAR(255) NOT NULL,
            ip VARCHAR(255) NOT NULL,
            user_id VARCHAR(255) DEFAULT NULL,
            visit_date DATETIME NOT NULL
        ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;";

        $this->db->query($createTableArticleVisitSQL);

        $sql = "INSERT INTO article_visit (article_id, ip, user_id, visit_date)
                VALUES (:article_id, :ip, :user_id, :visit_date)";

        $this->db->query($sql, [
            'article_id' => $visit->getArticleId(),
            'ip' => $visit->getIp(),
            'user_id' => $visit->getUserId(),
            'visit_date' => $visit->getVisitDate()->format('Y-m-d H:i:s')
        ]);
    }

    public function getArticleVisitsByArticleId(string $articleId) : array 
    {
        $sql = "SELECT * FROM article_visit WHERE article_id = :article_id";
        $result = $this->db->query($sql, ['article_id' => $articleId]);
        $articleVisits = [];

        while ($articleVisit = $result->fetch()) {
            $articleVisits[] = new ArticleVisit(
                $articleVisit['article_id'],
                $articleVisit['ip'],
                $articleVisit['user_id'] ?? null,
                $articleVisit['visit_date']
            );
        }
        return $articleVisits;
    }

    /**
     * Retrieve all article visits.
     * @return array : array of ArticleVisit objects.
     */
    public function getAllArticleVisits() : array 
    {
        $sql = "SELECT * FROM article_visit";
        $result = $this->db->query($sql);
        $articleVisits = [];

        while ($articleVisit = $result->fetch()) {
            $articleVisits[] = new ArticleVisit(
                $articleVisit['article_id'],
                $articleVisit['ip'],
                $articleVisit['user_id'] ?? null,
                $articleVisit['visit_date']
            );
        }
        return $articleVisits;
    }

    /**
     * Retrieve visits for a specific article with its id.
     * @param string $articleId : article's id.
     * @return array : array of ArticleVisit objects.
     */
    public function getArticleVisitByArticleId(string $articleId) : array 
    {
        $sql = "SELECT * FROM article_visit WHERE article_id = :article_id";
        $result = $this->db->query($sql, ['article_id' => $articleId]);
        $articleVisits = [];

        while ($articleVisit = $result->fetch()) {
            $articleVisits[] = new ArticleVisit(
                $articleVisit['article_id'],
                $articleVisit['ip'],
                new DateTime($articleVisit['visit_date']),
                $articleVisit['user_id'] ?? null,
            );
        }
        return $articleVisits;
    }

    /**
     * Retrieve visits for a specific article with its id and visitor's ip.
     * @param string $articleId : article's id.
     * @param string $ip : visitor's ip.
     * @return array : array of ArticleVisit objects.
     */
    public function getArticleVisitByArticleIdAndIp(string $articleId, string $ip) : array 
    {
        $sql = "SELECT * FROM article_visit WHERE article_id = :article_id AND ip = :ip";
        $result = $this->db->query($sql, ['article_id' => $articleId, 'ip' => $ip]);
        $articleVisits = [];

        while ($articleVisit = $result->fetch()) {
            $articleVisits[] = new ArticleVisit(
                $articleVisit['article_id'],
                $articleVisit['ip'],
                new DateTime($articleVisit['visit_date']),
                $articleVisit['user_id'] ?? null
            );
        }
        return $articleVisits;
    }

    public function hasVisited(int $articleId, string $ip): bool
    {
        return (bool) $this->getArticleVisitByArticleIdAndIp($articleId, $ip);
    }
}