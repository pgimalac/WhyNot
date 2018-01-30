<footer> <!-- de même que le header, le footer est chargé sur toutes les pages -->

  <?php $footer=array(
          "&Agrave; propos"=>array("qui_sommes_nous"=>array("Qui sommes-nous ?"),
                                   "partenaires"=>array("Nos partenaires"),
                                   "code_source"=>array("Code source"),
                                   "transparence"=>array("Transparence")),
          "Aide"=>array("regles_du_site" => array("R&egrave;gle du site"),
                        "faq"=>array("Foire aux questions"),
                        "wiki"=>array("Wiki"),
                        "contactez_nous"=>array("Contactez-nous")
                       )
          );

    foreach ($footer as $footerKey => $footerTab){
      foreach ($footerTab as $key => $tab){ $footer[$footerKey][$key][1]="index.php?DO=annexe#".$key; }
    }
    $footer["Aide"]["wiki"][1]="https://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Accueil_principal";
    $footer["&Agrave; propos"]["transparence"][1]="404.php"; // nous n'avons aucune transparence !
    $footer2=array("&Agrave; propos"=>"a_propos","Aide"=>"aide");

  // on fait un tableau qui contient toutes les informations à afficher
  // ce qui permet de tout afficher avec une boucle
  foreach ($footer as $footerKey => $footerTab){
      echo "<div class=\"$footer2[$footerKey]\"> <h3>$footerKey</h3>
              <ul>";
      foreach ($footerTab as $tab){
        echo "<li> <a href=\"$tab[1]\">$tab[0]</a> </li>";
      }
      echo "</ul> </div>";
    }
  ?>

</footer>
