<?php

session_start();

if(isset($_SESSION["tempid"])){
    $id = $_SESSION['tempid'];
}
else if(isset($_SESSION["userid"])){
    $id = $_SESSION['userid'];
}
else{
    header("Location: login.php");
}

if(isset($_GET["livro"])){
    $livroP = $_GET["livro"];
}
else{
    $livroP = "";
}

require 'config.php';

// Connect to database server
$con= mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME) or die (mysqli_error ());

if (isset($id)){
    // Select database
    //mysqli_select_db($con,"u563091889_logindb") or die(mysqli_error());
    $strSQL = "SELECT * FROM users WHERE id = '$id'" ;
    $rs = mysqli_query($con,$strSQL);
    $row = mysqli_fetch_array($rs);
    $name = $row['nome'];
    $email = $row['email'];
    $cargo = $row['cargo'];
    unset($row);
    
    
}
$countQ = mysqli_fetch_array(mysqli_query($con, "SELECT count(*) as num FROM categorias")) ;
$count = $countQ['num'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteca Virtual</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- Icon -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <!-- Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="home.php" class="nav-link">Home</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Biblioteca Virtual</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/avatars/avatar.svg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $name;?></a>
        </div>
        <div>
          <a href="logout.php" class="d-block btn btn-danger">Logout</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Procurar" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./home.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Livros</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./alugados.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alugados</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./recomendations.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recomendações</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Home</h1>
            <?php
            if($cargo == 'admin'){
            ?>
            <button data-toggle="modal" data-target="#modal_user_tab" class="btn btn-info" style="margin-left: 25px">Cadastrar novo Aluno</button>
            <?php
            }
            ?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Biblioteca Virtual</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <!-- CARD DE FUNÇÃO ↓ -->
        <?php
        if($cargo == 'admin'){
        ?>
        <a href="#" data-toggle="modal" data-target="#modal_lead_tab" class="text-decoration-none">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card-hover-shadow-2x mb-3 card bg-light d-flex justify-content-center" style="height: 75px!important; flex-direction: row!important;">
                    <div class="rm-border bg-light responsive-center text-center">
                        <i class="fas fa-plus text-info" style="font-size: 30px; margin-top: 20px; margin-right: 20px"></i>
                    </div>
                    <div class="widget-chart widget-chart2 text-center pt-0">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content">
                                <div class="widget-chart-flex">
                                    <div class="widget-numbers">
                                        <div class="widget-chart" style="margin-top: 3px!important;">
                                            <a href="#" data-toggle="modal" data-target="#modal_lead_tab" onclick="" class="text-decoration-none">
                                                <div class="text-info"><span style="font-size: 24px;"><b>Cadastrar Livro</b></span></div>
                                            </a>
                                            <div class="text-info"><span style="font-size: 16px; margin-top: -30px">Cadastrar novo livro</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="widget-chart-wrapper widget-chart-wrapper-lg he-auto opacity-10 m-0">
                                <!--<div id="dashboard-sparkline-4"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php
        }
        ?>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <div class="tabs-animation">
                <div>
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                      <div class="card-header border-transparent">
                        <h3 class="card-title">Lista de Livros</h3>
        
                        <div class="card-tools d-flex">
                          <input class="form-control" id="srci" type="search" placeholder="Procurar" value="<?php echo $livroP;?>"/>
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table m-0">
                            <thead>
                            <tr>
                              <th class="col-1">Cod. Produto</th>
                              <th class="col-3">Nome</th>
                              <th class="col-2">Nota</th>
                              <th class="col-1">Unidades Disponíveis</th>
                              <th class="col-1">Autor</th>
                              <th class="col-2">Editora</th>
                              <th class="col-2">Ações</th>
                            </tr>
                            </thead>
                            <tbody id="tabela">
                            
                            </tbody>
                          </table>
                        </div>
                        <!-- /.table-responsive -->
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer clearfix">
                      <!--  <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>-->
                      <!--  <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>-->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023-2032 <i>Quezia Souza</i>.</strong>
    Todos os direitos reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Versão</b> 1.0.0
    </div>
  </footer>
    
    
  <div class="modal fade bd-example-modal-xl" id="modal_lead_tab" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content ">
          <div class="modal-header text-center">
            <h4 class="modal-title white-text w-100 font-weight-bold py-2">Cadastrar Livro</h4>
            <button type="button" id="fechar_tabela" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>
        
          <div class="modal-body">
            <div id="tabela_head" class="row">
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Código de Produto</b></label>
                    <input type="text" id="inp1" placeholder="EX.: 123456">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Nome do livro</b></label>
                    <input type="name" id="inp2" placeholder="Nome">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Capa do livro (Link)</b></label>
                    <input type="text" id="inp5" placeholder="EX.: https://google.com.br/">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Quantidade em estoque</b></label>
                    <input type="text" id="inp3" placeholder="Quantidade">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Autor</b></label>
                    <input type="text" id="inp4" placeholder="EX.: Machado de Assis">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Editora</b></label>
                    <input type="text" id="inp6" placeholder="EX.: Panine">
                </div>
            </div>
          </div>

        
          <div class="modal-footer justify-content-center">
           <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
           <button type="button" class="btn btn-success" onclick="cadastrar()">Cadastrar</button>
           </div>
        </div>
      </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="modal_user_tab" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content ">
          <div class="modal-header text-center">
            <h4 class="modal-title white-text w-100 font-weight-bold py-2">Cadastrar Usuário</h4>
            <button type="button" id="fechar_tabela" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>
        
          <div class="modal-body">
            <div id="tabela_head" class="row">
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Nome</b></label>
                    <input type="name" id="inpn" placeholder="Nome aqui...">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Email</b></label>
                    <input type="email" id="inpe" placeholder="Email aqui...">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Senha</b></label>
                    <input type="password" id="inps" placeholder="Senha aqui...">
                </div>
            </div>
          </div>

        
          <div class="modal-footer justify-content-center">
           <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
           <button type="button" class="btn btn-success" onclick="cadastrar_user()">Cadastrar</button>
           </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade bd-example-modal-xl" id="modal_edit_tab" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content ">
          <div class="modal-header text-center">
            <h4 class="modal-title white-text w-100 font-weight-bold py-2">Editar Livro</h4>
            <button type="button" id="fechar_tabela" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>
        
          <div class="modal-body">
            <div id="tabela_head" class="row">
                <input type="hidden" id="inpEid">
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Nome</b></label>
                    <input type="name" id="inpEnome">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Código</b></label>
                    <input type="name" id="inpEcodigo">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Imagem</b></label>
                    <input type="name" id="inpEimagem">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Autor</b></label>
                    <input type="name" id="inpEautor">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Editora</b></label>
                    <input type="name" id="inpEeditora">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Quantidade</b></label>
                    <input type="number" id="inpEquantidade">
                </div>
                <div class="form-group col-md-6 d-flex flex-column">
                    <label class="text-info" ><b>Categorias</b></label>
                    <div class="d-flex flex-column">
                        <?php
                            $strSQL = "SELECT * FROM categorias" ;
                            $rs = mysqli_query($con,$strSQL);
                            while($row = mysqli_fetch_array($rs)){
                                $catName = $row['nome'];
                                $catId = $row['id'];
                                
                        ?>
                        <div>
                        <input type="checkbox" id="inpEcategoria<?php echo $catId; ?>" value="<?php echo $catId; ?>" />
                        <label for="subscribeNews"> <?php echo $catName; ?> </label>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
          </div>

        
          <div class="modal-footer justify-content-center">
           <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
           <button type="button" class="btn btn-success" onclick="editar_livro()">Salvar</button>
           </div>
        </div>
      </div>
    </div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script>
    //triggered when modal is about to be shown
    $('#modal_valor_tab').on('show.bs.modal', function(e) {
    
        //get data-id attribute of the clicked element
        var bookId = $(e.relatedTarget).data('book-id');
    
        //populate the textbox
        $(e.currentTarget).find('input[name="bookId"]').val(bookId);
    });
</script>
<script>
    function cadastrar(){
            
        let nome = $('#inp2').val();
        let codigo = $('#inp1').val();
        let quantidade = $('#inp3').val();
        let autor = $('#inp4').val();
        let editora = $('#inp6').val();
        let imagem = $('#inp5').val();
        
        $.ajax({
          type: "POST",
          url: "verify.php",
            cache: false,
          data: {
            nome : nome,
            codigo: codigo,
            quantidade: quantidade,
            autor: autor,
            editora: editora,
            imagem: imagem
          },
          success: function(data) {
            let dados = JSON.parse(data);
            if(dados['status'] == "success"){
                 $.ajax({
                    type: "POST",
                    url: 'cadastrar.php',
                    data:{
                      nome : nome,
                      codigo: codigo,
                      quantidade: quantidade,
                      autor: autor,
                      editora: editora,
                      imagem: imagem
                    },
                    cache: false,
                    success: function(data) {
                        let dados = JSON.parse(data);
                        if(dados['status'] == "success"){
                          swal.fire("Success",dados['message'],"success");
                            $('#inp1').val('');
                            $('#inp5').val('');
                            $('#inp6').val('');
                            $('#inp2').val('');
                            $('#inp3').val('');
                            $('#inp4').val('');
                        }else{
                          swal.fire("Error!",dados['message'],"error");
                        }
                    }
                });
            }else if(dados['status'] == "warning"){
                Swal.fire({
                  title: 'Erro encontrado',
                  text: dados['message'],
                  icon: 'warning',
                  showCancelButton: true,
                  showConfirmButton: false,
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'Editar'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: 'cadastrar.php',
                        data:{
                          nome : nome,
                          codigo: codigo,
                          quantidade: quantidade,
                          autor: autor,
                          editora: editora,
                          imagem: imagem
                        },
                        cache: false,
                        success: function(data) {
                            let dados = JSON.parse(data);
                            if(dados['status'] == "success"){
                              swal.fire("Success",dados['message'],"success");
                                $('#inp1').val('');
                                $('#inp2').val('');
                                $('#inp3').val('');
                                $('#inp2').val('');
                                $('#inp3').val('');
                                $('#inp4').val('');
                            }else{
                              swal.fire("Error!",dados['message'],"error");
                            }
                        }
                    });
                  }
                })
            }else{
              swal.fire("Error!",dados['message'],"error");
            }
          }
        });
    }
