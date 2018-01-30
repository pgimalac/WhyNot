<?php session_start(); if (! isset($_SESSION["connecte"])){ $_SESSION["connecte"]=false; } ?>
<!DOCTYPE html>
<html lang="fr">
      <head>
        <meta charset="utf-8">
        <title>Why not ?</title>
        <link rel="stylesheet" type="text/css" href="css.css" />
      </head>
      <body>
        <?php if (!$_SESSION['connecte']){ header("Location: index.php"); }

        /////////////////////////////////////////////////////////////////////////////////////////
        //            cette page est uniquement accessible aux personnes connectées            //
        // elle sert à écrire des articles et à lire les articles qui attendent d'être validés //
        /////////////////////////////////////////////////////////////////////////////////////////

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
            <article class="article_general">

<?php         if (isset($_GET['DO'],$_GET['id']) && $_GET['DO']=='write'){
                include("sous-pages/espace_connecte_write.php");
                // écriture d'un article
              }else if (isset($_GET['DO'],$_GET['id']) && $_GET['DO']=='article'){
                include("sous-pages/espace_connecte_article.php");
                // lecture d'un article en attente de validation
              }else{
                include("sous-pages/espace_connecte_accueil.php");
                // accueil de l'espace connecté, on y voit les articles en cours d'écriture et ceux en attente de validation
              } ?>

            </article>
          <?php include("sous-pages/aside.php"); ?>
        </div>
        <?php include("sous-pages/footer.php"); ?>
      </body>
</html>
