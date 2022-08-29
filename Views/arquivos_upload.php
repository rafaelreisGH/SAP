<?php
require_once '../Controllers/nivel_gestor.php';
include_once './header2.php';

echo '<div class="container"><div class="col-md-12">';
// --------------------------- //
//INÍCIO
//http://www.linhadecodigo.com.br/artigo/3578/php-upload-de-arquivos.aspx
// --------------------------- //
// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../arquivos/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'png', 'pdf');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
    die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
    exit; // Para a execução do script
}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

// Faz a verificação da extensão do arquivo
//$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
$extensao = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));
if (array_search($extensao, $_UP['extensoes']) === false) {
    echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}

// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
    echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
    // Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
        // Cria um nome unico e com a extensão
        $novoNome = uniqid() . ".$extensao";
    } else {
        // Mantém o nome original do arquivo
        $novoNome = $_FILES['arquivo']['name'];
    }

    // Depois verifica se é possível mover o arquivo para a pasta escolhida
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $novoNome)) {
        // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
        echo '<font style="color:#ff0000"><i class="bi bi-exclamation-circle" fill="currentColor"></i>&nbspInformação</font></br>';
        echo "Upload efetuado com sucesso!";
        //echo '<br /><a href="' . $_UP['pasta'] . $novoNome . '" target="_blank">Clique aqui para acessar o arquivo</a>';
        //echo '</br><a href="edicao_documentos_pasta_promo.php?id_da_pasta=' . $_POST['dados_pasta'] . '">Voltar</a>';

        //SALVAR O CAMINHO DO ARQUIVO NO BANCO DE DADOS
        $caminho = $_UP['pasta'] . $novoNome; //salva o caminho completo do arquivo
        if (salvaNoBanco($_POST['tipo_do_documento'], $caminho, $_POST['dados_pasta']) == 1) echo "<br>Documento salvo no Banco de Dados.";
        else echo "Documento não salvo no Banco de dados.";

        echo '<hr><a href="' . $_UP['pasta'] . $novoNome . '" target="_blank"><button class="btn btn-outline-info active" type="button">Clique aqui para acessar o arquivo</button></a>';
        echo '&nbsp<a href="edicao_documentos_pasta_promo.php?id_da_pasta=' . $_POST['dados_pasta'] . '"><button class="btn btn-outline-success active" type="button">Voltar</button></a>';
    } else {
        // Não foi possível fazer o upload, provavelmente a pasta está incorreta
        echo "Não foi possível enviar o arquivo, tente novamente";
    }
}
// --------------------------- //
//FIM
//http://www.linhadecodigo.com.br/artigo/3578/php-upload-de-arquivos.aspx
// --------------------------- //
echo '</div></div>';
function salvaNoBanco($documento, $caminho, $id)
{
    require_once '../ConexaoDB/conexao.php';
    $stmt = $conn->prepare('UPDATE pasta_promocional SET ' . $documento . ' = :caminho WHERE id = :id');
    $stmt->execute(array(
        ':id' => $id,
        ':caminho' => $caminho
    ));
    if ($stmt) {
        return 1;
    } else {
        return 0;
    }
}
