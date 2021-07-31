<?php
    
    if(!isset($_SESSION)) {
        session_start();
    }
    //include("protect.php");
    //protect();
    include '../../database/database.ini.php';
    $Username = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $Username = $_REQUEST['username'];

        $userModel = pg_query($conn, "SELECT * FROM public.\"cadastro\" WHERE username='$Username'");
        $user = pg_fetch_assoc($userModel);
        $users = pg_num_rows($userModel);
        if (!$users) {
            $error = "Username incorreto.";
        } else {
            if($user['id'] == $_SESSION['username']) {
                $id = $user['id'];
                pg_query($conn, "DELETE FROM public.\"cadastro\" WHERE id = $id");
                echo "<script>alert('Cadastro retirado com sucesso!')</script>";
                header ("location: ../logoff.php");
            } else {
                $error = "Username incorreto.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Excluir Cadastro</title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link rel="stylesheet" href="../../assets/css/responsive.css">
        <link rel="icon" href="../../assets/images/fevicon.png" type="image/gif" />
        <link rel="stylesheet" href="../../assets/css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <style> 
            body {
                background-color: black; 
            } 
            input[type=checkbox], input[type=radio] {
                width: 10%;
            }
        </style>
    </head>

    <body class="main-layout">
        <header>
            <div class="container">
                <div class="jumbotron" style="background-color: #e4dcd8">
                    <div class="logo">
                        <a href="../../../index.php"><img src="../../assets/images/logoStore.png" width="275" height="275"></a>
                    </div>
                    <div class="row">
                        <h1 class="display-4">Store Manager</h1><br>
                        <p style="font-family:'times new roman', monospace">by ET™ Ltda.</p>
                    </div>
                </div>
            </div>
        </header>

c
        <!------------------------------------ REMOVER CADASTRO ------------------------------------>


        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:300%; color:lightSkyBlue">Excluir cadastro</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <form action="" method="post">
                    <!-- Alerta em caso de erro -->
                    <?php if (!empty($error)) : ?>
                        <span class="text-danger"><?php echo $error; ?></span>
                    <?php endif; ?>

                    <h3>Você deve inserir o username da conta a ser removida.</h3>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Username:</label>
                        <input class="form-control" type="text" value="<?php echo $Username; ?>" placeholder="ex.: mario123" name="username" id="username" required>

                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Excluir conta" class="btn btn-danger"> Finalizar </button>
                        <button type="button" onclick="window.location.href='../../../index.php'" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</html>