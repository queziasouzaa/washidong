<?php

require 'config.php';

/* connect to MySQL database */ 
$db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);

$livro = $_POST['id'];

$nome = $_POST['nome'];
if($nome == ""){
    echo json_encode(["status"=>"error","message"=>"Livro precisa ter um Nome!"]);
    return;
}
$codigo = $_POST['codigo'];
if($codigo == ""){
    echo json_encode(["status"=>"error","message"=>"Livro precisa ter um Código!"]);
    return;
}
$imagem = $_POST['imagem'];
if($imagem == ""){
    echo json_encode(["status"=>"error","message"=>"Livro precisa ter uma Imagem!"]);
    return;
}
$autor = $_POST['autor'];
if($autor == ""){
    echo json_encode(["status"=>"error","message"=>"Livro precisa ter um Autor!"]);
    return;
}
$editora = $_POST['editora'];
if($editora == ""){
    echo json_encode(["status"=>"error","message"=>"Livro precisa ter uma Editora!"]);
    return;
}
$categorias = $_POST['categorias'];
if($categorias == ""){
    echo json_encode(["status"=>"error","message"=>"Livro precisa ter ao menos uma Categoria!"]);
    return;
}
$quantidade = $_POST['quantidade'];
if($quantidade <= 0){
    echo json_encode(["status"=>"error","message"=>"Livro precisa ter uma quantidade maior que 0!"]);
    return;
}

mysqli_query($db, "UPDATE `livros` SET `nome`='$nome',`codigo`='$codigo',`imagem`='$imagem',`autor`='$autor',`editora`='$editora',`categorias`='$categorias',`quantidade`='$quantidade' WHERE id = $livro");

echo json_encode(["status"=>"success","message"=>"Livro Editado com Sucesso"]);


mysqli_close($db);
?>