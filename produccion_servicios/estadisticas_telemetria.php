<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>REPORTE TELESALUD TIPOS DE ATENCION</title>
	    <script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'REPORTE TIPOS DE ATENCIÓN - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_psafci FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion !='1' AND idtipo_atencion !='2' AND idtipo_atencion !='5' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idtipo_atencion FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion !='1' AND idtipo_atencion !='2' AND idtipo_atencion !='5' GROUP BY idtipo_atencion ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idtipo_atencion, tipo_atencion FROM tipo_atencion WHERE idtipo_atencion='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_psafci FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
		</script>


<script type="text/javascript">
$(function () {
    $('#vulnerable').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'PACIENTE DE GRUPOS VULNERABLES - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_grupo_vulnerable FROM atencion_grupo_vulnerable WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idgrupo_vulnerable FROM atencion_grupo_vulnerable WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idgrupo_vulnerable ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idgrupo_vulnerable, grupo_vulnerable FROM grupo_vulnerable WHERE idgrupo_vulnerable='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_grupo_vulnerable FROM atencion_grupo_vulnerable WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idgrupo_vulnerable ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>


<script type="text/javascript">
$(function () {
    $('#captacion').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'CAPTACIÓN DE PACIENTES - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idcaptacion_ts FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idcaptacion_ts ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idcaptacion_ts, captacion_ts FROM captacion_ts WHERE idcaptacion_ts='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idcaptacion_ts ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>


<script type="text/javascript">
$(function () {
    $('#procedencia').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'PROCEDENCIA DE PACIENTES - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idde_ts FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idde_ts ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idde_ts, de_ts FROM de_ts WHERE idde_ts='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idde_ts ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>

<script type="text/javascript">
$(function () {
    $('#lugar_en').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'CONTEXTO DE ATENCIÓN - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT iden_ts FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY iden_ts ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT iden_ts, en_ts FROM en_ts WHERE iden_ts='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND iden_ts ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>

<script type="text/javascript">
$(function () {
    $('#comunicacion').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'VÍA DE COMUNICACIÓN DE CONSULTA - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idvia_comunicacion FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idvia_comunicacion ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idvia_comunicacion, via_comunicacion FROM via_comunicacion WHERE idvia_comunicacion='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idvia_comunicacion ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>

<script type="text/javascript">
$(function () {
    $('#especialidad').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'ESPECIALIDAD MÉDICA DE CONSULTA - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idespecialidad_medica FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idespecialidad_medica ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idespecialidad_medica ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>

<script type="text/javascript">
$(function () {
    $('#estado_p').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'ESTADO DE LOS PACIENTES - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idestado_paciente FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idestado_paciente ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idestado_paciente, estado_paciente FROM estado_paciente WHERE idestado_paciente='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idestado_paciente ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>


<script type="text/javascript">
$(function () {
    $('#tiempo').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'TIEMPO DE ATENCIÓN AL PACIENTE - TELESALUD'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Porcentaje',
            data: [
                 <?php
                    $sql0 = " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idtiempo_ts FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idtiempo_ts ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idtiempo_ts, tiempo_ts FROM tiempo_ts WHERE idtiempo_ts='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idatencion_teleconsulta FROM atencion_teleconsulta WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtiempo_ts ='$row[0]' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $conteo = mysqli_num_rows($result_c);

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[1];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>

                    ]
        }]
    });
});
</script>


	</head>
	<body>

<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="height: 300px"></div>
</br>
</br>
<div id="vulnerable" style="height: 300px"></div>
</br>
</br>
<div id="captacion" style="height: 300px"></div>
</br>
</br>
<div id="procedencia" style="height: 300px"></div>
</br>
</br>
<div id="lugar_en" style="height: 300px"></div>
</br>
</br>
<div id="comunicacion" style="height: 300px"></div>
</br>
</br>
<div id="especialidad" style="height: 300px"></div>
</br>
</br>
<div id="tiempo" style="height: 300px"></div>
</br>
</br>
<div id="estado_p" style="height: 300px"></div>




 



	</body>
</html>