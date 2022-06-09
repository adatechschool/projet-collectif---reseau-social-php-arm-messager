<?php
session_start();
?>

<!doctype html>
<html lang="fr">

<head>
    <title>ReSoC - Les message par mot-clé</title>
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
        <?php
        /**
         * Cette page est similaire à wall.php ou feed.php 
         * mais elle porte sur les mots-clés (tags)
         */
        /**
         * Etape 1: Le mur concerne un mot-clé en particulier
         */
        $tagId = intval($_GET['tag_id']);
        ?>


        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom du mot-clé
             */
            $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $tag = $lesInformations->fetch_assoc();
            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous
            //echo "<pre>" . print_r($tag, 1) . "</pre>";
            ?>
            <img src="keys.png" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p><?php echo $tag['label'] ?>
                    (n° <?php echo $tagId ?>)
                </p>

            </section>
        </aside>
        <main>
            <?php
            /**
             * Etape 3: récupérer tous les messages avec un mot clé donné
             */
            $laQuestionEnSql = "
                    SELECT posts.content,users.id as user_id,
                    posts.created,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts_tags as filter 
                    JOIN posts ON posts.id=filter.post_id
                    JOIN users ON users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE filter.tag_id = '$tagId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            /**
             * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
             */
            while ($post = $lesInformations->fetch_assoc()) {

                //echo "<pre>" . print_r($post, 1) . "</pre>";
            ?>
                <article>
                    <h3>
                    <time datetime='<?php echo $post['created'] ?>' >
                            <?php
                            setlocale(LC_TIME, "fr_FR","French");
                            echo strftime("%d %B %G à %Hh%M", strtotime($post['created']));?>
                    </time>
                        </h3>
                        <address><a href="wall.php?user_id=<?php echo $post['author_id'] ?>"><?php echo "par ".$post['author_name'] ?></a></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>
                        <footer>
                            <small>🧋 <?php echo $post['like_number'] ?></small>
                            <?php
                            $array = explode(',', $post['taglist']);
                            foreach ($array as $valeur) {
                                echo "<a href=''>#$valeur, </a>";}
                            ?>
                        </footer>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>