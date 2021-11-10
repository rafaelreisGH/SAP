<?php
include_once './header.php';

?>

        <div class="container">

            <br /><br />

            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3><?= $_SESSION['nome']?>, mensagem importante!</h3>
                <h4>Alteração obrigatória de senha para o primeiro acesso.</h4>
                <br />
                <form method="post" action="../Controllers/muda_senha.php" id="formCadastrarse">
                    <div class="form-group">
                        <input type="text" class="form-control" id="senhaNova" name="senhaNova" placeholder="Nova senha" required="required">    
                    </div>                   
                    <button type="submit" class="btn btn-danger form-control">Alterar senha</button>
                </form>
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