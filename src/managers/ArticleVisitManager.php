<?php

namespace App\Managers;

use App\Models\ArticleVisit;

/**
 * Classe pour la gestion des visites d’articles.
 * Cette classe permet d’ajouter une visite à un article, et de récupérer les visites d’un article.
 * Il permet également de vérifier si un utilisateur a déjà visité un article.
 * Il utilise la classe ArticleVisit pour représenter une visite et la classe Base de données pour interagir avec la base de données.
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
     * Récupère les visite pour un article spécifique.
     * @param string $articleId : id de l'article.
     * @return array : tableau d'objets ArticleVisit.
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

    /**
     * Récupère les visite pour un article, et un Ip spécifique.
     * @param string $articleId : id de l'article.
     * @param string $ip : Ip du visiteur.
     * @return array : tableau d'objets ArticleVisit.
     */
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

    /**
     * Vérifie si l'article a déjà été visité delon l'ip du visiteur.
     * @param string $articleId : id de l'article.
     * @param string $ip : Ip du visiteur.
     * @return bool : true si l'article a déjà été visité avec un ip spécifique sinon false.
     */
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