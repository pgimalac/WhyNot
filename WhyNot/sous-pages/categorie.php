<div class="categorie">
  <?php
    // affichage d'une catégorie

    $categorie=getCategorie($_GET['id']); // on récupère la catégorie
    if ($categorie){ // si elle existe, on l'affiche (l'affichage est dans display.php)
      $articles=getArticlesFromCateg($_GET['id']);
      echo "<h1>".htmlentities($categorie["nom"])."</h1>";

      // display.php
      include("sous-pages/display.php");
      displayCateg($articles,-1); // on affiche cette catégorie avec tous les articles qu'elle contient

    }else{ echo "<h2>Cette cat&eacute;gorie n'existe pas !</h2>"; } // sinon on dit que la catégorie n'existe pas

  ?>
</div>
