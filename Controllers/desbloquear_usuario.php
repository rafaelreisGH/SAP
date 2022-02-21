<?php

require_once '../ConexaoDB/conexao.php';

$nivel_de_acesso = (isset($_POST['perfil'])) ? $_POST['perfil'] : null;
$posto_grad = (isset($_POST['posto_grad'])) ? $_POST['posto_grad'] : null;

$usuario_a_desbloquear = isset($_POST['desbloquear']) ? filter_input(INPUT_POST, 'desbloquear', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW) : 0;
include_once './gera_senha.php';
$aux = geraSenha(15, true, true, true);
$primeira_senha = md5($aux);

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

$stmt = $conn->query("SELECT nome, email FROM usuarios WHERE id = '" . $usuario_a_desbloquear . "'")->fetch();
if($stmt){
    $aux_nome = $stmt['nome'];
    $aux_email = $stmt['email'];
}

//chama o PHP para enviar email com a senha
include_once '../Email/envia_email_senha.php';
if ($mail->send()) {
    $stmt = $conn->query("UPDATE usuarios SET status = 1, senha = '" . $primeira_senha . "', nivel_de_acesso = '".$nivel_de_acesso."', posto_grad_usuario = '".$posto_grad."' WHERE id = '" . $usuario_a_desbloquear . "'");
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

    