<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
        $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='2' AND iddeterminante_salud='4' AND idcat_determinante_salud='19' ";
        $resultd = mysqli_query($link,$sqld);
        $rowd = mysqli_fetch_array($resultd);

        $durante = '6';

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

    echo $grado_alimentario;
?>