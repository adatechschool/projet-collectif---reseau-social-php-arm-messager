<!doctype html>
<html lang="fr">
    <head>
        <title>ReSoC - Mes abonnements</title> 
    </head>
    <body>
        <?php 
        include 'header.php';
        include 'database_connexion.php';
        ?>
        <div id="wrapper">
            <aside>
                <img src="avart.png" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes dont
                        l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?>
                        suit les messages
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                // Etape 2: se connecter à la base de donnée
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.follower_id 
                    WHERE followers.follower_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                ?>
                <article>
                    <img src="avart.png" alt="blason"/>
                    <h3>Alexandra</h3>
                    <p>id:654</p>                    
                </article>
            </main>
        </div>
    </body>
</html>
