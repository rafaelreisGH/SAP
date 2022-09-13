<?php
require_once '../Controllers/nivel_admin.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

$usuario_id = (isset($_POST['militar_id'])) ? $_POST['militar_id'] : null;

//se o $usuario_id não for um inteiro, redireciona para acesso restrito
if ((!filter_var($usuario_id, FILTER_VALIDATE_INT))) {
    header('Location: ../Views/acesso_restrito.php');
}
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <A class="btn btn-primary" HREF="javascript:javascript:history.go(-1)">Voltar</A>
        </ul>
        <hr>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p align="center"><em>Informações de acesso pelos usuários.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>
                                <p align="center">Posto/Graduação</p>
                            </th>
                            <th>
                                <p align="center">Nome</p>
                            </th>
                            <th>
                                <p align="center">Quadro</p>
                            </th>
                            <th>
                                <p align="center">Excluir</p>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        require_once '../Controllers/alias_posto_grad.php';
                        //consultar dados de todos os militares que o usuário tem acesso
                        require_once '../Controllers/consulta_acessos_do_usuario.php';
                        $resultado = consulta_acessos_do_usuario($conn, $usuario_id);
                        if(!empty($resultado)){
                            foreach ($resultado as $item) {
                                
                                $aux_id = $item['id'];
                                echo '<tr>'
                                . '<td align="center">' . alias_posto_grad($item['posto_grad_mil']) . '</td>'
                                . '<td align="center">' . $item['nome'] . '</td>'
                                . '<td align="center">' . $item['quadro'] . '</td>'
                                . '<td align="center"><form action="../Controllers/excluir_acesso_a_militar.php" method="POST" name="formExcluiAcesso"><input type="hidden" name="usuario_id" value="' . $usuario_id . '"><button type="submit" class="btn btn-outline-primary" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi bi-x-octagon-fill" title="Excluir acesso"></i>&nbspExcluir acesso</button></form></td>';
                            }
                        } else {
                            echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspO usuário não possui acesso a nenhum militar!<br></font></p>';
                        }
                    ?>
                    </tbody>
                </table>

                <div class="col-md-12">
                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once './footer2.php';
?>