<?php 

namespace App\Controllers;

use App\Managers\ArticleManager;
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
    public function showArticle() : void
    {
        // Récupération de l'id de l'article demandé.
        echo "ID de l'article demandé : " . Utils::request("id", -1) . "<br>";
        $id = Utils::request("id", -1);
        $user = Utils::getConnectedUser() ?? null;

        $articleManager = new ArticleManager();
        $article = $articleManager->getArticleById($id);
        $articleVisitManager = new ArticleVisitManager();
        $hasVisited = $articleVisitManager->hasVisited(
            $article->getId(),
            $_SERVER['REMOTE_ADDR']
        );

        if (!$hasVisited) {
            $articleVisitManager->addArticleVisit(
                $article->getId(),
                $_SERVER['REMOTE_ADDR'],
                $user?->getId()
            );
        }
        
        if (!$article) {
            throw new \Exception("L'article demandé n'existe pas.");
        }

        $commentManager = new CommentManager();
        $comments = $commentManager->getAllCommentsByArticleId($id);

        $view = new View($article->getTitle());
        $view->render("detailArticle", ['article' => $article, 'comments' => $comments]);
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
}