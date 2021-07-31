<?php
include_once '..\database\database.ini.php';

$_SESSION['username'] = null;
$password = null;


if (isset($_POST['username'])) {
    session_start();
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $logonModel = pg_query($conn, "SELECT id, senha FROM public.\"cadastro\" WHERE username = '$_SESSION[username]'");
    $logon = pg_fetch_assoc($logonModel);
    $usernames = pg_num_rows($logonModel);
    
    if(!$usernames) {
        $error = "Usuário não encontrado.";
    } else {
        if ($logon['senha'] == $_SESSION['password']) {
            $_SESSION['username'] = $logon['id'];
        } else {
            $error = "Senha incorreta.";
        }
    }
    if (count($error) == 0 || !isset($error)) {
        $_SESSION['username'] = $logon['id'];
        echo "<script>alert('Login efetuado.');
        location.href='../../index.php';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title>Login</title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <link rel="icon" href="../assets/images/fevicon.png" type="image/gif" />
        <link rel="stylesheet" href="../assets/css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <style> body { background-color: black; } </style>
    </head>

    <body class="main-layout">
        <header>
            <div class="container">
                <div class="jumbotron" style="background-color: #e4dcd8">
                    <div class="logo">
                        <a href="../../index.php"><img src="../assets/images/logoStore.png" width="275" height="275"></a>
                    </div>
                    <div class="row">
                        <h1 class="display-4">Store Manager</h1><br>
                        <p style="font-family:'times new roman', monospace">by ET™ Ltda.</p>
                    </div>
                </div>
            </div>
        </header>


        <!------------------------------------ LOGIN ------------------------------------>

        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:300%; color:white">Login</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <form action="" method="post">
                    <!-- Alerta em caso de erro -->
                    <?php if (!empty($error)) : ?>
                        <span class="text-danger"><?php echo $error; ?></span>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Nome de usuário:</label>
                            <input class="form-control" value = "<?php echo $_SESSION['username'];?>" type="text" placeholder="Digite seu nome de usuário" name="username" required>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Senha:</label>
                            <input class="form-control" value = "<?php echo $password?>" type="password" placeholder="Digite sua senha" name="password" required>
                        </div>
                    </div>
                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Login" class="btn btn-success">Fazer Login </button>
                        <button type="button" onclick="window.location.href='insert/inserirPessoa.php'" class="btn btn-danger">Não tem conta?</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </body>



    

</html>