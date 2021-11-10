<?php
include_once './header.php';

$update_xml_no_bd = isset($_GET['update']) ? $_GET['update'] : 0;
?>

<div class="container">

    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="pagina_gestor.php">Voltar</a></li>
        </ul>
        <hr>
    </div>
    <div class="clearfix">

    </div>
    <div class="col-md-4">
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <h3>Atualização dos dados de militares</h3>
            <hr>
            <p>
                Atenção! Esta ação atualiza <strong>totalmente</strong> a tabela de militares.<br>
                Esteja certo de que o arquivo fonte esteja correto.<br><hr>
            </p>
            <?php
            include_once '../ConexaoDB/conexao.php';
            $stmt = $conn->query('SELECT COUNT(id) AS result FROM militar');
            $stmt->execute();
            $total = $stmt->fetchColumn();
            echo $total . " militares registrados atualmente.";
            ?>
            <hr>

            <form method="POST" action="../Controllers/atualiza_tb_militar.php" enctype="multipart/form-data">
                <label>Arquivo</label>
                <input type="file" name="arquivo" class="form-control-file"><br>
                <input type="submit" value="Enviar" class="btn btn-primary">
            </form>
            <?php
            if ($update_xml_no_bd == 1) {
                echo '<font style="color:#ff0000">*Registros atualizados com sucesso.</font>';
            }
            ?>
            <br>

        </div>

    </div>
    <div class="col-md-4">
    </div>
</div>


</div>

<?php
include_once './footer.php';
?>