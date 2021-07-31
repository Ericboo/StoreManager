<?php
    
    //include("protect.php");
    //protect();
    include '../../database/database.ini.php';
    $Username = null;
    $Cargo = null;
    $Admin = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['check'])) {
            $Admin = 1;
        } else {
            $Admin = 0;
        }
        $Cargo = $_REQUEST['cargo'];
        $Username = $_REQUEST['username'];

        $funcionarioModel = pg_query($conn, "SELECT * FROM public.\"cadastro\" WHERE username='$Username'");
        $funcionario = pg_fetch_assoc($funcionarioModel);
        $users = pg_num_rows($funcionarioModel);
        if (!$users) {
            $error[] = "Username não encontrado.";
        } else {
            $id = $funcionario['id'];
            pg_query($conn, "UPDATE public.\"funcionario\" SET cargo ='$Cargo', adm= $Admin WHERE id = $id");
            echo "<script>alert('Funcionário editado com sucesso!')</script>";
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
                <h2 style="font-size:300%; color:lightSkyBlue">Editar um Funcionário</h2>
            </div>
        </div>

        <div class="container_12">
            <div class="card-body mb-4" style="background-color: #F4F6FC;">
                <form action="" method="post">
                    <!-- Alerta em caso de erro -->
                    <?php if (!empty($error)) : ?>
                        <span class="text-danger"><?php foreach($error as $erro){ echo $erro;}; ?></span>
                    <?php endif; ?>

                    <h3>Você deve inserir o username da conta relativa ao funcionário a ser editado.</h3>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Username:</label>
                        <input class="form-control" type="text" value="<?php echo $Username; ?>" placeholder="ex.: mario123" name="username" id="username" required>
                    </div>
                    <h3>Defina o cargo a ser atrubuído à conta.</h3>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Cargo:</label>
                        <input class="form-control" type="text" value="<?php echo $Cargo; ?>" placeholder="ex.: Programadora" name="cargo" id="cargo" required>
                    </div>
                    <div class="col form-group">
                        <label style="color:black;" for="id_cliente">Admin:</label>
                        <p>Marque caso a conta deva ter privilégios administrativos: <input class="form-control" type="checkbox" value="<?php echo $Admin; ?>" name="check" id="check"></p>
                    </div>

                    <div style="text-align:center;">
                        <button type="submit" name="entrar" value="Criar conta" class="btn btn-success"> Finalizar </button>
                        <button type="button" onclick="window.location.href='../../../index.php'" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
</html>