<?php

require_once '../ConexaoDB/conexao.php';

$usuario_a_desbloquear = isset($_POST['desbloquear']) ? filter_input(INPUT_POST, 'desbloquear', FILTER_SANITIZE_STRING) : 0;
include_once './gera_senha.php';
$aux = geraSenha(15, true, true, true);
$nova_senha = md5($aux);

//criar o arquivo html que envia a senha temporária
$file = fopen("../Email/msg_email_senha.html", "w+");
fwrite($file, "<h1>Chave para acesso inicial no SAP - CBMMT</h1>
  <br>
  <p>
  Informe a senha provisória encaminhada nesta mensagem para realizar o acesso ao SAP - CBMMT.
  </p>
  <p>Senha:&nbsp;
  $aux
  </p>
  <br><br>");
fclose($file);

//chama o PHP para enviar email com a senha
include_once '../Email/envia_email_senha.php';
if ($mail->send()) {
    $stmt = $conn->query("UPDATE usuarios SET status = 1, senha = '" . $nova_senha . "' WHERE id = '" . $usuario_a_desbloquear . "'");
    unlink("../Email/msg_email_senha.html");
    header('Location:../Views/pagina_admin.php');
} else {
    echo "Não foi possível encaminhar a senha.";
}


/*EXEMPLO DE SELECT COM PDO
$stmt2 = $conn->query("SELECT * FRO WHERE id = '".$usuario_a_desbloquear."'");
while ($resultado = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $aux_id = $resultado['id'];
    $aux_nome = $resultado['nome'];
    $aux_email = $resultado['email'];
    echo $aux_id."<br>".$aux_nome."<br>".$aux_email;
}*/

    