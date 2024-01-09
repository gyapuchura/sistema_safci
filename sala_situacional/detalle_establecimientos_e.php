<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");

$idmunicipio = $_GET['idmunicipio'];

$sqlm =" SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$resultm = mysqli_query($link,$sqlm);
$rowm = mysqli_fetch_array($resultm);

$gestion       =  date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ESTABLECIMIENTOS CON PRESENCIA SAFCI</title>
</head>
	<body>
  <h3 style="font-family: Arial; text-align: center;">ESTABLECIMIENTOS DE SALUD</h3>
  <h3 style="font-family: Arial; text-align: center; font-size: 18px;">Municipio : <?php echo $rowm[1];?></h3>
	<table width="664" border="1" align="center">
	  <tbody>
        <tr>
            <td width="17" style="font-family: Arial; font-size: 12px;"><strong>N°</strong></td>
            <td width="62" style="font-family: Arial; font-size: 12px;"><strong>CÓDIGO</strong></td>
            <td width="78" style="font-size: 12px; font-family: Arial;"><strong>RED DE SALUD</strong></td>
            <td width="88" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>MUNICIPIO</strong></td>
            <td width="51" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>ESTABLECIMIENTO DE SALUD</strong></td>
            <td width="54" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>NIVEL</strong></td>	
            <td width="52" style="font-family: Arial; font-size: 12px; text-align: center;"><strong>TIPO DE ESTABLECIMIENTO</strong></td>	
            <td width="47" style="font-family: Arial; font-size: 12px;"><strong>PERSONAL DEL ESTABLECIMIENTO DE SALUD</strong></td>
        </tr>

        <?php
            $numero=1;
            $sql =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.codigo_establecimiento, departamento.departamento, ";
            $sql.=" red_salud.red_salud, municipios.municipio, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, ";
            $sql.=" tipo_establecimiento.tipo_establecimiento FROM personal, dato_laboral, establecimiento_salud, municipios, nivel_establecimiento, red_salud, departamento, tipo_establecimiento  ";
            $sql.=" WHERE personal.iddato_laboral=dato_laboral.iddato_laboral AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
            $sql.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND ";
            $sql.=" red_salud.iddepartamento=departamento.iddepartamento AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND  ";
            $sql.=" establecimiento_salud.idred_salud=red_salud.idred_salud AND establecimiento_salud.latitud != '' AND establecimiento_salud.longitud != ''  ";
            $sql.=" AND establecimiento_salud.idmunicipio='$idmunicipio' GROUP BY establecimiento_salud.idestablecimiento_salud ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>

	    <tr>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[3];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[4];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[5];?></td>
	      <td style="font-family: Arial; font-size: 12px;"><?php echo $row[6];?></td>
        <td style="font-family: Arial; font-size: 12px;"><?php echo $row[7];?></td>
        <td style="font-family: Arial; font-size: 12px;">

        <a href="detalle_personal_eess.php?idestablecimiento_salud=<?php echo $row[0];?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=70,left=250'); return false;">VER PERSONAL</a>  
 
        </td>
        </tr>

        <?php
            $numero=$numero+1;  
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>

      </tbody>
    </table>

	<p>&nbsp;</p>

</body>
</html>
