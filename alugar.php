<?php

require 'config.php';

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

$user = mysqli_real_escape_string($db, $_POST['user']);
$livro = mysqli_real_escape_string($db, $_POST['livro']);

mysqli_query($db, "INSERT INTO alugueis (user, livro) VALUES ('$user', '$livro')");
echo json_encode(["status"=>"success","message"=>"Registro realizado com sucesso!"]);


mysqli_close($db);
?>