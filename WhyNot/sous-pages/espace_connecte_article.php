<?php // affichage d'un article en attente de validation
  $article=writeArticle1($_GET['id']); // on récupère l'article
  if ($article){
    // s'il existe, on l'affiche (l'affichage est différent de celui contenu dans display.php car l'article n'est pas encore publié ici)
    echo "<div class=\"article_head\">".
            (($article["miniature"]!="null")?
              "<div class=\"article_img\"><img src=\"ARTICLES/{$article["id"]}.{$article["miniature"]}\" /></div>"
              :"").
           "<div class=\"article_head_content\">
              <h1>".htmlentities($article["titre"])."</h1>
              <div class=\"article_auteur\">&Eacute;crit par
                <a href=\"index.php?DO=user&id={$article["auteur"]}\">".htmlentities(getUser($article["auteur"])["pseudo"])."</a>
              </div>
            </div>
          </div>
          <div class=\"article_content\">
            {$article["contenu"]}
          </div>";
    if ($_SESSION['master']=='vrai'){ // si l'on est master, on peut supprimer ou publier cet article
                                      // (traitement dans espace_connecte_accueil.php)
      echo "<form method=\"POST\" action=\"espace_connecte.php\" class=\"article_write\">
              <input type=\"hidden\" name=\"id\" value=\"{$article["id"]}\" />
              <input type=\"submit\" name=\"submit\" value=\"Publier\" />
              <input type=\"submit\" name=\"submit\" value=\"Supprimer\" />
            </form>";

    }
  }else{ echo "<h2>Cet article n'existe pas !</h2>"; } // s'il n'existe pas, on le dit
?>
