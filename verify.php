<?php

require 'config.php';

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

$nome = mysqli_real_escape_string($db, $_POST['nome']);
$codigo = mysqli_real_escape_string($db, $_POST['codigo']);

$verify = mysqli_query($db,"SELECT * FROM livros WHERE codigo = '$codigo'");

$check = mysqli_fetch_array($verify);

$len = is_null($check['$id']) ? 0 : 1;

if($len != 0){
    echo json_encode(["status"=>"warning","message"=>"Código de produto já cadastrado!"]);
}
else{
    echo json_encode(["status"=>"success","message"=>"Código de produto disponível!"]);
}


mysqli_close($db);
?>