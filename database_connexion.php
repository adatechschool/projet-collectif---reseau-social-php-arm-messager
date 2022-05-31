        <?php
        /**
         * Etape 1: Ouvrir une connexion avec la base de donnée.
         */
        // on va en avoir besoin pour la suite 
           $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
        //verification
            if ($mysqli->connect_errno)//connect_errno description de l'erreur de la dernière connexion 
           {
            echo("Échec de la connexion : " . $mysqli->connect_error);
            // echo "<article>";
            //echo("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
            //echo "</article>" 
            exit();
            //echo = affichage directement sur la page web 
            //sorte de console.log
            // . concatenation 
        }
        ?>