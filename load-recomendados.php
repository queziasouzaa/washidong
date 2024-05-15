<?php
    require 'config.php';

    // Connect to database server
    $con= mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME) or die (mysqli_error ());
    $input = $_POST['input'];
    $user = $_POST['user'];
    
    $events = mysqli_query($con,"SELECT
                                    l.id AS id,
                                    l.codigo AS codigo,
                                    l.imagem AS imagem,
                                    l.nome AS nome,
                                    l.autor AS autor,
                                    l.editora AS editora,
                                    l.categorias AS categorias,
                                    l.data AS data,
                                    l.quantidade AS quantidade,
                                    COALESCE(SUM(n.nota), 0) AS soma,
                                    COUNT(n.id) AS votos,
                                    CASE 
                                        WHEN COUNT(n.id) > 0 THEN CEILING(COALESCE(SUM(n.nota), 0) / COUNT(n.id))
                                        ELSE 0 
                                    END AS media
                                FROM
                                    livros l
                                LEFT JOIN
                                    notas n ON l.id = n.livro
                                GROUP BY
                                    l.id, l.nome, l.autor, l.editora, l.categorias, l.data, l.quantidade
                                ORDER BY
                                    media DESC;");
    
    while($event = mysqli_fetch_array($events)){
      $id_livro = $event['id'];
      $soma = $event['soma'];
      $votos = $event['votos'];
      $nome = $event['nome'];
      $row = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM notas WHERE user = $user AND livro = $id_livro"));
      if($row){
          $lido = true;
      }
      else{
          $lido = false;
      }
      $categorias = $event['categorias'];
      
      $lista = explode(";", $categorias);
      if($votos > 0){
          $media = ceil($soma/$votos);
      }
      else{
          $media = 0;
      }
      if($media > 0){
      
?>
<tr>
  <td><?php echo $event['codigo'];?></td>
  <td><div class="row"><div><img width="50" src="<?php echo $event['imagem']; ?>" style="margin-right: 20px;?>" alt=""></div><div><strong><?php echo $event['nome'];?></strong> <?php echo ($lido) ? '<br><span class="text-success">Lido <i class="fas fa-check"></i></span>' : '' ?></div></div></td>
  <td>
     <i class="rating__star fas fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 1) ? 's' : 'r' ; ?> fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 2) ? 's' : 'r' ; ?> fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 3) ? 's' : 'r' ; ?> fa-star"></i>
     <i class="rating__star fa<?php echo ($media > 4) ? 's' : 'r' ; ?> fa-star"></i>
  </td>
  <td><?php echo $votos;?></td>
  <td>
      <div class="d-flex justify-content-center">
      <?php for($i = 0; $i < count($lista); $i ++){
        $cat = mysqli_fetch_array(mysqli_query($con,"SELECT nome FROM categorias WHERE id = $lista[$i]"));
        $catName = $cat['nome'];
      ?>
        <div class="m-1"><span class="btn btn-info"><?php echo $catName;?></span></div>
      <?php 
        }
      ?>
      </div>
  </td>
  <td>
    <div><button class="btn btn-success" onclick="window.location.href='home.php?&livro=<?php echo$event['nome'];?>'";?>Procurar</button></div>
  </td>
</tr>

<?php
    }
}
mysqli_close($con);
?>