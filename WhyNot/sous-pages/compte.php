<?php // affichage du compte d'un utilisateur
include('check.php');

function validForm(){ // pour vérifier si la modification du compte demandée est valide
  $error=array();
  foreach (array("password","newpwd","mail","site","image","description") as $b){
    $a='check_'.$b;
    $error[$b]=$a((isset($_POST[$b]))?$_POST[$b]:"");
  }
  $error["newpwdC"]=((count($error["newpwd"])==0 && $_POST["newpwd"]==$_POST["newpwdC"])?array():array('correct'=>'false'));
  $nbError=0;
  foreach (array("password","newpwd","newpwdC","mail","site","image","description") as $b){
    $nbError+=count($error[$b]);
  }
  if($nbError>0){return $error;}
  else{return true;}
}

function valider1(){
  $valid=validForm();
  if($valid){
    modifier_compte1($_SESSION["id"]);
    if(isset($_POST["mail"])){
      $_SESSION["mail"]=$_POST["mail"];
    }
    if(isset($_POST["site"])){
      $_SESSION["site"]=$_POST["site"];
    }
    if(isset($_POST["description"])){
      $_SESSION["description"]=$_POST["description"];
    }
    if (isset($_FILES['image']) && $_FILES['image']['error']==0){
      $_SESSION["image"]=$_SESSION['id'].'.'.strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
    }
  }
  else{ formulaire($valid); } // on réaffiche le formulaire avec les erreurs du précédent formulaire
}

function valider2(){
  $valid=validForm();
  if($valid){
    if(isset($_POST["password"])){
      if(code($_SESSION["pseudo"],$_POST["newpwd"]) == $_SESSION["mdp"] && $_POST["newpwd"] == $_POST["newpwdC"]){
        modifier_compte2($_SESSION["id"]);
        $_SESSION["mdp"]=code($_SESSION["pseudo"],$_POST["newpwd"]);
        $image=((!isset($_FILES["image"]) || $_FILES["image"]["error"]==4)?'null':strtolower(substr(strrchr($_FILES['image']['name'],'.'),1)));
        if ($image!='null') $_SESSION["image"]==$_SESSION['id'].'.'.$image;
      }
    }
  }else{formulaire($valid); }
}

function formulaire($error){ // le formulaire de modification du compte ?>
  <div class="compte_field">
    <fieldset><legend> Informations </legend>
      <form action ="login.php?DO=compte" method="post">
        <p>
          Nom : <?php echo $_SESSION["nom"];?><br />
          Prénom : <?php echo $_SESSION["prenom"];?><br />
          Pseudo : <?php echo $_SESSION["pseudo"];?><br />
        </p>
        <div><label for="password"> Ancien mot de passe :</label><br />
          <input type = "password" name = "password" maxlength="50"/></div>
        <div><label for="newpwd"> Nouveau mot de passe :</label><br />
          <input type ="password" name="newpwd" maxlength="50" /></div>
        <div><label for="newpwd"> Nouveau mot de passe (confirmation) :</label><br />
          <input type = "password" name="newpwdC" maxlength="50"/></div>
          <input type="submit" name="modifier2" value="Modifier" style="width:80px">
      </form>
    </fieldset>
    <fieldset>
      <legend>Supplémentaires</legend>
      <form action ="login.php?DO=compte" method ="post" enctype="multipart/form-data">
        <div><label for="image"> Image de profil (PNG,JPEG,GIF): </label><br />
          <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
          <input type="file" name="image"/></div>
        <div><label for="mail"> Mail :</label><br />
          <input type ="mail" name="mail" maxlength="50" value="<?php echo $_SESSION["mail"]?>"/></div>
        <div><label for="site"> Site :</label><br />
          <input type ="url" name="site" maxlength="50" value="<?php echo $_SESSION["site"]?>"/></div>
        <div class="textarea"><label for="description"> Description personnelle : </label><br />
          <textarea name="description"  placeholder="Maximum 255 caract&egrave;res" style="height:75px"><?php echo $_SESSION["description"]?></textarea></div>
        <div class = "compte_modifier_div"><input type="submit" name="modifier1" value="Modifier" style="width:80px"></div>
      </form>
    </fieldset>
  </div>
<?php
}

// on vérifie si l'on vient de faire une modification
if($_SESSION["connecte"] && (isset($_POST["modifier1"]) || isset($_POST["modifier2"]))){
  if(isset($_POST["modifier1"])){
    valider1();
    echo "<p> Votre compte a bien &eacute;t&eacute; modifi&eacute; ! Vous pouvez maintenant retourner à votre <a href=\"login.php?DO=compte\">compte</a>.</p>";
  }
  if(isset($_POST["modifier2"])){
    valider2();
    echo "<p> Votre mot de passe a bien &eacute;t&eacute; modifi&eacute; !</p>";
  }
}else if ($_SESSION['connecte']){ // on a demandé à modifier le compte
  if(isset($_POST["modifier"]) || isset($_POST["modifer1"]) || isset($_POST["modifier2"])){
    echo "<legend> Modification des données du compte </legend>";
    formulaire(array());
  }

// on a pas fait de modification
  else{ // affichage des informations du compte ?>
    <legend>Compte</legend>
    <div class="compte_field2">
      <div class="compte_field">
        <fieldset style="min-width:300px"style="max-width:300px">
          <legend> Informations </legend>
          <p> Photo de profil : <br />
            <img src =<?php echo "\"USERS/{$_SESSION["image"]}\"";?> style="width:100px" style="height:100px"><br /><br />
            Nom : <?php echo $_SESSION["nom"];?><br /><br />
            Prénom : <?php echo $_SESSION["prenom"];?><br /><br />
            Pseudo : <?php echo $_SESSION["pseudo"];?><br /><br />
            Date de création : <?php echo $_SESSION["date"];?><br /></p>
        </fieldset>
        <fieldset style="max-width:300px">
          <legend>Supplémentaires</legend>
          <p style="word-wrap:break-word"> Mail : <br /> <?php echo $_SESSION["mail"];?><br /><br />
            Site : <br /> <?php echo $_SESSION["site"];?><br /><br />
            Description personnelle: <br /><?php echo $_SESSION["description"];?><br /><br />
          </p>
        </fieldset>
      </div>
      <div class="compte_field3">
        <form action="login.php?DO=compte" method = "post">
          <input type="submit" name="modifier" value="Modifier">
        </form>
      </div>
    </div><?php
  }
}
else{ error_pas_connecte(); } // on n'est pas connecté

?>
