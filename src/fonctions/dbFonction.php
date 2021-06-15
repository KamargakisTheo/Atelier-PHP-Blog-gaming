<?php
    // Engegist un nouvel user dans notre BD

    function createUser($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban){
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO users(avatar, login, nom, prenom, email, mdp, roleId, ban)
                                    VALUES(?,?,?,?,?,?,?,?)");
        $requete->execute(array($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban)) or die(print_r($requete->errorInfo(), true));
        $requete->closeCursor();
    }

    // Fonction pour se connecter au site
    function login($user, $password){
        // connection à la db
        $bdd = new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8", "root", "");
        // requete pour récupérer l'user correspondant au login entré
        $requete = $bdd->query('SELECT * 
                                FROM users u 
                                INNER JOIN role r ON r.roleId = u.roleId;') or die(print_r($requete->errorInfo(), TRUE));

        // Traitement de la requete
        while($result = $requete->fetch()){
            if($result["login"] == $user){
                // sel du mdp envoyé avec le sel contenu dans la colonne ban
                $sel = md5($password) . $result["ban"];
                
                //J'active ma session user avec les infos dont je pourrai avoir besoin
                // tant que mon utilisateur est connecté 
                if($result["mdp"] == $sel){
                    $_SESSION["connect"] = true;
                    $_SESSION["user"] = [
                        "id" => $result["userId"],
                        "nom" => $result["nom"],
                        "prenom" => $result["prenom"],
                        "photo" => $result["avatar"],
                        "login" => $result["login"],
                        "email" => $result["email"],
                        "role" => $result["nomRole"]
                    ];
                    // J'active la session connecté
                    $_SESSION["connecté"] = true;
                    // Je redirige vers la page account
                    header("location: ../../src/pages/account.php");
                    exit();
                }
                else{
                    
                    header("location: ../../src/pages/login.php?erreur=Mot de passe incorrect");
                    exit();
                }
            }
        }
        // Si mon script arrive ici, il est sorti de ma boucle sans trouver de user
        header("location: ../../src/pages/login.php?erreur=Identifiant inconnu, veuillez recommencer!");
        exit();
    }

    function updateImg($fichier){
        $bdd = dbAccess();

        $requete = $bdd->prepare("UPDATE users SET avatar = ? WHERE userId = ?");
        $requete->execute(array($fichier, $_SESSION["user"]["id"]));
        $requete->closeCursor();
    }

    function getHardCategorie(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT * FROM hardware") or die(print_r($requete->errorInfo(), TRUE));

        while($données = $requete->fetch()){
            $listHardCategorie[] = $données;
        }
        $requete->closeCursor();
        return $listHardCategorie;
    }

    //ajouter une console
    function addHardCategorie($console){
        $bdd = dbAccess();
        $requete =$bdd->prepare("INSERT INTO hardware(console) VALUES(?)");
        $requete->execute(array($console));
        $requete->closeCursor();
    }

    //delet uen console
    function deleteHardCategorie($delConsole){
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM hardware WHERE hardId = ?");
        $requete->execute(array($delConsole));
        $requete->closeCursor();
    }

    //categorie type article
    function getCategorie(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT * FROM categorie");

        while($données = $requete->fetch()){
            $listCategorie[] = $données;
        }
        $requete->closeCursor();
        return $listCategorie;

    }

    //Ajouter un type d'article
    function addTypeArticle($typeArticle){
        $bdd = dbAccess();
        $requete =$bdd->prepare("INSERT INTO categorie(nomCategorie) VALUES(?)");
        $requete->execute(array($typeArticle)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();

    }

    //delet type article
    function deletTypeCategorie($intDeletType){
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM categorie WHERE categorieId = ?");
        $requete->execute(array($intDeletType)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();
    }

    //cherche tout gamecategorie
    function getGameCategorie(){
        $bdd = dbAccess();
        $requete =$bdd->query("SELECT * FROM gameCategory") or die(print_r($requete->errorInfo(), TRUE));
        
        while($données = $requete->fetch()){
            $listGameCat[] = $données;
        }
        $requete->closeCursor();
        return $listGameCat;
    }

    //add gamecat 
    function addGameCategorie($gameCat){
            $bdd = dbAccess();
            $requete =$bdd->prepare("INSERT INTO gameCategorie(genre) VALUES(?)");
            $requete->execute(array($gameCat)) or die(print_r($requete->errorInfo(), TRUE));
            $requete->closeCursor();
    
    }

    //delet gamecategorie
    function deleteGameCategorie($intDeleteGameCat){
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM gameCategorie WHERE gameategorieId = ?");
        $requete->execute(array($intDeleteGameCat)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();
    }
?>