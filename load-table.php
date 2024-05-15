<?php
    require 'config.php';

    // Connect to database server
    $con= mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME) or die (mysqli_error ());
    $input = $_POST['input'];
    $user = $_POST['user'];
    $cargoCheck = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE id = $user"));
    $cargo = $cargoCheck['cargo'];
    if(empty($input)){
        $events = mysqli_query($con,"SELECT * FROM livros ORDER BY nome ASC");  
    }else{
        $events = mysqli_query($con,"SELECT * FROM livros WHERE CONCAT(nome, autor, editora) LIKE '%$input%' ORDER BY nome ASC");  
    }
    
    while($event = mysqli_fetch_array($events)){
      $id_livro = $event['id'];
      $statistics = mysqli_fetch_array(mysqli_query($con, "SELECT  NVL(SUM(nota), 0) as soma, COUNT(*) as votacoes FROM `notas` WHERE livro = $id_livro"));
      if($statistics['votacoes'] != 0){
        $soma = $statistics["soma"];
        $votacoes = $statistics["votacoes"];  
        $media = ceil($soma/$votacoes);
      }
      else{
        $media = 0;
      }
      
      $counts = mysqli_query($con,"SELECT count(*) as qtd FROM `alugueis` WHERE livro = '$id_livro'");
      $count = mysqli_fetch_array($counts);
      $qtd = $count['qtd'];
      $qtdg = $event['quantidade'];
      $row = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM notas WHERE user = $user AND livro = $id_livro"));
      if($row){
          $lido = true;
      }
      else{
          $lido = false;
      }
      $qtdr = $qtdg - $qtd;
      $buyeds = mysqli_query($con,"SELECT a.*, b.data as dat FROM `alugueis` as b, `livros` as a WHERE b.user = '$user' and b.livro = '$id_livro'");
      $buyed = mysqli_fetch_array($buyeds);
      
?>
<tr>
  <td><?php echo $event['codigo'];?></td>
  <td><div class="row"><div><img width="50" src="<?php echo $event['imagem']; ?>" style="margin-right: 20px;?>" alt=""></div><div><strong><?php echo $event['nome'];?></strong> <?php echo ($lido) ? '<br><span class="text-success">Lido <i class="fas fa-check"></i></span>' : '' ?></div></div></td>
  <td>
     <?php 
     if($media > 0){
     ?>
     <i class="rating__star fas fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 1) ? 's' : 'r' ; ?> fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 2) ? 's' : 'r' ; ?> fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 3) ? 's' : 'r' ; ?> fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 4) ? 's' : 'r' ; ?> fa-star"></i>
     <?php }
     else{
         echo "Sem avaliações...";
     } 
     ?>
  </td>
  <td><?php echo $qtdr." / ".$qtdg;?></td>
  <td>
    <div><?php echo $event['autor'];?></div>
  </td>
  <td>
    <div><?php echo $event['editora'];?></div>
  </td>
  <td class="row d-flex justify-content-center">
    <div><button class="btn btn-success m-1" onclick="alugar(<?php echo $event['id'];?>)" <?php if ($buyed || $qtdr == 0) echo "disabled";?>>Alugar<?php echo ($lido) ? ' Novamente' : '' ?></button></div>
    <?php
    if($cargo == "admin"){ ?>
    <div><button class="btn btn-warning m-1" onclick="editar(<?php echo $event['id'];?>)">Editar</button></div>
    <?php }?>
  </td>
</tr>

<?php
}
mysqli_close($con);
?>