<?php
$DBSERVER = "localhost"; // Database server
$DBUSERNAME = 'u148872409_rootwa'; // Database username
$DBPASSWORD = "Quezia123*"; // Database password 
$DBNAME = "u148872409_subwa"; // Database name

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

// Check db connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_close($db);
?>