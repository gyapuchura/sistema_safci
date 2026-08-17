<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

$idpatologia = $_GET['idpatologia'];

$sql_pat = " SELECT idpatologia, patologia, cie FROM patologia WHERE idpatologia='$idpatologia' ";
$result_pat = mysqli_query($link,$sql_pat);
$row_pat = mysqli_fetch_array($result_pat);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MEDI-SAFCI ATENCIONES INTEGRALES - DIARIAS</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
        <script src="../js/highcharts.js"></script>
        <script src="../js/modules/exporting.js"></script>

		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
        $(function () {
            $('#container').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: '<?php echo $row_pat[1];?> - <?php echo $row_pat[2];?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        xAxis: {
            categories: [
 <?php
$numero = 0;
$sql = " SELECT atencion_psafci.fecha_registro FROM atencion_psafci, diagnostico_psafci WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
$sql.= " AND diagnostico_psafci.idpatologia='$idpatologia' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY atencion_psafci.fecha_registro ORDER BY atencion_psafci.fecha_registro ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

    $fecha_s = explode('-',$row[0]);
    $fecha_log = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
    ?>

             '<?php echo $fecha_log;?>'

                           <?php

$numero++;

if ($numero == $total) {

echo "";


}
else {



echo ",";

}


} while ($row = mysqli_fetch_array($result));


} else {

echo ",";

}
?>
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'rgba(68, 170, 213, .2)'
            }]
        },
        yAxis: {
            title: {
                text: 'ATENCIONES PSAFCI DIARIAS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' Atenciones'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'EN CONSULTA',
            data: [

             <?php

$numero = 0;
$sql = " SELECT atencion_psafci.fecha_registro FROM atencion_psafci, diagnostico_psafci WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
$sql.= " AND diagnostico_psafci.idpatologia='$idpatologia' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY atencion_psafci.fecha_registro ORDER BY atencion_psafci.fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT diagnostico_psafci.iddiagnostico_psafci  FROM diagnostico_psafci, atencion_psafci ";
$sql7.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND diagnostico_psafci.fecha_registro='$row[0]'  ";
$sql7.= " AND diagnostico_psafci.idpatologia='$idpatologia' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND atencion_psafci.idtipo_consulta = '1' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);

$cifra_diaria = $row7;
?>
             <?php echo $cifra_diaria; ?>

<?php
$numero++;
if ($numero == $total) {
echo "";
}
else {
echo ",";
}

} while ($row = mysqli_fetch_array($result));


} else {


echo ",";
/*
Si no se encontraron resultados
*/
}
?>
            ]
        },
 
        
        {
            name: 'EN VISITA FAMILIAR',
            data: [

             <?php

$numero = 0;
$sql = " SELECT atencion_psafci.fecha_registro FROM atencion_psafci, diagnostico_psafci WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
$sql.= " AND diagnostico_psafci.idpatologia='$idpatologia' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY atencion_psafci.fecha_registro ORDER BY atencion_psafci.fecha_registro ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT diagnostico_psafci.iddiagnostico_psafci  FROM diagnostico_psafci, atencion_psafci ";
$sql7.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND diagnostico_psafci.fecha_registro='$row[0]'  ";
$sql7.= " AND diagnostico_psafci.idpatologia='$idpatologia' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND atencion_psafci.idtipo_consulta = '2' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);

$cifra_diaria2 = $row7;
?>
             <?php echo $cifra_diaria2; ?>

<?php
$numero++;
if ($numero == $total) {
echo "";
}
else {
echo ",";
}

} while ($row = mysqli_fetch_array($result));


} else {


echo ",";
/*
Si no se encontraron resultados
*/
}
?>
            ]
        }



    ]
    });
});
		</script>
	</head>
	<body>
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
        border-top: 6px solid #f15c80; /* Turquesa corporativo de referencias */
        border-radius: 50%;
        animation: girar 1s linear infinite;
        margin-bottom: 20px;
    }
    .texto-loader {
        color: #f15c80;
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
    <div class="texto-loader">Procesando ATENCIONES POR MORBILIDAD, por favor espere...</div>
</div>
<?php
    // MAGIA BACKEND: Obligamos a Apache/PHP a pintar esto en la pantalla del usuario YA
    if (ob_get_level() == 0) ob_start();
    echo str_pad('', 4096); // Hack de 4KB para forzar el vaciado en servidores con GZIP
    ob_flush();
    flush();
?>  

<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<p style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">
<div align="center">
<form action="reporte_diagnosticos_preventivos_excel.php" method="post">
    <input type="hidden" name="idpatologia" value="<?php echo $idpatologia;?>">
    <input type="hidden" name="inicio" value="<?php echo $inicio;?>">
    <input type="hidden" name="finalizacion" value="<?php echo $finalizacion;?>">
    <button type="submit">DESCARGAR CUADRO EN EXCEL</button>
</form>
</p></div>
</br>
<table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO ATENCIÓN</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA ATENDIDA</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">EDAD</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">GENERO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONSULTA/VISITA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIPO ATENCIÖN</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CARGO ORGANIZACIONAL</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql =" SELECT atencion_psafci.idatencion_psafci, atencion_psafci.codigo, nombre.nombre, nombre.paterno, nombre.materno, ";
    $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_consulta.tipo_consulta, ";
    $sql.=" tipo_atencion.tipo_atencion,atencion_psafci.fecha_registro, atencion_psafci.hora_registro, atencion_psafci.idusuario, nombre.fecha_nac, genero.genero  ";
    $sql.=" FROM atencion_psafci, nombre, tipo_consulta, tipo_atencion, departamento, municipios, establecimiento_salud, diagnostico_psafci, genero ";
    $sql.=" WHERE atencion_psafci.idnombre=nombre.idnombre AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND nombre.idgenero=genero.idgenero ";
    $sql.=" AND atencion_psafci.idtipo_consulta=tipo_consulta.idtipo_consulta AND atencion_psafci.iddepartamento=departamento.iddepartamento ";
    $sql.=" AND atencion_psafci.idmunicipio=municipios.idmunicipio AND atencion_psafci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sql.=" AND atencion_psafci.idtipo_atencion=tipo_atencion.idtipo_atencion AND diagnostico_psafci.idpatologia='$idpatologia' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ORDER BY atencion_psafci.idatencion_psafci DESC ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="imprime_atencion_psafci.php?idatencion_psafci=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;">
              <?php echo $row[1];?></a>  </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[2]." ".$row[3]." ".$row[4]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php
                    $fecha_nacimiento = $row[13];
                    $dia = date("d");
                    $mes = date("m");
                    $ano = date("Y");    
                    $dianaz = date("d",strtotime($fecha_nacimiento));
                    $mesnaz = date("m",strtotime($fecha_nacimiento));
                    $anonaz = date("Y",strtotime($fecha_nacimiento));         
                    if (($mesnaz == $mes) && ($dianaz > $dia)) {
                    $ano=($ano-1); }      
                    if ($mesnaz > $mes) {
                    $ano=($ano-1);}       
                    $edad=($ano-$anonaz);  
                    echo $edad ;?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[14];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[5];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[8];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[9];?></td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[12]' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);                    
                echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
              </td>
              <td style="font-size: 12px; font-family: Arial;">
              <?php 
                $sql_c =" SELECT dato_laboral.idcargo_organigrama, cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama  ";
                $sql_c.=" WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama ";
                $sql_c.=" AND usuarios.idusuario='$row[12]' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1 ";
                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);                    
                echo $row_c[1];?>
              </td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[10]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[11];?></td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
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