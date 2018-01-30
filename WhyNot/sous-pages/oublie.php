<?php if ($_SESSION["connecte"]){ error_deja_connecte(); } // on est déjà connecté
else if (isset($_POST["mail"])){ echo "<h1>Dommage !</h1>"; }
else{ // on a oublié ses identifiants ?>
      <legend>Oubli des identifiants</legend>
        <form class="login_oublie_form" method="post" action="login.php?DO=oublie">
        <p>Entrez le mail utilis&eacute; lors de la création de votre compte pour recevoir un mail vous permettant de changer de mot de passe.</p>
          <label for="mail">Addresse email : <input type="email" name="mail" autofocus required/> </label>
          <input type="submit" value="Envoyer"/>
        </form>
<?php }

// ce formulaire existe mais ne fait rien, il n'est pas traité car il faudrait envoyer un mail pour être vraiment efficace

?>
