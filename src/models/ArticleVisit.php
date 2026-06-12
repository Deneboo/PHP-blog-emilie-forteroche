<?php

namespace App\Models;

class ArticleVisit extends AbstractEntity
{
    private string $articleId;
    private string $ip;
    private ?string $userId;
    
    private \DateTime $visitDate;

    /**
     * Constructeur de la classe ArticleVisit.
     * @param string $articleId : l'id de l'article visité.
     * @param string $ip : l'adresse IP du visiteur.
     * @param string|null $userId : l'id de l'utilisateur connecté, null si le visiteur n'est pas connecté.
     * @param \DateTime $visitDate : la date de la visite.
     */
    public function __construct(string $articleId, string $ip, ?string $userId, \DateTime $visitDate) 
    {
        $this->articleId = $articleId;
        $this->ip = $ip;
        $this->userId = $userId ?? null;
        $this->visitDate = new \DateTime($visitDate->format('Y-m-d H:i:s'));
    }

    /**
     * Getter pour l'id de l'article visité.
     * @return string
     */
    public function getArticleId() 
    {
        return $this->articleId;
    }

    /**
     * Getter pour l'adresse IP du visiteur.
     * @return string
     */
    public function getIp() 
    {
        return $this->ip;
    }

    /**
     * Getter pour l'id de l'utilisateur connecté.
     * @return string|null
     */
    public function getUserId() 
    {
        return $this->userId ?? null;
    }

    /**
     * Getter pour la date de la visite.
     * @return \DateTime
     */
    public function getVisitDate() 
    {
        return $this->visitDate;
    }
}