<?php // fichier de déconnexion

if (!$_SESSION["connecte"] && !(isset($_POST["boo"]) && $_POST["boo"]=="Oui")){ error_pas_connecte(); }
// si l'on est pas connecté et que l'on est pas en train de se déconnecter : erreur
else{ // sinon on peut se déconnecter
  echo "<legend>D&eacute;connexion</legend>";
  if (isset($_POST["boo"]) && $_POST["boo"]=="Oui"){ // si l'on vient déconnecter ?>
    <p>Vous &ecirc;tes bien d&eacute;connect&eacute;.
      Retourner &agrave; <a href="index.php">l'accueil</a>.</p>
<?php  }
  else{ // si l'on veut se déconnecter ?>
    <p>&Ecirc;tes-vous s&ucirc;r ?
      <form class="deconnect" action="login.php?DO=deconnect" method="post"> <input type="submit" value="Oui" name="boo" class="deconnect1"/> </form>
      <form class="deconnect" action="index.php" method="post"> <input type="submit" value="Non" class="deconnect2"/> </form>
    </p>
<?php  }
} ?>
