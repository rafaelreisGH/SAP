<?php
include_once './header2.php';
require_once '../ConexaoDB/conexao.php';

//colocar um POST aqui para pegar o nome e posto/grad do militar em questão para não ter que fazer outra pesquisa no BD
//colocar um campo hidden

//id do militar em questão (selecionado anteriormente)
$militar_id = (isset($_POST['militar_id'])) ? $_POST['militar_id'] : null;

//array para gravar os resultados que vem do BD
$consulta = array();
//SELECT para buscar no BD
$stmt = $conn->prepare("SELECT * FROM registro_de_promocoes WHERE militar_id = :id");
$resultado = $stmt->execute(array(
    ':id' => $militar_id,

));
//percorrer os resultados e salvar no $consulta
while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $consulta[] = $resultado;
}

?>

<div class="container">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="nav-item">
                <a href="listar_militares_relatorio_de_promocoes.php?pesquisar=" class="nav-link">Voltar</a>
            </li>
        </ul>
        <hr>
    </div>
    <h3>
        <strong>Relatório de Registros de promoção</strong>
    </h3>
    <hr>

    <div class="col-md-12">
    </div>


    
    <h5><?php echo '<p align="center">Nome do militar</p>';?></h5>



    <hr>
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th>
                                <p align="center">Data</p>
                            </th>
                            <th>
                                <p align="center">Promovido(a) a</p>
                            </th>
                            <th>
                                <p align="center">Modalidade</p>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        //só mostra a tabela se houver resultados na pesquisa
                        if (isset($stmt)) {
                            foreach ($consulta as $key => $valor) {
                                $aux_a_contar_de = $valor['a_contar_de'];
                                $aux_posto_grad = $valor['grau_hierarquico'];
                                $aux_modalidade = strtolower($valor['modalidade']);
                                
                                echo '<tr>'
                                . '<td align="center">' . $aux_a_contar_de . '</td>'
                                . '<td align="center">' . $aux_posto_grad . '</td>'
                                . '<td align="center">' . $aux_modalidade . '</td>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once './footer2.php';
?>