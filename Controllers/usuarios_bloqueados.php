<?php

require_once '../ConexaoDB/conexao.php';

/*
LEGENDA
0 = SIGINIFICA USUÁRIO BLOQUEADO
1 = SIGINIFICA USUÁRIO (DES)BLOQUEADO
*/

//query de seleção de usuários bloqueados
$consulta = $conn->query("SELECT * FROM usuarios WHERE status = 0");
//percorrer os resultados
while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $aux_id = $resultado['id'];
    $aux_nome = $resultado['nome'];
    $aux_email = $resultado['email'];

    echo '<tr>'
        . '<td align="center"><form action="../Controllers/desbloquear_usuario.php" method="POST">'
        .'<div class="input-group">'
        .'<button class="btn btn-info" type="submit" name="desbloquear" value="' . $aux_id . '"/><em class="glyphicon glyphicon-send" title="Enviar chave de desbloqueio."></em></td>'
        . '<td>' . $aux_nome . '</td>'
        . '<td>' . $aux_email . '</td>'
        . '<td><select class="form-select" name="perfil" required><option selected disabled>Selecione uma opção</option><option value="1">Gestor</option><option value="2">Administrador</option><option value="">Usuário</option></div></form></td>'
        . '<td><select class="form-select" name="posto_grad" required><option disabled selected>Posto/Graduação</option><option value="CEL BM">Coronel</option><option value="TC BM">Tenente Coronel</option><option value="MAJ BM">Major</option><option value="CAP BM">Capitão</option><option value="1º TEN BM">1º Tenente</option><option value="2º TEN BM">2º Tenente</option><option value="ASP OF BM">Aspirante-a-oficial</option><option value="ST BM">Sub-tentente</option><option value="1º SGT BM">1º Sargento</option><option value="2º SGT BM">2º Sargento</option><option value="3º SGT BM">3º Sargento</option><option value="CB BM">Cabo</option><option value="SD BM">Soldado</option></div></form></td>';
}
