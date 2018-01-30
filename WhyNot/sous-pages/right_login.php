<div class="pub">
  <!-- page particulière au login :
       il s'agit de aside.php mais réparti à droite et à gauche de la page (voir right_left_login.php)
       car le login est moins haut que les autres pages (on affiche juste deux pubs de chaque coté)-->
  <h3><a href="annexe.php#partenaires">Nos partenaires</a></h3>
  <dl>
  <?php $pubs=array("diderot"=>array("L'Universit&eacute; Paris Diderot","http://www.univ-paris-diderot.fr/sc/site.php?bc=accueil&np=accueil",
                                     "Qui nous fournit des cours"),
                    "oc"=>array("OpenClassroom","https://openclassrooms.com/","Qui compl&egrave;te nos cours"),
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
