<?php

    if (!isset($_SESSION)) {
        session_start();
    }

    include 'protect.php';
    protect();
    
    include '../database/database.ini.php';
    if (!isset($_SESSION['found'])) {
        $_SESSION['found'] = 0;
    }
    if (!isset($_SESSION['cnpj'])) {
        $_SESSION['cnpj'] = null;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if ($_SESSION['found'] == 0) {
            $_SESSION['cnpj'] = $_REQUEST['cnpj'];
            $estabelecimentoModel = pg_query($conn, "SELECT * FROM public.\"Estabelecimento\" WHERE cnpj='$_SESSION[cnpj]'");
            $estabelecimento = pg_fetch_assoc($estabelecimentoModel);
            if (pg_num_rows($estabelecimentoModel) == 0 && $_SESSION['found'] == 0) {
                $error = "Estabelecimento não encontrado!";
            }
        }

        if (isset($error) == 0) {
            if ($_SESSION['found'] == 0) {

                $_SESSION['found'] = 1;
                $Nome = $estabelecimento['nome'];
                $_SESSION['cnpj'] = $estabelecimento['cnpj'];
                $lim_acompanhantes = $estabelecimento['lim_acompanhantes'];
                $hora_abertura = $estabelecimento['hora_abertura'];
                $hora_fechamento = $estabelecimento['hora_fechamento'];
                $cliente = pg_fetch_assoc(pg_query($conn, "SELECT entrada, saida FROM public.\"cadastro\" WHERE id ='$_SESSION[username]'"));
                $entrada = $cliente['entrada'];
                $saida = $cliente['saida'];
                $num_acompanhantes = 0;
            
            } else {
                
                $cliente = pg_fetch_all(pg_query($conn, "SELECT * FROM public.\"cliente\" WHERE id='$_SESSION[username]'"));
                $entrada = $_REQUEST['entrada'];
                $saida = $_REQUEST['saida'];
                $num_acompanhantes = $_REQUEST['num_acompanhantes'];

                if (!$cliente) {
                    pg_query($conn, "INSERT INTO public.\"cliente\" VALUES ($num_acompanhantes, '$_SESSION[cnpj]', $_SESSION[username]);");
                    echo "<script>alert('Visita agendada com sucesso!')</script>";
                    pg_query($conn, "UPDATE public.\"cadastro\" SET entrada='$entrada', saida='$saida' WHERE id=$_SESSION[username];");
                    header("location: ../../index.php");
                } else {
                    pg_query($conn, "UPDATE public.\"cliente\" SET id=$_SESSION[username], num_acompanhantes=$num_acompanhantes, est_cadastrado='$_SESSION[cnpj]' WHERE id=$_SESSION[username];");
                    echo "<script>alert('Visita agendada com sucesso!')</script>";
                    header("location: ../../index.php");
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Agendar visita</title>
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
                        <a href="../../index.php"><img src="../assets/images/logoStore.png" width="275" height="275"></a>
                    </div>
                    <div class="row">
                        <h1 class="display-4">Store Manager</h1><br>
                        <p style="font-family:'times new roman', monospace">by ET™ Ltda.</p>
                    </div>
                </div>
            </div>
        </header>


        <!------------------------------------ EDITAR FUNCIONÁRIO ------------------------------------>


        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:300%; color:lightSkyBlue">Agendar acesso</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <form action="" method="post">
                    <!-- Alerta em caso de erro -->
                    <?php if (!empty($error)) : ?>
                        <span class="text-danger"><?php echo $error; ?></span>
                    <?php endif; ?>
                    
                    <?php if ($_SESSION['found'] == 0): ?>
                        <h3>insira o CNPJ do estabelecimento desejado.</h3>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">CNPJ:</label>
                            <input class="form-control" type="text" value="" placeholder="ex.: 00.000.000/0000-0" name="cnpj" id="cnpj" required>
                        </div>
                    <?php endif;?>
                    <?php if ($_SESSION['found'] == 1): ?>
                        <h3>Verifique os dados e registre-se caso seja o estabelecimento desejado.</h3>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Nome:</label>
                            <input class="form-control" type="text" value="<?php echo $Nome?>" name="nome" id="nome" disabled>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Limite de acompanhantes:</label>
                            <input class="form-control" type="text" value="<?php echo $lim_acompanhantes?>" name="lim_acompanhantes" id="nome" disabled>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Hora de abertura:</label>
                            <input class="form-control" type="text" value="<?php echo $hora_abertura?>" name="hora_abertura" id="hora_abertura" disabled>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Hora de fechamento:</label>
                            <input class="form-control" type="text" value="<?php echo $hora_fechamento?>" name="hora_fechamento" id="hora_fechamento" disabled>
                        </div>
                        <h3>Defina os dados relativos à sua visita:</h3>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Entrada</label>:</label>
                            <input class="form-control" type="text" value="<?php echo $entrada?>" name="entrada" id="entrada" required>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Saída:</label>
                            <input class="form-control" type="text" value="<?php echo $saida?>" name="saida" id="saida" required>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Número de acompanhantes:</label>
                            <input class="form-control" type="text" value="<?php echo $num_acompanhantes?>" name="num_acompanhantes" id="num_acompanhantes" required>
                        </div>
                        
                    <?php endif;?>

                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Criar conta" class="btn btn-success"> Finalizar </button>
                        <button type="button" onclick="window.location.href='../../index.php'" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</html>