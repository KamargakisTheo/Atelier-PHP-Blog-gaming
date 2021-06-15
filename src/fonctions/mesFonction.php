<?php

    //crate fonction grain de sel qui va générée un chaine random que l'on
    // rajoutera au hash du mdp pour compléxifier sa déscryption par un hacker
    function grainDeSel($x){
        //crate variable qui contiendra les caractère composre un hash md5
        $chars = "0123456789abcedf";
        $string = "";
        //je crée un boucle qui va choisire une série de c caractère
        //le x étant le paramètre de ma fonction qui sera lui aussi générée random
        for($i = 0; $i < $x; $i++){
            $string .= $chars[rand(0, strlen($chars) -1)];
        }
        return $string;
    }

    //fonction pour envoyer une image qui prendra en compte l'endoit ou sera envoyer l'ulpoad selon que se soit un avatar ou pour un article
    function sendImg($photo, $destination){
        //decider ou doit aller la photo
        if($destination == "avatar"){
            $dossier = "../../src/img/avatar/" . time();
        } else {
            $dossier = "../../src/img/article/" . time();
        }

        //cree un tablau avec extension autorisier
        $extensionArray = ["png", "jpg", "jpeg", "jfif", "PNG", "JPEG", "JFIF"];
        //recup info de ficheir envoyer
        $infofichier = pathinfo($photo["name"]);
        //recup l'extension du fichier envoyer
        $extensionImage = $infofichier["extension"];

        // extension autorisier ?
        if(in_array($extensionImage, $extensionArray)){
            //preprare chemin repertoire + nom de fichier
            $dossier .= basename($photo["name"]);
            //envoye mon fichier
            move_uploaded_file($photo["tmp_name"], $dossier);
        }
        return $dossier;
    }

    // fonction pour savoir si un user est connect ou non
    function estConnecte(){
        if(isset($_SESSION["connecté"]) && $_SESSION["connecté"] == true){
            header("location: ../../index.php");
        }
    }
?>