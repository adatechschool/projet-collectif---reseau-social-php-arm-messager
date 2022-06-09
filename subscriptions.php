<?php
session_start();
if (!isset($_SESSION['connected_id'])) {
    header("Location: login.php");
    exit();
    }
?>

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
            $subscriber_id = intval($_GET['user_id']);
            // Etape 2: se connecter à la base de donnée
            // Etape 3: récupérer le nom de l'utilisateur
            $laQuestionEnSql = "
                SELECT followers.user_id, users.email, users.password, users.alias, followers.follower_id
                FROM followers RIGHT JOIN users
                ON users.id=followers.user_id
                WHERE followers.follower_id='$subscriber_id';
                ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Etape 4: à vous de jouer
            //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous
            ?>
            <?php while ($subscribers = $lesInformations->fetch_assoc()) { ?>
                <article>
                <?php
                switch ($subscribers['user_id']) {
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
                    <h3><?php echo $subscribers['alias'] ?></h3>
                    <p>id: <?php echo $subscribers['user_id'] ?></p>
                </article>
            <?php } ?>
        </main>
    </div>
</body>
</html>
