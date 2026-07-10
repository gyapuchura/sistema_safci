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
		<title>ESTADISTICAS REFERENCIA Y CONTRAREFERENCIA</title>
	    <script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#estado_referencia').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'REPORTE ESTADO DE REFERENCIA '
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
                    $sql0 = " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idestado_referencia FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idestado_referencia ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idestado_referencia, estado_referencia FROM estado_referencia WHERE idestado_referencia='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idestado_referencia ='$row[0]' ";
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
    $('#motivo_ref').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'MOTIVO DE REFERENCIA'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
                    $sql0 = " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idmotivo_referencia FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idmotivo_referencia ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idmotivo_referencia, motivo_referencia FROM motivo_referencia WHERE idmotivo_referencia='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idmotivo_referencia ='$row[0]' ";
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
    $('#especialidad_med').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'ESPECIALIDAD MÉDICA DE REFERENCIA'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
                    $sql0 = " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idespecialidad_medica FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idespecialidad_medica ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica WHERE idespecialidad_medica='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idespecialidad_medica ='$row[0]' ";
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
    $('#tipo_tele').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'TIPO DE TELEINTERCONSULTA'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
                    $sql0 = " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idtipo_teleinterconsulta FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idtipo_teleinterconsulta ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idtipo_teleinterconsulta, tipo_teleinterconsulta FROM tipo_teleinterconsulta WHERE idtipo_teleinterconsulta='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_teleinterconsulta ='$row[0]' ";
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
    $('#tiempo_ref').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'TEMPORALIDAD DE LA REFERENCIA'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
                    $sql0 = " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idtiempo_ts FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY idtiempo_ts ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idtiempo_ts, tiempo_ts FROM tiempo_ts WHERE idtiempo_ts='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idreferencia_hc FROM referencia_hc WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtiempo_ts ='$row[0]' ";
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
    $('#via_contacto').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'VÍA DE CONTACTO PARA LA REFERENCIA'
        },
            subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
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
                    $sql0 = " SELECT idderiva_referencia_hc FROM deriva_referencia_hc WHERE fecha_deriva BETWEEN '$inicio' AND '$finalizacion' ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $numero = 0;
                    $sql = " SELECT idvia_comunicacion FROM deriva_referencia_hc WHERE fecha_deriva BETWEEN '$inicio' AND '$finalizacion' GROUP BY idvia_comunicacion ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t = " SELECT idvia_comunicacion, via_comunicacion FROM via_comunicacion WHERE idvia_comunicacion='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t = mysqli_fetch_array($result_t);

                    $sql_c= " SELECT idderiva_referencia_hc FROM deriva_referencia_hc WHERE fecha_deriva BETWEEN '$inicio' AND '$finalizacion' AND idvia_comunicacion ='$row[0]' ";
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

<script src="../js/referencia.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="estado_referencia" style="height: 300px"></div>
</br>
</br>
<div id="motivo_ref" style="height: 300px"></div>
</br>
</br>
<div id="especialidad_med" style="height: 300px"></div>
</br>
</br>
<div id="tipo_tele" style="height: 300px"></div>
</br>
</br>
<div id="tiempo_ref" style="height: 300px"></div>
</br>
</br>
<div id="via_contacto" style="height: 300px"></div>
</br>
</br>
	</body>
</html>