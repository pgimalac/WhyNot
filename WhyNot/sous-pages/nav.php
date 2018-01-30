<nav> <!-- le menu de navigation du site, qui permet d'acceder à la recherche
           ainsi qu'aux catégories et aux derniers articles rapidement -->

<?php function quickSearch(){ // le formulaire de recherche à gauche de la page,
                      //on l'affiche si l'on est pas sur la page de recherche avancée ?>
        <div class="quicksearch">
          <h3>Recherche rapide</h3>
          <form action="index.php?DO=search" method="post">
            <dt>Rechercher un article</dt>
            <dd>

              <input type="search" name="search" required/>

              <input type="hidden" value="1" name="what" />
              <input type="hidden" value="plus" name="pmc" />
              <input type="hidden" value="0" name="nbc" />
              <input type="hidden" value="after" name="ba" />
              <input type="hidden" value="0" name="date" />
              <input type="hidden" value="1" name="sort" />
              <input type="hidden" value="DESC" name="order" />
              <input type="hidden" value="0" name="categ[]" />

              <p></p>
              <a href="index.php?DO=search">Param&egrave;tres</a>
              <p></p>
              <input type="submit" value="Rechercher"/>
            </dd>
          </form>
        </div>
<?php }

      function messagerie(){ // affiche un lien pour aller sur la messagerie
        echo "<div class=\"nav_messagerie\"><a href=\"login.php?DO=messagerie\">Messagerie</a></div>";
      }

      if (!isset($_GET['DO']) || $_GET['DO']!='messagerie'){ messagerie(); } // si l'on est pas déjà dans la messagerie
      if (!isset($_GET["DO"]) || $_GET["DO"]!="search" ){ // si l'on est pas sur la page de recherche
        quickSearch();
      } ?>

    <div class="navigation"> <!-- on affiche les catégories et les derniers articles publiés -->

      <h3>Navigation</h3>
      <dl>
        <dt>Catégories</dt>
        <div class="nav_categorie_dd">
          <?php // on affiche les catégories, dans l'ordre du nombre d'articles
          $categories=getCategories();
          $a=$categories->fetch();
          $premier=$a["id"];
          while ($a){ // la dernière catégorie doit avoir les bords inférieurs de son cadre courbés (esthétique), on obtient ça comme ceci :
            $b=$categories->fetch();
            echo "<dd".((!$b)?" class=\"dernier\"":(($a["id"]==$premier)?" class=\"premier\"":""))."><a href=index.php?DO=categorie&id={$a["id"]}>".htmlentities($a['nom'])." ({$a["nb_articles"]})</a></dd>";
            $a=$b;
          } ?>
        </div>
      </dl>

      <dl class="nav_derniers_articles"> <!-- on affiche les derniers articles publiés -->
        <dt>Derniers articles</dt>
<?php   $articles=getArticles();
        $a=$articles->fetch();
        while ($a){ // de même le dernier article doit avoir les bords inférieurs de son cadre courbés
          $b=$articles->fetch();
          echo "<dd".((!$b)?" class=\"dernier\"":"")."><a href=index.php?DO=article&id={$a["id"]}>".htmlentities($a['titre'])."</a></dd>";
          $a=$b;
        } ?>
      </dl>

    </div>



</nav>
