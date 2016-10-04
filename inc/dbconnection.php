<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbconnection = "localhost";//http://sql.futo.edu.ng
$database_dbconnection = "classalbum";
$username_dbconnection = "root";
$password_dbconnection = "mysql";

$dbconnection = mysqli_connect($hostname_dbconnection, $username_dbconnection, $password_dbconnection); 
if (!$dbconnection) {
    die("Connection failed: " . mysqli_connect_error());
}

?>