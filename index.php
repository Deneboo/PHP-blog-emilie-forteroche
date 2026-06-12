<?php

require __DIR__ . '/vendor/autoload.php';
require_once  __DIR__ .'/config/_config.php';
require_once  __DIR__ .'/config/autoload.php';
require_once  __DIR__ .'/src/utils/Utils.php';
require_once  __DIR__ .'/src/controllers/ArticleController.php';

use App\Controllers\ArticleController;
use App\Controllers\AdminController;
use App\Controllers\CommentController;
use App\Views\View;
use App\Utils\Utils;

$action = Utils::request('action', 'home');

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $articleController = new ArticleController();
            $articleController->showHome();
            break;

        case 'apropos':
            $articleController = new ArticleController();
            $articleController->showApropos();
            break;
        
        case 'showArticle': 
            $articleController = new ArticleController();
            $articleController->showArticle();
            break;

        case 'addArticle':
            $articleController = new ArticleController();
            $articleController->addArticle();
            break;

        case 'addComment':
            $commentController = new CommentController();
            $commentController->addComment();
            break;


        // Section admin & connexion. 
        case 'admin': 
            $adminController = new AdminController();
            $adminController->showAdmin();
            break;

        case 'connectionForm':
            $adminController = new AdminController();
            $adminController->displayConnectionForm();
            break;

        case 'connectUser': 
            $adminController = new AdminController();
            $adminController->connectUser();
            break;

        case 'disconnectUser':
            $adminController = new AdminController();
            $adminController->disconnectUser();
            break;

        case 'showUpdateArticleForm':
            $adminController = new AdminController();
            $adminController->showUpdateArticleForm();
            break;

        case 'updateArticle': 
            $adminController = new AdminController();
            $adminController->updateArticle();
            break;

        case 'deleteArticle':
            $adminController = new AdminController();
            $adminController->deleteArticle();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
