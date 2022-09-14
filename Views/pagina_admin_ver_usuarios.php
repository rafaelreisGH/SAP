<?php
require_once '../Controllers/nivel_admin.php';
include_once './header2.php';

$usuario_id_GET = (isset($_GET['usuario_id'])) ? $_GET['usuario_id'] : null;
$sucesso = (isset($_GET['sucesso'])) ? $_GET['sucesso'] : null;
if ((isset($usuario_id_GET)) && ($usuario_id_GET != null)) {
    $usuario_id_GET = intval($usuario_id_GET);
    if (!intval($usuario_id_GET)) header('Location: ../Views/acesso_restrito.php');
}
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <A class="btn btn-primary" HREF="pagina_admin.php">Voltar</A>
        </ul>
        <hr>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p align="center"><em>Informações de acesso pelos usuários.</em></p>
        </div>
        <div class="col-md-12">
            <?php
            if ($sucesso == 1) {
                echo '<p><font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspRegistro excluído com sucesso!<br></font></p>';
            } else if ($sucesso == 2){
                echo '<p><font style="color:#00ff00"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspRegistro incluído com sucesso!<br></font></p>';
            } else if ($sucesso === 0){
                echo '<p><font style="color:#0000ff"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspNada foi alterado! É possível que o usuário já tenha acesso ao candidato.<br></font></p>';
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>
                                <p align="center">Concessão de acesso</p>
                            </th>
                            <th>
                                <p align="center">Acessos concedidos</p>
                            </th>
                            <th>
                                <p align="center">Posto/Graduação</p>
                            </th>
                            <th>
                                <p align="center">Nome</p>
                            </th>
                            <th>
                                <p align="center">Quadro</p>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        require_once '../Controllers/alias_posto_grad.php';
                        require_once '../ConexaoDB/conexao.php';
                        require_once '../Controllers/consulta_usuarios_desbloqueados.php';
                        $resultado = consulta_usuarios_desbloqueados($conn);

                        foreach ($resultado as $item) {

                            $aux_id = $item['id'];
                            echo '<tr>'
                                . '<td align="center"><form action="../Views/pagina_admin_permissoes_usuarios_adicionar.php" method="POST"><button type="submit" class="btn btn-outline-success" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi bi-person-plus-fill" title="Conferir"></i>&nbspAdicionar</button></form></td>'
                                . '<td align="center"><form action="../Views/pagina_admin_permissoes_usuarios.php" method="POST"><button type="submit" class="btn btn-outline-primary" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi bi-eye" title="Conferir"></i>&nbspConferir</button></form></td>'
                                . '<td align="center">' . alias_posto_grad($item['posto_grad_usuario']) . '</td>'
                                . '<td align="center">' . $item['nome'] . '</td>'
                                . '<td align="center">' . $item['email'] . '</td>';
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


<script>
    function validateForm() {
        // abaixo serve para Limite de Quantitativo
        let aux1 = document.forms["formCadastro"]["nome"].value;
        if (aux1 == "" || !isNaN(aux1)) {
            //alert("O nome deve ser preenchido.");
            document.getElementById('alertaNomeVazio').innerHTML = '* O nome não pode ser vazio ou numérico.'
            return false;
        } else {
            document.getElementById('alertaNomeVazio').innerHTML = ''
        }
    }
</script>

<?php
include_once './footer2.php';
?>