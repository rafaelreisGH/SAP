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
                        <td><?= $res[0]['grau_hierarquico_na_epoca'] ?></td>
                        <td><?= $res[0]['nome'] ?></td>
                        <td><?= $res[0]['quadro'] ?></td>
                        <td>
                            <?= $res[0]['semestre'] .'º semestre' ?></td>
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
                        <td><?= $res[0]['funcao_desempenhada'] ?></td>
                    </tr>

                </tbody>
            </table>
        </div>


        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">II - Habilidades, competências e valores avaliados</th>
                        <th scope="col">Conceito</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">1. PRODUTIVIDADE: Capacidade de obter resultados práticos, contribuindo para o alcance dos objetivos de sua área de atuação bem como a melhoria dos serviços prestados, considerando os recursos disponíveis, complexidade das ações e desafios encontrados, dentro de padrões e prazos estabelecidos.</p>
                        </th>
                        <td><?= ucfirst($res[0]['produtividade']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">2. LIDERANÇA: Capacidade de comandar, coordenar, gerenciar e desenvolver trabalhos em equipe, demonstrada pela influência que suas ações e palavras exercem sobre as pessoas.</p>
                        </th>
                        <td><?= ucfirst($res[0]['lideranca']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">3. DECISÃO: Capacidade de analisar fatos, situações e escolher com discernimento a alternativa de solução mais adequada nas diversas situações de trabalho sob sua responsabilidade.</p>
                        </th>
                        <td><?= ucfirst($res[0]['decisao']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">4. RELACIONAMENTO INTERPESSOAL: Capacidade de relacionar-se com as pessoas, independente do nível hierárquico ou social,com demonstração de respeito, compreensão e demonstrando habilidade em resolver conflitos interpessoais.</p>
                        </th>
                        <td><?= ucfirst($res[0]['relacionamento_interpessoal']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">5. SAÚDE FÍSÍCA: Capacidade de cuidar da própria saúde com a manutenção do condicionamento físico geral e de seu corpo, refletidos no seu desempenho profissional e em sua apresentação pessoal. </p>
                        </th>
                        <td><?= ucfirst($res[0]['saude_fisica']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">6. PLANEJAMENTO: Capacidade de analisar fatos e situações, estabelecer planos e ações; assessorar a chefia visando alcançar os objetivos institucionais, de forma sistemática, com previsão de conseqüências.</p>
                        </th>
                        <td><?= ucfirst($res[0]['planejamento']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">7. DISCIPLINA: Capacidade de proceder conforme as normas que regem a PM/BM MT, preservando os Valores Institucionais, sem a perder a visão crítica e a criatividade.</p>
                        </th>
                        <td><?= ucfirst($res[0]['disciplina']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">8. DISPOSIÇÃO PARA O TRABALHO: Capacidade de demonstrar comprometimento com a missão e objetivos da Instituição. É participativo e compartilha problemas e desafios da Instituição. Não foge da responsabilidade, não é apático nem desinteressado. Tem atitude para o seu trabalho.</p>
                        </th>
                        <td><?= ucfirst($res[0]['disposicao_para_o_trabalho']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">9. ASSIDUIDADE: Capacidade de estar disponível e com condições efetivas de executar as atividades, nos horários e locais pré-estabelecidos.</p>
                        </th>
                        <td><?= ucfirst($res[0]['assiduidade']) ?></td>

                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">10. PREPARO INTELECTUAL: Capacidade de buscar novos conhecimentos, mantendo-se em constante preparação intelectual, refletido no desempenho profissional. </p>
                        </th>
                        <td><?= ucfirst($res[0]['preparo_intelectual']) ?></td>

                    </tr>

                    <tr>
                        <th scope="row">
                            <p class="text-justify">Conceito final: (soma dos resultados divididos por 10)</p>
                        </th>
                        <td colspan="5">
                            <p class="text-center"><?= $res[0]['nota'] ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label for="textoDeJusitificativa">Justificativa: (Apenas constar nos casos de nota final maior que 5,8 e inferior a 3)</label>
                <textarea class="form-control" id="textoDeJusitificativa" rows="3"><?= $res[0]['justificativa'] ?></textarea>
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
                            <p class="text-justify">Ciente em: _____/_____/_______.</p>
                            </br>
                            </br>
                            <p class="text-center">_____________________________</br><?=$res[0]['nome']?>&nbsp-&nbsp<?=$res[0]['posto_grad_mil']?></br>Avaliado - RG nº_________</p>
                        </td>
                    </tr>
                </tbody>
            </table>






        </div>
    </div>