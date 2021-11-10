<?php
include_once '../Views/header2.php';
require_once '../ConexaoDB/conexao.php';


//^^^^APAGAR DAQUI PARA BAIXO DEPOIS
$id = 2339;// id do militar

//^^^^APAGAR DAQUI PARA CIMA DEPOIS


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
                        <th scope="col">Referente ao semestre de:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                    </tr>

                </tbody>
            </table>
        </div>


        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">II - Habilidades, competências e valores avaliados</th>
                        <th scope="col">E</th>
                        <th scope="col">MB</th>
                        <th scope="col">B</th>
                        <th scope="col">R</th>
                        <th scope="col">I</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">1. PRODUTIVIDADE: Capacidade de obter resultados práticos, contribuindo para o alcance dos objetivos de sua área de atuação bem como a melhoria dos serviços prestados, considerando os recursos disponíveis, complexidade das ações e desafios encontrados, dentro de padrões e prazos estabelecidos.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">2. LIDERANÇA: Capacidade de comandar, coordenar, gerenciar e desenvolver trabalhos em equipe, demonstrada pela influência que suas ações e palavras exercem sobre as pessoas.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">3. DECISÃO: Capacidade de analisar fatos, situações e escolher com discernimento a alternativa de solução mais adequada nas diversas situações de trabalho sob sua responsabilidade.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">4. RELACIONAMENTO INTERPESSOAL: Capacidade de relacionar-se com as pessoas, independente do nível hierárquico ou social,com demonstração de respeito, compreensão e demonstrando habilidade em resolver conflitos interpessoais.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">5. SAÚDE FÍSÍCA: Capacidade de cuidar da própria saúde com a manutenção do condicionamento físico geral e de seu corpo, refletidos no seu desempenho profissional e em sua apresentação pessoal. </p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">6. PLANEJAMENTO: Capacidade de analisar fatos e situações, estabelecer planos e ações; assessorar a chefia visando alcançar os objetivos institucionais, de forma sistemática, com previsão de conseqüências.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">7. DISCIPLINA: Capacidade de proceder conforme as normas que regem a PM/BM MT, preservando os Valores Institucionais, sem a perder a visão crítica e a criatividade.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">8. DISPOSIÇÃO PARA O TRABALHO: Capacidade de demonstrar comprometimento com a missão e objetivos da Instituição. É participativo e compartilha problemas e desafios da Instituição. Não foge da responsabilidade, não é apático nem desinteressado. Tem atitude para o seu trabalho.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">9. ASSIDUIDADE: Capacidade de estar disponível e com condições efetivas de executar as atividades, nos horários e locais pré-estabelecidos.</p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">10. PREPARO INTELECTUAL: Capacidade de buscar novos conhecimentos, mantendo-se em constante preparação intelectual, refletido no desempenho profissional. </p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">Total (Quantidade de vez que foi assinalado o conceito) </p>
                        </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">Fatores (multiplicar pelo total do conceito)</p>
                        </th>
                        <td><strong>
                                <p class="text-center">6</p>
                            </strong></td>
                        <td><strong>
                                <p class="text-center">5</p>
                            </strong></td>
                        <td><strong>
                                <p class="text-center">4</p>
                            </strong></td>
                        <td><strong>
                                <p class="text-center">3</p>
                            </strong></td>
                        <td><strong>
                                <p class="text-center">1</p>
                            </strong></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">Resultados</p>
                        </th>
                        <td>
                            <p class="text-center"></p>
                        </td>
                        <td>
                            <p class="text-center"></p>
                        </td>
                        <td>
                            <p class="text-center"></p>
                        </td>
                        <td>
                            <p class="text-center"></p>
                        </td>
                        <td>
                            <p class="text-center"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <p class="text-justify">Conceito final: (soma dos resultados divididos por 10)</p>
                        </th>
                        <td colspan="5">
                            <p class="text-center"></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label for="textoDeJusitificativa">Justificativa: (Apenas constar nos casos de nota final maior que 5,8 e inferior a 3)</label>
                <textarea class="form-control" id="textoDeJusitificativa" rows="3">Texto de exemplo.</textarea>
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
                            <p class="text-center">_____________________________</br>Nome - Posto</br>Avaliado - RG nº_________</p>
                        </td>
                    </tr>
                </tbody>
            </table>






        </div>
    </div>