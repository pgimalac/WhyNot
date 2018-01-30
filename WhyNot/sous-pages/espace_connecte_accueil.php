<?php

function valid_article($id){ // vérifie qu'un article existe
  if ($id=='new'){ return true; }
  if (is_entier($id)){
    return writeArticle($_SESSION['id'],$id);
  }else{ return false; }
}

function valid_categ($c){ // vérifie qu'une catégorie existe
  if (is_entier($c)){
    return getCategorie($c);
  }
  return false;
}

function check_image(){ // vérifie qu'une image est valide (taille,...)
  if (!isset($_FILES["image"]) || $_FILES["image"]["error"]==4){ return true; } //UPLOAD_ERR_NO_FILE : pas de fichier
  else if ($_FILES["image"]["error"]==3){ return false; } //UPLOAD_ERR_PARTIAL : erreur de téléchargement

  // vérification de l'extension et du type de fichier
  $a=array();
  $autor=array('png','jpg','jpeg','gif','svg');
  $ext=strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
    // on n'utilise pas $_FILES["image"]["type"] pour ne pas avoir 'image/jpg' mais directement 'jpg'
  if (!in_array($ext,$autor)){ return false; }
  if ($_FILES["image"]["error"]==1 || filesize($_FILES["image"]["tmp_name"])>500000){ // taille maximale : 500Ko
    return false; // UPLOAD_ERR_INI_SIZE : erreur de taille
  }
  return true;
}

$id_article=((isset($_POST['id']))?$_POST['id']:"");
// on regarde si l'on vient de créer/modifier un article
if (isset($_POST['submit']) && in_array($_POST['submit'],array("Enregistrer","Cr&eacute;er","Poster"))){

  if (valid_article($_POST['id']) && isset($_POST['titre'],$_POST['Categorie'],$_POST['id']) &&
      strlen($_POST['titre'])<256 && check_image() && valid_categ($_POST['Categorie'])){
    // l'article est valide

    $image=((!isset($_FILES["image"]) || $_FILES["image"]["error"]==4)?'null':strtolower(substr(strrchr($_FILES['image']['name'],'.'),1)));
    if ($_POST['id']=='new'){
      $id_article=creer_article($_SESSION['id'],$_POST['Categorie'],$_POST['titre'],$image,$_POST['editor']);
    }else{
      modifier_article($_POST['id'],$_POST['Categorie'],$_POST['titre'],$image,((isset($_POST['editor']))?$_POST['editor']:""));
    }

    if ($image!='null'){ // s'il y a une nouvelle image
      $a=glob("ARTICLES/{$_POST["id"]}.*");
      if ($a && count($a)!=0) unlink($a[0]); // on supprime l'ancienne image
      move_uploaded_file($_FILES["image"]['tmp_name'],"ARTICLES/$id_article.$image"); // on met la nouvelle
    }

  }else{ // il y a eu un problème
    echo "Une erreur est survenue";
  }
}

$poster=((isset($_POST['poster']))?$_POST['poster']:"");
if (isset($_POST['submit']) && $_POST['submit']=="Poster"){ $poster=(($_POST['id']=='new')?array($id_article):array($_POST['id'])); }
// On regarde si l'on veut poster des articles (les passer de 'en écriture' à 'en attente de publication')
if (isset($poster) && $poster!=""){
  $articles_post="";
  foreach ($poster as $value){ $articles_post.="$value "; }
  poster_articles($articles_post);
}

// On regarde si l'on veut valider des articles (les passer de 'en attente de publication' à 'posté')
if ($_SESSION['master']=='vrai' && (isset($_POST['valider']) || (isset($_POST['submit'],$_POST['id']) && $_POST['submit']=='Publier'))){
  $articles_valider="";
  if (isset($_POST['valider'])){
    foreach ($_POST["valider"] as $value) { $articles_valider.="$value "; }
  }else{ $articles_valider=$_POST['id']; }
  valider_articles($articles_valider);
}

