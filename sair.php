<?php
session_start();            // Inicia a sessão
session_unset();            // Limpa todas as variáveis de sessão
session_destroy();          // Destroi a sessão
//redirecionar o usuario para a página de login
header("Location: index.php");
exit();
