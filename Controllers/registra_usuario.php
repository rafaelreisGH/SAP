<?php

require_once '../ConexaoDB/conexao.php';
$retorno_get = '';

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
//$senha = md5(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
//verificar se o usuário já consta no Banco de Dados
//$retorno_get;
$nome_existe = false;
$email_existe = false;
$email_invalido = false;
try {
    //verifica se o nome já existe no BD
    $consulta1 = $conn->query("SELECT * FROM usuarios WHERE nome = '" . $nome . "' ");
    $resultado = $consulta1->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado['nome'])) {
        $nome_existe = true;
    }
    //verifica se o email já existe no BD
    $consulta2 = $conn->query("SELECT * FROM usuarios WHERE email = '" . $email . "' ");
    $resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
    if (isset($resultado2['email'])) {
        $email_existe = true;
    }

    //verifica se email é inválido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_invalido = true;
    }
    //

    if ($nome_existe || $email_existe || $email_invalido) {
        //$retorno_get = '';
        if ($nome_existe) {
            $retorno_get .= "erro_nome=1&";
        }
        if ($email_existe) {
            $retorno_get .= "erro_email=1&";
        }
        if ($email_invalido) {
            $retorno_get .= "email_invalido=1&";
        }

        header('Location: ../Views/inscrevase.php?' . $retorno_get);
        die(); //temporário
    }
} catch (PDOException $ex) {
    return $ex->getMessage();
}
try {
    //SQL Antigo. De antes de retirar o campo senha do FORM de LOGIN
    //$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?)");
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?,?)");

    $stmt->bindParam(1, $nome, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    //$stmt->bindParam(3, $senha, PDO::PARAM_STR);

    $stmt->execute();

    if ($stmt) {
        header('Location:../Views/recem_cadastrado.php');
    }
} catch (PDOException $ex) {
    return $ex->getMessage();
}

/*
  $stmt = $link->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?);
  //PDO::PARAM_STR - PDO::PARAM_INT - PDO::PARAM_BOOL
  //Informam o tipo de dados que está sendo inserido. Para não tratar tudo como string
  $stmt->bindParam(1, $nome, PDO::PARAM_STR);
  $stmt->bindParam(2, $email, PDO::PARAM_STR);
  $stmt->bindParam(3, $senha, PDO::PARAM_STR);

  $stmt->execute();
  if($stmt->execute()){
  echo "Usuário registrado com sucesso.";
  } else {
  echo "Erro ao registrar o usuário!";
  }
 */

/* outra maneira de exibir dados
  if ($stmt->rowCount()>0){
  $linha = $stmt->fetch(PDO::FETCH_ASSOC);
  echo 'Nome: ' . $linha['nome'];
  }
 */
//$conexao = new ClassConexao();
//$link = $conexao->conectaDB();
?>