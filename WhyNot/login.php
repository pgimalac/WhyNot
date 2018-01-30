<?php session_start(); if (! isset($_SESSION["connecte"])){ $_SESSION["connecte"]=false; } ?>
<!DOCTYPE html>
<html lang="fr">
      <head>
        <meta charset="utf-8">
        <title>Why not ?</title>
        <link rel="stylesheet" type="text/css" href="css.css" />
      </head>

      <body>
        <?php

        ///////////////////////////////////////////////////////////////////////////////////////////////
        //       pages de connexion, déconnexion, création de compte, oubli des identifiants,        //
        //                    affichage des informations du compte, messagerie,...                   //
        ///////////////////////////////////////////////////////////////////////////////////////////////

        function is_entier($i){
          // renvoie vrai si $i est un entier, on utilise pas is_int car elle ne fait pas tout à fait ce que l'on veut
          return ctype_digit(strval($i));
        }

          include("sous-pages/requetes.php");
          // ce fichier est inclu en premier car il contient toutes les requetes qui peuvent être executées,
          // il est donc utilisé un peu partout ensuite

          include("sous-pages/login_function.php");
          // ce fichier contient des fonctions utilisées par différentes pages appelées ensuite

          // On regarde si on est en déconnexion
          if (isset($_GET["DO"],$_POST["boo"]) && $_GET["DO"]=="deconnect" && $_POST["boo"]=="Oui"){
            changeConnexion($_SESSION["id"]); // on change la date de dernière connexion
            $_SESSION=array(); // on supprime les données du compte
            $_SESSION["connecte"]=false;
          }

          // On regarde si on est en connexion
          $connect=false;
          $error=isset($_POST["pseudo"],$_POST["password"]);
          if (isset($_GET["DO"]) && $_GET["DO"]=="connect" && $error){
            $mdp=code($_POST["pseudo"],$_POST["password"]);
            if (validLogin($_POST["pseudo"],$mdp)){ // Cette fonction est dans 'requetes.php'
              $connect=true;
            }
          }

          include("sous-pages/header.php"); ?>

        <div class="wrapper">
          <aside class="aside_login_left"> <?php include("sous-pages/right_left_login.php") ?> </aside>

          <article class="article_login">
            <fieldset class="login" <?php echo (($_GET['DO'])?"id=\"mess\"":""); ?>>
              <?php if (isset($_GET["DO"]) && isValidPage($_GET["DO"])){ include("sous-pages/{$_GET["DO"]}.php"); }
                    else{ echo "<legend> Erreur </legend>"; } ?>
            </fieldset>
          </article>

          <aside> <?php include("sous-pages/right_login.php") ?> </aside>
        </div>

        <?php include("sous-pages/footer.php"); ?>

      </body>

</html>
