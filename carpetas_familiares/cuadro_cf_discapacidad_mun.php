<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idmunicipio = $_GET['idmunicipio'];

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUADRO DISCAPACIDAD MUNICIPAL</title>
</head>
<body>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">INTEGRANTES DE LA FAMILIA CON DISCAPACIDAD - MUNICIPIO DE <?php echo mb_strtoupper($row_mun[1]);?></h2>
    
<table width="900" border="1" align="center" cellspacing="0">
  <tbody>
    <tr>
      <td width="150" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #205332;"><strong>NIVEL DE DISCAPCIDAD</strong></td>
      <td width="750" bgcolor="#C3EDD7" style="font-family: Arial; font-size: 12px; color: #284A1F; text-align: center;"><strong>TIPOS DE DISCAPACIDAD</strong></td>
    </tr>
    <?php 
$numero2 = 0;
$sql2 = " SELECT idnivel_discapacidad_cf, nivel_discapacidad_cf FROM nivel_discapacidad_cf ORDER BY idnivel_discapacidad_cf ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>
    <tr>
      <td bgcolor="#E5F3EC" style="font-family: Arial; font-size: 12px;"><strong>
      <?php  echo $row2[1]; ?>
      <span style="color: #ABEDBF"></span>      <span style="color: #CEE9D7"></span></strong></td>
      <td>
      
      <table width="836" border="0">
        <tbody>
          <tr>
          <?php 
$numero3 = 0;
$sql3 = " SELECT idtipo_discapacidad_cf, tipo_discapacidad_cf FROM tipo_discapacidad_cf ORDER BY idtipo_discapacidad_cf ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>
            <td width="138 ">              
              <span style="font-family: Arial; font-size: 12px;">
        <?php
        $sql_a = " SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar ";
        $sql_a.= " WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
        $sql_a.= " AND integrante_discapacidad.idtipo_discapacidad_cf='$row3[0]' AND integrante_discapacidad.idnivel_discapacidad_cf='$row2[0]' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
        $result_a = mysqli_query($link,$sql_a);
        $row_a = mysqli_fetch_array($result_a);
        ?>
        <?php echo $row3[1]; ?>
				<?php echo ":";?> 

<a href="discapacidad_cf_establecimientos.php?idnivel_discapacidad_cf=<?php echo $row2[0];?>&idtipo_discapacidad_cf=<?php echo $row3[0];?>&idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=420,scrollbars=YES,top=50,left=200'); return false;"><?php if ($row_a[0] !='0') { echo $row_a[0]; } else { } ?></a>  
</br>
<a href="piramide_discapacidad_mun.php?idnivel_discapacidad_cf=<?php echo $row2[0];?>&idtipo_discapacidad_cf=<?php echo $row3[0];?>&idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=650,scrollbars=YES,top=60,left=600'); return false;">ETÁREO</a>

</span></td>

<?php 
$numero3++;
} while ($row3 = mysqli_fetch_array($result3));
} else {
}
?>
          </tr>
        </tbody>
      </table>
        
    </td>
    </tr>
    <?php 
$numero2++;
} while ($row2 = mysqli_fetch_array($result2));
} else {
}
?>
  </tbody>
</table>

</body>
</html>