</script>
<script>
  function cadastrar_user(){
            
    let nome = $('#inpn').val();
    let email = $('#inpe').val();
    let senha = $('#inps').val();
    
    $.ajax({
      type: "POST",
      url: "registrar_user.php",
        cache: false,
      data: {
        nome : nome,
        email: email,
        senha: senha
      },
      success: function(data) {
        let dados = JSON.parse(data);
        if(dados['status'] == "success"){
          swal.fire("Success",dados['message'],"success");
        }
        else{
          swal.fire("Error!",dados['message'],"error");
        }
      }
    });
  }
  function editar_livro(){
    
    let id = $('#inpEid').val();         
    let nome = $('#inpEnome').val();
    let codigo = $('#inpEcodigo').val();
    let imagem = $('#inpEimagem').val();
    let autor = $('#inpEautor').val();
    let editora = $('#inpEeditora').val();
    let quantidade = $('#inpEquantidade').val();
    let categorias = "";
    
    for(let x = 1; x <= <?php echo $count?> ; x++){
        if($('#inpEcategoria' + x).is(":checked")){
            if(categorias == ""){
                categorias = categorias + `${x}`;
            }
            else{
                categorias = categorias + `;${x}`;
            }
        }
    }
    
    $.ajax({
      type: "POST",
      url: "editarLivro.php",
        cache: false,
      data: {
        id: id,
        nome : nome,
        codigo: codigo,
        imagem: imagem,
        autor: autor,
        editora: editora,
        quantidade: quantidade,
        categorias: categorias
      },
      success: function(data) {
        let dados = JSON.parse(data);
        if(dados['status'] == "success"){
          swal.fire("Success",dados['message'],"success");
          $('#modal_edit_tab').modal('hide');
        }
        else{
          swal.fire("Error!",dados['message'],"error");
        }
      }
    });
  }
