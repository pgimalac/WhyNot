<?php  // la page de connexion

      if (!$connect && $_SESSION["connecte"]){ error_deja_connecte(); } // si l'on est connecté sans être en train de se connecter, erreur
      else{ // sinon c'est que l'on se connecte ?>

        <legend>Connexion</legend>

  <?php if ($connect){  // on vient de se connecter ?>
          <p> Vous êtes bien connect&eacute; ! Cliquez ici pour aller &agrave; <a href="index.php">l'accueil</a>.</p>
  <?php }
        else{ // on veut se connecter, affichage du formulaire pour ?>
          <div class="login_connect_div">
            <form action="login.php?DO=connect" method="post" class="login_connect_form">

              <div><label for="pseudo">   Pseudonyme :   </label><br/><input type="text" name="pseudo" id="pseudo" required autofocus
                      <?php if($error){ ?> style="border-color:red" <?php } ?> /></div>
              <div><label for="password"> Mot de Passe : </label><br/><input type="password" name="password" id="password" required
                      <?php if($error){ ?> style="border-color:red" <?php } ?> /></div>
              <div><input type="submit" value="Envoyer" /> </div>
              <?php if ($error){ ?> <div class="connect_error">ERREUR ! Login invalide</div> <?php }
              // on s'est trompé en voulant se connecter ?>
            </form>
          </div>
<?php   // ce formulaire est traité dans login.php (la 'super-page')
        }
      } ?>
