<?php // pour écrire un article (nouveau ou en cours d'écriture)

function write($article){ // affiche l'article et permet de le modifier
  $categories=getCategories(); // on récupère les catégories pour pouvoir choisir la catégorie de l'article
  echo "<form action=\"espace_connecte.php\" method=\"POST\" class=\"article_write\" enctype=\"multipart/form-data\">
          <div class=\"article_head\">".
            (($article && $article["miniature"]!="null")?
              "<div class=\"article_img\"><img src=\"ARTICLES/{$_GET["id"]}.{$article["miniature"]}\" /></div>"
              :"").
           "<div class=\"article_head_content_write\">
              <label for=\"titre\">Titre : </label>
              <input id=\"titre\" type=\"text\" required ".(($article)?"":"autofocus")." name=\"titre\" value=\"".(($article)?htmlentities($article["titre"]):"")."\" />
              <label for=\"Categorie\">Cat&eacute;gorie : </label>
              <select name=\"Categorie\" id=\"Categorie\">";
              $i=0;
  while ($a=$categories->fetch()){ $i++; echo "<option value=\"{$a["id"]}\" ".(($article && $a['id']==$article['categorie'])?"selected":"").((!$article && $i==1)?" selected":"").">".htmlentities($a["nom"])."</option>"; }
  // select pour choisir la catégorie
  echo "      </select>
              <label for=\"image\">Image : </label>
              <input type=\"file\" id=\"image\" name=\"image\"/>
            </div>
          </div>
          <div class=\"article_content\">
            <textarea id=\"editor\" name=\"editor\">".(($article)?$article["contenu"]:"")."</textarea>".  // pour écrire les articles
          "</div>
          <input type=\"submit\" name=\"submit\" value=\"Supprimer\" />
          <input type=\"submit\" name=\"submit\" value=\"".(($article)?"Enregistrer":"Cr&eacute;er")."\" />
          <input type=\"submit\" name=\"submit\" value=\"Poster\" />
          <input type=\"hidden\" value=\"{$_GET['id']}\" name=\"id\" />
        </form>"; // l'auteur peut le supprimer, l'enregistrer/le créer ou le poster
}

if ($_GET['id']=='new'){ // si l'on crée un nouvel article
    write(false);
}else{ // si l'on modifie un article existant
  if (is_entier($_GET['id']) && $article=writeArticle($_SESSION['id'],$_GET['id'])){
    write($article); // si l'article existe et est modifiable
  }else{ // sinon l'article n'est pas modifiable
    echo "Cet article ne peut être modifié !";
  }
}
?>


<!-- Pour faire du fieldset servant à écrire les articles une vrai éditeur WYSIWYG enrichi -->
<script src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR.replace('editor');</script>
