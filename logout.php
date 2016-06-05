<?php 
 	
if(!isset($_SESSION)){session_start();}
unset($_SESSION['staffID']);
unset($_SESSION['role']);
session_destroy();
header("Location:index.php");
?>