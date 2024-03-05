<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

//----- Guardamos en la tabla registro enfermedad por grupo etareo BEGIN ------//

$sql4 =" SELECT notificacion_ep.idnotificacion_ep, registro_enfermedad.idsospecha_diag FROM notificacion_ep, registro_enfermedad WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql4.="  AND registro_enfermedad.idsospecha_diag='19' AND notificacion_ep.estado='CONSOLIDADO' GROUP BY notificacion_ep.idnotificacion_ep ";
$result4 = mysqli_query($link,$sql4);
if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do { 

$sql5 =" SELECT idregistro_enfermedad, idnotificacion_ep, idsospecha_diag FROM registro_enfermedad ";
$sql5.=" WHERE idsospecha_diag='19' AND idnotificacion_ep='$row4[0]' ";
$result5 = mysqli_query($link,$sql5);
$registros = mysqli_num_rows($result5);

echo $row4[0]." - ".$row4[1]." - CANTIDAD REGISTROS = ".$registros;

if ($registros == '40') {

    $numero=1;
    $sql6 =" SELECT idregistro_enfermedad, idnotificacion_ep FROM registro_enfermedad ";
    $sql6.=" WHERE idsospecha_diag='19' AND idnotificacion_ep='$row4[0]' ";
    $result6 = mysqli_query($link,$sql6);
    if ($row6 = mysqli_fetch_array($result6)){
    mysqli_field_seek($result6,0);
    while ($field6 = mysqli_fetch_field($result6)){
    } do {    

        if ($numero < '21') {

            $sql7 = " DELETE FROM registro_enfermedad WHERE idregistro_enfermedad='$row6[0]'";
            $result7 = mysqli_query($link,$sql7);

            $numero=$numero+1;
        } else {  

            $numero=$numero+1;        
        }
 
    }
    while ($row6 = mysqli_fetch_array($result6));
    } else {
    }

    echo "  Se surpimio 20 registros";

} else {   
}
echo "</br>";
}
 while ($row4 = mysqli_fetch_array($result4));
 } else {
 }
//** header("Location:correcion_exitosa.php"); */ 
//----- Guardamos en la tabla registro enfermedad por grupo etareo END ------//

?>
