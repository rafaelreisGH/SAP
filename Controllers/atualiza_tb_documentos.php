<?php
require_once '../Controllers/nivel_gestor.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST)) {
    header('Location:../Views/acesso_restrito.php');
} elseif ($_POST["excluir_documento"]) {
    echo 'excluir do documento de id:' . $_POST["excluir_documento"] . '';
    $aux_id = $_POST["excluir_documento"];
    $aux_id = (int)filter_var($aux_id, FILTER_SANITIZE_NUMBER_INT);

    if (!filter_var($aux_id, FILTER_VALIDATE_INT)) {
        return false;
    }
    $resultado = ExcluiDoBancoDocPromo($aux_id);
    if ($resultado) {
        header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $_POST["id_da_pasta"] . '');
        exit;
    } else {
        echo "Erro ao salvar o documento.";
    }
} else {
    //Salva os dados recebidos no INPUT em variáveis e executa o SANITIZE
    $id_da_pasta_promo = filter_input(INPUT_POST, "id_da_pasta", FILTER_SANITIZE_NUMBER_INT);
    $militar_id = filter_input(INPUT_POST, "militar_id", FILTER_SANITIZE_NUMBER_INT);
    $nome_documento = filter_input(INPUT_POST, "nome_do_documento", FILTER_SANITIZE_SPECIAL_CHARS);
    $caminho_do_arquivo = filter_input(INPUT_POST, "caminho_do_arquivo", FILTER_SANITIZE_URL);
    $status_documento = filter_input(INPUT_POST, "status_documento", FILTER_SANITIZE_NUMBER_INT);

    //Definição de array para armazenar os erros
    $erros = array();

    //Validação das variáveis
    if (!filter_var($id_da_pasta_promo, FILTER_VALIDATE_INT)) {
        $erros[] = "O id da pasta promocional deve ser um número inteiro.";
    }
    if (!filter_var($militar_id, FILTER_VALIDATE_INT)) {
        $erros[] = "O id do militar deve ser um número inteiro.";
    }
    if (!filter_var($caminho_do_arquivo, FILTER_VALIDATE_URL)) {
        $erros[] = "URL inválida.";
    }
    if (filter_var($status_documento, FILTER_VALIDATE_INT) === false) {
        $erros[] = "O documento deve ter 1 dos 3 status disponíveis.";
    }

    //verificação se houve erros ou não
    if (!empty($erros)) {
        foreach ($erros as $erro)
            echo '<li> $erro </li>' .
                '<div class="container">' .
                '<div class="col-md-12">' .
                '<h4>Atenção!</h4><hr>' .
                '<p>' .
                '<A class="btn btn-primary" HREF="../Views/edicao_documentos_pasta_promo.php?' . $id_da_pasta_promo . '">Voltar</A>' .
                '</div></div>';
    } else {
        if (isset($id_da_pasta_promo, $militar_id, $nome_documento, $caminho_do_arquivo, $status_documento)) {
            $resultado = salvaNoBancoDocPromo($id_da_pasta_promo, $militar_id, $nome_documento, $caminho_do_arquivo, $status_documento);
            if ($resultado) {
                header('Location:../Views/edicao_documentos_pasta_promo.php?id_da_pasta=' . $id_da_pasta_promo . '');
                exit;
            } else {
                echo "Erro ao salvar o documento.";
            }
        } else {
            header('Location:../Views/acesso_restrito.php');
            exit;
        }
    }
}

function salvaNoBancoDocPromo($id, $militar_id, $nome, $caminho, $validado)
{
    require_once '../ConexaoDB/conexao.php';

    try {
        //aqui se encontra o id do documento em específico
        $stmt = $conn->prepare('SELECT id_doc_promo FROM documento_promocao WHERE doc_promo_nome = :a AND pasta_promocional_id = :b');
        $stmt->bindParam(':a', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':b', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado1 = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($resultado1)) {
            // Documento não existe, então insere um novo registro
            $stmt = $conn->prepare('INSERT INTO documento_promocao (doc_promo_nome, doc_promo_url, doc_status_id, pasta_promocional_id, militar_id) VALUES (:nome, :doc_url, :validado, :id, :militar_id)');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':doc_url', $caminho, PDO::PARAM_STR);
            $stmt->bindParam(':validado', $validado, PDO::PARAM_INT);
            $stmt->bindParam(':militar_id', $militar_id, PDO::PARAM_INT);
            $stmt->execute();

            // Verifica se alguma linha foi afetada
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } else {
            //pega o valor do array e coloca na variável
            $id = reset($resultado1);

            // Atualiza o caminho do arquivo e outros dados
            $stmt = $conn->prepare('UPDATE documento_promocao SET doc_promo_url = :b, doc_status_id = :c WHERE id_doc_promo = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':b', $caminho, PDO::PARAM_STR);
            $stmt->bindParam(':c', $validado, PDO::PARAM_INT);
            $stmt->execute();
            // Verifica se alguma linha foi afetada
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        die();
    }
}

function ExcluiDoBancoDocPromo($id)
{
    require_once '../ConexaoDB/conexao.php';

    try {
        //aqui se encontra o id do documento em específico
        $stmt = $conn->prepare('SELECT id_doc_promo FROM documento_promocao WHERE id_doc_promo = :a');
        $stmt->bindParam(':a', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado1 = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($resultado1)) {
            // Documento não existe, retorna false
            return false;
        } else {
            // Atualiza o documento: define doc_promo_url como NULL e doc_status_id como 3
            $stmt = $conn->prepare('
                            UPDATE documento_promocao 
                            SET doc_promo_url = NULL, doc_status_id = 2 
                            WHERE id_doc_promo = :id
                            ');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Verifica se alguma linha foi afetada
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        die();
    }
}
