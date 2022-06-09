<?php
  if (session_status()== 2) {
  $userId = intval($_SESSION['connected_id']);
}
?>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <img src="resoc1.png" alt="Logo de notre réseau social"/>
            <nav id="menu">
                <a href="news.php">Actualités🗣️</a>
                <a href="wall.php?user_id=<?php echo $userId;?>">Mur🧱</a>
                <a href="feed.php?user_id=<?php echo $userId;?>">Flux🌌</a>
                <a href="tags.php?tag_id=<?php echo $tagId;?>">Mots-clés🗝️</a>
                <a href="usurpedpost.php?user_id=<?php echo $userId;?>">Catfish🙀</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="settings.php?user_id=<?php echo $userId;?>">Paramètres</a></li>
                    <li><a href="followers.php?user_id=<?php echo $userId;?>">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=<?php echo $userId;?>">Mes abonnements</a></li>
                    <li><a href="destroy.php">Se déconnecter</a></li>
                </ul>
        </nav>
    </header>
</body>
</html>
