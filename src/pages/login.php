<?php
    $titre = "Connectez-vous";
    require "../../src/common/template.php";
    $mdpNoK = false;
    require "../../src/fonctions/mesFonction.php";
    require "../../src/fonctions/dbFonction.php";

    // Si mon user est co je le renvoir sur l'acceuil grace a la fonction
    estConnecte();

    //traitement du formulaire
    if(isset($_POST["login"]) && isset($_POST["mdp"])){
        $login = htmlspecialchars($_POST["login"]);
        $mdp = htmlspecialchars($_POST["mdp"]);

        //mes donée sont sécu, je peux appeler ma fonction pour connecter mon user
        login($login, $mdp);
    } else {
?>

<section class="register">
    <form action="" method="post" class="login">

    <?php
        if(isset($_GET["erreur"])){
    ?>
        <h2><?=$_GET["erreur"]?></h2>
    <?php
        }
    ?>

        <table>
            <thead>
                <tr>
                    <th colspan="2">Connectez-vous</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" require placeholder="Entrez votre login"></td>
                </tr>
                <tr>
                    <td>Mot de passe:</td>
                    <td><input type="password" name="mdp" require placeholder="Entrez votre mot de passe"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Connectez-vous"></td>
                </tr>
            </tbody>
        </table>
    </form>
</section>

<?php
    }
?>


<?php
    require "../../src/common/footer.php";
?>