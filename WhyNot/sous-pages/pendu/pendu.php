<?php
        function victory($l,$mot){
            if ($l=="" || $mot==""){ return false; }
            for ($i=0;$i<strlen($mot);$i++){ if (!contient(substr($mot,$i,1),$l)){ return false; } }
            return true;
        }

        function contient($lettre,$mot){
            if ($lettre=="" || $mot==""){ return false; }
            for ($i=0;$i<strlen($mot);$i++){ if ($lettre==substr($mot,$i,1)){ return true; } }
            return false;
        }

        function nbErr($mot,$lettres){
            $error=0;
            for ($i=0;$i<strlen($lettres);$i++){ if (!contient(substr($lettres,$i,1),$mot)){ $error++; } }
            return $error;
        }

        function simplify($l){
            $a="";
            for ($i=ord("a");$i<=ord("z");$i++){ $a=$a.((contient(chr($i),$l))?chr($i):""); }
            return $a;
        }

        $_SESSION["l"]=simplify(((isset($_SESSION["l"]))?$_SESSION["l"]:"").((isset($_POST["ll"]))?$_POST["ll"]:""));

        if (!isset ($_SESSION["mot"])){
          $a=explode("\n",file_get_contents("sous-pages/pendu/mots.txt"));
          $_SESSION["mot"]=strtolower($a[rand(0,count($a)-1)]);
        }

        echo "<p>";
        for ($i=0;$i<strlen($_SESSION["mot"]);$i++){
            if (contient(substr($_SESSION["mot"],$i,1),$_SESSION["l"])){ echo substr($_SESSION["mot"],$i,1); }
            else{ echo"_"; }
            echo " ";
        }
        echo "</p>";

        echo "<p> Lettres non utilisées :</p> <p>";
        for ($i=ord("a");$i<=ord("z");$i++){ if (!contient(chr($i),$_SESSION["l"])){ echo chr($i)." "; } }
        echo "</p>";
        if ($_SESSION["l"]!=""){
            echo "<p> Lettres utilisées :</p> <p>";
            for ($i=ord("a");$i<=ord("z");$i++){ if (contient(chr($i),$_SESSION["l"])){ echo chr($i)." "; } }
            echo "</p>";
        }


        $err=2*nbErr($_SESSION["mot"],$_SESSION["l"]);
        if ($err>=11){ echo "<h3> Perdu ! </h3>"; word($_SESSION["mot"]); again(); }
        else if (victory($_SESSION["l"],$_SESSION["mot"])){ echo "<h3>Victoire, voici l'email pour nous contacter ! </h3>
                                                                  <h3>notresite@gmail.com </h3>"; again(); }
        else{
            echo "<form action=\"index.php?DO=pendu\" method=\"POST\">
                     <p> <input type=\"text\" name=\"ll\" id=\"ll\" autofocus required/> </p>
                     <p> <input type=\"submit\" value=\"Envoyer\"/> </p>
                  </form>";
        }
        echo "<img class=\"pendu_img\" src=\"sous-pages/pendu/pendu".(($err>10)?11:$err).".svg\" alt=\"pendu\" />";

        function again(){
            echo "<form action=\"index.php?DO=pendu\" method=\"POST\">
                     <p> <input type=\"submit\" value=\"Rejouer ?\" autofocus/> </p>
                  </form>";
            unset($_SESSION["mot"]);
            unset($_SESSION["l"]);
        }

        function word ($mot){
          echo "<h4> Le mot &eacute;tait <strong>".$mot."</strong></h4>";
        }

        ?>
