<?php
include_once './header3.php';
?>

<div class="container">
    <div class="col-md-12">
    <h4>Atenção!</h4>
    <hr>    
    <p>
            <?php
            echo 'Sr(Srª) ';
            echo $_SESSION['posto_grad_usuario'] . ' ' . $_SESSION['nome'] .'.</br></br>    ';
            echo '<strong>ACESSO NEGADO</strong></br>';
            echo 'Seu perfil não confere acesso a esta página, ou a operação não é permitida.</br></br>';
            ?>
        </p>
        <A class="btn btn-primary" HREF="javascript:javascript:history.go(-1)">Voltar</A>
    </div>
</div>


<?php
include_once './footer.php';
?>