<?php
require_once '../Controllers/nivel_usuario.php';
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';
//^^^^APAGAR DAQUI PARA CIMA DEPOIS

if (isset($_POST['militar_id'])) {
    $id = $_POST['militar_id'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
        $quadro = $resultado['quadro'];
    }
} else if (isset($_GET['militar_id'])) {
    $id = $_GET['militar_id'];
    //pegar no BD dados do militar selecionado
    $stmt = $conn->query("SELECT * FROM militar WHERE id = '" . $id . "'");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome = $resultado['nome'];
        $posto_grad = $resultado['posto_grad_mil'];
        $quadro = $resultado['quadro'];
        $media = $resultado['media'];
        $militar_id = $resultado['id'];
    }
}

$nota_url = isset($_GET['nota']) ? $_GET['nota'] : 0;
$id_url = isset($_GET['militar_id']) ? $_GET['militar_id'] : 0;
$semestre_url = isset($_GET['semestre']) ? $_GET['semestre'] : 0;
$ano_url = isset($_GET['ano']) ? $_GET['ano'] : 0;

require_once '../Controllers/verifica_permissoes_usuario.php';
verifica_permissao_usuario($conn, $id);

//pegar dados do avaliador
require_once '../Controllers/select_dados_militar.php';
$avaliador = select_dados_avaliador();
?>

