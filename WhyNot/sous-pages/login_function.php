<?php  // ce fichier contient des fonctions utilisées par plusieurs pages du login

      function error_deja_connecte(){ // l'erreur si l'on est déjà connecté ?>
        <div><legend> Vous &ecirc;tes d&eacute;j&agrave; connect&eacute; ! </legend>
          <p> Si vous n'&ecirc;tes pas <strong><em> <?php htmlentities($_SESSION["USER"]) ?>
            </em></strong> ou que vous voulez vous d&eacute;connecter,
            cliquez <a href="login.php?DO=deconnect">ici</a>.</p>
          <p> Pour revenir à l'accueil, cliquez <a href="index.php">ici</a>.</p>
        </div>
<?php }

      function error_pas_connecte(){ // l'erreur si l'on est pas connecté ?>
        <div><legend> Vous n'&ecirc;tes pas connect&eacute; ! </legend>
          <p> Si vous avez un compte et que vous voulez vous connecter,
              cliquez <a href="login.php?DO=connect">ici</a>.</p>
          <p>Si vous n'avez pas encore de compte, cr&eacute;ez vous en un <a href="login.php?DO=creer">ici</a> !</p>
          <p>Si vous avez oubli&eacute; vos identifiants, cliquez <a href="login.php?oublie">ici</a></p>
          <p> Pour revenir à l'accueil, cliquez <a href="index.php">ici</a>.</p>
        </div>
<?php }

      function isValidPage($a){ return ($a=="connect" || $a=="deconnect" || $a=="creer" || $a=="compte" || $a=="oublie" || $a=="messagerie"); }
      // pour vérifier que la page demandée existe

      function code($pseudo,$mdp){
        // sert à coder le mot de passe, on utilise une clé (fichier 'cle') qui sert de salt pour coder le pseudo
        // et le résultat sert de salt pour coder le mot de passe lui-même
        $fic=fopen("sous-pages/cle","r");
        $cle=fgets($fic,40);
        fclose($fic);
        return substr(password_hash($mdp,PASSWORD_DEFAULT,array(
            "salt"=>substr(password_hash($pseudo,PASSWORD_BCRYPT,array("salt"=>$cle)),28))),28);
      }

?>
