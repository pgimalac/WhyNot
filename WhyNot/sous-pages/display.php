<?php // ce fichier contient les fonctions d'affichage des articles, utilisateurs et messages
      // (en tant que résultats de la recherche) mais aussi des catégories et articles en entier

function displayArticle($article){ // pour affiche un article en entier (son contenu avec)
  if ($article){ // si l'article existe
    augmenter_lecture($article['id']); // on incrémente son nombre de lectures

    $mDate=strtotime($article["date_de_publication"]);
    $jour=array("1"=>"lundi", "2"=>"mardi","3"=>"mercredi","4"=>"jeudi","5"=>"vendredi","6"=>"samedi","7"=>"dimanche");
    $mois=array("janvier","février","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","décembre");
    $date="{$jour[date('N',$mDate)]} ".date('j',$mDate)." {$mois[date('n',$mDate)-1]} à ".date('H:i:s',$mDate);
    $nbNotes=getNbNotes($article['id']); // on récupère le nombre de notes de l'article
    $note=$article["note"]; // on récupère la note de l'article
    $notePerso=$notePerso=(($_SESSION['connecte'])?getNoteFromUser($_SESSION['id'],$article['id']):"");
    // on récupère la note donnée par le visiteur (s'il est connecté) à l'article
    $commentaires=getCommentsFromArticleID($article['id']); // on récupère les commentaires


    echo "<div class=\"article_head\">".
            (($article["miniature"]!="null")?
              "<div class=\"article_img\"><img src=\"ARTICLES/{$article["id"]}.{$article["miniature"]}\" /></div>"
              :"").
           "<div class=\"article_head_content\">
              <h1>".htmlentities($article["titre"])."</h1>
              <div class=\"article_auteur\">&Eacute;crit par
                <a href=\"index.php?DO=user&id={$article["auteur"]}\">".htmlentities(getUser($article["auteur"])["pseudo"])."</a>
                et publi&eacute; le $date
              </div>".
              (($nbNotes!=0)?"<div>Not&eacute; par $nbNotes personne".(($nbNotes!=1)?"s":"")." : $note/20</div>":"").
            "</div>
          </div>
          <div class=\"article_content\">
            {$article["contenu"]}
          </div>".(($_SESSION['connecte'])?"
          <fieldset class=\"article_note\"><legend>Note</legend><form method=\"post\" action=\"index.php?DO=article&id={$article['id']}\">".
              (($notePerso!=-1)?"Vous avez mis $notePerso/20 à cet article, changer de note : ":
              "Mettre une note &agrave; cet article : ")."
                <input type=\"number\" min=0 max=20 name=\"note\" value=\"10\"/> <input type=\"submit\" value=\"OK\"/>
              </form>
          </fieldset>":"")."
          <fieldset class=\"article_commentaires\">
            <legend>Commentaires</legend>".

            // le formulaire du modérateur pour supprimer des messages
            (($_SESSION['connecte'] && $_SESSION['master']=='vrai')?
              "<form action=\"index.php?DO=article&id={$article['id']}\" method=\"post\" class=\"articles_commentaires_form\">":"");

              // on affiche les messages de l'article
              while ($a=$commentaires->fetch()){
                $mDate=strtotime($a["date_de_publication"]);
                $date="{$jour[date('N',$mDate)]} ".date('j',$mDate)." {$mois[date('n',$mDate)-1]} à ".date('H:i:s',$mDate);
                echo "<div class=\"article_commentaires_affichage\"><div class=\"articles_commentaires_head\">
                              <div class=\"articles_commentaires_titre\"><a href=\"index.php?DO=user&id={$a["auteur"]}\">".htmlentities(getUser($a["auteur"])["pseudo"])."</a> le $date</div>".

                              // si on est un modérateur (master) on affiche le formulaire permettant de supprimer des messages
                              (($_SESSION["connecte"] && $_SESSION["master"]=='vrai')?
                                  "<input type=\"checkbox\" value=\"{$a["id"]}\" name=\"toSuppr[]\"/>":"").
                          "</div>
                           <div>".htmlentities($a["contenu"])."</div>
                      </div>";
              }
            if ($_SESSION['connecte'] && $_SESSION['master']=='vrai'){
              echo (($article['nb_commentaires']>0)?"<input type=\"submit\" value=\"suppr\"/>":"")."</form>";
            }
            if ($_SESSION['connecte']){ // si l'on est connecté, on peut écrire un commentaire
        echo "<div class=\"articles_commentaires_ecrire\"><form method=\"post\" action=\"index.php?DO=article&id={$article['id']}\">
                <textarea name=\"commentaire\" class=\"commentaire_ecrire\" placeholder=\"&Eacute;crire un commentaire...\"></textarea>". // pour écrire les commentaires
               "<input type=\"submit\" value=\"Envoyer\" />
              </form></div>";
            }

    echo "</fieldset>";

  }else{ echo "<h2>Cet article n'existe pas !</h2>"; } // sinon l'article n'existe pas
}

