<?php // ce fichier contient toutes les requêtes et les fonctions qui leur sont associées

  // connexion à la base de données
  $host="localhost";
  $user="root";
  $pass=""; // à remplir
  $bdd = new PDO("mysql:host=$host;dbname=projet;charset=utf8", $user, $pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


  // requêtes préparées
  $connexion=$bdd->prepare('SELECT *, (SELECT COUNT(*) FROM commentaires WHERE auteur=utilisateurs.id) AS nb_commentaires,
                          (SELECT COUNT(*) FROM articles WHERE auteur=utilisateurs.id AND etat=2) AS nb_articles
                           FROM utilisateurs WHERE pseudo= :pseudo AND mdp= :mdp ;');
  $ajoutIP=$bdd->prepare('INSERT INTO personnes_connectees(adresse_ip,connecte, id) VALUES ( :ip , :connecte, :id);');
  $supprIP=$bdd->prepare('DELETE FROM personnes_connectees WHERE adresse_ip= ? ;');
  $cherchePseudo=$bdd->prepare('SELECT COUNT(*) FROM utilisateurs WHERE pseudo= ? ;');
  $creerUser=$bdd->prepare('INSERT INTO utilisateurs(pseudo,mdp,nom,prenom,mail,inscription,description,image,site,master)
                            VALUES (:pseudo,:mdp,:nom,:prenom,:mail,:inscription,:description,:image,:site,:master);');
  $getIdUser=$bdd->prepare('SELECT id FROM utilisateurs WHERE pseudo= ? ;');
  $getIdAuteurs=$bdd->prepare('SELECT id FROM utilisateurs WHERE pseudo LIKE ? ;');
  $nbArticles=$bdd->prepare('SELECT COUNT(*) FROM articles WHERE categorie= ? AND etat=\'2\'');
  $lastConnect=$bdd->prepare('SELECT connexion FROM utilisateurs WHERE id= ? ;');
  $getUser=$bdd->prepare('SELECT *, (SELECT COUNT(*) FROM commentaires WHERE auteur=utilisateurs.id) AS nb_commentaires,
                        (SELECT COUNT(*) FROM articles WHERE auteur=utilisateurs.id AND etat=2) AS nb_articles
                         FROM utilisateurs WHERE id= ? ;');
  $getArticle=$bdd->prepare('SELECT *, (SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note,
                           ( SELECT COUNT(*) FROM ( SELECT article FROM commentaires ) AS a WHERE id=article ) AS nb_commentaires
                             FROM articles WHERE id= ? AND etat=2 ORDER BY date_de_publication DESC;');
  $getCategorie=$bdd->prepare('SELECT nom FROM categories WHERE id= ? ;');
  $getArticlesFromCateg=$bdd->prepare('SELECT *, (SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note,
                                     ( SELECT COUNT(*) FROM ( SELECT article FROM commentaires ) AS a WHERE id=article ) AS nb_commentaires
                                       FROM articles WHERE etat=2 AND categorie= ? ORDER BY date_de_publication DESC;');
  $getCommentsFromArticleID=$bdd->prepare('SELECT * FROM commentaires WHERE article= ? ORDER BY date_de_publication DESC;');
  $getNbNotes=$bdd->prepare('SELECT COUNT(*) FROM notes WHERE article= ? ;');
  $getNoteFromUser=$bdd->prepare('SELECT note FROM notes WHERE article= :art AND utilisateur= :user ;');
  $modNote=$bdd->prepare('UPDATE notes SET note = :no WHERE article= :ar AND utilisateur = :ut;');
  $setNote=$bdd->prepare('INSERT INTO notes(utilisateur,article,note) VALUES (:ut, :ar, :no);');
  $augmenter_lecture=$bdd->prepare('UPDATE articles SET nb_lectures=nb_lectures+1 WHERE id= ? ;');
  $getNotesOfId=$bdd->prepare('SELECT note FROM notes WHERE article= ? ;');
  $postMessage=$bdd->prepare('INSERT INTO commentaires(auteur, article, contenu, date_de_publication) VALUES (:aut, :art, :cont, :dat);');
  $writing_articles=$bdd->prepare('SELECT *,(SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note FROM articles WHERE etat=0 AND auteur= ?;');
  $poster_articles=$bdd->prepare('UPDATE articles SET etat=1 , date_de_publication= :date_publi WHERE auteur= :id AND id IN ( :list );');
  $valider_articles=$bdd->prepare('UPDATE articles SET etat=2 WHERE id IN ( ? );');
  $create_new_article=$bdd->prepare('INSERT INTO articles(auteur,categorie,titre,miniature,contenu) VALUES (:aut,:cat,:tit,:min,:con);');
  $writeArticle=$bdd->prepare('SELECT *,(SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note
                               FROM articles WHERE id= :id AND etat=0 AND auteur= :aut ;');
  $writeArticle1=$bdd->prepare('SELECT *,(SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note FROM articles WHERE id= ? AND etat=1;');
  $modifier_article=$bdd->prepare('UPDATE articles SET categorie= :cat , titre= :tit , miniature= :min , contenu= :con WHERE id= :id ;');
  $getArticleNotId=$bdd->prepare('SELECT id FROM articles WHERE auteur= :aut AND titre= :tit AND categorie= :cat;');
  $supprimer_article=$bdd->prepare('DELETE FROM articles WHERE id= :id;');
  $getAuteurArticle=$bdd->prepare('SELECT auteur FROM articles WHERE id= ? ;');
  $getMessagesPersonnes=$bdd->prepare('SELECT * FROM (SELECT personne,max(date) AS date, SUM(nLu) AS nLu FROM
                              (SELECT date, nLu, auteur AS personne FROM messages WHERE destinataire= :id
                         UNION SELECT date, nLu, destinataire AS personne FROM messages WHERE auteur= :id ) AS b
                               GROUP BY personne) AS a LEFT JOIN utilisateurs ON utilisateurs.id=personne ORDER BY date DESC;');
  $getMessages=$bdd->prepare('SELECT * FROM messages WHERE (auteur= :autre AND destinataire= :moi)
                              OR (auteur= :moi AND destinataire= :autre) ORDER BY date;');
  $readMessages=$bdd->prepare('UPDATE messages SET nLu=0 WHERE auteur= :autre AND destinataire= :moi ;');
  $poster_message=$bdd->prepare('INSERT INTO messages(auteur,destinataire,contenu,date) VALUES (:aut,:des,:cont,NOW());');

  $modcompte1=$bdd->prepare('UPDATE utilisateurs SET mail=:ma, site=:si, description=:de,image=:image WHERE id =:id;');
  $modcompte2=$bdd->prepare('UPDATE utilisateurs SET mdp=:mdp WHERE id=:id;');
  $getArticleOfId=$bdd->prepare('SELECT *, (SELECT ROUND(AVG(note),2) FROM notes WHERE article=id) AS note,
                               ( SELECT COUNT(*) FROM ( SELECT article FROM commentaires ) AS a
                                 WHERE id=article ) AS nb_commentaires FROM articles WHERE etat=2 AND auteur = ?
                                 ORDER BY date_de_publication DESC;');
  $suppr_user=$bdd->prepare('DELETE FROM utilisateurs WHERE id = ? ;');
  $update_user=$bdd->prepare('UPDATE utilisateurs SET master="vrai" WHERE id= ? ;');

  // fonction liées à la base de données

  function update_user($id){
    global $update_user;
    $update_user->execute(array($id));
  }

  function supprimer_user($id){
    global $suppr_user;
    $suppr_user->execute(array($id));
  }

  function getArticleOfId($id){
    global $getArticleOfId;
    $getArticleOfId->execute(array($id));
    return $getArticleOfId;
  }
  function modifier_compte1($id){
    global $modcompte1;
    $imactuelle=getUser($_SESSION["id"])[7];
    $image=((!isset($_FILES["image"]) || $_FILES["image"]["error"]==4)?$imactuelle:strtolower(substr(strrchr($_FILES['image']['name'],'.'),1)));
    $a = array("id"=>$id,"ma"=>$_POST["mail"],"de"=>(isset($_POST["description"]))?$_POST["description"]:"","si"=>(isset($_POST["site"]))?$_POST["site"]:"","image"=>$image);
    if ($image!=$imactuelle){
      if (count(glob("USERS/{$_SESSION["id"]}.*"))!=0){ unlink(glob("USERS/{$_SESSION["id"]}.*")[0]); }
      move_uploaded_file($_FILES["image"]['tmp_name'],"USERS/".$_SESSION["id"].'.'.$image);
    }
    $modcompte1->execute($a);
  }

  function modifier_compte2($id){
    global $modcompte2;
    $modcompte2->execute(array("id"=>$id,"mdp"=>code($_SESSION["pseudo"],$_POST["newpwd"])));
  }

  function poster_message($id,$contenu){
    global $poster_message;
    $poster_message->execute(array("aut"=>$_SESSION['id'],"des"=>$id,"cont"=>$contenu));
  }

  function getMessages($autre,$moi){
    global $getMessages;
    global $readMessages;
    $readMessages->execute(array("autre"=>$autre,"moi"=>$moi));
    $getMessages->execute(array("autre"=>$autre,"moi"=>$moi));
    return $getMessages;
  }

  function getMessagesPersonnes($id){
    global $getMessagesPersonnes;
    $getMessagesPersonnes->execute(array("id"=>$id));
    return $getMessagesPersonnes;
  }

  function getAuteurArticle($id){
    global $getAuteurArticle;
    $getAuteurArticle->execute(array($id));
    if ($a=$getAuteurArticle->fetch()){ return $a['auteur']; }else{ return false; }
  }

  function supprimer_article($id){
    global $supprimer_article;
    $supprimer_article->execute(array("id"=>$id));
  }

  function writeArticle1($id){
    global $writeArticle1;
    $writeArticle1->execute(array($id));
    return $writeArticle1->fetch();
  }

  function writeArticle($auteur, $id){
    global $writeArticle;
    $writeArticle->execute(array("aut"=>$auteur,"id"=>$id));
    return $writeArticle->fetch();
  }

  function modifier_article($id,$categorie,$titre,$miniature,$contenu){
    global $modifier_article;
    $modifier_article->execute(array("id"=>$id,"cat"=>$categorie,"tit"=>$titre,"min"=>$miniature,"con"=>$contenu));
  }

  function creer_article($auteur,$categorie,$titre,$miniature,$contenu){
    global $create_new_article;
    global $getArticleNotId;
    $create_new_article->execute(array("aut"=>$auteur,"cat"=>$categorie,"tit"=>$titre,"min"=>$miniature,"con"=>$contenu));
    $getArticleNotId->execute(array("aut"=>$auteur, "tit"=>$titre, "cat"=>$categorie));
    return $getArticleNotId->fetch()['id'];
  }

  function valider_articles($list){
    global $valider_articles;
    $valider_articles->execute(array($list));

  }

  function poster_articles($list){
    global $poster_articles;
    $poster_articles->execute(array("id"=>$_SESSION['id'],"list"=>$list,"date_publi"=>date("Y-m-d H:i:s")));
  }

  function writing_articles($id){
    global $writing_articles;
    $writing_articles->execute(array($id));
    return $writing_articles;
  }

  function waiting_articles(){
    global $bdd;
    $wait=$bdd->query('SELECT * FROM articles WHERE etat=1;');
    return $wait;
  }

  function supprimerCommentaires($id){
    global $bdd;
    $bdd->exec("DELETE FROM commentaires WHERE id IN ($id) ;");
  }

  function postComment($user,$article,$message){
    global $postMessage;
    $postMessage->execute(array('aut'=>$user,'art'=>$article,'cont'=>$message,'dat'=>date('Y-m-j H:i:s')));
  }

  function augmenter_lecture($id){
    global $augmenter_lecture;
    $augmenter_lecture->execute(array($id));
  }

  function modNote($user,$art,$note){
    global $modNote;
    $modNote->execute(array("ut"=>$user,"ar"=>$art,"no"=>$note));
  }

  function setNote($user,$art,$note){
    global $setNote;
    $setNote->execute(array("ut"=>$user,"ar"=>$art,"no"=>$note));
  }

  function getNoteFromUser($userId,$articleId){
    global $getNoteFromUser;
    $getNoteFromUser->execute(array("user"=>$userId,"art"=>$articleId));
    $a=$getNoteFromUser->fetch();
    if (!$a){ return -1; }else{ return $a['note']; }
  }

  function getCommentsFromArticleID($id){
    global $getCommentsFromArticleID;
    $getCommentsFromArticleID->execute(array($id));
    return $getCommentsFromArticleID;
  }

  function getNbNotes($id){
    global $getNbNotes;
    $getNbNotes->execute(array($id));
    return $getNbNotes->fetch()[0];
  }

  function getIdAuteurs($search){
    global $getIdAuteurs;
    $getIdAuteurs->execute(array($search));
    $auteurs="";
    while ($a=$getIdAuteurs->fetch()){
      $auteurs.="{$a["id"]} ";
    }
    return (($auteurs=="")?"0":$auteurs);
  }

  function getArticlesFromCateg($id){
    global $getArticlesFromCateg;
    $getArticlesFromCateg->execute(array($id));
    return $getArticlesFromCateg;
  }

  function getArticle($id){
    global $getArticle;
    $getArticle->execute(array($id));
    $a=$getArticle->fetch();
    return $a;
  }

  function getUser($id){
    global $getUser;
    $getUser->execute(array($id));
    $a=$getUser->fetch();
    return $a;
  }

  function getCategorie($id){
    global $getCategorie;
    $getCategorie->execute(array($id));
    $a=$getCategorie->fetch();
    return $a;
  }

  function request($requete,$tab){
    global $bdd;
    $a=$bdd->prepare($requete);
    try{
      $a->execute($tab);
    }catch(Exception $e){
      return false;
    }
    if ($a->rowCount()==0){ return false; }
    return $a;
  }

  function getLastConnection ($id){
    global $lastConnect;
    $lastConnect->execute(array($id));
    $a=$lastConnect->fetch();
    if (!$a){ return 'NEVER'; }
    $a=$a[0];
    if ($a==NULL){ return "NEVER"; }else{ return $a; }
  }

  function getArticles(){
    global $bdd;
    return $bdd->query('SELECT id , titre FROM articles WHERE etat=2 ORDER BY date_de_publication DESC LIMIT 0, 10 ;');
  }

  function getCategories(){
    global $bdd;
    return $bdd->query('SELECT id, nom, (SELECT COUNT(*) FROM articles WHERE categorie=categories.id AND etat=2) AS nb_articles
                        FROM categories ORDER BY nb_articles DESC,nom ASC;');
  }

  function creerUser(){
    global $creerUser;
    $image=(isset($_FILES["image"]) && $_FILES["image"]["error"]==4)?'null':strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));

    $a=array("pseudo"=>$_POST["pseudo"], "mdp"=>code($_POST["pseudo"],$_POST["password"]), "nom"=>$_POST["nom"],
             "prenom"=>$_POST["prenom"], "mail"=>$_POST["mail"], "description"=>(isset($_POST["description"]))?$_POST["description"]:"",
             "site"=>(isset($_POST["site"]))?$_POST["site"]:"", "master"=>"faux", "inscription"=>date('Y-m-j'), "image"=>$image);
    try{
      $creerUser->execute($a);
      if ($image!='null'){
        move_uploaded_file($_FILES["image"]['tmp_name'],"USERS/".getIdUser($_POST["pseudo"]).'.'.$image);
      }
      echo "<p>Votre compte a bien &eacute;t&eacute; cr&eacute;&eacute; ! Vous pouvez mainteanant vous <a href=\"login.php?DO=connect\">connecter</a> !</p>";
    }catch(Exception $e){
      echo "<h1>Erreur</h1>";
    }
  }

  function existeDeja($pseudo){
    global $cherchePseudo;
    $cherchePseudo->execute(array($pseudo));
    $a=$cherchePseudo->fetch();
    return $a[0]!=0;
  }

  function getIdUser($pseudo){
    global $getIdUser;
    $getIdUser->execute(array($pseudo));
    return $getIdUser->fetch()[0];
  }

  function validLogin($pseudo,$mdp){
    global $connexion;
    $connexion->execute(array('pseudo'=>$pseudo,'mdp'=>$mdp));
    if ($donnees=$connexion->fetch()){
      $_SESSION["connecte"]="true";
      $_SESSION["pseudo"]=$pseudo;
      if ($donnees["image"]=="null"){ $_SESSION["image"]="null.jpg"; }else{ $_SESSION["image"]=getIdUser($pseudo).'.'.$donnees["image"]; }
      $_SESSION["nom"]=$donnees["nom"];
      $_SESSION["prenom"]=$donnees["prenom"];
      $_SESSION["mail"]=$donnees["mail"];
      $_SESSION["date"]=$donnees["inscription"];
      $_SESSION["description"]=$donnees["description"];
      $_SESSION["site"]=$donnees["site"];
      $_SESSION["id"]=$donnees["id"];
      $_SESSION["master"]=$donnees["master"];
      return true;
    }
    return false;
  }

  function nb_users_connectes(){
    global $bdd;
    $anonymes=($bdd->query('SELECT COUNT(*) FROM personnes_connectees WHERE connecte=\'faux\' ;'))->fetch()[0];
    $connecte=($bdd->query('SELECT COUNT(*) FROM personnes_connectees WHERE connecte=\'vrai\' ;'))->fetch()[0];
    return array($anonymes,$connecte);
  }

  function nb_articles_postes(){
    global $bdd;
    return ($bdd->query('SELECT COUNT(*) FROM articles WHERE etat=\'2\';'))->fetch()[0];
  }

  function nb_comments_postes(){
    global $bdd;
    return ($bdd->query('SELECT COUNT(*) FROM commentaires;'))->fetch()[0];
  }

  function changeConnexion($id){
    global $bdd;
    $update=$bdd->prepare('UPDATE utilisateurs SET connexion=CURRENT_TIMESTAMP() WHERE id= ? ;');
    $update->execute(array($id));
  }

  function miseAJourIP(){ // met à jour la table de la base de données qui contient les adresses ip
    global $bdd;
    global $ajoutIP;
    global $supprIP;
    $ip=get_IP();

    $oldIP=$bdd->prepare('SELECT id,timestamp FROM personnes_connectees WHERE TIMESTAMPDIFF(MINUTE,timestamp,CURRENT_TIMESTAMP())>30
                        AND adresse_ip!= ? AND id!=0 ;');
    $oldIP->execute(array($ip));

    $update=$bdd->prepare('UPDATE utilisateurs SET connexion= :connexion WHERE id= :id ;');
    while ($a=$oldIP->fetch()){
      $update->execute(array("connexion"=>$a['timestamp'], "id"=>$a["id"]));
    }

    $bdd->exec('DELETE FROM personnes_connectees WHERE TIMESTAMPDIFF(MINUTE,timestamp,CURRENT_TIMESTAMP())>30;');
    // on supprime les adresses ip de visiteurs n'ayant pas chargé de pages depuis plus de 30min
    $supprIP->execute(array($ip));
    $ajoutIP->execute(array('ip'=>$ip,'connecte'=>(($_SESSION["connecte"])?'vrai':'faux'),
                            'id'=>(($_SESSION["connecte"])?$_SESSION["id"]:'0')));
    // et on ajoute l'ip du visiteur ayant causé l'appel de cette fonction
  }

  function get_IP() { // pour obtenir l'adresse ip du visiteur
    if (isset($_SERVER['HTTP_CLIENT_IP'])) { // IP si internet partagé
      return $_SERVER['HTTP_CLIENT_IP'];
    }
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { // IP derrière un proxy
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else { // Sinon : IP normale
      return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    }
  }

?>
