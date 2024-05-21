<?php include("../inc.config.php"); ?>
<?php
$sumatoria  = 17;


if ($sumatoria <= 7 ) {
    $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='1'  ";
    $result5 = mysqli_query($link,$sql5);
    $row5 = mysqli_fetch_array($result5);
    echo " = ".$row5[0];
} else {
    if ($sumatoria <= 11 ) {
        $sql6 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='2' ";
        $result6 = mysqli_query($link,$sql6);
        $row6 = mysqli_fetch_array($result6);
        echo " = ".$row6[0];
    } else {
        if ($sumatoria >= 17) {
                $sql7 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='3' ";
                $result7 = mysqli_query($link,$sql7);
                $row7 = mysqli_fetch_array($result7);
                echo " = ".$row7[0];
        } else {
            if ($sumatoria >= 24) {
                    $sql8 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='4' ";
                    $result8 = mysqli_query($link,$sql8);
                    $row8 = mysqli_fetch_array($result8);
                    echo " = ".$row8[0];
            } else { 
                if ($sumatoria >= 37) {
                        $sql9 = " SELECT riesgo_cf FROM riesgo_cf WHERE idriesgo_cf ='5' ";
                        $result9 = mysqli_query($link,$sql9);
                        $row9 = mysqli_fetch_array($result9);
                        echo " = ".$row9[0];
                } else {  } } } } }
?>
