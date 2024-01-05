<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");
?>

<?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, ";
$sql2.= " nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud ";
$sql2.= " FROM establecimiento_salud, nivel_establecimiento, tipo_establecimiento WHERE establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !=''  ";
$sql2.= " AND establecimiento_salud.longitud !='' AND establecimiento_salud.idmunicipio = '90' ORDER BY idestablecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>
            {
            address: '<?php echo $row2[2];?>',
            description: '<?php echo $row2[1];?>',
            price: '$ 3,889,000',
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
echo "";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>