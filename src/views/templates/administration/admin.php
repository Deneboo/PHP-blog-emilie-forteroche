<?php 
    /** 
     * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
     * Et un formulaire pour ajouter un article. 
     */

    /** @var App\Models\Article[] $articles */
    use App\Utils\Utils;
    
?>

<h2>Edition des articles</h2>

<div class="adminArticle">
    <?php foreach ($articles as $article) { ?>
        <div class="articleLine">
            <div class="title"><a href="index.php?action=showArticle&id=<?= $article->getId()?>"><?= $article->getTitle() ?></a></div>
            <div class="content"><?= $article->getContent(200) ?></div>
            <div><a class="submit" href="index.php?action=showUpdateArticleForm&id=<?= $article->getId() ?>">Modifier</a></div>
            <div>
                <form
                    method="post" 
                    action="index.php?action=deleteArticle" 
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');"
                    class="form--delete"
                >
                    <input type="hidden" name="id" value="<?= $article->getId() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<a class="submit" href="index.php?action=showUpdateArticleForm">Ajouter un article</a>