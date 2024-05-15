<?php

require 'config.php';

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

$user = mysqli_real_escape_string($db, $_POST['user']);
$livro = mysqli_real_escape_string($db, $_POST['livro']);
$nota = $_POST['nota'];
if($nota == 0){
    echo json_encode(["status"=>"error","message"=>"Nota precisa ser maior que 0!"]);
    return;
}

$row = mysqli_fetch_array(mysqli_query($db, "SELECT * from notas WHERE user = $user AND livro = $livro"));

if($row){
    mysqli_query($db, "UPDATE `notas` SET `nota`=$nota WHERE user = $user AND livro = $livro"); 
}
else{
    mysqli_query($db, "INSERT INTO `notas`(`user`, `livro`, `nota`) VALUES ($user, $livro, $nota)"); 
}

mysqli_query($db, "DELETE FROM `alugueis` WHERE user = '$user' AND livro = '$livro'");
echo json_encode(["status"=>"success","message"=>"Registro realizado com sucesso!"]);


mysqli_close($db);
?>