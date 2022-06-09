<?php
session_start();
?>
<!doctype html>
<html lang="fr">
    <head> 
        <title>ReSoC - Mes abonnés </title> 
    </head>
    <body>
        <?php 
         include 'header.php';
         include 'database_connexion.php';
         if (!isset($_SESSION['connected_id'])) {
            header("Location: login.php");
            exit();
            }
        ?>
        
        <div id="wrapper">          
            <aside>
                <?php
                switch ($userId) {
                    case 24:
                        echo " <img src='avart.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 25:
                        echo "<img src='alex.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 26:
                        echo "<img src='julia.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 27:
                        echo "<img src='suzon.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 28:
                        echo "<img src='joe.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    }
                        ?>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?></p>

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
                    WHERE followers.user_id='$userId'
                    GROUP BY users.id
                    ";
                    $lesInformations = $mysqli->query($laQuestionEnSql);
                    // Etape 4: à vous de jouer
                    //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                    while ($followers = $lesInformations->fetch_assoc())
                {
                   //echo "<pre>" . print_r($followers, 1) . "</pre>";
                ?>
                <article>
                <?php
                switch ($followers['id']) {
                    case 24:
                        echo " <img src='avart.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 25:
                        echo "<img src='alex.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 26:
                        echo "<img src='julia.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 27:
                        echo "<img src='suzon.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    case 28:
                        echo "<img src='joe.png' alt='Portrait de l'utilisatrice'/>";
                        break;
                    }
                        ?>
                    <h3><a href="wall.php?user_id=<?php echo $followers['id'] ?>"> <?php echo $followers['alias'] ?> </a></h3>
                    <p>id:<?php echo $followers['id'] ?></p>
                </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
                
                