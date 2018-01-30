<?php if ($_SESSION['connecte']) { // la page de messagerie ?>
        <legend>Messagerie</legend>
<?php

  $personnes=getMessagesPersonnes($_SESSION['id']);
  // on récupère la liste des utilisateurs auxquels l'utilisateur a envoyé un message ?>
    <div class="messagerie_left">
      <form class="messagerie_rechercher" method="POST" action="index.php?DO=search">
        <input type="text" placeholder="Rechercher" name="search" required/>
        <input type="submit" value="Ok" />

        <input type="hidden" value="3" name="what" />
        <input type="hidden" value="plus" name="pma" />
        <input type="hidden" value="0" name="nba" />
        <input type="hidden" value="plus" name="pmc" />
        <input type="hidden" value="0" name="nbc" />
        <input type="hidden" value="after" name="ba" />
        <input type="hidden" value="0" name="date" />
        <input type="hidden" value="1" name="sort" />
        <input type="hidden" value="DESC" name="order" />

      </form>
<?php if ($personnes->rowCount()!=0){ ?>
      <div class="messagerie_personnes">
<?php $dateActuelle=new DateTime(date("Y-m-d H:i:s"));
    while ($a=$personnes->fetch()){
      $dateMessage=new DateTime($a["date"]);
      $diff = $dateActuelle->diff($dateMessage);
      $time=$diff->days;
      $date=(($time==0)?date("H:i",strtotime($a["date"])):date("d/m",strtotime($a["date"])));
      echo "<p class=\"messagerie_personne\">
              <a href=\"login.php?DO=messagerie&id={$a["id"]}\">".htmlentities($a["pseudo"]).(($a["nLu"]!=0)?" ({$a["nLu"]})":"")." - $date</a>
            </p>";
    }
    echo "</div>";
  }else{ echo "<p>Vous n'avez aucun contact !</p>"; }
  echo "</div>";

  if (isset($_GET['id']) && is_entier($_GET['id']) && $user=getUser($_GET['id'])){ // si l'on a envoyé des messages à la personne
    // on regarde si l'on vient d'envoyer un message
    if (isset($_POST['message'])){
      poster_message($_GET['id'],$_POST['message']);
    }

          // on affiche les messages que l'utilisateur a échangés avec l'autre utilisateur ?>
          <div class="messagerie_right">
            <div class="messagerie_right_header">
              <a href=<?php echo "\"index.php?DO=user&id={$user["id"]}\">".htmlentities($user['pseudo']); ?></a>
            </div>
            <div class="messagerie_messages" id="messagerie_messages">
<?php $messages=getMessages($_GET['id'],$_SESSION['id']); // on récupère les messages
    while ($a=$messages->fetch()){ // et on les affiche
      echo "<div class=\"".(($a['auteur']==$_SESSION['id'])?"message_auteur":"message_destinataire")."\">".
              htmlentities($a["contenu"])."
            </div>";
    } ?>
            </div>
            <div class="messagerie_ecrire">
              <form method="POST" action=<?php echo "login.php?DO=messagerie&id={$_GET["id"]}"; ?>>
                <input type="text" name="message" placeholder="&Eacute;crire un message" />
                <input type="submit" value="Envoyer" />
              </form>
            </div>
          </div>

          <!-- on utilise un petit script pour être en bas de la liste de messages dès le chargement de la page -->
          <script type="text/javascript">
            element = document.getElementById('messagerie_messages');
            element.scrollTop = element.scrollHeight;
          </script>
<?php  }

}else{ error_pas_connecte(); }
