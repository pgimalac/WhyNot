<?php // formulaire de création de compte

  include('check.php'); // ce fichier contient des fonctions de vérification des informations donnée au formulaire

  // La partie qui s'execute au chargement de cette page
  if ($_SESSION["connecte"]){ error_deja_connecte(); } // si l'on est déjà connecté, on affiche l'erreur
  else if (isset($_GET["id"]) && $_GET['id']=="conditions"){
    conditions();
  }else{
    echo "<legend><a class=\"creer_compte_legend\" href=\"login.php?DO=creer&id=conditions\">Cr&eacute;ation de compte</a></legend>";
    if (isset($_POST["nom"])){ valider(); } //si l'on a déjà rempli le formulaire, on vérifie les données
        // sinon on affiche le formulaire
    else{ formulaire(array()); } // array() est le tableau des erreurs, qui est ici vide
  }


  // des fonctions auxiliaires

// pour afficher les conditions à remplir dans le formulaire
  function conditions(){ ?>
    <legend><a class="creer_compte_legend" href="login.php?DO=creer">Cr&eacute;ation de compte</a></legend>
    <div class="compte_conditions">
      <div>
        <h3>pseudonyme</h3>
        <ul>
          <li>Taille : entre 1 et 50 caract&egrave;res</li>
          <li>Ne doit pas d&eacute;jà exister</li>
          <p>Caractères autoris&eacute;s :</p>
          <li>Lettres majuscules et minuscules non accentu&eacute;es</li>
          <li>Lettres accentu&eacute;s : à,â,ä,ç,é,è,ê,ë,î,ï,ô,ö,û,ü,ŷ,ÿ</li>
          <li>Chiffres</li>
          <li>Autres caract&egrave;res : <?php echo htmlentities("-_.<>/\*!?:,+=&"); ?></li>
        </ul>

        <h3>Nom et pr&eacute;nom</h3>
        <ul>
          <li>Taille : entre 1 et 50 caractères</li>
        </ul>

        <h3>Mot de passe</h3>
        <ul>
          <li>Taille : entre 8 et 50 caract&egrave;res</li>
          <li>Caract&egrave;res autoris&eacute;s : les mêmes que que pour le nom et le pr&eacute;nom</li>
          <li>Doit contenir au moins deux majuscules, deux minuscules et deux chiffres</li>
        </ul>

      </div>
      <div>

        <h3>Adresse mail</h3>
        <ul>
          <li>Ne doit pas avoir utilisée pour s'incrire avant</li>
          <li>Taille : entre 5 et 200 caract&egrave;res</li>
        </ul>
        <h3>Image</h3>
        <ul>
          <li>Extensions autorisées : jpg, jpeg, png, svg, gif</li>
          <li>Taille : 500ko</li>
        </ul>

        <h3>Site internet</h3>
        <ul>
          <li>Taille : entre 0 et 100 caract&egrave;res</li>
        </ul>

        <h3>Description</h3>
        <ul>
          <li>Taille : entre 0 et 256 caract&egrave;res</li>
        </ul>
      </div>
    </div>

<?php }

  function validForm(){ // pour vérifier si le formulaire est valide
    $error=array(); // pour stocker d'éventuelles erreurs

    // On teste chaque champ pour voir s'il est correct
    foreach (array("nom","prenom","pseudo","password","mail","site","image","description") as $b){
      $a='check_'.$b;
      $error[$b]=$a((isset($_POST[$b]))?$_POST[$b]:"");
    }
    $error["passwordC"]=((count($error["password"])==0 && $_POST["password"]==$_POST["passwordC"])?array():array('correct'=>'false'));

    // on regarde s'il y a des erreurs
    $nbError=0;
    foreach (array("nom","prenom","pseudo","password","passwordC","mail","site","image","description") as $b){
      $nbError+=count($error[$b]);
    }

    if ($nbError>0){ return $error; } // s'il y a des erreurs, on renvoit le tableau d'erreurs
    else{ return "true"; } // sinon on dit que c'est valide
  }

  function formulaire($error){ //$error est le tableau des erreurs ?>
    <!--
    nous voulions afficher dynamiquement en javascript les conditions à remplir pour chaque champ mais
    c'était trop long et compliqué à faire donc au final $error ne sert pas ici...
    -->
    <form class="login_creer_compte_form" method="post" action="login.php?DO=creer" enctype="multipart/form-data">
        <fieldset> <legend>Champs obligatoires</legend>
            <div><label for="nom">      Nom :           </label><br />
              <input type="text" name="nom"  maxlength="50" required autofocus/></div>
            <div><label for="prenom">   Pr&eacute;nom : </label><br />
              <input type="text"     name="prenom"    maxlength="50" required/></div>
            <div><label for="pseudo">   Pseudonyme :    </label><br />
              <input type="text"     name="pseudo"    maxlength="50" required/></div>
            <div><label for="password"> Mot de passe :  </label><br />
              <input type="password" name="password"  maxlength="50" required/></div>
            <div><label for="password"> Mot de passe (confirmation) : </label><br />
              <input type="password" name="passwordC" maxlength="50" required/></div>
            <div><label for="mail">     Mail :          </label><br />
              <input type="email"    name="mail"      maxlength="50" required/></div>
        </fieldset>

        <div class="creer_valider_div"><input type="submit" value="Valider" class="creer_valider"/></div>
        <div class="creer_effacer_div"><input type="reset" value="Effacer" class="effacer"/></div>

        <fieldset> <legend>Champs facultatifs</legend>
            <div><label for="site">Site : </label><br />
              <input type="url"  name="site"/></div>
            <div><label for="image">Image de profil (PNG,JPEG,GIF): </label><br />
              <input type="hidden" name="MAX_FILE_SIZE" value="500000" /> <!-- limitation pour la taille : 500ko -->
              <input type="file" name="image"/></div>
            <div class="textarea"><label for="description_personnelle">Description personnelle : </label><br />
              <textarea name="description" form="creer" placeholder="Maximum 255 caract&egrave;res"></textarea>
            </div>
        </fieldset>
    </form>
<?php }

  function valider(){
      $valid=validForm(); // on récupère les erreurs du formulaires

      if($valid==="true"){ // s'il n'y en a pas on crée l'utilisateur
        creerUser(); ?>
<?php }
      else{ print_r($valid); formulaire($valid); } // sinon on réaffiche le formulaire avec les erreurs du précédent formulaire
  }
?>
