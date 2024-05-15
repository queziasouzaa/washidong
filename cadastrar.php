<?php

require 'config.php';

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

$nome = mysqli_real_escape_string($db, $_POST['nome']);
$imagem = mysqli_real_escape_string($db, $_POST['imagem']);
$codigo = mysqli_real_escape_string($db, $_POST['codigo']);
$autor = mysqli_real_escape_string($db, $_POST['autor']);
$editora = mysqli_real_escape_string($db, $_POST['editora']);
$quantidade = mysqli_real_escape_string($db, $_POST['quantidade']);


if(empty($codigo)){
    echo json_encode(["status"=>"error","message"=>"Código de produto não pode ser vazio!"]);
    return;
}
if(empty($nome)){
    echo json_encode(["status"=>"error","message"=>"Nome não pode ser vazio!"]);
    return;
}
if(empty($imagem)){
    echo json_encode(["status"=>"error","message"=>"Imagem não pode ser vazia!"]);
    return;
}
if(empty($autor)){
    echo json_encode(["status"=>"error","message"=>"Autor não pode ser vazio!"]);
    return;
}
if(empty($editora)){
    echo json_encode(["status"=>"error","message"=>"Editora não pode ser vazia!"]);
    return;
}
if(empty($quantidade)){
    echo json_encode(["status"=>"error","message"=>"Quantidade não pode ser vazia!"]);
    return;
}

mysqli_query($db, "INSERT INTO livros (nome, codigo, imagem, autor, editora, quantidade) VALUES ('$nome', '$codigo', '$imagem', '$autor', '$editora', '$quantidade')");
echo json_encode(["status"=>"success","message"=>"Registro realizado com sucesso!"]);


mysqli_close($db);
?>