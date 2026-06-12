<?php
    /**
     * Affichage de Liste des articles. 
     */

    /** @var App\Models\Article[] $articles */
    use App\Utils\Utils;
    
?>

<div class="articleList">
    <?php foreach($articles as $article) { 
        ?>
        <article class="article">
            <h2><?= $article->getTitle() ?></h2>
            <span class="quotation">«</span>
            <p><?= $article->getContent(400) ?></p>
            
            <div class="footer">
                <p class="italic">
                <?= $article->getArticleVisitNumber() ?>
                <?= Utils::pluralize(
                    $article->getArticleVisitNumber(),
                    'visite'
                ) ?>
                </p>
                <span class="info"> <?= ucfirst(Utils::convertDateToFrenchFormat($article->getDateCreation())) ?></span>
                <a class="info" href="index.php?action=showArticle&id=<?= $article->getId() ?>">Lire +</a>
            </div>
        </article>
    <?php } ?>
</div>