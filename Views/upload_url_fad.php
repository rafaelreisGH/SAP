<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';

echo '<div class="container"><div class="col-md-12">';

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento_id = $_POST['documento_id'] ?? null;
    $documento_url = $_POST['documento_url'] ?? null;
    $militar_id = $_POST['militar_id'] ?? null;

    if ($documento_id && $documento_url) {
        $resultado = salvaNoBanco($documento_url, $documento_id);

        if ($resultado) {
            echo "URL salva com sucesso!";
        } else {
            echo "Erro ao salvar a URL.";
        }
    } else {
        echo "Dados inválidos.";
    }
} else {
    echo "Método inválido.";
}


echo '<hr><a href="' . $documento_url . '" target="_blank"><button class="btn btn-outline-info active" type="button">Clique aqui para acessar o arquivo</button></a>';

echo '&nbsp<a href="view_fad.php?militar_id='.$militar_id.'"><button class="btn btn-outline-success active" type="button">Voltar</button></a>';

echo '</div></div>';



function salvaNoBanco($url_da_fad, $id)
{
    require_once '../ConexaoDB/conexao.php';

    try {
        $stmt = $conn->query('SELECT caminho_do_arquivo FROM fad WHERE id = ' . $id . '')->fetch();

        if (!empty($stmt)) {
            $fad_existe = true;
        }

        if ($fad_existe == true) {
            $stmt = $conn->prepare('UPDATE fad SET caminho_do_arquivo = :caminho WHERE id = :id');
            $stmt->execute(array(
                ':id' => $id,
                ':caminho' => $url_da_fad
            ));
        }
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        die();
    }

    if ($stmt) {
        return 1;
    } else {
        return 0;
    }
}
