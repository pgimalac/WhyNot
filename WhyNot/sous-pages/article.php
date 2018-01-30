<div class="article">
  <?php // pour afficher un article entier

    $valid=getArticle($_GET['id']);
    // on regarde si l'on vient de mettre une note (ou de la changer)
    if ($valid && isset($_POST['note']) && is_entier($_POST["note"]) && $_POST["note"]>=0 && $_POST['note']<=20){
      if (getNoteFromUser($_SESSION['id'],$_GET['id'])==-1){
        setNote($_SESSION['id'],$_GET['id'],$_POST['note']);
      }else{
        modNote($_SESSION['id'],$_GET['id'],$_POST['note']);
      }
    }

    // on regarde si l'on vient de mettre un commentaire
    if ($_SESSION['connecte'] && $valid && isset($_POST['commentaire']) && $_POST['commentaire']!=""){
      postComment($_SESSION['id'],$_GET['id'],$_POST['commentaire']);
      // on suppose que l'utilisateur n'est pas passé outre l'éditeur
      // et donc que le commentaire est valide
    }

    // on regarde si l'on veut supprimer un commentaire
    if (isset($_POST['toSuppr']) && $_SESSION['connecte'] && $_SESSION['master']=='vrai'){
      $comment="";
      foreach ($_POST['toSuppr'] as $a){ $comment.="'{$a}',"; }
      supprimerCommentaires(substr($comment,0,strlen($comment)-1));
    }


    $article=getArticle($_GET['id']); // on récupère l'article

    // display.php
    include("display.php");
    displayArticle($article); // et on l'affiche

  ?>
</div>
