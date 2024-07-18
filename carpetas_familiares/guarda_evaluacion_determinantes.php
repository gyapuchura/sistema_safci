<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$hora    = date("H:i");
$gestion    = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];
?>

        <?php
            $sql =" SELECT idcarpeta_familiar FROM determinante_salud_cf GROUP BY idcarpeta_familiar";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {

                $sql_1 =" SELECT iddeterminante_salud, determinante_salud FROM determinante_salud ORDER BY iddeterminante_salud";
                $result_1 = mysqli_query($link,$sql_1);
                if ($row_1 = mysqli_fetch_array($result_1)){
                mysqli_field_seek($result_1,0);
                while ($field_1 = mysqli_fetch_field($result_1)){
                } do {

                    echo "Carpeta N° ".$row[0]." - ".$row_1[0].".- ".$row_1[1];
/************ Evaluamos para cada detrminante de la salud  BEGIN ************/

switch ($row_1[0]) {
    case 1:
       
        $sqla = "SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' ";
        $resulta = mysqli_query($link,$sqla);
        $rowa = mysqli_fetch_array($resulta);
        echo " = ".$rowa[0];
        
        $sumatoria = $rowa[0];
        
            if ($sumatoria <= 7 ) {
                $sql5 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
                $result5 = mysqli_query($link,$sql5);
                $row5 = mysqli_fetch_array($result5);
                echo "<h6 style='color: #000000; font-family: arial; font-size: 12px;'>".$row5[1]."</h6>";
                $idriesgo_cfd = $row5[0];
            } else {
                if ($sumatoria <= 11 ) {
                    $sql6 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                    $result6 = mysqli_query($link,$sql6);
                    $row6 = mysqli_fetch_array($result6);
                    echo "<h6 style='color: #00913f; font-family: arial; font-size: 12px;'>".$row6[1]."</h6>";
                    $idriesgo_cfd = $row6[0];
                } else {
                    if ($sumatoria <= 17) {
                            $sql7 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                            $result7 = mysqli_query($link,$sql7);
                            $row7 = mysqli_fetch_array($result7);
                            echo "<h6 style='color: #0000ff; font-family: arial; font-size: 12px;'>".$row7[1]."</h6>";
                            $idriesgo_cfd = $row7[0];
                    } else {
                        if ($sumatoria <= 24) {
                                $sql8 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                                $result8 = mysqli_query($link,$sql8);
                                $row8 = mysqli_fetch_array($result8);
                                echo "<h6 style='color: #FFA500; font-family: arial; font-size: 12px;'>".$row8[1]."</h6>";
                                $idriesgo_cfd = $row8[0];
                        } else { 
                            if ($sumatoria <= 35) {
                                    $sql9 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                    $result9 = mysqli_query($link,$sql9);
                                    $row9 = mysqli_fetch_array($result9);
                                    echo "<h6 style='color: #FF0000; font-family: arial; font-size: 12px;'>".$row9[1]."</h6>";
                                    $idriesgo_cfd = $row9[0];
                            } else {  } } } } }    

                $sql_gu = " INSERT INTO evaluacion_determinante_salud (idcarpeta_familiar, iddeterminante_salud, idriesgo_cf, valor_cf, fecha_registro, hora_registro, idusuario) ";
                $sql_gu.= " VALUES ('$row[0]','$row_1[0]','$idriesgo_cfd','$sumatoria','$fecha','$hora','$idusuario_ss') ";
                $result_gu = mysqli_query($link,$sql_gu); 

        break;
    case 2:
       
        $sqlb = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' ";
        $resultb = mysqli_query($link,$sqlb);
        $rowb = mysqli_fetch_array($resultb);
        echo " = ".$rowb[0];

        $sumatoria = $rowb[0];
        if ($sumatoria <= 16 ) {
            $sql5 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
            $result5 = mysqli_query($link,$sql5);
            $row5 = mysqli_fetch_array($result5);
            echo "<h6 style='color: #000000; font-family: arial; font-size: 12px;'>".$row5[1]."</h6>";
            $idriesgo_cfd = $row5[0];
        } else {
            if ($sumatoria <= 31 ) {
                $sql6 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                $result6 = mysqli_query($link,$sql6);
                $row6 = mysqli_fetch_array($result6);
                echo "<h6 style='color: #00913f; font-family: arial; font-size: 12px;'>".$row6[1]."</h6>";
                $idriesgo_cfd = $row6[0];
            } else {
                if ($sumatoria <= 41) {
                        $sql7 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                        $result7 = mysqli_query($link,$sql7);
                        $row7 = mysqli_fetch_array($result7);
                        echo "<h6 style='color: #0000ff; font-family: arial; font-size: 12px;'>".$row7[1]."</h6>";
                        $idriesgo_cfd = $row7[0];
                } else {
                    if ($sumatoria <= 56) {
                            $sql8 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                            $result8 = mysqli_query($link,$sql8);
                            $row8 = mysqli_fetch_array($result8);
                            echo "<h6 style='color: #FFA500; font-family: arial; font-size: 12px;'>".$row8[1]."</h6>";
                            $idriesgo_cfd = $row8[0];
                    } else { 
                        if ($sumatoria <= 80) {
                                $sql9 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                $result9 = mysqli_query($link,$sql9);
                                $row9 = mysqli_fetch_array($result9);
                                echo "<h6 style='color: #FF0000; font-family: arial; font-size: 12px;'>".$row9[1]."</h6>";
                                $idriesgo_cfd = $row9[0];
                        } else {  } } } } }

                    $sql_gu = " INSERT INTO evaluacion_determinante_salud (idcarpeta_familiar, iddeterminante_salud, idriesgo_cf, valor_cf, fecha_registro, hora_registro, idusuario) ";
                    $sql_gu.= " VALUES ('$row[0]','$row_1[0]','$idriesgo_cfd','$sumatoria','$fecha','$hora','$idusuario_ss') ";
                    $result_gu = mysqli_query($link,$sql_gu); 
        
        break;
    case 3:
       
        $sqlc = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' ";
        $resultc = mysqli_query($link,$sqlc);
        $rowc = mysqli_fetch_array($resultc);
        echo " = ".$rowc[0];

        $valor_cf = $rowc[0];

        $sumatoria = $rowc[0];
        if ($sumatoria <= 3) {
            $sql5 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
            $result5 = mysqli_query($link,$sql5);
            $row5 = mysqli_fetch_array($result5);
            echo "<h6 style='color: #000000; font-family: arial; font-size: 12px;'>".$row5[1]."</h6>";
            $idriesgo_cfd = $row5[0];
        } else {
            if ($sumatoria <= 5) {
                $sql6 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                $result6 = mysqli_query($link,$sql6);
                $row6 = mysqli_fetch_array($result6);
                echo "<h6 style='color: #00913f; font-family: arial; font-size: 12px;'>".$row6[1]."</h6>";
                $idriesgo_cfd = $row6[0];
            } else {
                if ($sumatoria <= 9) {
                        $sql7 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                        $result7 = mysqli_query($link,$sql7);
                        $row7 = mysqli_fetch_array($result7);
                        echo "<h6 style='color: #0000ff; font-family: arial; font-size: 12px;'>".$row7[1]."</h6>";
                        $idriesgo_cfd = $row7[0];
                } else {
                    if ($sumatoria <= 11) {
                            $sql8 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                            $result8 = mysqli_query($link,$sql8);
                            $row8 = mysqli_fetch_array($result8);
                            echo "<h6 style='color: #FFA500; font-family: arial; font-size: 12px;'>".$row8[1]."</h6>";
                            $idriesgo_cfd = $row8[0];
                    } else { 
                        if ($sumatoria <= 15) {
                                $sql9 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                $result9 = mysqli_query($link,$sql9);
                                $row9 = mysqli_fetch_array($result9);
                                echo "<h6 style='color: #FF0000; font-family: arial; font-size: 12px;'>".$row9[1]."</h6>";
                                $idriesgo_cfd = $row9[0];
                        } else {  } } } } }

                    $sql_gu = " INSERT INTO evaluacion_determinante_salud (idcarpeta_familiar, iddeterminante_salud, idriesgo_cf, valor_cf, fecha_registro, hora_registro, idusuario) ";
                    $sql_gu.= " VALUES ('$row[0]','$row_1[0]','$idriesgo_cfd','$sumatoria','$fecha','$hora','$idusuario_ss') ";
                    $result_gu = mysqli_query($link,$sql_gu); 
        
        break;
    case 4:
       
        $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' AND idcat_determinante_salud='19' ";
        $resultd = mysqli_query($link,$sqld);
        $rowd = mysqli_fetch_array($resultd);
        $durante = $rowd[0];

        if ($durante == '0' || $durante == '') {
           $grado_alimentario = '1';
        } else {
            if ($durante <= 3) {
                $grado_alimentario = '3';
            } else {
                if ($durante <= 5) {
                    $grado_alimentario = '4';
                } else {
                    if ($durante >= 6) {
                        $grado_alimentario = '5';
                    } else {  } } } }                                                           

        $sqlcon = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' AND idcat_determinante_salud='21' ";
        $resultcon = mysqli_query($link,$sqlcon);
        $rowcon = mysqli_fetch_array($resultcon);
        $consumo = $rowcon[0];

        $alimentaria = $grado_alimentario + $consumo;

        echo " = ".$alimentaria;

        if ($alimentaria <= 7) {
            $sql5 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
            $result5 = mysqli_query($link,$sql5);
            $row5 = mysqli_fetch_array($result5);
            echo "<h6 style='color: #000000; font-family: arial; font-size: 12px;'>".$row5[1]."</h6>";
            $idriesgo_cfd = $row5[0];
        } else {
            if ($alimentaria <= 13) {
                $sql6 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
                $result6 = mysqli_query($link,$sql6);
                $row6 = mysqli_fetch_array($result6);
                echo "<h6 style='color: #00913f; font-family: arial; font-size: 12px;'>".$row6[1]."</h6>";
                $idriesgo_cfd = $row6[0];
            } else {
                if ($alimentaria <= 21) {
                        $sql7 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                        $result7 = mysqli_query($link,$sql7);
                        $row7 = mysqli_fetch_array($result7);
                        echo "<h6 style='color: #0000ff; font-family: arial; font-size: 12px;'>".$row7[1]."</h6>";
                        $idriesgo_cfd = $row7[0];
                } else {
                    if ($alimentaria <= 30) {
                            $sql8 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                            $result8 = mysqli_query($link,$sql8);
                            $row8 = mysqli_fetch_array($result8);
                            echo "<h6 style='color: #FFA500; font-family: arial; font-size: 12px;'>".$row8[1]."</h6>";
                            $idriesgo_cfd = $row8[0];
                    } else { 
                        if ($alimentaria <= 35) {
                                $sql9 = " SELECT idriesgo_cf, riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                                $result9 = mysqli_query($link,$sql9);
                                $row9 = mysqli_fetch_array($result9);
                                echo "<h6 style='color: #FF0000; font-family: arial; font-size: 12px;'>".$row9[1]."</h6>";
                                $idriesgo_cfd = $row9[0];
                        } else {  } } } } }

            $sql_gu = " INSERT INTO evaluacion_determinante_salud (idcarpeta_familiar, iddeterminante_salud, idriesgo_cf, valor_cf, fecha_registro, hora_registro, idusuario) ";
            $sql_gu.= " VALUES ('$row[0]','$row_1[0]','$idriesgo_cfd','$alimentaria','$fecha','$hora','$idusuario_ss') ";
            $result_gu = mysqli_query($link,$sql_gu); 
        
        break;
}

echo "</br>";
/************ Evaluamos para cada detrminante de la salud  END  ************/
                }
                while ($row_1 = mysqli_fetch_array($result_1));
                } else {
                }            
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>
