<?php 
    session_start();
    if (isset($_SESSION['found'])) {
        unset($_SESSION['found']);
        unset($_SESSION['cnpj']);
    }
    include("protect.php");
    protectAdmin();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Setor Administrativo</title>
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

        <style> 
            body { 
                background-color: black; 
            }
            label {
                color: darkSlateGray;
                font-size: 150%;
            }
            p {
                font-size: 125%;
                padding: 15px;
            }
        </style>
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


        <!------------------------------------ SETOR ADMINISTRATIVO ------------------------------------>


        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:400%; color:gold">Ambiente administrativo</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <!-- Alerta em caso de erro -->
                <?php if (!empty($error)) : ?>
                    <span class="text-danger"><?php echo $error; ?></span>
                <?php endif; ?>
                <br>
                <label for="id_cliente">Estabelecimentos</label> <br>
                <p><a href = "edit/editarEstabelecimento.php">Edite</a> ou <a href= "remove/removeEstabelecimento.php">remova</a> estabelecimentos cadastrados.</p>
                <br>
                <label for="id_cliente">Funcionários</label> <br>
                <p><a href = "insert/inserirFuncionario.php">Adicione</a>, <a href = "edit/editarFuncionario.php">edite</a> ou <a href= "remove/removeFuncionario.php">remova</a> Funcionários cadastrados.</p>
                <br>
            </div>
        </div>
</html>