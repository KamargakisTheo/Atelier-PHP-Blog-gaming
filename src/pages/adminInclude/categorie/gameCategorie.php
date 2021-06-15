<?php
    //verifier si admin
    if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){

    

        //mon formulaire ajout catego jeux a-t-il été envoyeé
        if(isset($_POST["gameCat"]) && !empty($_POST["gameCat"])){
            $gameCat = htmlspecialchars($_POST["gameCat"]);
            addGameCategorie($gameCat);

        }

        //delet game cat
        if(isset($_GET["deleteGameCat"]) && $_GET["deleteGameCat"] == true){
            $GameCatId = htmlspecialchars($_GET["value"]);
            $intDeletGameCat = intval($GameCatId);
            deleteGameCategorie($intDeleteGameCat);
        }
    }

    //je récupère les type d'article disp dans ma db
    $listeGameCat = getGameCategorie();
?>

<table class="mlr-a mt-3 p-1" id="gamecat">
    <thead>
        <tr>
            <th colspan="2">Liste des types des jeux</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nom de la catégorie</td>
            <td>Supprimer</td>
        </tr>
        <!-- FOREACH POUR AFFICHER LES TYPES D'ARTICLE DISPONIBLE -->
        <?php
            foreach($listeGameCat as $value){
        ?>
            <tr>
                <td><?= $value["genre"]?></td>
                <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeCategorie&deletGameCat=true&value=<?= $value["gameCategorieId"]?>"><i class="far fa-plus-square"></i></a></td>
            </tr>
        <?php
            }
        ?>
            <tr>
                <td>Ajouter un genre</td>
                <td class="ta-c tc-g"><a href="../../src/pages/admin.php?choix=listeCategorie&createGameCat=true/#gamecat"><i class="far fa-plus-square"></i></a></td>
            </tr>

        <?php
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
                if(isset($_GET["createGameCat"]) && $_GET["createGameCat"] == true){
        ?>
            <form action="" method="post">
                <tr>
                    <td>Nom de la catégorie de jeux à ajouter</td>
                    <td class="ta-c tc-g"><input type="text" name="gameCat" placeholder="Entrez le nom de de la catégorie de jeux" required></td>
                    <td><input type="submit" value="Ajouter genre"></td>
                </tr>
            </form>
            
        <?php
             }
            }
        ?>
    </tbody>
</table>