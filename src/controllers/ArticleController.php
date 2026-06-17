<?php 

namespace App\Controllers;

use App\Managers\ArticleManager;
use App\Models\ArticleVisit;
use App\Managers\ArticleVisitManager;
use App\Managers\CommentManager;
use App\Views\View;
use App\Utils\Utils;

class ArticleController 
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome() : void
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->getAllArticles();

        $view = new View("Accueil");
        $view->render("home", ['articles' => $articles]);
    }

    /**
     * Affiche le détail d'un article.
     * @return void
     */
    public function showArticle(): void
{
    $id = Utils::request("id", -1);
    $user = Utils::getConnectedUser();

    $articleManager = new ArticleManager();
    $article = $articleManager->getArticleById($id);

    if (!$article) {
        throw new \Exception("L'article demandé n'existe pas.");
    }

    $visitManager = new ArticleVisitManager();

    $ip = $_SERVER['REMOTE_ADDR'];

    $hasVisited = $visitManager->hasVisited($article->getId(), $ip);

    if (!$hasVisited) {
        $visit = new ArticleVisit([
            'article_id' => $article->getId(),
            'ip' => $ip,
            'user_id' => $user?->getId(),
            'visit_date' => new \DateTime()
        ]);

        $visitManager->addArticleVisit($visit);
    }

    $commentManager = new CommentManager();
    $comments = $commentManager->getAllCommentsByArticleId($id);

    $view = new View($article->getTitle());
    $view->render("detailArticle", [
        'article' => $article,
        'comments' => $comments
    ]);
}

    /**
     * Affiche le formulaire d'ajout d'un article.
     * @return void
     */
    public function addArticle() : void
    {
        $view = new View("Ajouter un article");
        $view->render("addArticle");
    }

    /**
     * Affiche la page "à propos".
     * @return void
     */
    public function showApropos() {
        $view = new View("A propos");
        $view->render("apropos");
    }

    /**
     * Delete comment in article
     * @return void
     */
    public function deleteComment() : void
    {
        $id = Utils::request("id", -1);


        $commentManager = new CommentManager();
        $comment= $commentManager->getCommentById($id);
        $articleId = $comment->getIdArticle();
        $commentManager = new CommentManager();
        $commentManager->deleteComment($comment);

        Utils::redirect("showArticle", ['id' => $articleId]);
    }
}