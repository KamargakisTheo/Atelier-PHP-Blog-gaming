<?php
    $titre = "Espace d'administration";
    require "../../src/common/template.php";
    require "../../src/fonctions/mesFonction.php";
    require "../../src/fonctions/dbFonction.php";
    require "../../src/fonctions/dbAccess.php";

    // Refuser l'accès à la page aux personnes qui ne sont pas admin
if ($_SESSION['user']['role'] != 'admin') {
    header('location: ../../index.html');
    exit();
}

// Gérer une class de manière dynamique
$choixMenu = 'adminContenu';
?>

<section class="gestionAdmin mb-5 p-3">
    <div class="template p-2">
        <div class="menu mt-5">
            <a href="../../src/pages/admin.php?choix=listeCategorie">Gérer les catégories</a>
            <a href="../../src/pages/admin.php?choix=listeUser">Gérer les users</a>
            <a href="../../src/pages/admin.php?choix=listeCommentaire">Gérer les commentaires</a>
            <a href="../../src/pages/admin.php?choix=listeArticle">Gérer les articles</a>
        </div>

        <div class="<?=$choixMenu?>">
            <?php
                if(isset($_GET["choix"]) && $_GET["choix"] == "listeCategorie"){
                require "../../src/pages/adminInclude/categorie/listeCategorie.php";
            }

            
            ?>

        </div>
    </div>
</section>



<?php 
    require '../../src/common/footer.php';
?>