<?php
	session_start();
	
	unset(
		$_SESSION['nome'],
		$_SESSION['email'],
		$_SESSION['nivel_de_acesso'],
		$_SESSION['logado']
	);
	//redirecionar o usuario para a página de login
	header("Location: index.php");
?>