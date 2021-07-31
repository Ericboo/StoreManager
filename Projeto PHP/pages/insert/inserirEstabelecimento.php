<?php
include_once '../../database/database.ini.php';

session_start();

$Nome = null;
$CNPJ = null;
$max_funcionarios = null;
$max_clientes = null;
$lim_acompanhantes = null;
$hora_abertura = null;
$hora_fechamento = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!$lim_acompanhantes) {
        $lim_acompanhantes = 0;
    }
    unset($_SESSION['found']);
    $Nome = $_REQUEST['nome'];
    $CNPJ = $_REQUEST['cnpj'];
    $max_funcionarios = $_REQUEST['max_funcionarios'];
    $max_clientes = $_REQUEST['max_clientes'];
    $lim_acompanhantes = $_REQUEST['lim_acompanhantes'];
    $hora_abertura = $_REQUEST['hora_abertura'];
    $hora_fechamento = $_REQUEST['hora_fechamento'];

    $checkCnpj = pg_query($conn, "SELECT cnpj FROM public.\"Estabelecimento\" WHERE cnpj = '$CNPJ'");
    if (pg_num_rows($checkCnpj) != 0) {
        $error = "CNPJ já cadastrado!";
    } else {
        $lim_pessoas = $max_funcionarios + ($max_clientes * ($lim_acompanhantes + 1));
        $estabelecimentoModel = pg_query($conn, "INSERT INTO public.\"Estabelecimento\" VALUES ('$Nome', '$CNPJ', $lim_pessoas, $max_funcionarios, $max_clientes, $lim_acompanhantes,'$hora_abertura', '$hora_fechamento')");
        echo "<script>alert('Estabelecimento cadastrado com sucesso!')</script>";
    }
}?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Cadastrar Estabelecimento</title>
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


        <!------------------------------------ CADASTRAR ESTABELECIMENTO ------------------------------------>


        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:300%; color:white">Novo estabelecimento</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <form action="" method="post">
                    <!-- Alerta em caso de erro -->
                    <?php if (!empty($error)) : ?>
                        <span class="text-danger"><?php echo $error; ?></span>
                    <?php endif; ?>

                    <div class="form-group">
                        <label style="color: black" for="id_cliente">Nome do estabelecimento:</label> <br>
                        <input type="text" value="<?php echo $Nome; ?>" class="form-control" placeholder="ex.: Fotografia Encanto" name="nome" id="Nome" required>
                    </div>

                    <div class="form-group">
                        <label style="color: black" for="id_cliente">CNPJ:</label> <br>
                        <input type="text" value="<?php echo $CNPJ; ?>" class="form-control" placeholder="ex.: 00.000.000/0000-00" name="cnpj" required>
                    </div>
                    
                    <div class="row">
                        <div class="col form-group">
                            <label style="color: black" for="id_cliente">Quantidade máxima de funcionários:</label> <br>
                            <input type="number" value="<?php echo $max_funcionarios; ?>"  class="form-control" placeholder="ex.: 4" name="max_funcionarios" required>
                        </div>

                        <div class="col form-group">
                            <label style="color: black" for="id_cliente">Quantidade máxima de clientes:</label> <br>
                            <input type="number" value="<?php echo $max_clientes; ?>" class="form-control" placeholder="ex.: 12" name="max_clientes" required>
                        </div>
                        <div class="col form-group">
                            <label style="color: black" for="id_cliente">Limite de acompanhantes:</label> <br>
                            <input type="number" value="<?php echo $lim_acompanhantes; ?>" placeholder="ex.: 2" class="form-control" name="lim_acompanhantes">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col form-group">
                            <label style="color: black" for="id_cliente">Horário de abertura:</label> <br>
                            <input type="text" value="<?php echo $hora_abertura; ?>"  class="form-control" placeholder="ex.: 08:00:00" name="hora_abertura" required>
                        </div>

                        <div class="col form-group">
                            <label style="color: black" for="id_cliente">Horário de fechamento:</label> <br>
                            <input type="text" value="<?php echo $hora_fechamento; ?>" class="form-control" placeholder="ex.: 22:00:00" name="hora_fechamento" required>
                        </div>
                    </div>
                    
                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Cadastrar" class="btn btn-success"> Cadastrar </button>
                        <button type="button" onclick="window.location.href='../../../index.php'" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</html>