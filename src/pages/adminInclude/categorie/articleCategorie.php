<?php
    //verifier si admin
    if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){

    

        //mon formulaire ajout type a-t-il été envoyeé
        if(isset($_POST["article"]) && !empty($_POST["article"])){
            $typeArticle = htmlspecialchars($_POST["article"]);
            addTypeArticle($typeArticle);

        }

        //delet type ARticle
        if(isset($_GET["deletType"]) && $_GET["deletType"] == true){
            $deletType = htmlspecialchars($_GET["value"]);
            $intDeletType = intval($deletType);
            deletTypeCategorie($intDeletType);
        }
    }

    //je récupère les type d'article disp dans ma db
    $listeTypeCategorie = getCategorie();
?>

<table class="mlr-a mt-3 p-1" id="typeArticle">
    <thead>
        <tr>
            <th colspan="2">Liste des types d'articles</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nom de la catégorie</td>
            <td>Supprimer</td>
        </tr>
        <!-- FOREACH POUR AFFICHER LES TYPES D'ARTICLE DISPONIBLE -->
        <?php
            foreach($listeTypeCategorie as $value){
        ?>
            <tr>
                <td><?= $value["nomCategorie"]?></td>
                <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeCategorie&deletType=true&value=<?= $value["categorieId"]?>"><i class="far fa-plus-square"></i></a></td>
            </tr>
        <?php
            }
        ?>
            <tr>
                <td>Ajouter un type</td>
                <td class="ta-c tc-g"><a href="../../src/pages/admin.php?choix=listeCategorie&createType=true/#typeArticle"><i class="far fa-plus-square"></i></a></td>
            </tr>

        <?php
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
                if(isset($_GET["createType"]) && $_GET["createType"] == true){
        ?>
            <form action="" method="post">
                <tr>
                    <td>Nom de l'article à ajouter</td>
                    <td class="ta-c tc-g"><input type="text" name="article" placeholder="Entrez le nom de l'article"></td>
                    <td><input type="submit" value="Ajouter article"></td>
                </tr>
            </form>
            
        <?php
             }
            }
        ?>
    </tbody>
</table>