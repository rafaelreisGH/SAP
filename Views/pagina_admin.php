<?php
include_once './header.php';
include_once '../Controllers/verifica_permissoes.php';
?>

<div class="container">

    <br /><br />
    <div class="col-md-3">
        <h3>Página de Admin</h3>
        <p><strong>Bem-vindo(a), </strong> <?= $_SESSION['nome'] ?>.</p><br>
        <p><strong>Email/Login:</strong> <?= $_SESSION['email'] ?>.</p><br>
    </div>
    <link rel="stylesheet" href="../css/tabela_usuarios_bloqueados.css">

    <div class="col-md-9">

        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">Usuário Bloqueados</h3>
                    </div>

                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th align="center"><em class="glyphicon glyphicon-cog"></em></th>
                            <!--<th class="hidden-xs">ID</th>-->
                            <th><em class="glyphicon glyphicon-user"></em>&nbsp;Nome</th>
                            <th><em class="glyphicon glyphicon-inbox"></em>&nbsp;E-mail</th>
                            <th><em class="glyphicon glyphicon-pencil"></em>&nbsp;Perfil de usuário</th>
                            <th>Posto/Graduação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!--<td class="hidden-xs">1</td>-->
                            <?php
                            include_once '../Controllers/usuarios_bloqueados.php';
                            ?>

                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col col-xs-4">Page 1 of 5
                    </div>
                    <div class="col col-xs-8">
                        <ul class="pagination hidden-xs pull-right">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                        </ul>
                        <ul class="pagination visible-xs pull-right">
                            <li><a href="#">«</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-3">
    </div>

    <div class="clearfix">

    </div>
    <br />

    <div class="container">
        <div class="row">

        </div>
    </div>


</div>

<div class="col-md-12">
    <h2>Lorem Ipsum</h2>
    <p style="text-align: justify">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit, nibh sit amet gravida rhoncus, quam nisl bibendum ipsum, vitae vestibulum erat eros eget massa. Integer id velit vitae diam semper tempor. Donec sollicitudin mollis dolor ut mollis. Etiam quis lacinia ex, ut imperdiet nibh. Vivamus congue arcu tellus, non bibendum justo viverra id. Ut sollicitudin accumsan est, eget iaculis massa. Sed malesuada efficitur faucibus. Integer ut semper nulla. Nam dictum congue aliquam. Proin a nunc semper, ultrices magna a, ultricies justo. Sed ornare enim vel dapibus tincidunt. Aliquam egestas magna a diam consequat dictum. Vestibulum tincidunt ipsum non sodales congue. Aenean non suscipit sem. Maecenas a posuere mauris, quis interdum lorem. Donec egestas sem ligula, quis porta eros tincidunt non.
    </p>
</div>

</div>


</div>

<?php
include_once './footer.php';
?>