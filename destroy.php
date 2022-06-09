<?php
session_start();
session_destroy();
header("location:login.php"); //redirection vers la page news 
exit("Vous êtes déconnecté.e");
?>
