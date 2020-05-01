<?php 
session_start();
$_SESSION['login'] = false;
$_SESSION['user']=0;
session_destroy();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header('location: index.php');
