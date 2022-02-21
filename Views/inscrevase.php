<?php

$erro_nome = isset($_GET['erro_nome']) ? $_GET['erro_nome'] : 0;
$email_invalido = isset($_GET['email_invalido']) ? $_GET['email_invalido'] : 0;
$erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;
?>


<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>SAP - CBMMT</title>		
        <!-- jquery - link cdn -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <!-- bootstrap - link cdn -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="icon" href="../imagens/brasao_cbmmt.ico">
    </head>
    <body>
        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="../imagens/Vetor CBMMT.png" style="width: 45px;
                         padding: 5px 0 5px 0;"/>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../index.php">Voltar para Home</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>


        <div class="container">

            <br /><br />

            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3>Formulário de registro.</h3>
                <br />
                <form method="post" action="../Controllers/registra_usuario.php" id="formCadastrarse">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required="required">
                        <?php
                        if ($erro_nome) {
                            echo '<font style="color:#ff0000"><i>*Usuário já cadastrado.</i></font>';
                        }
                        ?>                                                
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="required">
                        <?php
                        if ($erro_email) {
                            echo '<font style="color:#ff0000"><i>*Email já cadastrado como login.</i></font>';
                        }
                        if ($email_invalido) {
                            echo '<font style="color:#ff0000"><i>*Email inválido.</i></font>';
                        }
                        ?>                                                
                    </div>
                    <!--RETIREI O CAMPO DE SENHA DO LOGIN POR SER NECESSÁRIO O ADMIN VALIDAR O USUÁRIO E ATRIBUIR NOVA SENHA
                    <div class="form-group">
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required="required">
                    </div>
                    -->
                    <button type="submit" class="btn btn-danger form-control">Registrar-se</button>
                </form>
            </div>
            <div class="col-md-4"></div>

            <div class="clearfix"></div>
            <br />

        </div>


    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>