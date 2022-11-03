<?php
function consulta_acessos_do_usuario($conn, $id_usuario)
{
    //pegar informação no BD
    //quais militares o usuário tem acesso
    try {
        $stmt = $conn->query("SELECT militar.id, militar.nome, militar.posto_grad_mil, militar.quadro, usuario_acesso_militar.acesso_candidato, usuario_acesso_militar.acesso_sadm, usuario_acesso_militar.acesso_avaliador
    FROM militar
    INNER JOIN usuario_acesso_militar
    ON militar.id = usuario_acesso_militar.militar_id
    WHERE usuario_acesso_militar.usuario_id = '$id_usuario'");
    } catch (PDOException $ex) {
        echo 'Exceção capturada: ', $ex->getMessage(), "\n";
    }
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}
