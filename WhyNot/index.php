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
        //        pages d'accueil, de recherche, d'affichage des articles, des utilisateurs,         //
        //                              des messages, des catégories,...                             //
        ///////////////////////////////////////////////////////////////////////////////////////////////

        function is_entier($i){
          // renvoie vrai si $i est un entier, on utilise pas is_int car elle ne fait pas tout à fait ce que l'on veut
          return ctype_digit(strval($i));
        }

        include("sous-pages/requetes.php");
        // ce fichier est inclu en premier car il contient toutes les requetes qui peuvent être executées,
        // il est donc utilisé un peu partout ensuite

        include("sous-pages/header.php"); ?>
        <div class="wrapper">
          <?php include("sous-pages/nav.php"); ?>
          <article class="article_general"> <?php include("sous-pages/".page()); ?></article>
          <?php include("sous-pages/aside.php"); ?>
        </div>
        <?php include("sous-pages/footer.php"); ?>
      </body>

      <?php

      function page(){ // renvoie la page à afficher en fonction de ce qui est fourni par $_GET
        if (isset($_GET["DO"])){ switch($_GET["DO"]){
            case "article": if (isset($_GET["id"]) && is_entier($_GET['id'])){ return "article.php"; }
            // affichage d'un article
              break;
            case "categorie": if (isset($_GET["id"]) && is_entier($_GET['id'])){ return "categorie.php"; }
            // affichage d'une catégorie
              break;
            case "user": if (isset($_GET["id"]) && is_entier($_GET['id'])){ return "user.php"; };
            // affichage d'un utilisateur
              break;
            case "search": return "recherche.php";
            // la fonction de recherche dans le site
              break;
            case "annexe": return "annexe.php";
            // contient des informations sur le site, son fonctionnement,...
              break;
            case "pendu": return "pendu/pendu.php";
            // ce pendu ne sert pas à grand chose, si l'on clique sur 'nous contacter' on arrive sur ce pendu
            // (c'est le pendu qui était à faire dans un des premiers tp)
            // si on le résoud (la difficulté a été augmentée pour que ce ne soit pas évident) on obtient notre adresse mail
            // (une fausse adresse mail en fait)
              break;
            default: ;
          }
        }
        return("accueil.php"); // l'accueil, c'est-à-dire la page par défaut qui affiche les derniers articles postés
      }
      ?>
</html>
