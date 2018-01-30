<?php session_start(); if (! isset($_SESSION["connecte"])){ $_SESSION["connecte"]=false; } ?>
<!DOCTYPE html>
<html lang="fr">
      <head>
        <meta charset="utf-8">
        <title>Why not ?</title>
        <link rel="stylesheet" type="text/css" href="css.css" />
      </head>

      <!-- il s'agit de notre page 404, dans les faits on ne renvoit presque jamais les utilisateurs sur cette page,
           nous avons préféré afficher aux utilisateurs que ce qu'ils cherchent n'existe pas (un article, une catégorie, un utilisateur)
           plutôt que de les renvoyer sur cette page

           en théorie si l'url est une page qui n'existe pas on arrive sur cette page

           Nous n'avons par contre pas fait de page pour les autres erreurs possibles, celle-ci étant la plus courante...
      -->

      <body>
        <?php
        include("sous-pages/requetes.php");
        include("sous-pages/header.php")
        ?>

        <div class="wrapper">
          <nav> </nav>
          <article class="article_404"> <img width="100%" src="sous-pages/404.svg" alt="ERROR 404"/></article>
          <?php include("sous-pages/aside.php"); ?>
        </div>

        <?php include("sous-pages/footer.php"); ?>
      </body>

</html>
