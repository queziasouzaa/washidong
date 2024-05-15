<?php

require 'config.php';

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

$user = mysqli_real_escape_string($db, $_POST['user']);
$livro = mysqli_real_escape_string($db, $_POST['livro']);

$info = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM livros WHERE id = $livro"));

$nome = $info['nome'];
$codigo = $info['codigo'];
$imagem = $info['imagem'];
$autor = $info['autor'];
$editora = $info['editora'];
$categorias = $info['categorias'];
$rate = $info['rate'];
$quantidade = $info['quantidade'];

echo json_encode(["status"=>"success","nome"=>$nome,"codigo"=>$codigo,"imagem"=>$imagem,"autor"=>$autor,"editora"=>$editora,"categorias"=>$categorias,"rate"=>$rate,"quantidade"=>$quantidade]);


mysqli_close($db);
?>