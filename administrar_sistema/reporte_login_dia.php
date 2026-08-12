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

    <style>
    #pantalla-carga {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.95);
        z-index: 9999999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: opacity 0.5s ease;
        font-family: Arial, sans-serif;
    }
    .spinner-loader {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #7cb5ec; /* Turquesa corporativo de referencias */
        border-radius: 50%;
        animation: girar 1s linear infinite;
        margin-bottom: 20px;
    }
    .texto-loader {
        color: #7cb5ec;
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 1px;
    }
    @keyframes girar {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    body.bloqueado { overflow: hidden; }
</style>

<div id="pantalla-carga">
    <div class="spinner-loader"></div>
    <div class="texto-loader">Procesando INGRESOS DEL DIA, por favor espere...</div>
</div>
<?php
    // MAGIA BACKEND: Obligamos a Apache/PHP a pintar esto en la pantalla del usuario YA
    if (ob_get_level() == 0) ob_start();
    echo str_pad('', 4096); // Hack de 4KB para forzar el vaciado en servidores con GZIP
    ob_flush();
    flush();
?> 

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

    <script>
    // Evitamos que el usuario baje por la página mientras carga
    document.body.classList.add('bloqueado');

    // Escuchamos el evento 'load', que se dispara solo cuando TODO ha cargado
    window.addEventListener('load', function() {
        const loader = document.getElementById('pantalla-carga');
        if(loader) {
            // Animación de desvanecimiento
            loader.style.opacity = '0';
            setTimeout(function() {
                loader.style.display = 'none';
                document.body.classList.remove('bloqueado');
            }, 500); // Se remueve del DOM tras medio segundo
        }
    });
</script>

</body>
</html>