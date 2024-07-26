<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php  
    $sql_seg = " SELECT sum(valor_cf) FROM determinante_salud_cf WHERE idcarpeta_familiar='2' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
    $result_seg = mysqli_query($link,$sql_seg);
    $row_seg = mysqli_fetch_array($result_seg);
    $seguridad = $row_seg[0];

    echo "</br>= ".$seguridad;

    if ($seguridad == '0') {
        $sql5 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='103'  ";
        $result5 = mysqli_query($link,$sql5);
        $row5 = mysqli_fetch_array($result5);
        echo "<h6 class='text-secundary'>".$row5[1]."</h6>";
    } else {
        if ($seguridad <= 3) {
            $sql6 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='104' ";
            $result6 = mysqli_query($link,$sql6);
            $row6 = mysqli_fetch_array($result6);
            echo "<h6 class='text-info'>".$row6[1]."</h6>";
        } else {
            if ($seguridad <= 5) {
                    $sql7 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='105' ";
                    $result7 = mysqli_query($link,$sql7);
                    $row7 = mysqli_fetch_array($result7);
                    echo "<h6 class='text-primary'>".$row7[1]."</h6>";
            } else {
                if ($seguridad >= 6) {
                        $sql8 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE idcat_determinante_salud='20' AND iditem_determinante_salud='106' ";
                        $result8 = mysqli_query($link,$sql8);
                        $row8 = mysqli_fetch_array($result8);
                        echo "<h6 class='text-warning'>".$row8[1]."</h6>";
                } else {  } } } }
?>




<?php
    $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='2' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
    $resultd = mysqli_query($link,$sqld);
    $rowd = mysqli_fetch_array($resultd);
    $durante = $rowd[0];

    if ($durante == '0') {
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
?>