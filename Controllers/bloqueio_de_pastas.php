<?php
require_once '../ConexaoDB/conexao.php';

//array para gravar os militares que tiveram os registros alterados
$alteracoes = array();

$aux = isset($_POST['pasta_id']) ? $_POST['pasta_id'] : null;
if (!is_null($aux)) :
    foreach ($aux as $item) {
        try {
            $stmt = $conn->prepare('UPDATE pasta_promocional SET pasta_bloqueada = 1 WHERE id = :id');
            $stmt->execute(array(
                ':id' => $item
            ));
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        $rowCount = $stmt->rowCount();
        if ($rowCount != 0) {
            $alteracoes[] = $item;
        }
    }
    if (!empty($alteracoes)) :
        $location = 'Location:../Views/listar_pastas_bloqueadas.php?';
        if (sizeof($alteracoes)) :
            $location .= "alteracoes_realizadas[]=" . implode("&alteracoes_realizadas[]=", $alteracoes);
            header($location);
        endif;
    endif;
else :
    header('Location:../Views/listar_pastas_bloqueadas.php?erro=1');
endif;