<script type="text/javascript" src="../js/meus_scripts/atualiza_resumo.js"></script>
<script type="text/javascript" src="../js/meus_scripts/valida_formulario.js"></script>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <a class="btn btn-primary" href="../Views/pagina_usuario.php">Voltar</a></li>
        </ul>
        <hr>
    </div>

    <div class="row">

        <div class="col-md-12">
            <h3><strong>Militar avaliado</strong></h3>
            <div class="form-text col-md-12">
                <p><?= $posto_grad ?> <?= $nome ?></p>
            </div>
            </br>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <form name="myForm" action="../Controllers/processa_fad_v2.php" method="POST" onload="atualiza_resumo();" onchange="atualiza_resumo();" onsubmit="return validateForm()">
                <h3><strong>Ficha de avaliação de desempenho</strong></h3></br>

                <div class="form-row">

                    <div class="form-group col-md-6">

                        <label for="FormControlSelectAno">Ano</label>
                        <select class="form-control" id="FormControlSelectAno" name="ano">
                            <?php
                            $ano_atual = date("Y");
                            for ($i = $ano_atual; $i >= 2014; $i--) {
                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?>
                        </select>
                        <small id="anoHelp" class="form-text text-muted">Insira o <strong>ano</strong> correspondente da F.A.D.</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="FormControlSelectSemestre">Semestre</label>
                        <select class="form-control" id="FormControlSelectSemestre" name="semestre">
                            <option value="1">1º Semestre</option>
                            <option value="2">2º Semestre</option>
                        </select>
                        <small id="anoHelp" class="form-text text-muted">Insira o <strong>semestre</strong> correspondente da F.A.D.</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="FormControlSelectPostoGrad">Posto/Graduação no período avaliado</label>
                        <select class="form-control" id="FormControlSelectPostoGrad" name="postoGradNoPerioAvaliado" required>
                            <option value=""></option>
                            <option value="TC BM">Tenente Coronel</option>
                            <option value="MAJ BM">Major</option>
                            <option value="CAP BM">Capitão</option>
                            <option value="1º TEN BM">1º Tenente</option>
                            <option value="2º TEN BM">2º Tenente</option>
                            <option value="ASP OF BM">Aspirante-a-oficial</option>
                            <option value="ST BM">Sub-tentente</option>
                            <option value="1º SGT BM">1º Sargento</option>
                            <option value="2º SGT BM">2º Sargento</option>
                            <option value="3º SGT BM">3º Sargento</option>
                            <option value="CB BM">Cabo</option>
                            <option value="SD BM">Soldado</option>
                        </select>
                        <small id="anoHelp" class="form-text text-muted">Informe o <strong>posto/graduação</strong> do militar no período correspondente desta avaliação.</small>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="mb-3">
                            <label for="inputQuadro">Quadro</label>
                            <input class="form-control" type="text" placeholder="<?= $quadro ?>" id="inputQuadro" disabled>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="mb-3">
                            <label for="funcaoDesempenhada">Funções desempenhadas</label>
                            <textarea class="form-control" name="funcaoDesempenhada" aria-label="With textarea" required></textarea>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group">

                        <h3><strong>Habilidades, competências e valores avaliados</strong></h3></br>

                        <label><strong>1. Produtividade</strong></label></br>
                        <small id="anoHelp" class="form-text text-muted">
                            <p class="text-justify">Capacidade de obter resultados práticos, contribuindo para o alcance dos objetivos de sua área de atuação bem como a melhoria dos serviços prestados, considerando os recursos disponíveis, complexidade das ações e desafios encontrados, dentro de padrões e prazos estabelecidos.</p>
                        </small>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="produtividade" id="produtividadeRadio1" value="excelente">
                                <label class="form-check-label" for="produtividadeRadio1" style="padding-right:15px;">Excelente</label>

                                <input class="form-check-input" type="radio" name="produtividade" id="produtividadeRadio2" value="muito bom">
                                <label class="form-check-label" for="produtividadeRadio2" style="padding-right:15px;">Muito bom</label>

                                <input class="form-check-input" type="radio" name="produtividade" id="produtividadeRadio3" value="bom">
                                <label class="form-check-label" for="produtividadeRadio3" style="padding-right:15px;">Bom</label>

                                <input class="form-check-input" type="radio" name="produtividade" id="produtividadeRadio4" value="regular">
                                <label class="form-check-label" for="produtividadeRadio4" style="padding-right:15px;">Regular</label>

                                <input class="form-check-input" type="radio" name="produtividade" id="produtividadeRadio5" value="insuficiente">
                                <label class="form-check-label" for="produtividadeRadio5" style="padding-right:15px;">Insuficiente</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label><strong>2. Liderança</strong></label></br>
                        <small id="anoHelp" class="form-text text-muted">
                            <p class="text-justify">Capacidade de comandar, coordenar, gerenciar e desenvolver trabalhos em equipe, demonstrada pela influência que suas ações e palavras exercem sobre as pessoas.</p>
                        </small>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="lideranca" id="liderancaRadio1" value="excelente">
                                <label class="form-check-label" for="liderancaRadio1" style="padding-right:15px;">Excelente</label>

                                <input class="form-check-input" type="radio" name="lideranca" id="liderancaRadio2" value="muito bom">
                                <label class="form-check-label" for="liderancaRadio2" style="padding-right:15px;">Muito bom</label>

                                <input class="form-check-input" type="radio" name="lideranca" id="liderancaRadio3" value="bom">
                                <label class="form-check-label" for="liderancaRadio3" style="padding-right:15px;">Bom</label>

                                <input class="form-check-input" type="radio" name="lideranca" id="liderancaRadio4" value="regular">
                                <label class="form-check-label" for="liderancaRadio4" style="padding-right:15px;">Regular</label>

                                <input class="form-check-input" type="radio" name="lideranca" id="liderancaRadio5" value="insuficiente">
                                <label class="form-check-label" for="liderancaRadio5" style="padding-right:15px;">Insuficiente</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label><strong>3. Decisão</strong></label></br>
                        <small id="anoHelp" class="form-text text-muted">
                            <p class="text-justify">Capacidade de analisar fatos, situações e escolher com discernimento a alternativa de solução mais adequada nas diversas situações de trabalho sob sua responsabilidade.</p>
                        </small>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="decisao" id="decisaoRadio1" value="excelente">
                                <label class="form-check-label" for="decisaoRadio1" style="padding-right:15px;">Excelente</label>

                                <input class="form-check-input" type="radio" name="decisao" id="decisaoRadio2" value="muito bom">
                                <label class="form-check-label" for="decisaoRadio2" style="padding-right:15px;">Muito bom</label>

                                <input class="form-check-input" type="radio" name="decisao" id="decisaoRadio3" value="bom">
                                <label class="form-check-label" for="decisaoRadio3" style="padding-right:15px;">Bom</label>

                                <input class="form-check-input" type="radio" name="decisao" id="decisaoRadio4" value="regular">
                                <label class="form-check-label" for="decisaoRadio4" style="padding-right:15px;">Regular</label>

                                <input class="form-check-input" type="radio" name="decisao" id="decisaoRadio5" value="insuficiente">
                                <label class="form-check-label" for="decisaoRadio5" style="padding-right:15px;">Insuficiente</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label><strong>4. Relacionamento interpessoal</strong></label></br>
                        <small id="anoHelp" class="form-text text-muted">
                            <p class="text-justify">Capacidade de relacionar-se com as pessoas, independente do nível hierárquico ou social, com demonstração de respeito, compreensão e demonstrando habilidade em resolver conflitos interpessoais.</p>
                        </small>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="interpessoal" id="interpessoalRadio1" value="excelente">
                                <label class="form-check-label" for="interpessoalRadio1" style="padding-right:15px;">Excelente</label>

                                <input class="form-check-input" type="radio" name="interpessoal" id="interpessoalRadio2" value="muito bom">
                                <label class="form-check-label" for="interpessoalRadio2" style="padding-right:15px;">Muito bom</label>

                                <input class="form-check-input" type="radio" name="interpessoal" id="interpessoalRadio3" value="bom">
                                <label class="form-check-label" for="interpessoalRadio3" style="padding-right:15px;">Bom</label>

                                <input class="form-check-input" type="radio" name="interpessoal" id="interpessoalRadio4" value="regular">
                                <label class="form-check-label" for="interpessoalRadio4" style="padding-right:15px;">Regular</label>

                                <input class="form-check-input" type="radio" name="interpessoal" id="interpessoalRadio5" value="insuficiente">
                                <label class="form-check-label" for="interpessoalRadio5" style="padding-right:15px;">Insuficiente</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label><strong>5. Saúde física</strong></label></br>
                        <small id="anoHelp" class="form-text text-muted">
                            <p class="text-justify">Capacidade de cuidar da própria saúde com a manutenção do condicionamento físico geral e de seu corpo, refletidos no seu desempenho profissional e em sua apresentação pessoal.</p>
                        </small>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="saude" id="saudeRadio1" value="excelente">
                                <label class="form-check-label" for="saudeRadio1" style="padding-right:15px;">Excelente</label>

                                <input class="form-check-input" type="radio" name="saude" id="saudeRadio2" value="muito bom">
                                <label class="form-check-label" for="saudeRadio2" style="padding-right:15px;">Muito bom</label>

                                <input class="form-check-input" type="radio" name="saude" id="saudeRadio3" value="bom">
                                <label class="form-check-label" for="saudeRadio3" style="padding-right:15px;">Bom</label>

                                <input class="form-check-input" type="radio" name="saude" id="saudeRadio4" value="regular">
                                <label class="form-check-label" for="saudeRadio4" style="padding-right:15px;">Regular</label>

                                <input class="form-check-input" type="radio" name="saude" id="saudeRadio5" value="insuficiente">
                                <label class="form-check-label" for="saudeRadio5" style="padding-right:15px;">Insuficiente</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label><strong>6. Planejamento</strong></label></br>
                        <small id="anoHelp" class="form-text text-muted">
                            <p class="text-justify">Capacidade de analisar fatos e situações, estabelecer planos e ações; assessorar a chefia visando alcançar os objetivos institucionais, de forma sistemática, com previsão de conseqüências.</p>
                        </small>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="planejamento" id="planejamentoRadio1" value="excelente">
                                <label class="form-check-label" for="planejamentoRadio1" style="padding-right:15px;">Excelente</label>

                                <input class="form-check-input" type="radio" name="planejamento" id="planejamentoRadio2" value="muito bom">
                                <label class="form-check-label" for="planejamentoRadio2" style="padding-right:15px;">Muito bom</label>

                                <input class="form-check-input" type="radio" name="planejamento" id="planejamentoRadio3" value="bom">
                                <label class="form-check-label" for="planejamentoRadio3" style="padding-right:15px;">Bom</label>

                                <input class="form-check-input" type="radio" name="planejamento" id="planejamentoRadio4" value="regular">
                                <label class="form-check-label" for="planejamentoRadio4" style="padding-right:15px;">Regular</label>

                                <input class="form-check-input" type="radio" name="planejamento" id="planejamentoRadio5" value="insuficiente">
                                <label class="form-check-label" for="planejamentoRadio5" style="padding-right:15px;">Insuficiente</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label><strong>7. Disciplina</strong></label></br>
                    <small id="anoHelp" class="form-text text-muted">
                        <p class="text-justify">Capacidade de proceder conforme as normas que regem a PM/BM MT, preservando os Valores Institucionais, sem a perder a visão crítica e a criatividade.</p>
                    </small>
                    <div class="mb-3">
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="disciplina" id="disciplinaRadio1" value="excelente">
                            <label class="form-check-label" for="disciplinaRadio1" style="padding-right:15px;">Excelente</label>

                            <input class="form-check-input" type="radio" name="disciplina" id="disciplinaRadio2" value="muito bom">
                            <label class="form-check-label" for="disciplinaRadio2" style="padding-right:15px;">Muito bom</label>

                            <input class="form-check-input" type="radio" name="disciplina" id="disciplinaRadio3" value="bom">
                            <label class="form-check-label" for="disciplinaRadio3" style="padding-right:15px;">Bom</label>

                            <input class="form-check-input" type="radio" name="disciplina" id="disciplinaRadio4" value="regular">
                            <label class="form-check-label" for="disciplinaRadio4" style="padding-right:15px;">Regular</label>

                            <input class="form-check-input" type="radio" name="disciplina" id="disciplinaRadio5" value="insuficiente">
                            <label class="form-check-label" for="disciplinaRadio5" style="padding-right:15px;">Insuficiente</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label><strong>8. Disposição para o trabalho</strong></label></br>
                    <small id="anoHelp" class="form-text text-muted">
                        <p class="text-justify">Capacidade de demonstrar comprometimento com a missão e objetivos da Instituição. É participativo e compartilha problemas e desafios da Instituição. Não foge da responsabilidade, não é apático nem desinteressado. Tem atitude para o seu trabalho.</p>
                    </small>
                    <div class="mb-3">
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="disposicao" id="disposicaoRadio1" value="excelente">
                            <label class="form-check-label" for="disposicaoRadio1" style="padding-right:15px;">Excelente</label>

                            <input class="form-check-input" type="radio" name="disposicao" id="disposicaoRadio2" value="muito bom">
                            <label class="form-check-label" for="disposicaoRadio2" style="padding-right:15px;">Muito bom</label>

                            <input class="form-check-input" type="radio" name="disposicao" id="disposicaoRadio3" value="bom">
                            <label class="form-check-label" for="disposicaoRadio3" style="padding-right:15px;">Bom</label>

                            <input class="form-check-input" type="radio" name="disposicao" id="disposicaoRadio4" value="regular">
                            <label class="form-check-label" for="disposicaoRadio4" style="padding-right:15px;">Regular</label>

                            <input class="form-check-input" type="radio" name="disposicao" id="disposicaoRadio5" value="insuficiente">
                            <label class="form-check-label" for="disposicaoRadio5" style="padding-right:15px;">Insuficiente</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label><strong>9. Assiduidade</strong></label></br>
                    <small id="anoHelp" class="form-text text-muted">
                        <p class="text-justify">Capacidade de estar disponível e com condições efetivas de executar as atividades, nos horários e locais pré-estabelecidos.</p>
                    </small>
                    <div class="mb-3">
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="assiduidade" id="assiduidadeRadio1" value="excelente">
                            <label class="form-check-label" for="assiduidadeRadio1" style="padding-right:15px;">Excelente</label>

                            <input class="form-check-input" type="radio" name="assiduidade" id="assiduidadeRadio2" value="muito bom">
                            <label class="form-check-label" for="assiduidadeRadio2" style="padding-right:15px;">Muito bom</label>

                            <input class="form-check-input" type="radio" name="assiduidade" id="assiduidadeRadio3" value="bom">
                            <label class="form-check-label" for="assiduidadeRadio3" style="padding-right:15px;">Bom</label>

                            <input class="form-check-input" type="radio" name="assiduidade" id="assiduidadeRadio4" value="regular">
                            <label class="form-check-label" for="assiduidadeRadio4" style="padding-right:15px;">Regular</label>

                            <input class="form-check-input" type="radio" name="assiduidade" id="assiduidadeRadio5" value="insuficiente">
                            <label class="form-check-label" for="assiduidadeRadio5" style="padding-right:15px;">Insuficiente</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label><strong>10. Preparo intelectual</strong></label></br>
                    <small id="anoHelp" class="form-text text-muted">
                        <p class="text-justify">Capacidade de buscar novos conhecimentos, mantendo-se em constante preparação intelectual, refletido no desempenho profissional.</p>
                    </small>
                    <div class="mb-3">
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="preparo" id="preparoRadio1" value="excelente">
                            <label class="form-check-label" for="preparoRadio1" style="padding-right:15px;">Excelente</label>

                            <input class="form-check-input" type="radio" name="preparo" id="preparoRadio2" value="muito bom">
                            <label class="form-check-label" for="preparoRadio2" style="padding-right:15px;">Muito bom</label>

                            <input class="form-check-input" type="radio" name="preparo" id="preparoRadio3" value="bom">
                            <label class="form-check-label" for="preparoRadio3" style="padding-right:15px;">Bom</label>

                            <input class="form-check-input" type="radio" name="preparo" id="preparoRadio4" value="regular">
                            <label class="form-check-label" for="preparoRadio4" style="padding-right:15px;">Regular</label>

                            <input class="form-check-input" type="radio" name="preparo" id="preparoRadio5" value="insuficiente">
                            <label class="form-check-label" for="preparoRadio5" style="padding-right:15px;">Insuficiente</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?= $id ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" name="avaliador" value="<?= $avaliador ?>">
                </div>

                <!-- AQUI VAI A NOTA CALCULADA NO JAVASCRIPT ATUALIZA_RESUMO.JS-->
                <div class="form-group">
                    <input type="hidden" id="nota" name="notaCalculada" value="">
                </div>
                <!-- ****************************************************** -->

                <div class="form-group col-md-12">
                    <div class="mb-3">
                        <label for="funcaoDesempenhada">Justificativa</label>
                        <textarea class="form-control" name="textoJustificativa" aria-label="With textarea"></textarea>
                    </div>
                    <small id="justificativaHelp" class="form-text text-muted">Obrigatório o preenchimento quando o conceito final for <strong>menor que 3</strong>.</small>
                </div>

                <div class="form-group col-md-12">
                    <button class="btn btn-primary">Salvar</button>
                    <!-- <button class="btn btn-success">Gerar PDF</button> -->
                    <input type="reset" class="btn btn-secondary">
                </div>
            </form>

            <hr>

        </div>

        <div class="col-md-5">
            <div class="sticky-top">
                <table class="table table-striped" style="text-align: center;">
                    <caption>Resumo da Ficha de Avaliação</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Excelente</th>
                            <th scope="col">Muito bom</th>
                            <th scope="col">Bom</th>
                            <th scope="col">Regular</th>
                            <th scope="col">Insuficiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Total</th>
                            <td id="qtdeExcelente">N/D</td>
                            <td id="qtdeMuitoBom">N/D</td>
                            <td id="qtdeBom">N/D</td>
                            <td id="qtdeRegular">N/D</td>
                            <td id="qtdeInsuficiente">N/D</td>
                        </tr>
                        <tr>
                            <th scope="row">Fatores</th>
                            <td>6</td>
                            <td>5</td>
                            <td>4</td>
                            <td>3</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <th scope="row">Resultados</th>
                            <td id="resultadoExcelente">N/D</td>
                            <td id="resultadoMuitoBom">N/D</td>
                            <td id="resultadoBom">N/D</td>
                            <td id="resultadoRegular">N/D</td>
                            <td id="resultadoInsuficiente">N/D</td>
                        <tr>
                            <th scope="row">Conceito final</th>
                            <td colspan="5" id="conceitoFinal"></td>
                        </tr>

                        <tr>
                            <th scope="row"></th>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <th scope="row">Representa</th>
                            <td colspan="5" id="escalaDeZeroAdez"></td>
                        </tr>
                        <tr>
                            <th scope="row">Média</th>
                            <td colspan="5">
                                <p>
                                    <?php
                                    $stmtPesquisar = $conn->query("SELECT nota FROM fad WHERE militar_id = '$id' AND grau_hierarquico_na_epoca = '$posto_grad'");
                                    $stmtPesquisar->execute();

                                    $resultado = $stmtPesquisar->fetchAll(PDO::FETCH_COLUMN, 0);
                                    $elementos = count($resultado);
                                    if ($elementos >= 3) {
                                        sort($resultado);
                                        array_shift($resultado);
                                        array_pop($resultado);
                                        $qtde = sizeof($resultado);
                                        $media = array_sum($resultado) / $qtde;
                                        //inserção da média no BD
                                        $stmt3 = $conn->prepare("UPDATE militar SET media = ? WHERE id = '$id'");
                                        $stmt3->bindParam(1, $media);
                                        $stmt3->execute();
                                    } else {
                                        //vai colocar a média como ZERO quando houver menos de 3 notas de FAD
                                        $stmt4 = $conn->prepare("UPDATE militar SET media = 0 WHERE id = '$id'");
                                        $stmt4->execute();
                                    }
                                    ?>
                                    <?php
                                    $consulta = $conn->query("SELECT media FROM militar WHERE id = '" . $id . "' ");
                                    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
                                    if (isset($resultado['media'])  && $resultado['media'] != 0) {
                                        $media = $resultado['media'];
                                        echo number_format($media, 2);
                                    } else {
                                        echo "Ainda não há notas suficientes para calcular a média.";
                                    }
                                    ?>
                                <p>

                            </td>
                        </tr>
                    </tbody>
                </table>

                <?php
                if (isset($_GET['erro'])) {
                    $erro = $_GET['erro'];
                    if ($erro == 1) {
                        echo '<br><font style="color:#ff0000"><i>*Já havia registro de FAD no período informado.<br>'
                            . 'Portanto o registro foi <strong>atualizado</strong>.</i></font>';
                    }
                }
                ?>
                </p>
                <table class="table table-striped">
                    <caption>Registros de Ficha de Avaliação</caption>
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Ano</th>
                            <th>Nota</th>
                            <th>Excluir</th>
                            <th>Visualizar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        try {
                            //PROCURA REGISTRO DE FAD CONFORME ID DO MILITAR
                            $consulta = $conn->query("SELECT id, ano, semestre, nota FROM fad WHERE militar_id = '$id' AND validacao = 0 ORDER BY ano ASC");
                            //percorrer os resultados
                            while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                $id_da_fad = $resultado['id'];
                                $aux_semestre = $resultado['semestre'];
                                $aux_ano = $resultado['ano'];
                                $aux_nota = $resultado['nota'];

                                echo '<tr>'
                                    . '<td>' . $aux_semestre . 'º semestre</td>'
                                    . '<td>' . $aux_ano . '</td>'
                                    . '<td>' . $aux_nota . '</td>'
                                    . '<td><form action="../Controllers/exclui_fad.php" method="POST"><input type="hidden" name="militar_id" value="' . $id . '"><button class="btn btn-danger" type="submit" name="id_da_fad" value="' . $id_da_fad . '"><i class="bi bi-trash3" title="Excluir FAD."></i></button></form></td>'
                                    . '<td><form action="../Views/view_fad.php" method="POST" target="_blank"><input type="hidden" name="militar_id" value="' . $id . '"><button class="btn btn-success" type="submit" name="id_da_fad" value="' . $id_da_fad . '"><i class="bi bi-eye-fill" title="Visualizar FAD."></i></button></form></td>';
                            }
                        } catch (PDOException $ex) {
                            return $ex->getMessage();
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

</div>

</div>

<?php
include_once '../Views/footer2.php';
?>