function displayCateg($articles,$i){ // pour afficher une catégorie
  // $i correspond au nombre d'articles à afficher (-1 pour tous les afficher)
  while ($i!=0 && $a=$articles->fetch()){ // pour chaque article
    $i--;
    $mDate=strtotime($a["date_de_publication"]);
    $jour=array("1"=>"lundi", "2"=>"mardi","3"=>"mercredi","4"=>"jeudi","5"=>"vendredi","6"=>"samedi","7"=>"dimanche");
    $mois=array("janvier","février","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","décembre");
    $date="{$jour[date('N',$mDate)]} ".date('j',$mDate)." {$mois[date('n',$mDate)-1]} à ".date('H:i:s',$mDate);
    $b=getNbNotes($a['id']); // on récupère le nombre de notes
    echo "<div class=\"categorie_article\">". // on affiche l'aperçu de l'article (des informations mais pas le contenu)
            (($a["miniature"]!="null")?"<div class=\"categorie_img\"><img src=\"ARTICLES/{$a["id"]}.{$a["miniature"]}\" /></div>":"").
            "<div class=\"categorie_content\" id=\"".(($a["miniature"]!="null")?"categorie_withimg":"categorie_withoutimg")."\">
                  <div class=\"categorie_titre\"><a href=\"index.php?DO=article&id={$a["id"]}\">".htmlentities($a["titre"])."</a></div>
                  <div class=\"categorie_auteur\">&Eacute;crit par <a href=\"index.php?DO=user&id={$a["auteur"]}\">".htmlentities(getUser($a["auteur"])["pseudo"])."</a>, lu {$a["nb_lectures"]} fois et comment&eacute; {$a["nb_commentaires"]} fois</div>".
                 "<div class=\"categorie_date\">Post&eacute; le ".htmlentities($date.(($a['note']==null)?"":" et noté à {$a["note"]}/20 par ".$b." personne".(($b>1)?"s":"")))."</div>
             </div>
          </div>";
  }
}

function displayMessage($messages){ // pour afficher des messages
  while ($a=$messages->fetch()){ // pour chaque message :
    $mDate=strtotime($a["date_de_publication"]);
    $jour=array("1"=>"lundi", "2"=>"mardi","3"=>"mercredi","4"=>"jeudi","5"=>"vendredi","6"=>"samedi","7"=>"dimanche");
    $mois=array("janvier","février","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","décembre");
    $date="{$jour[date('N',$mDate)]} ".date('j',$mDate)." {$mois[date('n',$mDate)-1]} à ".date('H:i:s',$mDate);
    echo "<div class=\"categorie_article\">".
           "<div class=\"categorie_content\" id=\"categorie_withoutimg\">
              <div class=\"categorie_titre\"><a href=\"index.php?DO=article&id={$a["article"]}\">".htmlentities(getArticle($a["article"])['titre'])."</a></div>
              <div class=\"categorie_auteur\">&Eacute;crit par <a href=\"index.php?DO=user&id={$a["auteur"]}\">".htmlentities(getUser($a["auteur"])["pseudo"])."</a> et post&eacute; le ".htmlentities($date)."</div>".
              "<div class=\"categorie_date\"><pre>".htmlentities($a["contenu"])."</pre></div>
            </div>
          </div>";
  }
}

function displayUsers($users){ // pour afficher des utilisateurs (il s'agit d'un aperçu pas de l'affichage de user.php)
  while ($a=$users->fetch()){ // pour chaque utilisateur :
    $mDate=strtotime($a["inscription"]);
    $jour=array("1"=>"lundi", "2"=>"mardi","3"=>"mercredi","4"=>"jeudi","5"=>"vendredi","6"=>"samedi","7"=>"dimanche");
    $mois=array("janvier","février","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","décembre");
    $date="{$jour[date('N',$mDate)]} ".date('j',$mDate)." {$mois[date('n',$mDate)-1]}";
    echo "<div class=\"categorie_article\">".
            (($a["image"]!="null")?"<div class=\"categorie_img\"><img src=\"USERS/{$a["id"]}.{$a["image"]}\" /></div>":"").
            "<div class=\"categorie_content\" id=\"".(($a["image"]!="null")?"categorie_withimg":"categorie_withoutimg")."\">
                  <div class=\"categorie_titre\"><a href=\"index.php?DO=user&id={$a["id"]}\">".htmlentities($a["pseudo"])."</a></div>
                  <div class=\"categorie_auteur\">Article".(($a['nb_articles']>1)?"s":"").
                  " post&eacute;".(($a['nb_articles']>1)?"s":"")." : ".$a["nb_articles"].", commentaire"
                  .(($a['nb_commentaires']>1)?"s":"")." post&eacute;".(($a['nb_commentaires']>1)?"s":"")." : ".$a["nb_commentaires"]."</div>".
                 "<div class=\"categorie_date\">Inscrit depuis le ".htmlentities($date)."</div>
             </div>
          </div>";
  }
}

?>
