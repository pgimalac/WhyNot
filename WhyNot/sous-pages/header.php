<header> <!-- le header du site, présent sur toutes les pages -->

  <div class="titre"> <h1> <a href="index.php" class="link_titre">Why not ?</a> </h1> </div>
  <!-- on affiche le nom du site -->

  <div class="header_flex">
    <?php
    // Cette partie met à jour le nombre de pages chargées et récupère ce nombre pour l'afficher dans 'aside.php'
    // (on le fait dans le header car il est chargé dans toutes les pages)
      $count=fopen("sous-pages/count.txt","r+");
      $nb=fgets($count,10)+1;
      fseek($count,0);
      fputs($count,$nb);
      fclose($count);
    // On stocke aussi l'IP dans la BDD pour avoir le nombre de personnes connectées
      miseAJourIP();
      // Cette fonction est dans 'requete.php'
    // FIN

      if (!$_SESSION["connecte"]){ ?>
          <div class="header_redirect"> <a href="login.php?DO=connect"><p></p><p>Connexion</p></a> </div>
          <div class="header_redirect"> <a href="login.php?DO=oublie"><p>Identifiants</p><p>oubli&eacute;s ?</p></a> </div>
          <div class="header_redirect"> <a href="login.php?DO=creer"><p>Cr&eacute;er</p><p>un compte</p></a> </div>
        </div>
<?php }
      else{
        echo "<div class=\"header_redirect\">";
        if ($_SERVER['REQUEST_URI']=="/espace_connecte.php"){
          // si l'on est dans l'accueil de l'espace connecté, on propose d'aller à l'accueil du site
          echo "<a href=\"index.php\">Page d'accueil</a>";
        }else{
          // sinon on propose d'aller sur l'accueil de l'espace connecté
          echo "<a href=\"espace_connecte.php\">Espace connect&eacute;</a>";
        } ?>
          </div>
          <div class="header_redirect"> <a href="login.php?DO=compte" >Mon compte</a> </div>
          <div class="header_redirect"> <a href="login.php?DO=deconnect" >D&eacute;connexion</a> </div>
          <div class="header_empty_img"> </div>
        </div>
        <div class="header_image_div_user"> <!-- on affiche l'image de l'utilisateur-->
<?php echo "<a href=\"login.php?DO=compte\" ><img src=\"USERS/{$_SESSION["image"]}\" class=\"header_image_img_user\" alt=\"".htmlentities($_SESSION["pseudo"])."\" />
         </a></div>";
      }
?>

</header>
