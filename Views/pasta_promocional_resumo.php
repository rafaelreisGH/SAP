<?php
include_once '../Views/header3.php';
require_once '../ConexaoDB/conexao.php';

if (isset($_GET['id_da_pasta'])) {
    $id_da_pasta = $_GET['id_da_pasta'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM pasta_promocional WHERE id = '" . $id_da_pasta . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado)) {

        $militar_id = $resultado['militar_id'];

        $stmt2 = $conn->query("SELECT * FROM militar WHERE id = '" . $militar_id . "'");
        $res = $stmt2->fetch(PDO::FETCH_ASSOC);
        if (isset($res['nome'])) {
            $nome = $res['nome'];
            $posto_grad = $res['posto_grad_mil'];
        }
    } else {
        echo "Nenhum resultado encontrado.";
    }
}

?>

<div class="container">
    <div class="col-md-12">
        <h4>Militar Selecionado</h4>
        <div class="form-text">
            <p><?= $posto_grad ?>&nbsp<?= $nome ?></p>
        </div>
    </div>

    <hr>

    <div class="col-md-12">
        <h4><strong>Documentos constantes na pasta promocional</strong></h4>
        <?php
        try {
            //PROCURA REGISTRO DE DOCUMENTOS CONFORME ID DO MILITAR
            $consulta = $conn->query("SELECT * FROM pasta_promocional WHERE id = '$id_da_pasta'");

            $documentos_nomes = array('Certidão TJ-MT - 1ª instância', 'Certidão TJ-MT - 2ª instância', 'Certidão TRF - Seção Judiciária/MT', 'Certidão TRF-1', 'Nada Consta da Corregedoria - CBMMT', 'Conceito Moral', 'Cursos e Estágios', 'Avaliação de Desempenho Físico', 'Inspeção de Saúde', 'Avaliação de Desempenho Satisfatória');
            $documentos = [];
            //percorrer os resultados
            while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $id_da_pasta = $resultado['id'];
                $aux_semestre_promocional = $resultado['semestre_processo_promocional'];
                $aux_ano_promocional = $resultado['ano_processo_promocional'];

                $documentos[] = $resultado['certidao_tj_1_inst'];
                $documentos[] = $resultado['certidao_tj_2_inst'];
                $documentos[] = $resultado['certidao_trf_sj_mt'];
                $documentos[] = $resultado['certidao_trf_1'];
                $documentos[] = $resultado['nada_consta_correg'];
                $documentos[] = $resultado['conceito_moral'];
                $documentos[] = $resultado['cursos_e_estagios'];
                $documentos[] = $resultado['taf_id'];
                $documentos[] = $resultado['ais_id'];
                $documentos[] = $resultado['fad_id'];
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        ?>
        <p><Strong>Referência:&nbsp</Strong>
            <?php
            echo $aux_semestre_promocional . 'º semestre de ';
            echo $aux_ano_promocional;
            ?>
        </p>
        <hr>
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-body">
                    <div class="row justify-content-center">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th>
                                        <p align="center">Ordem</p>
                                    </th>
                                    <th>
                                        <p align="center"></br>
                                            <label><strong>Documento</strong></label>
                                        </p>
                                    </th>
                                    <th>
                                        <p align="center">Status</p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ordem = 1;
                                foreach ($documentos_nomes as $key => $value) {
                                    $res = (!is_null($documentos[$key])) ? 'Presente' : 'Ausente';
                                    echo '<tr>'
                                        . '<td align="center">' . $ordem . '</td><td align="center">' . $value . '</td><td align="center">' . $res . '</td>'
                                        . '</tr>';
                                    $ordem++;
                                }

                                ?>
                            </tbody>
                        </table>

                    </div>


                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <br />
        <?php
        include_once '../Views/footer.php';
        ?>