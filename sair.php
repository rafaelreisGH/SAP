<?php
	session_start();
	
	unset(
		$_SESSION['nome'],
		$_SESSION['email'],
		$_SESSION['nivel_de_acesso']
	);
	//redirecionar o usuario para a página de login
	header("Location: index.php");
?>