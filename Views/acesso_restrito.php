<?php
include_once './header2.php';
?>

<div class="container">
    <div class="col-md-12">
    <h4>Atenção!</h4>
    <hr>    
    <p>
            <?php
            echo 'Sr(Srª) ';
            echo $_SESSION['posto_grad_usuario'] . ' ' . $_SESSION['nome'] .',</br>';
            echo '</br><strong>Não foi possível acessar essa página.</strong></br>';
            echo 'Seu perfil de usuário não permite o acesso.</br>';
            echo 'Ou a operação não foi realizada por falta de dados.</br></br>';
            ?>
        </p>
        <A class="btn btn-primary" HREF="javascript:javascript:history.go(-1)">Voltar</A>
    </div>
</div>


<?php
include_once './footer.php';
?>