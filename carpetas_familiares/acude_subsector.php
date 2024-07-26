<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php           
    $sql6 =" SELECT idintegrante_subsector_salud, idsubsector_salud, idsubsector_elige FROM integrante_subsector_salud WHERE idintegrante_cf='8' GROUP BY idsubsector_salud ";
    $result6 = mysqli_query($link,$sql6);
    if ($row6 = mysqli_fetch_array($result6)){
    mysqli_field_seek($result6,0);
    while ($field6 = mysqli_fetch_field($result6)){
    } do { 

    $sql7 =" SELECT idintegrante_subsector_salud, idsubsector_salud, idsubsector_elige FROM integrante_subsector_salud WHERE idintegrante_cf='8' AND idsubsector_salud='$row6[1]' AND idsubsector_elige='1' ";
    $result7 = mysqli_query($link,$sql7);
    if ($row7 = mysqli_fetch_array($result7)){
    mysqli_field_seek($result7,0);
    while ($field7 = mysqli_fetch_field($result7)){
    } do { 

        $sql8 =" SELECT idintegrante_subsector_salud, idsubsector_salud, idsubsector_elige FROM integrante_subsector_salud WHERE idintegrante_cf='8' AND idsubsector_salud='$row6[1]' AND idsubsector_elige='2' ";
        $result8 = mysqli_query($link,$sql8);
        if ($row8 = mysqli_fetch_array($result8)){
        mysqli_field_seek($result8,0);
        while ($field8 = mysqli_fetch_field($result8)){
        } do {     
            echo " SI ";    
        }
        while ($row8 = mysqli_fetch_array($result8));
        } else {
            echo " NO ";
        }
    }
    while ($row7 = mysqli_fetch_array($result7));
    } else {              
    }           
    }
    while ($row6 = mysqli_fetch_array($result6));
    } else {
    }
?>