</script>
<script>
  function alugar(livro){
            
    let user = <?php echo $id;?>
    
    $.ajax({
      type: "POST",
      url: "alugar.php",
        cache: false,
      data: {
        user : user,
        livro: livro,
      },
      success: function(data) {
        let dados = JSON.parse(data);
        if(dados['status'] == "success"){
          swal.fire("Success",dados['message'],"success");
        }
        else{
          swal.fire("Error!",dados['message'],"error");
        }
      }
    });
  }
  function editar(livro){
      
    
    let user = <?php echo $id;?>
    
    $.ajax({
      type: "POST",
      url: "getLivro.php",
        cache: false,
      data: {
        user : user,
        livro: livro,
      },
      success: function(data) {
        let dados = JSON.parse(data);
        if(dados['status'] == "success"){
            $('#inpEid').val(livro);
            $('#inpEnome').val(dados['nome']);
            $('#inpEcodigo').val(dados['codigo']);
            $('#inpEimagem').val(dados['imagem']);
            $('#inpEautor').val(dados['autor']);
            $('#inpEeditora').val(dados['editora']);
            $('#inpEcategorias').val(dados['categorias']);
            
            for(let y = 1; y <= <?php echo $count;?> ; y++){
                $(`#inpEcategoria${y}`).prop('checked', false);
            }
            let categorias = dados['categorias'].split(';');
            for(let x = 0; x < categorias.length; x++){
                $(`#inpEcategoria${categorias[x]}`).prop('checked', true);
            }
            $('#inpEquantidade').val(dados['quantidade']);
            $('#modal_edit_tab').modal('toggle');
            $('#modal_edit_tab').modal('show'); 
        }
        else{
          swal.fire("Error!",dados['message'],"error");
        }
      }
    });
  }
</script>
<script>
    setInterval(function(){
       var input = document.getElementById("srci").value;
       $.ajax({
          type: "POST",
          data : {
            tipo: "aguardo",
            input: input,
            user: <?php echo $id;?>
          },
          url: "load-table.php",
            cache: false,
          success: function(data) {
            $('#tabela').html(data);
          }
        });
  }, 1000);
</script>
</body>
</html>
<?php
mysqli_close($con);
?>