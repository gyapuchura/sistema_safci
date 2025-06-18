<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI CONCURRENCIA DIA</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>

	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>


<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">INGRESOS A SISTEMA MEDI-SAFCI HOY <?php echo $f_emision;?></h4>

<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">NOMBRE DEL USUARIO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MUNICIPIO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">PERFIL DE USUARIO</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FECHA Y HORA DE INGRESO</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT idlog_login, usuario, fecha_hora, ip FROM log_login WHERE fecha='$fecha' ORDER BY idlog_login DESC ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {

        $sql2 = " SELECT nombre.nombre, nombre.paterno, nombre.materno, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, usuarios.perfil ";
        $sql2.= " FROM usuarios, nombre, personal, dato_laboral, departamento, municipios, establecimiento_salud  ";
        $sql2.= " WHERE usuarios.idnombre=nombre.idnombre AND personal.idnombre=nombre.idnombre AND  personal.iddato_laboral=dato_laboral.iddato_laboral ";
        $sql2.= " AND dato_laboral.iddepartamento=departamento.iddepartamento AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
        $sql2.= " AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND usuarios.usuario='$row[1]' ";
        $result2 = mysqli_query($link,$sql2);
        if ($row2 = mysqli_fetch_array($result2)){
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial;"><?php echo mb_strtoupper($row2[0]." ".$row2[1]." ".$row2[2]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row2[6];?></td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <?php echo $row[2];?>
              </td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
	        </tr>
            <?php
        }
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
	      </tbody>
    </table>


</body>
</html>