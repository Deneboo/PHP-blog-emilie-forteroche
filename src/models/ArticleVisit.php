<?php

namespace App\Models;

class ArticleVisit extends AbstractEntity
{
    private string $articleId;
    private string $ip;
    private ?string $userId = null;
    private \DateTime $visitDate;

    public function getArticleId(): string
    {
        return $this->articleId;
    }

    public function setArticleId(string $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): void
    {
        $this->userId = $userId;
    }

    public function getVisitDate(): \DateTime
    {
        return $this->visitDate;
    }

    public function setVisitDate($date): void
    {
        if (is_string($date)) {
            $this->visitDate = new \DateTime($date);
        } else {
            $this->visitDate = $date;
        }
    }
}