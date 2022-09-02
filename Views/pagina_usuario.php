<?php
require_once '../Controllers/nivel_usuario.php';
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

// --------------------------- //
//pegar informação da Session (ID do usuário)
$id_usuario = $_SESSION['id'];
//pegar informação no BD
//quais militares o usuário tem acesso
try {
    $stmt = $conn->query("SELECT militar.id, militar.nome, militar.posto_grad_mil, militar.quadro
    FROM militar
    INNER JOIN usuario_acesso_militar
    ON militar.id = usuario_acesso_militar.militar_id
    WHERE usuario_acesso_militar.usuario_id = '$id_usuario'");
} catch (PDOException $ex) {
    echo 'Exceção capturada: ', $ex->getMessage(), "\n";
}
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">

    <div class="row">
        <div class="col-md-4">
            <h4>Página inicial / Perfil usuário</h4>
            <div class="form-text">
                <p><strong>Bem-vindo(a), </strong> <?= $_SESSION['nome'] ?>.</br>
                    <strong>Email/Login:</strong> <?= $_SESSION['email'] ?>.
                </p>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <p align="center"><em>Seu perfil de usuário concede acesso às informações do(s) seguinte(s) militar(es).</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>
                                <p align="center">Documentação</p>
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
                        //consultar dados de todos os militares que o usuário tem acesso

                        if (isset($resultado)) {
                            foreach ($resultado as $item) {
                                $aux_id = $item['id'];
                                echo '<tr>'
                                    . '<td align="center"><form action="../Views/pasta_promocional_home_candidato.php" method="POST"><button type="submit" class="btn btn-outline-primary" type="submit" name="militar_id" value="' . $aux_id . '"><i class="bi bi-file-earmark-arrow-up-fill" title="Enviar documentação"></i>&nbspAcessar</button></form></td>'
                                    . '<td align="center">' . alias_posto_grad($item['posto_grad_mil']) . '</td>'
                                    . '<td align="center">' . $item['nome'] . '</td>'
                                    . '<td align="center">' . $item['quadro'] . '</td>';
                            }
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