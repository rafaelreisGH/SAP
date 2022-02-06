<?php
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';


// --------------------------- //
if (isset($_GET['militar_id'])) {
    $militar_id = $_GET['militar_id'];
} else if (isset($_POST['militar_id'])) {
    $militar_id = $_POST['militar_id'];
}
// --------------------------- //

$retorno = (isset($_GET['retorno'])) ? $_GET['retorno'] : null;
$sucesso_cadastro = (isset($_GET['dados'])) ? $_GET['dados'] : null;

try {
    //pegar no BD dados do militar selecionado
    if (isset($militar_id)) {
        $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $militar_id . "'");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($res['nome'])) {
            $nome = $res['nome'];
            $posto_grad = $res['posto_grad_mil'];
        }
    }
} catch (PDOException $ex) {
    return $ex->getMessage();
}
?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <?php
            echo ('<li class="nav-item"><a class="nav-link active" aria-current="page" href="../Views/pagina_ferramentas.php">Voltar</a></li>');
            ?>
        </ul>
        <hr>
    </div>

    <div class="col-md-12">
        <h4>Militar Selecionado</h4>
        <div class="form-text">
            <p><?= $posto_grad ?>&nbsp<?= $nome ?></p>
        </div>
    </div>

    <h3><strong>Inserção de dados sobre Ata de Inspeção de Saúde</strong></h3>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <form action="../Controllers/inserir_evento_ais.php" method="POST" name="formCadastro">
                <label class="form-label">Dados da A.I.S.</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Data da inspeção</span>
                    <input type="date" class="form-control" name="data_realizacao" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Aptidão</span>
                    <select class="form-select" name="aptidao" required>
                        <option selected disabled>Selecione uma condição</option>
                        <option value="APTO">Apto</option>
                        <option value="INAPTO">Inapto</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Restrições</span>
                    <select class="form-select" name="restricoes" required>
                        <option selected disabled>Selecione a condição</option>
                        <option value="NENHUMA">Nenhuma restrição</option>
                        <option value="PARCIAL">Restrição parcial</option>
                        <option value="TOTAL">Restrição total</option>
                        <option value="GESTANTE">Gestante</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Número do Boletim</span>
                    <input type="number" class="form-control" name="numero_bge" placeholder="Informe o número" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Data do Boletim</span>
                    <input type="date" class="form-control" name="data_publicacao" required>
                </div>

                <input type="hidden" class="form-control" name="militar_id" value="<?= $militar_id ?>">

                <hr>
                <button class="btn btn-outline-success active" type="submit">Salvar</button>
            </form>
            <hr>

            <label class="form-label">Arquivo digital A.I.S.</label>
            <form enctype="multipart/form-data" action="arquivos_upload.php" method="post">

                <div class="input-group">
                    <input type="file" name="arquivo" class="form-control" aria-label="Upload">
                    <input type="hidden" name="tipo_do_documento" value="certidao_tj_2_inst">
                    <input type="hidden" name="dados_pasta" value="<?= $id_da_pasta ?>">
                    <input type="submit" class="btn btn-outline-success" value="Salvar">
                </div>
                <small class="form-text text-muted">Envie o <strong>arquivo digital</strong> correspondente.</small>

            </form>

            <div>

                <?php
                
                // if (isset($resultado['cursos_e_estagios'])) {
                //     $cursos_e_estagios = $resultado['cursos_e_estagios'];
                //     echo '<label class="form-label">Ações disponíveis:</label>'
                //         . '<form action="arquivos_excluir.php" method="post">'
                //         . '<div class="form-group">'
                //         . '<a target="_blank" href="' . $cursos_e_estagios . '"><button class="btn btn-outline-warning" type="button">Visualizar arquivo</button></a>&nbsp'
                //         . '<input type="hidden" name="tipo_do_documento" value="cursos_e_estagios">'
                //         . '<input type="hidden" name="id_pasta" value="' . $id_da_pasta . '">'
                //         . '<button class="btn btn-outline-danger" type="submit">Excluir arquivo</button>'
                //         . '</div>'
                //         . '</form>';
                // }
                ?>

            </div>

        </div>

        <div class="col-md-6">
            <br>
            <?php
            if (!is_null($retorno)) {
                switch ($retorno) {
                    case 1:
                        echo 'A A.I.S. já foi cadastrada anteriormente.';
                        break;
                    case 2:
                        echo '<p><font style="color:#0000ff"><i class="bi bi-person-check" fill="currentColor"></i><strong>&nbspA A.I.S. foi cadastrada com sucesso!</strong></font></p>';
                        $array = ['Data de realização:', 'BGE nº:', 'Data de publicação:'];
                        $aux = 0;
                        foreach ($sucesso_cadastro as $item) {
                            echo '<p><font style="color:#0000ff">' . $array[$aux] . '&nbsp';
                            echo $item . '</font></p>';
                            $aux++;
                        }
                        break;
                    case 3:
                        echo '<p><font style="color:#0000ff">Erro na tentativa de cadastro.</font></p>';
                        break;
                    case 4:
                        echo '<p><font style="color:#0000ff">Registro(s) excluído(s) com sucesso.</font></p>';
                        break;
                }
            }
            ?>
        </div>
    </div>

    <hr>
    <h3><strong>Edição de dados sobre A.I.S.</strong></h3>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-body">
                    <form action="../Controllers/inserir_evento_ais.php" method="POST">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th>
                                        <p align="center"></br>

                                            <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off" onclick="checkUncheck(this)">
                                            <label class="btn btn-light" for="btn-check"><strong>Selecionar<br>todos</strong></label>
                                        </p>
                                    </th>
                                    <th>
                                        <p align="center">Inspeção realizada em</p>
                                    </th>
                                    <th>
                                        <p align="center">Condição</p>
                                    </th>
                                    <th>
                                        <p align="center">Restrição</p>
                                    </th>
                                    <th>
                                        <p align="center">Número do BGE</p>
                                    </th>
                                    <th>
                                        <p align="center">BGE publicado em</p>
                                    </th>
                                    <th>
                                        <p align="center">Arquivo</p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                try {
                                    $stmt = $conn->query('SELECT * FROM promocao.ais WHERE militar_id = ' . $militar_id . '');
                                    while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $aux_id = $resultado['id'];
                                        $aux_data_da_inspecao = $resultado['data_da_inspecao'];
                                        $aux_bge = $resultado['bge_numero'];
                                        $aux_data_public = $resultado['data_public'];
                                        $aux_aptidao = $resultado['aptidao'];
                                        $aux_retricoes = $resultado['restricoes'];
                                        $aux_caminho = $resultado['caminho_do_arquivo'];

                                        require_once '../Controllers/alias_ultima_promocao.php';
                                        $aux_data_da_inspecao = alias_ultima_promocao($aux_data_da_inspecao);
                                        $aux_data_public = alias_ultima_promocao($aux_data_public);

                                        echo '<tr>'
                                            . '<td align="center"><input class="form-check-input mt-0" type="checkbox" value="' . $aux_id . '" name="aux_id"><input type="hidden" name="militar_id" value="'. $militar_id .'"></td>'
                                            . '<td align="center">' . $aux_data_da_inspecao . '</td>'
                                            . '<td align="center">' . $aux_aptidao . '</td>'
                                            . '<td align="center">' . $aux_retricoes . '</td>'
                                            . '<td align="center">' . $aux_bge . '</td>'
                                            . '<td align="center">' . $aux_data_public . '</td>';
                                        if ($aux_caminho == null) echo '<td align="center">N/C</td>';
                                        else echo '<td align="center">' . $aux_caminho . '</td>';
                                    }
                                } catch (PDOException $ex) {
                                    return $ex->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="btn btn-outline-danger active" type="submit" name="excluir">Excluir registro(s)</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<br>

<script>
    function checkUncheck(main) {
        all = document.getElementsByName('aux_id[]');
        for (var a = 0; a < all.length; a++) {
            all[a].checked = main.checked;
        }
    }
</script>

<?php
include_once './footer2.php';
?>