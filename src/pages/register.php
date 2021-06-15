<?php
    $titre = "Enregistrez-vous";
    require "../../src/common/template.php";
    require "../../src/fonctions/mesFonction.php";
    require "../../src/fonctions/dbFonction.php";
    require "../../src/fonctions/dbAccess.php";

    // si user est connect, je le renvoi vers page d'acceuil grave a ma fonction
    estConnecte();

    // definir la variable qui marquera si le mdp est correct ou pas
    if(isset($_SESSION["mdpNok"]) && $_SESSION["mdpNok"] == true){
        $mdpNok = $_SESSION["mdpNok"];
        $_SESSION["mdpNok"] = false;
    } else {
        $mdpNok = false;
    }

?>

<?php
    //verifier si les input sont présent (et donc que ma méthode POST a été déclenchée)
    if(isset($_POST["nom"]) && !empty($_POST["nom"]) && !empty($_POST["prénom"])  && !empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"]) ){

    //Si j'ai pas d'avatar, je vais en mettre un par defaut
    $photo = "../../src/img/site/defaut_avatar.png";

    //Sanétiser mes donée
    //Je construit un tableau avec les donées recues
    $option = array(
        "nom"       => FILTER_SANITIZE_STRING,
        "prénom"    => FILTER_SANITIZE_STRING,
        "login"     => FILTER_SANITIZE_STRING,
        "email"     => FILTER_VALIDATE_EMAIL,
        "mdp"       => FILTER_SANITIZE_STRING,
        "mdp2"      => FILTER_SANITIZE_STRING,
    );

    //Crée une variable resulte qui va receuillie les donée saines
    $result = filter_input_array(INPUT_POST, $option);

    $nom = $result["nom"];
    $prénom = $result["prénom"];
    $login = $result["login"];
    $email = $result["email"];
    $mdp = $result["mdp"];
    $mdp2 = $result["mdp2"];
    $role = 4;

    //verifier si les mdp sont identique
    if($mdp == $mdp2){
        // hash du mdp en md5
        $mpdHash =md5($mdp);
        // generée grain de sel
        $sel = grainDeSel(rand(5,20));
        // mdp a envoyer
        $mdpToSend = $mpdHash . $sel;
        $mdpNok = false;
        } else {
            //booleun de controle
            $mdpNok = true;
            //active un session pour indiquer que les mdp sont non ok
            $_SESSION["mdpNok"] = true;
            //je recharge ma page
            header("location: ../../src/pages/register.php");
            exit();

        }

        // verifier si le login ou mail n'est pas present dans ma dv
        $bdd = dbAccess();
        // check login
        $requete = $bdd->prepare("SELECT COUNT(*) AS x
                                    FROM users
                                    WHERE login = ?");
        $requete->execute(array($login));

        while($result = $requete->fetch()){
            if($result["x"] != 0){
                $_SESSION["msgLogin"] = true;
                header("location: ../../src/page/register.php");
                exit();
            }
        }
        //check mail 
        $requete = $bdd->prepare("SELECT COUNT(*) AS x
                                    FROM users
                                    WHERE email = ?");
        $requete->execute(array($email));

        while($result = $requete->fetch()){
            if($result["x"] != 0){
                $_SESSION["msgEmail"] = true;
                header("location: ../../src/page/register.php");
                exit();
            }
        }
        // verifier si user envoye photo et agit en consequence
        if(isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] == 0){
            $photo = sendImg($_FILES["fichier"], "avatar");
        }

        //mes donées sont correcte et saines, je peux crée mon user
        createUser($photo, $login, $nom, $prénom, $email, $mdpToSend, $role, $sel);

        // tout s'est bien passé, inv user a se connecter
?>
    <h2 class=registerOk>Votre compte est maitenant crée, vous pouvez vous <a href="../../src/pages/login.php">CONNECTER</a></h2>
<?php
    } else {
?>

<section class="register">
    <form action="" method="post" class="login" enctype="multipart/form-data">
    <?php
        if(isset($_SESSION["msgEmail"]) && $_SESSION["msgEmail"] = true){
            echo "<h2>Cet email possède déja un compte, veuillez vous connecter</h2>";
            $_SESSION["msgEmail"] = false;
        }

        if(isset($_SESSION["msgLogin"]) && $_SESSION["msgLogin"] = true){
            echo "<h2>Ce login possède déja un compte, veuillez vous connecter</h2>";
            $_SESSION["msgLogin"] = false;
        }
        if($mdpNok == true){
            echo "<h2>Les mots de passe ne sont pas identique</h2>";
        }
    ?>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Créez votre compte</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Prénom:</td>
                    <td><input type="text" name="prénom" required placeholder="Entrez votre prénom"></td>
                </tr>
                <tr>
                    <td>Nom:</td>
                    <td><input type="text" name="nom" required placeholder="Entrez votre nom"></td>
                </tr>
                <tr>
                    <td>login:</td>
                    <td><input type="text" name="login" required placeholder="Entrez votre login"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" required placeholder="Entrez votre email"></td>
                </tr>
                <tr>
                    <td>Mot de passe:</td>
                    <td><input type="password" name="mdp" required placeholder="Entrez votre mot de passe" <?php if($mdpNok == true){?> class="danger" placeholder="mot de passe pas indentique"<?php } ?>></td>
                </tr>
                <tr>
                    <td>Mot de passe:</td>
                    <td><input type="password" name="mdp2" required placeholder="Répétez votre mot de passe" <?php if($mdpNok == true){?> class="danger" placeholder="mot de passe pas indentique"<?php } ?>></td>
                </tr>
                <tr>
                    <td>Uploader votre avatar:</td>
                    <td><input type="file" name="fichier"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Créer votre compte"></td>
                </tr>
            </tbody>
        </table>
    </form>
</section>

<?php
    }
    require "../../src/common/footer.php";
?>