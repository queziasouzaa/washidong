<?php

require 'config.php';

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$senha = password_hash($senha, PASSWORD_BCRYPT);
$profile = "assets/images/avatars/avatar.svg";

mysqli_query($db, "INSERT INTO users (nome, senha, email) VALUES ('$nome', '$senha', '$email')");
echo json_encode(["status"=>"success","message"=>"Registro realizado com sucesso!"]);

mysqli_close($db);
?>