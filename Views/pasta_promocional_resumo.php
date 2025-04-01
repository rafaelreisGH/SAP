<?php
require_once '../Controllers/nivel_gestor.php';
include_once '../Views/header3.php';
require_once '../ConexaoDB/conexao.php';

if (isset($_GET['id_da_pasta'])) {

    //verificação de a variável $_GET é um inteiro
    $aux_id_da_pasta = filter_var($_GET['id_da_pasta'], FILTER_SANITIZE_NUMBER_INT);

    //se não for um INT, para a execução.
    if (!filter_var($aux_id_da_pasta, FILTER_VALIDATE_INT)) {
        echo "Operação não permitida.";
        exit();
    } else {

        //array com os nomes dos documentos necessários
        try {
            $documentos_nomes = array('cert_1JE', 'cert_2JE', 'cert_1JF', 'cert_2JF', 'cert_trf_sç_jud_mt', 'nada_consta_correg', 'conceito_moral', 'cursos_e_estagios', 'militar_tem_taf_id', 'ais_id', 'media_das_avaliacoes');
            $documentos = [];

            $stmt = $conn->prepare('SELECT doc_promo_nome, doc_promo_validado FROM documento_promocao WHERE pasta_promocional_id = :auxiliar');
            $stmt->bindParam(':auxiliar', $aux_id_da_pasta, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }

        //se não haver resultados, para a execução do código.
        if (empty($resultado)) {
            echo "A pasta não tem nenhum documento registrado.";
            exit();
        } else {

            //transforma o 0 e 1 em Inválido e Válido
            foreach($resultado as &$res){
                if ($res["doc_promo_validado"] === 1){
                    $res["doc_promo_validado"] = "Validado";
                } else {
                    $res["doc_promo_validado"] = "<strong>Inválido</strong>";
                }
            }

            // Criar um array apenas com os nomes dos documentos da consulta
            $documentos_encontrados = array_column($resultado, "doc_promo_nome");

            //aqui o objetivo é buscar os dados do militar (nome e posto) sabendo apenas o id da pasta promocional
            try {
                $stmt = $conn->prepare('SELECT nome, posto_grad_mil FROM militar JOIN pasta_promocional ON militar_id = militar.id WHERE pasta_promocional.id = :id');
                $stmt->bindParam(':id', $aux_id_da_pasta, PDO::PARAM_INT);
                $stmt->execute();
                $consulta = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($consulta)) {
                    $nome = $consulta['nome'];
                    $posto_grad = $consulta['posto_grad_mil'];
                }
            } catch (PDOException $ex) {
                return $ex->getMessage();
            }
        }
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
        <p><Strong>Referência:&nbsp</Strong>
            <?php
            try {
                $stmt = $conn->prepare('SELECT ano_processo_promocional, semestre_processo_promocional FROM pasta_promocional WHERE pasta_promocional.id = :id');
                $stmt->bindParam(':id', $aux_id_da_pasta, PDO::PARAM_INT);
                $stmt->execute();
                $consulta = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($consulta)) {
                    $aux_ano_promocional = $consulta['ano_processo_promocional'];
                    $aux_semestre_promocional = $consulta['semestre_processo_promocional'];
                }
            } catch (PDOException $ex) {
                return $ex->getMessage();
            }
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
                                        <p align="center">Registro</p>
                                    </th>
                                    <th>
                                        <p align="center">Validação</p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                $ordem = 1;
                                $itens = 0;
                                foreach ($documentos_nomes as $documento) {
                                    if (in_array($documento, $documentos_encontrados)) {
                                        echo '<tr><td align="center">' . $ordem . '</td><td align="center">' . $documento . '</td><td align="center">Presente</td><td align="center">' . $resultado[$itens]["doc_promo_validado"] . '</td></tr>';
                                        $itens++;
                                    } else {
                                        echo '<tr><td align="center">' . $ordem . '</td><td align="center">' . $documento . '</td><td align="center"><i>Ausente</i></td><td align="center"> - </td></tr>';
                                    }
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