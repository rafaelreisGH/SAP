<?php

require_once '../ConexaoDB/conexao.php';

try {
    //query de seleção de usuários bloqueados
    $consulta = $conn->query("SELECT * FROM usuarios WHERE status = 0");
    //percorrer os resultados
    while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $aux_id = $resultado['id'];
        $aux_nome = $resultado['nome'];
        $aux_email = $resultado['email'];
        
        echo '<tr>'
        . '<td align="center"><form action="../Controllers/desbloquear_usuario.php" method="POST"><button class="btn btn-info" type="submit" name="desbloquear" value="'.$aux_id.'"/><em class="glyphicon glyphicon-send" title="Enviar chave de desbloqueio."></em><button></form></td>'
        . '<td>' . $aux_nome . '</td>'
        . '<td>' . $aux_email . '</td>';
    }
} catch (PDOException $ex) {
    return $ex->getMessage();
}

    



 