// On regarde si l'on veut supprimer un article
if (isset($_POST['submit'],$_POST['id']) && $_POST['submit']=='Supprimer'){
  if (is_entier($_POST['id']) && ($_SESSION['master']=='vrai' || $_SESSION['id']==getAuteurArticle($_POST['id']))) supprimer_article($_POST['id']);
}



// Affichage de l'accueil

echo "<div class=\"espace_connecte_home\">
        <h1>Espace connect&eacute;</h1>";
$waiting=waiting_articles(); // on récupère la liste des articles en attente de validation
if ($waiting->rowCount()!=0){ // s'il y en a, on les affiche
  echo (($_SESSION['master']=='vrai' )?"<form class=\"articles_poster\" action=\"espace_connecte.php\" method=\"POST\">":"").
  "<fieldset class=\"categorieMain\"><legend>Articles en attente de validation</legend>"; // le master peut les publier
  while ($a=$waiting->fetch()){ // pour chaque article, on affiche un aperçu
    $mDate=strtotime($a["date_de_publication"]);
    $jour=array("1"=>"lundi", "2"=>"mardi","3"=>"mercredi","4"=>"jeudi","5"=>"vendredi","6"=>"samedi","7"=>"dimanche");
    $mois=array("janvier","février","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","décembre");
    $date="{$jour[date('N',$mDate)]} ".date('j',$mDate)." {$mois[date('n',$mDate)-1]} à ".date('H:i:s',$mDate);
    echo "<div class=\"categorie_article\">".
            (($a["miniature"]!="null")?"<div class=\"categorie_img\"><img src=\"ARTICLES/{$a["id"]}.{$a["miniature"]}\" /></div>":"").
            "<div class=\"categorie_content\" id=\"".(($a["miniature"]!="null")?"categorie_withimg":"categorie_withoutimg")."\">
                <div class=\"categorie_titre\"><a href=\"espace_connecte.php?DO=article&id={$a["id"]}\">".htmlentities($a["titre"])."</a>".
                (($_SESSION['master']=='vrai')?"<input type=\"checkbox\" name=\"valider[]\" value=\"{$a["id"]}\"/>":"")."</div>
                <div class=\"categorie_date\">&Eacute;crit par <a href=\"index.php?DO=user&id={$a["auteur"]}\">".
                htmlentities(getUser($a["auteur"])["pseudo"])."</a> et post&eacute; le ".htmlentities($date)."</div>
             </div>
          </div>";
  }
  echo (($_SESSION['master']=='vrai')?"<input type=\"submit\" value=\"Valider\" />":"")."</fieldset>".(($_SESSION['master']=='vrai')?"</form>":"");
  // le master peut les publier
}

$writing=writing_articles($_SESSION['id']); // on récupère la liste des articles que l'utilisateur est en train d'écrire
if ($writing->rowCount()!=0){ // s'il y en a, on les affiche
  echo "<form class=\"articles_poster\" method=\"POST\" action=\"espace_connecte.php\">
          <fieldset class=\"categorieMain\"><legend>Mes articles en cours d'&eacute;criture</legend>";
  while ($a=$writing->fetch()){ // pour chaque article, on affiche un aperçu
    echo "<div class=\"espace_connecte_list\"><a href=\"espace_connecte.php?DO=write&id={$a["id"]}\">".htmlentities($a["titre"])."</a>
            <input type=\"checkbox\" value=\"{$a["id"]}\" name=\"poster[]\" /></div>";
  }
  echo "<input type=\"submit\" value=\"Poster\"/></fieldset></form>";
  // l'utilisateur peut choisir de poster ses articles en cours d'écriture
}
echo "<p class=\"nouvel_article\"><a href=\"espace_connecte.php?DO=write&id=new\">&Eacute;crire un nouvel article</a></p>
    </div>"; // l'utilisateur peut aussi commencer à écrire un nouvel article
?>
