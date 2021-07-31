<?php
include_once '../../database/database.ini.php';

$Nome = null;
$Idade = null;
$Endereco = null;
$Telefone = null;
$Senha = null;
$Username = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Nome = $_REQUEST['nome'];
    $id = rand(0,9999);
    $Username = $_REQUEST['username'];
    $Idade = $_REQUEST['idade'];
    $Endereco = $_REQUEST['endereco'];
    $Telefone = $_REQUEST['telefone'];
    $Senha = $_REQUEST['senha'];

    $checkUsername = pg_query($conn, "SELECT username FROM public.\"cadastro\" WHERE username ='$Username'");

    if(pg_num_rows($checkUsername) == 0) {
    $cadastro = pg_query($conn, "INSERT INTO public.\"cadastro\" VALUES ('$Nome', $Idade, '$Endereco', '2021-04-26 16:00:00', '$Telefone','2021-04-26 16:00:00', '$Username', '$Senha', $id)");
        if ($cadastro) {
            echo "<script>alert('Sucesso! Sua conta foi criada.')</script>";
            header("../login.php");
        }
    } else {
        $error = "Nome de usuário já está em uso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Criar conta</title>
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

        <style> body { background-color: black; } </style>
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


        <!------------------------------------ CRIAR CONTA ------------------------------------>


        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:300%; color:white">Criar Conta</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <form action="" method="post">
                    <!-- Alerta em caso de erro -->
                    <?php if (!empty($error)) : ?>
                        <span class="text-danger"><?php echo $error; ?></span>
                    <?php endif; ?>

                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Nome:</label>
                        <input class="form-control" type="text" value="<?php echo $Nome; ?>" placeholder="ex.: Mário Daniel Farias" name="nome" id="Nome" required>
                    </div>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Idade:</label>
                        <input class="form-control" type="number" value="<?php echo $Idade; ?>" placeholder="ex.: 64" name="idade" id="Idade" required>
                    </div>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Endereço:</label>
                        <input class="form-control" type="text" value="<?php echo $Endereco; ?>" placeholder="ex.: Rua Barbacena Nº 290, Três Córregos" name="endereco" id="Endereco" required>
                    </div>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Telefone:</label>
                        <input class="form-control" type="text" value="<?php echo $Telefone; ?>" placeholder="ex.: (21) 98942-3581" name="telefone" id="Telefone">
                    </div>
                    <div class = "row">
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Nome de usuário:</label>
                            <input class="form-control" type="text" value="<?php echo $Username; ?>" placeholder="ex.: mario123" name="username" id="Nome" required>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Senha:</label>
                            <input class="form-control" type="password" value="<?php echo $Senha; ?>" placeholder="Senha" name="senha" id="senha">
                        </div>
                    </div>


                    <!--<div class="col form-group">
                        <label style="color:black;" for="id_cliente">Quantidade de acompanhantes:</label>
                        <input class="form-control" type="number" value="<?//php echo $num_acompanhantes; ?>" placeholder="ex.: 2" name="num_acompanhantes" id="Num_acompanhantes">
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Data e horário de entrada:</label>
                            <input class="form-control" type="text" value="<?//php echo $hora_entrada; ?>" placeholder="ex.: 2021-02-20 11:00:00" name="hora_entrada" id="Hora_entrada">
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Data e horário de saída:</label>
                            <input class="form-control" type="text" value="<?//php echo $hora_saida; ?>" placeholder="ex.: 2021-02-20 16:00:00" name="hora_saida" id="Hora_saida">
                        </div>
                    </div>-->

                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Criar conta" class="btn btn-success"> Finalizar </button>
                        <button type="button" onclick="window.location.href='../../../index.php'" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</html>