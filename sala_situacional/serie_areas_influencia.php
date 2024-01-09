<?php  include("../inc.config.php");?>
<?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, ";
$sql2.= " nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud ";
$sql2.= " FROM establecimiento_salud, nivel_establecimiento, tipo_establecimiento WHERE establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !=''  ";
$sql2.= " AND establecimiento_salud.longitud !='' AND establecimiento_salud.idestablecimiento_salud = '808' ORDER BY idestablecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>
            {
            address: '<?php echo $row2[3];?>',
            description: '<?php echo $row2[3];?>',
            price: '<?php echo $row2[1]." - ".$row2[2];?>',
            type: 'home',
            bed: 5,
            bath: 4.5,
            size: 300,
            position: {  
                lat: <?php echo $row2[4];?>,
                lng: <?php echo $row2[5];?>,
            },
            }
            
<?php 
$numero2++;
if ($numero2 == $total2) {
echo ",";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {

}

/****** Areas de influencia del Establecimiento de salud *********/

$numero4 = 0;
$sql4 = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, ";
$sql4.= " area_influencia.habitantes, area_influencia.familias, area_influencia.distancia, area_influencia.latitud, area_influencia.longitud ";
$sql4.= " FROM area_influencia, tipo_area_influencia WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
$sql4.= " AND area_influencia.idestablecimiento_salud='808' ";
$result4 = mysqli_query($link,$sql4);
$total4 = mysqli_num_rows($result4);
 if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do {
	?>
            {
            address: '<?php echo $row4[3];?>',
            description: '<?php echo $row4[4];?>',
            price: '<?php echo $row4[1]." - ".$row4[2];?>',
            type: 'warehouse',
            bed: 5,
            bath: 4.5,
            size: 300,
            position: {  
                lat: <?php echo $row4[6];?>,
                lng: <?php echo $row4[7];?>,
            },
            }
            
<?php 
$numero4++;
if ($numero4 == $total4) {
echo "";
}
else {
echo ",";
}
} while ($row4 = mysqli_fetch_array($result4));
} else {
}
?>