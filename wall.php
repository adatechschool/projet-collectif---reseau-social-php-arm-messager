<?php
session_start();
?>
<!doctype html>
<html lang="fr">

<head>
    <title>ReSoC - Mur</title>
</head>

<body>
    <?php
    include 'header.php';
    include 'database_connexion.php';
    ?>
    </header>
    <div id="wrapper">
        <?php
        /**
         * Etape 1: Le mur concerne un utilisateur en particulier
         * La première étape est donc de trouver quel est l'id de l'utilisateur
         * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
         * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
         * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
         */
        $userId = intval($_GET['user_id']);
        ?>
        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom de l'utilisateur
             */
            $laQuestionEnSqlDisplayName = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSqlDisplayName);
            $user = $lesInformations->fetch_assoc();
            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
             echo "<pre>" . print_r($user, 1) . "</pre>";
            ?>
            <img src="avart.png" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message de l'utilisatrice :
                    (n° <?php echo $userId . ' - ' . 'alias ' . $user['alias'] ?>)
                </p>
            </section>
        </aside>
        <main>
            <?php
            /**
             * Etape 3: récupérer tous les messages de l'utilisatrice
             */
            $displayingTheContentSQL = "
            SELECT users.id as user_id, posts.content, posts.created, users.alias as author_name, 
            COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
            FROM posts
            JOIN users ON  users.id=posts.user_id
            LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
            LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
            LEFT JOIN likes      ON likes.post_id  = posts.id 
            WHERE posts.user_id='$userId' 
            GROUP BY posts.id
            ORDER BY posts.created DESC  
            ";

            $enCoursDeTraitementWriting = isset($_POST['message']);
            if ($enCoursDeTraitementWriting) {
                echo "<pre>" . print_r($_POST, 1) . "</pre>";
                $postContent = $_POST['message'];
                $postContent = $mysqli->real_escape_string($postContent);

                $writingOnTheWallSQL = "INSERT INTO posts "
                    . "(id, user_id, content, created, parent_id) "
                    . "VALUES (NULL, "
                    . $userId . ", "
                    . "'" . $postContent . "', "
                    . "NOW(), "
                    . "NULL);";
                $lesInformationsWrite = $mysqli->query($writingOnTheWallSQL);

                if (!$lesInformationsWrite) {
                    echo ("Échec de la requete : " . $mysqli->error);
                }
            }
            // echo $lInstructionSql;
            // Etape 5 : execution

            $lesInformationsDisplayWall = $mysqli->query($displayingTheContentSQL);

            if (!$lesInformationsDisplayWall) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            /**
             * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
             */
            ?>
            <form name="new_post" action="wall.php?user_id=<?php echo $userId ?>" method="post">
                <input type='hidden' name='???' value='achanger'>
                <dl>
                    <dt><label for='message'>Message</label></dt>
                    <dd><textarea name='message' placeholder='Entrez votre message'></textarea></dd>
                </dl>
                <input type='submit'>

                <?php
                while ($posted = $lesInformationsDisplayWall->fetch_assoc()) {
                    echo "<pre>" . print_r($posted, 1) . "</pre>";
                ?>
                    <article>
                        <h3>
                            <time datetime='<?php echo $posted['created'] ?>'> <?php echo $posted['created'] ?></time>
                        </h3>
                        <address><a href="wall.php?user_id=<?php echo $posted['user_id'] ?>"> par <?php echo $posted['author_name'] ?> </a></address>
                        <div>
                            <?php foreach (explode(',', $posted['content']) as $paragraph) { ?>
                                </p> <?php echo $paragraph; ?></p>
                            <?php } ?>
                        </div>
                        <footer>
                            <small>🧋<?php echo $posted['like_number'] ?></small>
                            <?php foreach (explode('.', $posted['taglist']) as $tag) { ?>
                                <a href=" <?php echo '#' . $tag ?>"> <?php echo '#' . $tag . ' ' ?></a>
                            <?php } ?>
                        </footer>
                    </article>
                <?php } ?>
        </main>
    </div>
</body>

</html>