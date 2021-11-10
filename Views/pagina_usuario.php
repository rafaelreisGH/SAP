<?php
include_once './header.php';
?>
<div class="container">

    <br /><br />

    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h2>Página de Usuário</h2>
        <p><strong>Bem-vindo(a), </strong> <?= $_SESSION['nome'] ?>.</p><br>
        <p><strong>Email/Login:</strong> <?= $_SESSION['email'] ?>.</p><br>
    </div>
    <div class="col-md-4"></div>

    <div class="clearfix"></div>
    <br />
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>

</div>


</div>

<?php
include_once './footer.php';
?>
    


