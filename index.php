<?php
include_once 'Projeto PHP\database\database.ini.php';

if(!isset($_SESSION)) {
    session_start();
    if (isset($_SESSION['found'])) {
        unset($_SESSION['found']);
        unset($_SESSION['cnpj']);
    }
}

$estabelecimentoModel = pg_query($conn, 'SELECT * FROM public."Estabelecimento" ORDER BY "nome" ASC ');
$estabelecimentos = pg_fetch_all($estabelecimentoModel);

$logado = (isset($_SESSION['username']) && is_numeric($_SESSION['username']));
if ($logado) {
    $admins = pg_fetch_assoc(pg_query($conn, "SELECT * FROM public.\"funcionario\" WHERE id = '$_SESSION[username]'"));
}

?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title>StoreManager</title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="Projeto PHP/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="Projeto PHP/assets/css/style.css">
        <link rel="stylesheet" href="Projeto PHP/assets/css/responsive.css">
        <link rel="icon" href="Projeto PHP/assets/images/fevicon.png" type="image/gif" />
        <link rel="stylesheet" href="Projeto PHP/assets/css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <style> 
            body { 
                background-color: black; 
            }
            table {
                font-family: verdana;
                font-size: 12px;
                color: black;
                text-align: center;
                background-color: PaleTurquoise;   
                border-collapse: collapse;
            }
            td, th {
                border: 1px solid SkyBlue;
            } 
        </style>
    </head>

    <body class="main-layout">
        <header>
            <div class="container">
                <div class="jumbotron" style="background-color: #e4dcd8">
                    <div class="logo">
                        <a href="index.php"><img src="Projeto PHP/assets/images/logoStore.png" width="275" height="275"></a>
                    </div>
                    <div class="row">
                        <h1 class="display-4">Store Manager</h1><br>
                        <p style="font-family:'times new roman', monospace">by ET™ Ltda.</p>
                    </div>
                </div>
                <nav class="main-menu">
                    <ul class="menu-area-main">
                        <li class="active"> <a href="index.php" style="color:white" >Home</a> </li>
                        <li> <a href="#est" style="color: skyBlue">Estabelecimentos cadastrados</a> </li>
                        <li>
                            <?php if($logado && $admins['adm'] == 1) { 
                                    echo "<a href=\"Projeto PHP/pages/admin.php\" style=\"color:gold\">Administrar</a>";
                                } else {
                                    echo "<a href=#adm style=\"color:gold\">Marcar Horário</a>"; 
                                }
                            ?>
                        <li> 
                            <?php if(!$logado) { 
                                    echo "<a href=\"Projeto PHP/pages/login.php\" >Login</a>";
                                } else {
                                    echo "<a href=\"Projeto PHP/pages/edit/editarCadastro.php\" style=\"color: DarkOrchid\">Meu perfil</a>"; 
                                }
                            ?> 
                        </li>
                        <li> <a href="#cont" style="color: lightGreen">Contato</a> </li>
                    </ul>
                </nav>
            </div>
            
            <br><br>
            
            <div class="container">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="Projeto PHP/assets/images/gucci.jpg" style="width:100%;">
                        </div>

                        <div class="item">
                            <img src="Projeto PHP/assets/images/mall.jpg" style="width:100%;">
                        </div>
                        
                        <div class="item">
                            <img src="Projeto PHP/assets/images/sup.jpg" style="width:100%;">
                        </div>
                    </div>

                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </header>

        <br><br>

        <div id="est" class="est">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="titlepage">
                            <h2 style="text-align:center; color: SkyBlue">Estabelecimentos cadastrados</h2>
                        </div>
                    </div>
                </div>

                <br>

                <div class="container">
                <table align="center" style="width: 100%">
        <thead style="background-color: SkyBlue" >
            <th>Nome</th>
            <th>CNPJ</th>
            <th>Limite de pessoas</th>
            <th>Máximo de funcionários</th>
            <th>Máximo de clientes</th>
            <th>Máximo de acompanhantes</th>
            <th>Hora de abertura</th>
            <th>Hora de fechamento</th>

        </thead>
        <?php foreach ($estabelecimentos as $estabelecimento) {?>
        <?php $estabelecimento['lim_pessoas'] = $estabelecimento['max_funcionarios'] + ($estabelecimento['max_clientes'] * $estabelecimento['lim_acompanhantes']);?>
        <tr>
            <td><p><?php echo $estabelecimento['nome']?> </p></td>
            <td><p><?php echo $estabelecimento['cnpj']?> </p></td>
            <td><p><?php echo $estabelecimento['lim_pessoas']?> </p></td>
            <td><p><?php echo $estabelecimento['max_funcionarios']?> </p></td>
            <td><p><?php echo $estabelecimento['max_clientes']?> </p></td>
            <td><p><?php echo $estabelecimento['lim_acompanhantes']?> </p></td>
            <td><p><?php echo $estabelecimento['hora_abertura']?> </p></td>
            <td><p><?php echo $estabelecimento['hora_fechamento']?> </p></td>
        <tr>
        <?php }?>
    </table>
                </div>
            </div>
        </div>

        <br><br>

        <div id="adm" class="adm">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="titlepage">
                            <h2 style="text-align:center"><a style="color: black; background-color:skyblue" href='Projeto PHP/pages/marcarHora.php'>Agendar entrada</a></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mx-auto" style="background-color: #e4dcd8">
                        <div class="about-box">
                            <h3>Gerencie sua loja e evite aglomerações</h3>
                            <p>Com a mais tecnológica administração de pessoal em estabelecimentos disponibilizada por 
                            ET™ Ltda, você tem o poder e a praticidade de um banco de dados moderno e atual para 
                            controlar o acesso de multidões em lojas, supermercados, bancos, etc!</p>
                        </div>
                    </div>

                
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mx-auto" style="background-color: #e4dcd8">
                        <div class="about-box">
                            <h3>Prático e eficiente</h3>
                            <p>O software Store Manager da ET™ Ltda. pode ser preparado para um novo estabelecimento
                            em questão de poucos minutos, tudo no conforto e segurança do seu lar ou negócio! Não são 
                            necessários quaisquer encontros presenciais.</p>
                            <p>A simplicidade também alcança seus clientes! A entrada no estabelecimento exige apenas 
                            uma senha numérica simples, garantindo praticidade e agilidade sem complicações.</p>
                        </div>
                    </div>
                </div>
                <a class="read_more" href="Projeto PHP/pages/insert/inserirEstabelecimento.php">Cadastre seu estabelecimento</a> <br>
            </div>
        </div>

        <br><br>

        <div id="cont" class="cont">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="titlepage">
                            <h2 style="text-align:center">Contato</h2>
                        </div>
                    </div>
                </div>

                <br>

                <div class="container">
                    <div class="row">
                        <p style="color:white">Gmail: equipe.et@gmail.com<br>
                        Telefone: 63 91234-5678<br>
                        CNPJ: 00.115.989/2469-23<br>
                        Endereço: Avenida NS-15, Quadra 109, Norte, s/n - Palmas - TO, 77001-090</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="map">
            <img src="Projeto PHP/assets/images/map.png" style="width:100%;">
        </div>
    </body>
</html>

<?php
include('Projeto PHP/templates/footer.php');
?>