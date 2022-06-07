<?php
session_start();
session_destroy(); 
header("location:news.php"); 
exit("Vous êtes déconnecté.e");
?>

