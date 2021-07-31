<?php
    
    //include("protect.php");
    //protect();
    if(!isset($_SESSION)) {
        session_start();
    }
    include '../../database/database.ini.php';
    $isAdmin = false;
    $Cargo = null;
    $AdminPriv = null;

    $cadastro = pg_fetch_assoc(pg_query($conn, "SELECT * FROM public.\"cadastro\" WHERE id=$_SESSION[username]")); 
    $admins = pg_query($conn, "SELECT * FROM public.\"funcionario\" WHERE id=$_SESSION[username]");
    $admin = pg_fetch_assoc($admins);
    if (pg_num_rows($admins) != 0) {
        $Cargo = $admin['cargo'];
        $isWorker = true;
        $AdminPriv = $admin['adm']; 
    }

    $Username = $cadastro['username'];
    $Senha = $cadastro['senha'];
    $Nome = $cadastro['nome'];
    $Idade = $cadastro['idade'];
    $Endereco = $cadastro['endereco'];
    $Telefone = $cadastro['telefone'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $Senha = $_REQUEST['senha'];
        $Nome = $_REQUEST['nome'];
        $Idade = $_REQUEST['idade'];
        $Endereco = $_REQUEST['endereco'];
        $Telefone = $_REQUEST['telefone'];

        pg_query($conn, "UPDATE public.\"cadastro\" SET nome='$Nome', senha= '$Senha', idade = $Idade, endereco = '$Endereco', telefone = '$Telefone' WHERE id=$_SESSION[username]");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Perfil</title>
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


        <!------------------------------------ EDITAR FUNCIONÁRIO ------------------------------------>


        <div class="container">
        <div class="mb-4 extra_wrapper style1" style="text-align: center">
            <div class="col-auto mr-auto">
                <h2 style="font-size:300%; color:darkOrchid">Seu perfil</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <form action="" method="post">

                    <h3>Veja os dados do seu perfil e altere o que for necessário:</h3>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Nome:</label>
                        <input class="form-control" type="text" value="<?php echo $Nome; ?>" placeholder="ex.: Mário Daniel Farias" name="nome" id="Nome" required>
                    </div>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Idade:</label>
                        <input class="form-control" type="number" value="<?php echo $Idade; ?>" placeholder="ex.: 64" name="idade" id="idade" required>
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
                            <input class="form-control" type="text" value="<?php echo $Username; ?>" placeholder="ex.: mario123" name="username" id="Nome" disabled>
                        </div>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Senha:</label>
                            <input class="form-control" type="password" value="<?php echo $Senha; ?>" placeholder="Senha" name="senha" id="senha" requeired>
                        </div>
                    </div>
                    <?php if ($isWorker): ?>
                        <div class="col form-group">
                            <label style="color:black;" for="id_cliente">Cargo:</label>
                            <input class="form-control" type="text" value="<?php echo $Cargo; ?>" placeholder="Cargo" name="cargo" id="cargo" disabled>
                        </div>
                        <?php if ($AdminPriv) echo "<p>Você possui privilégios administrativos.</p>";?>
                    <?php endif;?>

                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Criar conta" class="btn btn-success"> Atualizar </button>
                        <button type="button" name="sair" onclick="window.location.href='../logoff.php';" style="background-color:yellow" class="btn btn-alert"> Desconectar </button>
                        <button type="button" onclick="window.location.href='../../../index.php'" class="btn btn-secondary">Cancelar</button>
                        <button type="button" onclick="window.location.href='../remove/removeCadastro.php'" class="btn btn-danger">Exluir minha conta</button>

                    </div>
                </form>
            </div>
        </div>
</html>