<?php

  // ce fichier contient des fonctions de vérification pour la création et la modification de compte

function check_nom($b){ // on vérifie le nom
  $a=array();
  if ($b="" || strlen($b)>50){ $a["taille"]=false; }
  return $a;
}

function check_prenom($b){ // on vérifie le prénom
  $a=array();
  if ($b="" || strlen($b)>50){ $a["taille"]=false; }
  return $a;
}

function check_pseudo($b){ // on vérifie le pseudo
  $a=array();
  if (strlen($b)<5 || strlen($b)>50){ $a["taille"]=false; }
  else if(bonsCaract($b)){ $a["valide"]=false; }
  else if (existeDeja($b)){ $a["dispo"]=false; } // on vérifie que ce pseudonyme n'existe pas déjà
  return $a;
}

function bonsCaract($string){
  // pour vérifier que la chaîne de caractère (le pseudo ou le mdp) ne contient que les caractères autorisés
  $a=true;
  for ($i=0;$i<strlen($string);$i++){
    $c=$string[$i];
    if (!(ord($c)>=chr('a') && ord($c)<=chr('z')) && !(ord($c)>=chr('A') && ord($c)<=chr('Z')) &&
        // -- n'est pas une lettre minuscule  --       --  n'est pas une lettre majuscule  --
        !in_array($c,array('à','â','ä','ç','é','è','ê','ë','î','ï','ô','ö','û','ü','ŷ','ÿ')) &&
        // --                  n'est pas une des lettre accentuée ci-dessus                  --
        !(ord($c)>=ord('0') && ord($c)<=ord('9')) && !in_array($c,array('-','_','.','<','>','/','*','\\','!','?',':',',','+','=','&'))
        // --       n'est pas un chiffre       --    -- n'est pas un caractère parmi ceux de la liste -_.<>/*\!?:,+=& --
        ){ $a=false; break; }
  }
  return $a;
}

function check_password($b){ // on vérifie le mot de passe
  $a=array();
  if (strlen($b)<8 || strlen($b)>50){ $a["taille"]=false; } // le mdp doit contenir entre 10 et 50 caractères
  else if(bonsCaract($b)){ $a["valide"]=false; } // on regarde si les caractères sont autorisés
  else if (minCond($b)){ $a["conditions"]=false; } // et si les conditions minimales du mdp sont remplies
  return $a;
}

function check_newpwd($b){ // on vérifie le nouveau mot de passe (même chose qu'avant)
  $a=array();
  if (strlen($b)<10 || strlen($b)>50){ $a["taille"]=false; } // le mdp doit contenir entre 10 et 50 caractères
  else if(bonsCaract($b)){ $a["valide"]=false; } // on regarde si les caractères sont autorisés
  else if (minCond($b)){ $a["conditions"]=false; } // et si les conditions minimales du mdp sont remplies
  return $a;
}

function minCond($mdp){ // le mpd doit contenir au moins
  $majuscule=0;    // 2 majuscules
  $minuscule=0;    // 2 minuscules
  $chiffre=0;      // 2 chiffres

  for ($i=0;$i<strlen($mdp);$i++){
    $c=$mdp[$i];
    if (ord($c)>=chr('a') && ord($c)<=chr('z')){ $minuscule++; }
    else if (ord($c)>=chr('A') && ord($c)<=chr('Z')){ $majuscule++; }
    else if (ord($c)>=ord('0') && ord($c)<=ord('9')){ $chiffre++; }
  }
  return $majuscule>1 && $minuscule>1 && $chiffre>1;
}

function check_mail($b){ // on vérifie le mail
  // on suppose que l'adresse mail est valide (il faudrait envoyer un mail à l'adresse donnée pour le confirmer)
  if ($b=="" || strlen($b)<4 || strlen($b)>200){ return array("taille"=>false); }
  return array();
}

function check_site($b){ // on vérifie le site
  // on considère que si quelque chose a été mis, il s'agit bien d'un site
  if ($b=="" || strlen($b)<100){ return array(); }
  return array("taille"=>false);
}

function check_image($b){ // ici $b ne sert à rien (on utilise une boucle pour appeler ces fonctions et certaines ont un argument)
  if (!isset($_FILES["image"]) || $_FILES["image"]["error"]==4){ return array(); } //UPLOAD_ERR_NO_FILE : pas de fichier
  else if ($_FILES["image"]["error"]==3){ return array("upload"=>false); } //UPLOAD_ERR_PARTIAL : erreur de téléchargement

  // vérification de l'extension et du type de fichier
  $a=array();
  $autor=array('png','jpg','jpeg','gif', 'svg');
  $ext=strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
    // on n'utilise pas $_FILES["image"]["type"] pour ne pas avoir 'image/jpg' mais directement 'jpg'
  if (!in_array($ext,$autor)){ $a["type"]=false; }
  if ($_FILES["image"]["error"]==1 || filesize($_FILES["image"]["tmp_name"])>500000){ // taille maximale : 500Ko
    $a["taille"]=false; // UPLOAD_ERR_INI_SIZE : erreur de taille
  }
  return $a;
}

function check_description($b){ // on vérifie la description
  if ($b=="" || strlen($b)<256){ return array(); }
  else{ return array("taille"=>false); }
} ?>
