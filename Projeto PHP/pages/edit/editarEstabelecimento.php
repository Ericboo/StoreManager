<?php

    if (!isset($_SESSION)) {
        session_start();
    }
    
    include '../../database/database.ini.php';
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
                $max_funcionarios = $estabelecimento['max_funcionarios'];
                $_SESSION['cnpj'] = $estabelecimento['cnpj'];
                $max_clientes = $estabelecimento['max_clientes'];
                $lim_acompanhantes = $estabelecimento['lim_acompanhantes'];
                $lim_pessoas = $max_funcionarios + ($max_clientes * $lim_acompanhantes); 
                $hora_abertura = $estabelecimento['hora_abertura'];
                $hora_fechamento = $estabelecimento['hora_fechamento'];
            
            } else {
                
                $Nome = $_REQUEST['nome'];
                $max_funcionarios = $_REQUEST['max_funcionarios'];
                $max_clientes = $_REQUEST['max_clientes'];
                $lim_acompanhantes = $_REQUEST['lim_acompanhantes'];
                $lim_pessoas = $max_funcionarios + ($max_clientes * $lim_acompanhantes); 
                $hora_abertura = $_REQUEST['hora_abertura'];
                $hora_fechamento = $_REQUEST['hora_fechamento'];
                
                pg_query($conn, "UPDATE public.\"Estabelecimento\" SET nome ='$Nome', max_funcionarios= $max_funcionarios, max_clientes = $max_clientes, lim_acompanhantes = $lim_acompanhantes, lim_pessoas = $lim_pessoas, hora_abertura= '$hora_abertura', hora_fechamento='$hora_fechamento' WHERE cnpj ='$_SESSION[cnpj]'");
                echo "<script>alert('Estabelecimento editado com sucesso!')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Novo Funcionario</title>
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


        <!------------------------------------ EDITAR FUNCIONÁRIO ------------------------------------>


        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:300%; color:lightSkyBlue">Editar um Estabelecimento</h2>
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
                    <h3>Você deve inserir o CNPJ do estabelecimento a ser editado.</h3>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">CNPJ:</label>
                        <input class="form-control" type="text" value="" placeholder="ex.: 00.000.000/0000-0" name="cnpj" id="cnpj" required>
                    </div>
                    <?php endif;?>
                    <?php if ($_SESSION['found'] == 1): ?>
                        <h3>Verifique os dados atuais e altere o que for necessário.</h3>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Nome:</label>
                            <input class="form-control" type="text" value="<?php echo $Nome; ?>" placeholder="ex.: Fotografia encanto" name="nome" id="nome" required>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">CNPJ:</label>
                            <input class="form-control" type="text" value="<?php echo $_SESSION['cnpj']; ?>" placeholder="ex.: 00.000.000/0000-0" name="cnpj" id="cnpj" disabled>
                        </div>
                        <div class ="row">
                            <div class="col form-group">
                                <label style="color:black;" for="id_cliente">Máximo de funcionários:</label>
                                <input class="form-control" type="number" value="<?php echo $max_funcionarios; ?>" name="max_funcionarios" id="max_funcionarios"></p>
                            </div>
                            <div class="col form-group">
                                <label style="color:black;" for="id_cliente">Máximo de clientes:</label>
                                <input class="form-control" type="number" value="<?php echo $max_clientes; ?>" name="max_clientes"></p>
                            </div>
                            <div class="col form-group">
                                <label style="color:black;" for="id_cliente">Limite de acompanhantes:</label>
                                <input class="form-control" type="number" value="<?php echo $lim_acompanhantes;?>" name="lim_acompanhantes" id="lim_acompanhantes"></p>
                            </div>
                        </div>                        
                        <div class = "row">
                            <div class="col form-group">
                                <label style="color:black;" for="id_cliente">Hora de abertura:</label>
                                <input class="form-control" type="text" value="<?php echo $hora_abertura; ?>" name="hora_abertura" id="$hora_abertura"></p>
                            </div>
                            <div class="col form-group">
                                <label style="color:black;" for="id_cliente">Hora de fechamento:</label>
                                <input class="form-control" type="text" value="<?php echo $hora_fechamento; ?>" name="hora_fechamento" id="$hora_fechamento"></p>
                            </div>
                        </div>
                    <?php endif;?>

                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Criar conta" class="btn btn-success"> Finalizar </button>
                        <button type="button" onclick="window.location.href='../../../index.php'" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</html>