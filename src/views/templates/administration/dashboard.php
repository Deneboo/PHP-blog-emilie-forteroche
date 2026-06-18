<?php 
    /** 
     * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
     * Et un formulaire pour ajouter un article. 
     */

    /** @var App\Models\Article[] $articles */
    use App\Utils\Utils;

    $articles = Utils::sortItems($articles);    
?>

<h2>Tableau de bord</h2>
<div>
    <table>
        <tr>
            <th>
                Titre 
                <a href="?action=dashboard&tri=title&sens=asc">↑</a>
                <a href="?action=dashboard&tri=title&sens=desc">↓</a>
            </th>
            <th>
                Date de publication 
                <a href="?action=dashboard&tri=date_creation&sens=asc">↑</a>
                <a href="?action=dashboard&tri=date_creation&sens=desc">↓</a>
            </th>
            <th>
                Commentaires
                <a href="?action=dashboard&tri=comment&sens=asc">↑</a>
                <a href="?action=dashboard&tri=comment&sens=desc">↓</a>
            </th>
            <th>
                Vues
                <a href="?action=dashboard&tri=article_visit&sens=asc">↑</a>
                <a href="?action=dashboard&tri=article_visit&sens=desc">↓</a>
            </th>
        </tr>
        <?php foreach ($articles as $article) { ?>
            <tr class="">    
                <td class="title"><a href="index.php?action=showArticle&id=<?= $article->getId()?>"><?= $article->getTitle() ?></a></td>
                <td class="title"><?= $article->getDateCreation()->format('d/m/Y') ?></td>
                <td>
                    <?= $article->getCommentNumber() > 0
                        ? '<a href="index.php?action=showArticle&id=' . $article->getId() . '#comment">' . $article->getCommentNumber() . '</a>'
                        : $article->getCommentNumber()
                    ?>
                </td>
                <td class=""><?= $article->getArticleVisitNumber() ?></td>
            </tr>
        <?php } ?>
    </table>
</div>