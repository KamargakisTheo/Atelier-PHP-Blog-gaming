<?php
//function pour connect correctement a ma db
    function dbAccess(){
        try{
            $bdd = new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8", "root", "");
            return $bdd;
        } catch(PDOException $e){
            echo $e->getMessage();
            echo $e->getLine();
        }
    }
?>