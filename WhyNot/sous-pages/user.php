<!-- affichage du compte d'un utilisateur -->
<?php
// si l'on veut supprimer un utilisateur
if (isset($_POST['suppr']) && $_SESSION['connecte'] && $_SESSION["master"]=="vrai"){
  supprimer_user($_GET["id"]);
}

//si l'on veut rendre un utilisateur master
if (isset($_POST['update']) && $_SESSION['connecte'] && $_SESSION["master"]=="vrai"){
  update_user($_GET["id"]);
}

// on affiche l'utilisateur demandé
include('display.php');
$user=getUser($_GET["id"]);
if ($user){ // on récupère les informations de l'utilisateur, s'il existe, on les affiche : ?>
  <fieldset class="user_field"><legend>Informations sur <?php echo $user['pseudo']; ?></legend>
    <div>
      <img src =<?php echo "\"USERS/".(($user[7]=='null')?'null.jpg':"{$user["id"]}.{$user[7]}")."\""; ?> style="width:300px" style="height:200px">
    </div>
    <div class="user_info">
        <p>Pseudonyme : <?php echo htmlentities($user['pseudo']); ?></p>
        <p>Nombre d'articles : <?php echo $user["nb_articles"]; ?> </p>
        <p>Nombre de messages : <?php echo $user["nb_commentaires"]; ?> </p>
        <p>Site : <?php echo htmlentities($user[8]); ?></p>
        <p>Description : <?php echo htmlentities($user[6]); ?></p>
        <?php if ($_SESSION['connecte']){
                echo "<p class=\"compte_ecrire_message\"><a href=\"login.php?DO=messagerie&id={$user["id"]}\">&Eacute;crire un message</a></p>";
                if ($_SESSION['master']=='vrai'){
                  echo "<form method=\"POST\" action=\"index.php?DO=user&id={$_GET["id"]}\" class=\"compte_ecrire_message\">
                          <input type=\"submit\" name=\"suppr\" value=\"Supprimer le compte\">
                        </form>";
                  if ($user['master']=='faux'){
                    echo "<form method=\"POST\" action=\"index.php?DO=user&id={$_GET["id"]}\" class=\"compte_ecrire_message\">
                            <input type=\"submit\" name=\"update\" value=\"Rendre master\">
                          </form>";
                  }
                }
              } ?>
    </div>
  </fieldset>
  <?php // on affiche les derniers articles écrits par l'utilisateur
  $articles = getArticleOfId($_GET["id"]);
  if ($articles && $articles->rowCount()!=0){
    echo "<fieldset><legend>Derniers articles</legend>";
    displayCateg($articles,5);
    echo "</fieldset>";
  }
}else{ echo "Cet utilisateur n'existe pas !"; } // sinon on dit que l'utilisateur n'existe pas ?>
