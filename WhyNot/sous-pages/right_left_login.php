<div class="pub">
  <!-- page particulière au login :
       il s'agit de aside.php mais réparti à droite et à gauche de la page (voir right_login.php)
       car le login est moins haut que les autres pages (on affiche juste deux pubs de chaque coté)-->

  <h3><a href="index.php?DO=annexe#partenaires">Nos partenaires</a></h3>
  <dl>
  <?php $pubs=array("crous"=>array("Le Crous","http://www.crous-paris.fr/","Qui nous nourrit pour pas cher"),
                    "google"=>array("Google","https://www.google.fr/","Qui r&eacute;pond &agrave; nos questions")
                  );

        foreach ($pubs as $value=>$tab) {
          echo "<dt><a href=\"$tab[1]\">$tab[0]</a></dt>
                <dd><a href=\"$tab[1]\"><img src=\"PUBS/logo_$value.jpg\" alt=\"$value\"/></a>
                <p>$tab[2]</p></dd>
                ";
        }
  ?>
  </dl>
</div>
