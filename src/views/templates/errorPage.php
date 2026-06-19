<?php
    /**
     * Template pour afficher une page d'erreur.
     */

    /** @var string $errorMessage */
?>

<div class="error">
    <h2>Erreur</h2>
    <p><?= $errorMessage ?></p>
    <a href="index.php?action=home">Retour à la page d'accueil</a>
</div>
