<?php

$error = '';
$fire = 0;
session_start();
if (isset($_SESSION["userid"])){
    header("location: home.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    session_start();
    require 'config.php';
    
    /* connect to MySQL database */ 
    $db = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME);
    
    // Check db connection
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    // Connect to database server
    $con= mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME) or die (mysqli_error ());

    // validate if email is empty
    if (empty($email)) {
        $error .= '<p class="error" style="color:red;">Por favor, insira o email.</p>';
    }

    // validate if password is empty
    if (empty($password)) {
        $error .= '<p class="error" style="color:red;">Por favor, insira a senha.</p>';
    }
    

    if (empty($error)) {
        $strSQL = "SELECT * FROM users WHERE email = '$email'" ;
        $rs = mysqli_query($con,$strSQL);
        $row = mysqli_fetch_array($rs);
        if ($row) {
            
            if (password_verify($password, $row['senha'])) {
                if(isset($_POST['check'])){
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION['username'] = $row['nome'];
                    $_SESSION['usermail'] = $row['email'];
                    $_SESSION['user'] = $row;
                }else{
                    $_SESSION['tempid'] = $row['id'];
                }
                // Redirect the user to welcome page
                header("location: home.php");
                exit;
            } 
            else {
                $error .= '<p class="error" style="color:red;">A senha não é válida.</p>';
            }
            
        } 
        else {
            $error .= '<p class="error" style="color:red;">Não existe nenhum usuário com este endereço de email.</p>';
        }
        
    }
    // Close connection
    mysqli_close($db);
}
?>
<!doctype html>
<html lang="pt-BR">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login - Biblioteca</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Biblioteca">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="icon" href="assets/images/favicon.png" />
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <meta name="google-signin-client_id"
        content="351176805555-bg1gm1vouirfrag5rj4anegvjqdl0a5i.apps.googleusercontent.com">

    <link href="main.d810cf0ae7f39f28f336.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-4">
                        <div class="slider-light">
                            <div class="slick-slider">
                                <!-- <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-plum-plate"
                                        tabindex="-1">
                                        <div class="slide-img-bg"
                                            style="background-image: url('assets/images/banner1.jpg');"></div>
                                        <div class="slider-content">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark"
                                        tabindex="-1">
                                        <div class="slide-img-bg"
                                            style="background-image: url('assets/images/banner1.jpg');">
                                        </div>
                                        <div class="slider-content">
                                        </div>
                                    </div>
                                </div> -->
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-sunny-morning"
                                        tabindex="-1">
                                        <div class="slide-img-bg"
                                            style="background-image: url('assets/images/banner1.jpg');">
                                        </div>
                                        <div class="slider-content">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo"></div>
                            <h4 class="mb-0">
                                <span class="d-block">Bem vindo,</span>
                                <span>Faça login com sua conta da biblioteca.</span>
                            </h4>
                            <?php echo $error;?>
                            <div class="divider row"></div>
                            <div>
                                <form action="" method="POST">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail" class="">Email</label>
                                                <input name="email" id="exampleEmail" placeholder="Email aqui..."
                                                    type="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="examplePassword" class="">Senha</label>
                                                <input name="password" id="examplePassword"
                                                    placeholder="Senha Aqui..." type="password" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative form-check">
                                        <input name="check" id="exampleCheck" type="checkbox" class="form-check-input">
                                        <label for="exampleCheck" class="form-check-label">Mantenha-me Logado!</label>
                                    </div>
                                    <div class="divider row"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="ml-auto">
                                            <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Entrar">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script>
    </script>
</body>

</html>