<aside>

  <?php // ce fichier est la partie droite de la plupart des pages (les publicités ainsi que les informations sur le site)

  $users=nb_users_connectes(); //cette fonction est dans requetes.php,
                              //elle renvoit le nombre de personnes en lignes (anonymes et connectées)

  $infos=array("Pages charg&eacute;es"=>$nb, //$nb est obtenu dans le header
               "Articles post&eacute;s"=>nb_articles_postes(), //cette fonction est dans requetes.php,
                                                              //elle renvoit le nombre d'articles en ligne
               "Commentaires post&eacute;s"=>nb_comments_postes(), //cette fonction est dans requetes.php,
                                                              //elle renvoit le nombre de messages postes
               "Membres connect&eacute;s"=>$users[1],
               "Anonymes connect&eacute;s"=>$users[0]);

  ?>

  <div class="infos"> <!-- on affiche les informations du site -->
    <h3>Statistiques</h3>
    <dl>
      <?php foreach ($infos as $key => $value){ // tout est contenu dans le tableau déclaré ci-dessus
              echo "
                <dt>$value</dt>
                <dd>$key</dd>
              ";
            }
      ?>
    </dl>
  </div>

  <div class="pub"> <!-- on affiches les publicités -->
    <h3><a href="index.php?DO=annexe#partenaires">Nos partenaires</a></h3>
    <dl>
    <?php $pubs=array("diderot"=>array("L'Universit&eacute; Paris Diderot","http://www.univ-paris-diderot.fr/sc/site.php?bc=accueil&np=accueil",
                                       "Qui nous fournit des cours"),
                      "oc"=>array("OpenClassroom","https://openclassrooms.com/","Qui compl&egrave;te nos cours"),
                      "crous"=>array("Le Crous","http://www.crous-paris.fr/","Qui nous nourrit pour pas cher"),
                      "google"=>array("Google","https://www.google.fr/","Qui r&eacute;pond &agrave; nos questions")
                    );

          foreach ($pubs as $value=>$tab) { // tout est dans le tableau déclaré ci-dessus
            echo "<dt><a href=\"{$tab[1]}\">{$tab[0]}</a></dt>
                  <dd><a href=\"{$tab[1]}\"><img src=\"PUBS/logo_$value.jpg\" alt=\"$value\"/></a>
                  <p>{$tab[2]}</p></dd>
                  ";
          }
    ?>
    </dl>
  </div>

</aside>
