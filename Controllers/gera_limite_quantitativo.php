<?php

require_once '../ConexaoDB/conexao.php';

try {
    $stmt = $conn->prepare("SELECT * FROM tb_intersticio");
    $resultado = $stmt->execute();
    $resultado_int = $stmt->fetch(PDO::FETCH_ASSOC);

    //instanciar variaveis que guardam os interstícios
    $aux_sd_cb;
    $aux_cb_3sgt;
    $aux_3sgt_2sgt;
    $aux_2sgt_1sgt;
    $aux_1sgt_st;
    $aux_st_2ten;
    $aux_asp_2ten;
    $aux_2ten_1ten;
    $aux_1ten_cap;
    $aux_cap_maj;
    $aux_maj_tc;
    $aux_tc_cel;

    foreach ($resultado_int as $key => $value) {
        switch ($key) {
            case "sd_cb":
                $aux_sd_cb = $value;
                break;
            case "cb_3sgt":
                $aux_cb_3sgt = $value;
                break;
            case "3sgt_2sgt":
                $aux_3sgt_2sgt = $value;
                break;
            case "2sgt_1sgt":
                $aux_2sgt_1sgt = $value;
                break;
            case "1sgt_st":
                $aux_1sgt_st = $value;
                break;
            case "st_2ten":
                $aux_st_2ten = $value;
                break;
            case "asp_2ten":
                $aux_asp_2ten = $value;
                break;
            case "2ten_1ten":
                $aux_2ten_1ten = $value;
                break;
            case "1ten_cap":
                $aux_1ten_cap = $value;
                break;
            case "cap_maj":
                $aux_cap_maj = $value;
                break;
            case "maj_tc":
                $aux_maj_tc = $value;
                break;
            case "tc_cel":
                $aux_tc_cel = $value;
                break;
        }
    }

    $stmt = $conn->prepare("SELECT ultima_promocao FROM militar WHERE id = 33");
    $resultado = $stmt->execute();
    $resultado_data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $resultado_data['ultima_promocao'];
    $data_ultima_promocao = $resultado_data['ultima_promocao'] . '</br>';
    print "<br>";

    //proxima promocao
    $proxima_promocao;
    $mes_atual = date("m"); //verifica o mês atual
    echo 'Data atual: ' . $mes_atual . '</BR>';
    if ($mes_atual < 7) {
        $ano_atual = date("Y");
        $proxima_promocao = $ano_atual . "-07-02";
        echo "Próxima promoção: " . $proxima_promocao;
    } else if ($mes_atual > 6)

    print "<br>";

    $data1 = "2015-07-02";
    $data2 = "2019-07-02";

    $data1_aux = strtotime($data1);
    $data2_aux = strtotime($data2);

    $diff = ($data2_aux - $data1_aux) * (3.1688 / 100000000);
    list($ano, $mes, $dia) = explode("-", $proxima_promocao); //exibir a data formato BR
    echo round($diff) . ' anos de interstício em ' . $dia . '/' . $mes . '/' . $ano;


    /*
      while ($resultados = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $aux_id = $resultados['id'];
      $aux_nome = $resultados['nome'];
      $aux_posto_grad = $resultados['posto_grad_mil'];

      echo '<tr>'
      . '<td align="center"><form action="../Views/insere_fad.php" method="POST"><button class="btn btn-info" type="submit" name="militar_id" value="'.$aux_id.'"><em class="glyphicon glyphicon-copy" title="Cadastrar FAD."></em></button></form></td>'
      . '<td align="center"><form action="../Views/pasta_promocional_home.php" method="POST"><button class="btn btn-danger" type="submit" name="militar_id" value="'.$aux_id.'"><em class="glyphicon glyphicon-folder-open" title="Cadastrar Documentos."></em></button></form></td>'
      . '<td>' . $aux_posto_grad . '</td>'
      . '<td>' . $aux_nome . '</td>';
      }
     *      */

    //header('Location:../Views/pasta_promocional_home.php?militar_id=' . $id . '&sucesso_exclusão=' . $sucesso . '');
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}