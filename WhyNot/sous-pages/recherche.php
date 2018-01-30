<!-- la recherche dans le site -->
<form method="POST" action="index.php?DO=search" class="search_form">
  <div class="search">
    <div class="search_colonne">
  		<fieldset class="search_recherche">
  			<legend>Rechercher dans ce site </legend>
        <div>
  				<div>Recherche:</div>
          <select name="what" id="what" onchange="aff()" <?php echo ((isset($_POST["search"]))?"":"autofocus"); ?>>
            <!-- le type de recherche -->
            <option value="1" <?php echo ((!isset($_POST["what"]) || !in_array($_POST["what"],array(2,3,4)))?"selected":""); ?> >articles (titre)</option>
            <option value="2" <?php echo ((isset($_POST["what"]) && $_POST["what"]==2)?"selected":""); ?> >articles (contenu)</option>
            <option value="3" <?php echo ((isset($_POST["what"]) && $_POST["what"]==3)?"selected":""); ?> >utilisateurs</option>
            <option value="4" <?php echo ((isset($_POST["what"]) && $_POST["what"]==4)?"selected":""); ?> >commentaires</option>
          </select>
  				<input type="text" name="search" required <?php echo ((isset($_POST["search"]))?"value=\"".htmlentities($_POST["search"])."\"":""); ?>/>
          <!-- la recherche elle même -->
  				<div id='exact'>
            <label for="checkbox_exact">Recherche exacte :
              <input type="checkbox" id="checkbox_exact" value="exact" name="exact" <?php echo ((isset($_POST["exact"]) && $_POST["exact"]=='exact')?"checked":""); ?> />
            </label>
            <!-- si l'on veut faire une recherche booleenne ou exacte -->
          </div>
        </div>

		  </fieldset>

  		<fieldset class="search_condition" id="search_condition">
  			<legend>Recherche d<span id="span1">'article</span>s avec</legend>
  			<div id="pma">
  				<select name="pma">
            <option value="plus"  <?php echo ((!isset($_POST["pma"]) || $_POST["pma"]!="moins")?"selected":""); ?> >Au moins</option>
  					<option value="moins" <?php echo (( isset($_POST["pma"]) && $_POST["pma"]=="moins")?"selected":""); ?> >Au plus</option>
  				</select>
  				<input name="nba" size="5" value="0" type="number"> articles
          <!-- nombre d'article -->
  			</div>
        <div>
  				<select name="pmc">
  					<option value="plus"  <?php echo ((!isset($_POST["pmc"]) || $_POST["pmc"]!="moins")?"selected":""); ?> >Au moins</option>
  					<option value="moins" <?php echo (( isset($_POST["pmc"]) && $_POST["pmc"]=="moins")?"selected":""); ?> >Au plus</option>
  				</select>
  				<input name="nbc" size="5" value= <?php echo ((isset($_POST["nbc"]))?"\"".htmlentities($_POST["nbc"])."\"":"\"0\""); ?> type="number"> commentaires
          <!-- nombre de commentaire -->
  			</div>
  		</fieldset>

      <fieldset class="search_date">
        <legend>Chercher les <span id="span2">article</span>s</legend>

        <div>
          <select name="ba">
            <option <?php echo ((!isset($_POST["ba"]) || $_POST['ba']!="before")?'selected':'')?> value="after">Plus r&eacute;cents que</option>
            <option <?php echo (( isset($_POST["ba"]) && $_POST['ba']=="before")?'selected':'')?> value="before">Plus anciens que</option>
          </select>
          <select name="date">
            <?php
            $date=array("1"=>"Hier", "7"=>"Derni&egrave;re semaine",
                        "14"=>"Derni&egrave;res 2 semaines", "30"=>"Dernier mois", "90"=>"Derniers 3 mois",
                        "180"=>"Derniers 6 mois", "365"=>"Derni&egrave;re ann&eacute;e");

            echo "<option ".((!(isset($_POST['date'],$date[$_POST['date']]) ||
                  (isset($_POST['date']) && $_SESSION['connecte'] && $_POST['date']==-1)))?'selected':"")." value=\"0\">Tous</option>";

            if ($_SESSION['connecte']){ echo "<option ".((isset($_POST['date']) && $_POST['date']==-1)?'selected':"").
                                             " value=\"-1\">Derni&egrave;re visite</option>"; }

            foreach ($date as $key=>$value){
              echo "<option ".((isset($_POST['date']) && $_POST['date']==$key)?'selected':"")." value=\"$key\">$value</option>";
            }

            ?>
          </select>
          <!-- condition temporelle -->
        </div>
      </fieldset>

      <fieldset class="classer">
        <legend>Classer par</legend>
        <div>
          <select name="sort" class="sortby">
            <option <?php echo ((isset($_POST["sort"]) && !in_array($_POST['sort'],array(2,3,4,5,6,7)))?'selected':''); ?> id="sort1" value="1">Date</option>
            <option <?php echo ((isset($_POST["sort"]) && $_POST['sort']==2)?'selected':''); ?> id="sort2" value="2">Titre</option>
            <option <?php echo ((isset($_POST["sort"]) && $_POST['sort']==3)?'selected':''); ?> id="sort3" value="3">Nombre de commentaires</option>
            <option <?php echo ((isset($_POST["sort"]) && $_POST['sort']==4)?'selected':''); ?> id="sort4" value="4">Nombre de lectures</option>
            <option <?php echo ((isset($_POST["sort"]) && $_POST['sort']==5)?'selected':''); ?> id="sort5" value="5">Nom de l'auteur</option>
            <option <?php echo ((isset($_POST["sort"]) && $_POST['sort']==6)?'selected':''); ?> id="sort6" value="6">Categorie</option>
            <option <?php echo ((isset($_POST["sort"]) && $_POST['sort']==7)?'selected':''); ?> id="sort7" value="7">Note de l'article</option>
          </select>
          <select name="order">
            <option <?php echo ((isset($_POST["order"]) && $_POST['order']!='ASC')?'selected':''); ?> value="DESC">Decroissant</option>
            <option <?php echo ((isset($_POST["order"]) && $_POST['order']=='ASC')?'selected':''); ?> value="ASC">Croissant</option>
          </select>
          <!-- tri des résultats -->
        </div>
      </fieldset>
    </div>

    <div class="search_colonne" id="column2">
      <fieldset class="search_auteur">
        <legend>Chercher par </legend>
        <div>Auteur :</div>
        <div>
          <input name="eu" <?php echo ((isset($_POST["eu"]))?"value=\"".htmlentities($_POST["eu"])."\"":""); ?> type="text" class="exactname">
        </div>
        <!-- auteur (de l'article ou du commentaire) -->
      </fieldset>

    	<fieldset class="search_categorie">
    		<legend>Cat&eacute;gories de recherche </legend>
        <select multiple name="categ[]" id="categ">
          <option <?php echo ((!isset($_POST["categ"]) || in_array(0,$_POST["categ"]))?"selected":""); ?> value="0">- Toutes les categories -</option>
          <?php
            $categories=getCategories();
            $nbCateg=0;
            while ($a=$categories->fetch()){
              $nbCateg=$a['id'];
              echo "<option ".((isset($_POST["categ"]) && in_array($a['id'],$_POST["categ"]))?"selected":"")." value=\"{$a["id"]}\">".htmlentities($a["nom"])."</option>";
            }
          ?>
        </select>
        <!-- catégorie de l'article -->
		  </fieldset>
    </div>

  </div>

  <div class="search_end" id="search_end">
      <input type="submit" value="Rechercher">
      <input type="reset"  value="Vider">
  </div>
  <!-- validation ou suppression de la recherche -->
</form>

<script>
  var aff=function(){ //cette fonction n'affiche que ce qui est nécéssaire dans le formulaire
                      // de recherche (en fonction de ce que l'on recherche)
    var what=document.getElementById('what');
    var exact=document.getElementById('exact');
    var span1=document.getElementById('span1');
    var span2=document.getElementById('span2');
    var pma=document.getElementById('pma');
    var search_condition=document.getElementById('search_condition');
    var column2=document.getElementById('column2');
    var search_end=document.getElementById('search_end');
    var categ=document.getElementById('categ');
    var sort1=document.getElementById('sort1');
    var sort2=document.getElementById('sort2');
    var sort3=document.getElementById('sort3');
    var sort4=document.getElementById('sort4');
    var sort5=document.getElementById('sort5');
    var sort6=document.getElementById('sort6');
    var sort7=document.getElementById('sort7');


    // il s'agit des seules choses qui changent entre les deux types de recherche sur des articles
   if (what.value==1){
      exact.style.display='block';
      categ.style.height='197px';
      search_end.style.bottom='100px';
   }else if (what.value==2){
     exact.style.display='none';
     categ.style.height='172px';
     search_end.style.bottom='100px';
   }

    if(what.value==1 || what.value==2){ // si l'on cherche un article
        span1.firstChild.data='\'article';
        span2.firstChild.data='article';
        pma.style.display='none';
        search_condition.style.display='block';
        column2.style.display='block';
        sort1.firstChild.data="Date";
        sort2.style.display='block';
        sort3.style.display='block';
        sort4.firstChild.data="Nombre de lectures"; sort4.style.display='block';
        sort5.firstChild.data="Nom de l'auteur";
        sort6.style.display='block';
        sort7.style.display='block';
    }else if(what.value==3){ // si l'on cherche un utilisateur
        span2.firstChild.data='utilisateur';
        exact.style.display='none';
        span1.firstChild.data='\'utilisateur';
        pma.style.display='block';
        search_condition.style.display='block';
        column2.style.display='none';
        search_end.style.bottom='0px';
        sort1.firstChild.data="Date d'inscription";
        sort2.style.display='none';
        sort3.style.display='block';
        sort4.firstChild.data="Nombre d'articles"; sort4.style.display='block';
        sort5.firstChild.data='Pseudonyme';
        sort6.style.display='none';
        sort7.style.display='none';
    }else if(what.value==4){
        exact.style.display='none'; // si l'on cherche un commentaire
        span2.firstChild.data='commentaires';
        pma.style.display='none';
        search_condition.style.display='none';
        column2.style.display='block';
        search_end.style.bottom='100px';
        categ.style.height='103px';
        sort1.firstChild.data="Date";
        sort2.style.display='none';
        sort3.style.display='none';
        sort4.style.display="none";
        sort5.firstChild.data="Nom de l'auteur";
        sort6.style.display='none';
        sort7.style.display='none';
    }
  };

  aff(); // on affiche uniquement ce qui est nécéssaire en fonction de ce que l'on cherche

</script>

<?php
$validSearch=false; // on va vérifier si la recherche qui a été effectuée est valide

if (isset($_POST['search'],$_POST['what']) && in_array($_POST['what'],array(1,2,3,4))){

  $pmc=isset($_POST['pmc']) && ($_POST['pmc']=='plus' || $_POST['pmc']=='moins');
  $nbc=isset($_POST['nbc']) && is_entier($_POST['nbc']) && $_POST['nbc']>=0;

  $pma=isset($_POST['pma']) && ($_POST['pma']=='plus' || $_POST['pma']=='moins');
  $nba=isset($_POST['nba']) && is_entier($_POST['nba']) && $_POST['nba']>=0;

  $ba=isset($_POST['ba']) && ($_POST['ba']=='before' || $_POST['ba']=='after');
  $date=isset($_POST['date']) && (in_array($_POST['date'],array(0,1,7,14,30,90,180,365)) || ($_SESSION['connecte'] && $_POST['date']==-1));

  $sort=isset($_POST['sort']) && is_entier($_POST['sort']) && $_POST['sort']<8 && $_POST['sort']>0;
  $order=isset($_POST['order']) && ($_POST['order']=='DESC' || $_POST['order']=='ASC');

  $categ=isset($_POST['categ']) && count($_POST['categ'])>0; if ($categ){
    foreach ($_POST['categ'] as $value) {
      if (!(is_entier($value) && $value>=0 && $value<=$nbCateg)){ $categ=false; }
    }
  }
  // on vérifie si chaque champ est valide
  switch ($_POST['what']){
    case '1': case '2':
      $validSearch=$pmc && $nbc && $ba && $date && $sort && $order && $categ;
    break;
    case '3':
      $validSearch=$pmc && $nbc && $pma && $nba && $ba && $date && $sort && $order;
    break;
    case '4':
      $validSearch=$ba && $date && $sort && $order && $categ;
    break;
  default: // et on regarde selon ce que l'on cherche si la recherche est valide
  }
}

// on peut maintenant afficher les résultats
echo "<div class=\"resultats\">";
if (isset($_POST['search']) && !$validSearch){ echo "<h1>Recherche invalide</h1>"; } // problème dans la recherche
else if ($validSearch && isset($_POST['search']) && strlen($_POST['search'])<2){ // ce qui a été recherché est trop court
  echo "<h1>Recherche insuffisante (inférieure à 2 caractères)</h1>";
}
else if ($validSearch){ // on peut afficher les résultats
  $requete=";"; //la future requete finale complète

  // on sépare la requete finale en différentes variables
  $mode=((isset($_POST['exact']))?'NATURAL LANGUAGE':'BOOLEAN');
  $commentaires="nb_commentaires ".(($_POST['pmc']=='plus')?'>':'<')."={$_POST["nbc"]}";
  $articles="AND nb_articles ".(isset($_POST['pma']) && ($_POST['pma']=='plus')?'>':'<').((isset($_POST['nba']))?"={$_POST["nba"]}":"");

  $date="";
  // on définit l'intervalle de temps sur lequel on veut récuperer les résultats
  $daate=(($_SESSION['connecte'])?getLastConnection($_SESSION['id']):'NEVER'); //la date de comparaison
  $diff; // le temps en jours depuis la date $daate (ou juste le temps demandé si on a pas demandé 'depuis la derniere connexion')
  // au moins l'une des deux conditions suivantes est réalisée si on a une condition sur le temps
  if ($daate!='NEVER'){ $diff=date_diff(new DateTime($daate),new Datetime(date("Y-m-d H:i:s")))->format('%a'); }
  if ($_POST['date']>0){ $diff=$_POST['date']; }
  // on obtient ainsi la partie de la requete correspondant à la date
  if ($_POST['date']!=0 && !($_POST['date']==-1 && $daate=='NEVER')){ // si l'on a bien une condition sur la date
    $date="AND TIMESTAMPDIFF(DAY,date_de_publication,CURRENT_TIMESTAMP())".(($_POST['ba'])?">=":"<=").$diff;
  }

  $order="ORDER BY ";
  switch ($_POST['sort']){
    case 1:
      $order.=(($_POST['what']==3)?"inscription":"date_de_publication");
    break;
    case 2:
      $order.="titre";
    break;
    case 3:
      $order.="nb_commentaires";
    break;
    case 4:
      $order.=(($_POST['what']==3)?"nb_articles":"nb_lectures");
    break;
    case 5:
      $order.=(($_POST['what']==3)?"pseudo":"auteur");
    break;
    case 6:
      $order.="categorie";
    break;
    case 7:
      $order.="note";
    break;
    default: echo "<h1>Erreur</h1>";
  }
  $order.=" {$_POST["order"]}";

  $idAuteurs=((isset($_POST['eu']) && $_POST['eu']!="")?getIdAuteurs($_POST["eu"]):"");
  $auteur=(($idAuteurs!="")?"AND auteur IN ($idAuteurs)":"");

  $categ="";
  if (!in_array(0,$_POST['categ'])){
    $categ="AND categorie IN ";
    foreach ($_POST['categ'] as $value) {
      $categ.="$value ";
    }
  }


  // enfin on obtient la requête finale :

  switch ($_POST['what']){
    case '1' :
      $requete="SELECT * FROM ( SELECT *, ( SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note,
              ( SELECT COUNT(*) FROM commentaires WHERE articles.id = commentaires.article ) AS nb_commentaires
                FROM articles WHERE etat=2 AND MATCH (titre) AGAINST (:search IN $mode MODE)) AS b
                WHERE $commentaires $auteur $date $categ $order;";
    break;
    case '2' :
      $requete="SELECT * FROM ( SELECT *, ( SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note,
              ( SELECT COUNT(*) FROM commentaires WHERE articles.id = commentaires.article ) AS nb_commentaires
                FROM articles WHERE etat=2 AND MATCH (contenu) AGAINST (:search IN BOOLEAN MODE)) AS b
                WHERE $commentaires $auteur $date $categ $order;";
    break;
    case '3' :
      $requete="SELECT * FROM (SELECT *,(SELECT COUNT(*) FROM commentaires WHERE auteur=utilisateurs.id) AS nb_commentaires,
               (SELECT COUNT(*) FROM articles WHERE auteur=utilisateurs.id AND etat=2) AS nb_articles
                FROM utilisateurs) AS b WHERE pseudo LIKE :search AND $commentaires $articles $date $order;";
    break;
    case '4' :
      $requete="SELECT * FROM commentaires WHERE MATCH(contenu) AGAINST (:search IN BOOLEAN MODE) $auteur $date $categ $order ;";
    break;
    default : echo "<h1>Erreur</h1>";
  }
  $reponses=request($requete,array("search"=>$_POST['search']));
    // voir 'requete.php'
    // $reponses vaut false s'il n'y a pas de résultats
    // la requête est executée dans un try catch au cas où il y ait un problème
    // (pouvant principalement provenir de ce qui a été recherché)

  if ($reponses){ // il y a des résultats, on les affiche
    echo "<h1>Résultats (".$reponses->rowCount().") :</h1>";
    include("sous-pages/display.php");
    if ($_POST['what']==1 || $_POST['what']==2){
      displayCateg($reponses,-1);
    }else if($_POST['what']==3){
      displayUsers($reponses);
    }else{
      displayMessage($reponses);
    }
  }
  else{ echo "<h1>Pas de r&eacute;sultats !</h1>"; } // pas de résultats...

}
echo "</div>";
?>
