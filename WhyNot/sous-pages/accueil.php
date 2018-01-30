<div class="categorie"> <!-- l'accueil du site (dans index.php) -->
  <h1>Accueil</h1>
<?php
  include("sous-pages/display.php"); // contient des fonctions d'affichage
  $categories=getCategories(); // on récupère les catégories ordonnées selon le nombre d'articles
  while ($a=$categories->fetch()){ // pour chaque catégorie
    if ($a['nb_articles']==0){ continue; } // si elle n'est pas vide
    echo "<fieldset class=\"categorieMain\"><legend>".htmlentities($a["nom"])."</legend>";
    $articles=getArticlesFromCateg($a['id']);
    displayCateg($articles,3); // on affiche les 3 derniers articles qui lui appartiennent
    echo "</fieldset>";
  }
?>
</div>
