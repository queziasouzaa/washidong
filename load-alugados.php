<?php
    require 'config.php';

    // Connect to database server
    $con= mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME) or die (mysqli_error ());
    $input = $_POST['input'];
    $user = $_POST['user'];
    if(empty($input)){
        $events = mysqli_query($con,"SELECT a.*, b.data as dat FROM `alugueis` as b, `livros` as a WHERE b.user = '$user' and a.id = b.livro ORDER BY a.nome ASC");  
    }else{
        $events = mysqli_query($con,"SELECT a.*, b.data as dat FROM `alugueis` as b, `livros` as a WHERE b.user = '$user' and a.id = b.livro AND CONCAT(a.nome, a.autor, a.editora) LIKE '%$input%' ORDER BY a.nome ASC");  
    }
    
    while($event = mysqli_fetch_array($events)){
?>
<tr>
  <td><?php echo $event['codigo'];?></td>
  <td><div class="row"><div><img width="50" src="<?php echo $event['imagem']; ?>" style="margin-right: 20px;?>" alt=""></div><div><strong><?php echo $event['nome'];?></strong></div></div></td>
  <td>
    <div><?php echo $event['autor'];?></div>
  </td>
  <td>
    <div><?php echo $event['editora'];?></div>
  </td>
  <td><?php echo $event['dat'];?></td>
  <td>
    <div><button class="btn btn-danger" onclick="devolver(<?php echo $event['id'];?>)">Devolver</button></div>
  </td>
</tr>

<?php
}
?>