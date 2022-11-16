<?php
require_once '../Controllers/nivel_usuario.php';
include_once '../Views/header3.php';
require_once '../ConexaoDB/conexao.php';
require_once '../Controllers/select_dados_fad.php';


$id = (isset($_POST['id_da_fad'])) ? $_POST['id_da_fad'] : null;
//se o $uid não for um inteiro, redireciona para acesso restrito
if ((!filter_var($id, FILTER_VALIDATE_INT))) {
    header('Location: ../Views/acesso_restrito.php');
}

$res = select_dados_fad_por_id($conn, $id);
?>

<body>

    <div class="container">

        <div>
            <h3 class="text-center">Ficha de Avaliação de Desempenho</h3>
        </div>

    </div>

    <div class="container" style="font-size: 9pt">

        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Posto/Graduação</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Quadro</th>
                        <th scope="col">Semestre</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $res['grau_hierarquico_na_epoca'] ?></td>
                        <td><?= $res['nome'] ?></td>
                        <td><?= $res['quadro'] ?></td>
                        <td>
                            <?= $res['semestre'] . 'º semestre' ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-md-12">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">I - Cargos desempenhados</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $res['funcao_desempenhada'] ?></td>
                    </tr>

                </tbody>
            </table>
        </div>


        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">II - Habilidades, competências e valores avaliados</th>
                        <th scope="col" colspan="5">Conceito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">1. PRODUTIVIDADE: Capacidade de obter resultados práticos, contribuindo para o alcance dos objetivos de sua área de atuação bem como a melhoria dos serviços prestados, considerando os recursos disponíveis, complexidade das ações e desafios encontrados, dentro de padrões e prazos estabelecidos.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['produtividade']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">2. LIDERANÇA: Capacidade de comandar, coordenar, gerenciar e desenvolver trabalhos em equipe, demonstrada pela influência que suas ações e palavras exercem sobre as pessoas.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['lideranca']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">3. DECISÃO: Capacidade de analisar fatos, situações e escolher com discernimento a alternativa de solução mais adequada nas diversas situações de trabalho sob sua responsabilidade.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['decisao']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">4. RELACIONAMENTO INTERPESSOAL: Capacidade de relacionar-se com as pessoas, independente do nível hierárquico ou social,com demonstração de respeito, compreensão e demonstrando habilidade em resolver conflitos interpessoais.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['relacionamento_interpessoal']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">5. SAÚDE FÍSÍCA: Capacidade de cuidar da própria saúde com a manutenção do condicionamento físico geral e de seu corpo, refletidos no seu desempenho profissional e em sua apresentação pessoal. </p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['saude_fisica']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">6. PLANEJAMENTO: Capacidade de analisar fatos e situações, estabelecer planos e ações; assessorar a chefia visando alcançar os objetivos institucionais, de forma sistemática, com previsão de conseqüências.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['planejamento']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">7. DISCIPLINA: Capacidade de proceder conforme as normas que regem a PM/BM MT, preservando os Valores Institucionais, sem a perder a visão crítica e a criatividade.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['disciplina']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">8. DISPOSIÇÃO PARA O TRABALHO: Capacidade de demonstrar comprometimento com a missão e objetivos da Instituição. É participativo e compartilha problemas e desafios da Instituição. Não foge da responsabilidade, não é apático nem desinteressado. Tem atitude para o seu trabalho.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['disposicao_para_o_trabalho']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">9. ASSIDUIDADE: Capacidade de estar disponível e com condições efetivas de executar as atividades, nos horários e locais pré-estabelecidos.</p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['assiduidade']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">10. PREPARO INTELECTUAL: Capacidade de buscar novos conhecimentos, mantendo-se em constante preparação intelectual, refletido no desempenho profissional. </p>
                        </th>
                        <td colspan="5"><?= ucfirst($res['preparo_intelectual']) ?></td>

                    </tr>

                    <?php
                    /* ---------------------- */
                    //contar (Quantidade de vezes que foi assinalado o conceito)
                    $qtde = array($res['produtividade'], $res['lideranca'], $res['decisao'], $res['relacionamento_interpessoal'], $res['saude_fisica'], $res['planejamento'], $res['disciplina'], $res['disposicao_para_o_trabalho'], $res['assiduidade'], $res['preparo_intelectual'],);
                    $qtde = array_count_values($qtde);

                    //verifica se existe a chave EXCELENTE
                    if (!array_key_exists("excelente", $qtde)) {
                        $qtde['excelente'] = 0;
                    }
                    //verifica se existe a chave MUITO BOM
                    if (!array_key_exists("muito bom", $qtde)) {
                        $qtde['muito bom'] = 0;
                    }
                    //verifica se existe a chave BOM
                    if (!array_key_exists("bom", $qtde)) {
                        $qtde['bom'] = 0;
                    }
                    //verifica se existe a chave REGULAR
                    if (!array_key_exists("regular", $qtde)) {
                        $qtde['regular'] = 0;
                    }
                    //verifica se existe a chave INSUFICIENTE
                    if (!array_key_exists("insuficiente", $qtde)) {
                        $qtde['insuficiente'] = 0;
                    }
                    /* ---------------------- */
                    ?>


                    <tr style="font-weight: bold;">
                        <th scope="row">
                            <p class="text-justify">Conceito</p>
                        </th>
                        <td colspan="1">
                            <p class="text-center">E</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">MB</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">B</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">R</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">I</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">Total (Quantidade de vezes que foi assinalado o conceito)</p>
                        </th>
                        <td colspan="1">
                            <p class="text-center"><?= $qtde['excelente'] ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= $qtde['muito bom'] ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= $qtde['bom'] ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= $qtde['regular'] ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= $qtde['insuficiente'] ?></p>
                        </td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <th scope="row">
                            <p class="text-justify">Fatores (multiplicar pelo total do conceito</p>
                        </th>
                        <td colspan="1">
                            <p class="text-center">6</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">5</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">4</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">3</p>
                        </td>
                        <td colspan="1">
                            <p class="text-center">1</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">Resultados</p>
                        </th>
                        <td colspan="1">
                            <p class="text-center"><?= ($qtde['excelente'] * 6) ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= ($qtde['muito bom'] * 5) ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= ($qtde['bom'] * 4) ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= ($qtde['regular'] * 3) ?></p>
                        </td>
                        <td colspan="1">
                            <p class="text-center"><?= ($qtde['insuficiente'] * 1) ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">Conceito final: (soma dos resultados divididos por 10)</p>
                        </th>
                        <td colspan="5">
                            <p class="text-center"><?= $res['nota'] ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label for="textoDeJusitificativa">Justificativa: (Apenas constar nos casos de nota final maior que 5,8 e inferior a 3)</label>
                <textarea class="form-control" id="textoDeJusitificativa" rows="3"><?= $res['justificativa'] ?></textarea>
            </div>


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Assinaturas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p class="text-justify">Quartel do(a)_________________, em________________ - MT, _____/_____/_________.</p>
                            </br>
                            </br>
                            <p class="text-center">_____________________________</br>Nome - Posto - Função</br>Avaliador - RG nº_________</p>
                            </br>
                            <?php
                            if (!is_null($res['data_do_ciente'])) {
                                $aux = $res['data_do_ciente'];
                                list($ano, $mes, $dia) = explode("-", $aux);
                                list($dia, $hora) = explode(" ", $dia);
                                echo '<p class="text-justify">Ciente em: ' . $dia . '/' . $mes . '/' . $ano . ' às ' . $hora . '.';
                            } else echo '<p class="text-justify">Ciente em: _____/_____/_______.</p>';
                            ?>

                            </br>
                            </br>
                            <?php
                            if ($res['ciente_do_avaliado'] == 1) {
                                echo '<p class="text-center">Validado digitalmente por '.$res['nome'].'</p>';
                            }
                            ?>
                            <p class="text-center">_____________________________</br><?= $res['nome'] ?>&nbsp-&nbsp<?= $res['posto_grad_mil'] ?></br>Avaliado - RG nº_________</p>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>