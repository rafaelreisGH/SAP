<?php
include_once '../Controllers/controle_de_sessao.php';

require_once '../ConexaoDB/conexao.php';
$conn = Conexao::getConexao(); // Obtém a conexão ativa

// $criterio_posto_grad = $_POST['criterio_posto_grad'];
// $criterio_quadro = $_POST['criterio_quadro'];
// $antiguidade_atual = $_POST['antiguidade_atual'];
// $nova_antiguidade = $_POST['antiguidade_informada'];

// Sanitizar strings removendo todas as tags HTML
$criterio_posto_grad = isset($_POST['criterio_posto_grad']) ? strip_tags($_POST['criterio_posto_grad']) : '';
$criterio_quadro = isset($_POST['criterio_quadro']) ? strip_tags($_POST['criterio_quadro']) : '';
// Sanitizar inteiros para $antiguidade_atual e $nova_antiguidade
$antiguidade_atual = isset($_POST['antiguidade_atual']) ? filter_input(INPUT_POST, 'antiguidade_atual', FILTER_SANITIZE_NUMBER_INT) : 0;
$nova_antiguidade = isset($_POST['antiguidade_informada']) ? filter_input(INPUT_POST, 'antiguidade_informada', FILTER_SANITIZE_NUMBER_INT) : 0;

$vetor = array();

//Código para capturar o id do militar que está sendo atualizado
//-----------------------------------------------------//
$stmt = $conn->prepare("SELECT id FROM militar WHERE antiguidade = :posicao_atual");
    $stmt->execute([
        ':posicao_atual' => $antiguidade_atual
    ]);
$militar_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
//-----------------------------------------------------//

if ($antiguidade_atual > $nova_antiguidade) {
    $stmt = $conn->prepare("SELECT antiguidade, id FROM militar WHERE antiguidade >= :posicao_menor AND antiguidade <= :posicao_maior");
    $stmt->execute([
        ':posicao_menor' => $nova_antiguidade,
        ':posicao_maior' => $antiguidade_atual
    ]);
} else {
    $stmt = $conn->prepare("SELECT antiguidade, id FROM militar WHERE antiguidade >= :posicao_maior AND antiguidade <= :posicao_menor");
    $stmt->execute([
        ':posicao_menor' => $nova_antiguidade,
        ':posicao_maior' => $antiguidade_atual
    ]);
}

while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor = $resultado['antiguidade'];
    $key = $resultado['id'];
    $vetor += ["{$key}" => $valor];
}

require_once '../Controllers/ordenar_pela_antiguidade.php';
$vetor = ordenar($vetor, $antiguidade_atual, $nova_antiguidade);

foreach ($vetor as $id => $antiguidade) {
    $antiguidade = (int)$antiguidade;
    $stmt = $conn->prepare('UPDATE militar SET antiguidade = :antiguidade WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id,
        ':antiguidade' => $antiguidade
    ));
}

unset($vetor);

if ($stmt) {

    // Log de alteração de antiguidade
    require_once __DIR__ . '/../Logger/LoggerFactory.php';
    $logger = LoggerFactory::createLogger();
    $logger->info('Usuário atualizou a antiguidade', [
        'id' => $_SESSION['id'],
        'usuario' => $_SESSION['nome'],
        'email' => $_SESSION['email'],
        'perfil' => $_SESSION['nivel_de_acesso'],
        'sujeito' => $militar_id
    ]);

    header('Location:../Views/listar_militares_atualizar_antiguidade.php?sucesso=1&criterio_posto_grad=' . $criterio_posto_grad . '&criterio_quadro=' . $criterio_quadro . '');
}
