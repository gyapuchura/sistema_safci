<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idestablecimiento_salud = $_GET['idestablecimiento_salud'];

$sql_est = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>FUNCIONALIDAD FAMILIAR ESTABLECIMIENTO DE SALUD</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
        ${demo.css}
		</style>

		<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];

            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([0-9]+[\.0-9x]*)/);
                    if (version) {
                        version = version[0];
                    }
                    brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push(['v' + version, columns[1][i]]);
                    }
                }

            });

            $.each(brands, function (name, y) {
                brandsData.push({
                    name: name,
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart

            <?php
$sql_t =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar  ";
$sql_t.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_t.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_i =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_i.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_i.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='9' ";
$result_i = mysqli_query($link,$sql_i);
$row_i = mysqli_fetch_array($result_i);
$economica = $row_i[0];

$sql_j =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_j.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_j.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='10' ";
$result_j = mysqli_query($link,$sql_j);
$row_j = mysqli_fetch_array($result_j);
$educativa = $row_j[0];

$sql_k =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_k.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_k.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='11' ";
$result_k = mysqli_query($link,$sql_k);
$row_k = mysqli_fetch_array($result_k);
$afectiva = $row_k[0];

$sql_l =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_l.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_l.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='12' ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);
$social = $row_l[0];

$economica_p    = ($economica*100)/$total;
$educativa_p    = ($educativa*100)/$total;
$afectiva_p     = ($afectiva*100)/$total;
$social_p    = ($social*100)/$total;

?>

            $('#funcionalidad_cf').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'FUNCIONALIDAD FAMILIAR - Establecimiento: <?php echo mb_strtoupper($row_est[1]);?>'
                },
                subtitle: {
                    text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Porcetaje de un total de <?php echo $total;?>'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                },

                series: [{
                    name: 'Carpetas Familiares',
                    colorByPoint: true,
                    data: brandsData
                }],
                drilldown: {
                    series: drilldownSeries
                }
            });
        }
    });
});
		</script>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Funcionalidad Familiar	Total Carpetas Familiares
CUMPLE FUNCIÓN ECONÓMICA	<?php echo $economica_p;?>%
CUMPLE FUNCIÓN EDUCATIVA 	<?php echo $educativa_p;?>%
CUMPLE FUNCIÓN AFECTIVA	  <?php echo $afectiva_p;?>%
CUMPLE FUNCIÓN SOCIAL 	<?php echo $social_p;?>% </pre>

<!------ DISFUNCIONALIDAD FAMILIAR --------->


<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('tsvd').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];

            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([0-9]+[\.0-9x]*)/);
                    if (version) {
                        version = version[0];
                    }
                    brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push(['v' + version, columns[1][i]]);
                    }
                }

            });

            $.each(brands, function (name, y) {
                brandsData.push({
                    name: name,
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart

            <?php
$sql_t =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar  ";
$sql_t.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_t.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_8 =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_8.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_8.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='1' ";
$result_8 = mysqli_query($link,$sql_8);
$row_8 = mysqli_fetch_array($result_8);
$desmemb = $row_8[0];

$sql_b =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_b.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='2' ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$incremento = $row_b[0];

$sql_c =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_c.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='3' ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$desmoralizacion =$row_c[0];

$sql_d =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_d.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_d.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='4' ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);
$desorganizacion = $row_d[0];

$sql_e =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_e.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_e.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='5' ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);
$violencia = $row_e[0];

$sql_f =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_f.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_f.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='6' ";
$result_f = mysqli_query($link,$sql_f);
$row_f = mysqli_fetch_array($result_f);
$tabaquismo = $row_f[0];

$sql_g =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_g.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_g.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='7' ";
$result_g = mysqli_query($link,$sql_g);
$row_g = mysqli_fetch_array($result_g);
$alcohol =$row_g[0];

$sql_h =" SELECT count(funcionalidad_familiar_cf.idfuncionalidad_familiar_cf) FROM funcionalidad_familiar_cf, carpeta_familiar ";
$sql_h.=" WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_h.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND funcionalidad_familiar_cf.idfuncionalidad_familiar ='8' ";
$result_h = mysqli_query($link,$sql_h);
$row_h = mysqli_fetch_array($result_h);
$drogas = $row_h[0];

$desmem_p  = ($desmemb*100)/$total;
$incremento_p   = ($incremento*100)/$total;
$desmoralizacion_p  = ($desmoralizacion*100)/$total;
$desorganizacion_p  = ($desorganizacion*100)/$total;
$violencia_p        = ($violencia*100)/$total;
$tabaquismo_p = ($tabaquismo*100)/$total;
$alcohol_p      = ($alcohol*100)/$total;
$drogas_p   = ($drogas*100)/$total;
$economica_p    = ($economica*100)/$total;
$educativa_p    = ($educativa*100)/$total;
$afectiva_p     = ($afectiva*100)/$total;
$social_p    = ($social*100)/$total;

?>

            $('#disfuncionalidad_cf').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'DISFUNCIONALIDAD FAMILIAR - Establecimiento: <?php echo mb_strtoupper($row_est[1]);?>'
                },
                subtitle: {
                    text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Porcetaje de un total de <?php echo $total;?>'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                },

                series: [{
                    name: 'Carpetas Familiares',
                    colorByPoint: true,
                    data: brandsData
                }],
                drilldown: {
                    series: drilldownSeries
                }
            });
        }
    });
});
		</script>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsvd" style="display:none">Funcionalidad Familiar	Total Carpetas Familiares
DESMEMBRAMIENTO(*)	<?php echo $desmem_p;?>%
INCREMENTO(*)	<?php echo $incremento_p;?>%
DESMORALIZACIÓN(*)	<?php echo $desmoralizacion_p;?>%
DESORGANIZACIÓN(*)	<?php echo $desorganizacion_p;?>%
VIOLENCIA EN LA FAMILIA(*)	<?php echo $violencia_p;?>%
TABAQUISMO PASIVO(*)	<?php echo $tabaquismo_p;?>%
CONSUMO DE ALCOHOL CON REPERCUSIÓN EN LA FAMILIA(*) 	<?php echo $alcohol_p;?>%
CONSUMO DE DROGAS EN PRESENCIA DE LA FAMILIA(*) 	<?php echo $drogas_p;?>% </pre>

<script type="text/javascript">
$(function () {
    $('#evaluacion_funcionalidad').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'EVALUACIÓN FUNCIONALIDAD FAMILIAR - Establecimiento: <?php echo mb_strtoupper($row_est[1]);?>'
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
                    $sql0 = " SELECT funcionalidad_familiar_cf.idcarpeta_familiar FROM funcionalidad_familiar_cf, funcionalidad_familiar, carpeta_familiar  ";
                    $sql0.= " WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar   ";
                    $sql0.= " AND funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar ";
                    $sql0.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                    $sql0.= " GROUP BY funcionalidad_familiar_cf.idcarpeta_familiar ";
                    $result0 = mysqli_query($link,$sql0);
                    $total = mysqli_num_rows($result0);

                    $sql_t = " SELECT funcionalidad_familiar_cf.idcarpeta_familiar FROM funcionalidad_familiar_cf, funcionalidad_familiar, carpeta_familiar ";
                    $sql_t.= " WHERE funcionalidad_familiar_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                    $sql_t.= " AND funcionalidad_familiar_cf.idfuncionalidad_familiar=funcionalidad_familiar.idfuncionalidad_familiar  ";
                    $sql_t.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' ";
                    $sql_t.= " AND funcionalidad_familiar.funcional='NO' GROUP BY funcionalidad_familiar_cf.idcarpeta_familiar  ";
                    $result_t = mysqli_query($link,$sql_t);
                    $disfuncional = mysqli_num_rows($result_t);

                    $funcional = $total - $disfuncional;

                    $p_disfuncional = ($disfuncional*100)/$total;
                    $porcentaje_disfuncional = number_format($p_disfuncional, 2, '.', '');

                    $p_funcional   = ($funcional*100)/$total;
                    $porcentaje_funcional    = number_format($p_funcional, 2, '.', '');
                    ?>

                    ['FUNCIONAL', <?php echo $porcentaje_funcional;?>], ['DISFUNCIONAL', <?php echo $porcentaje_disfuncional;?>]


                    ]
        }]
    });
});
		</script>

<script src="../js/highcharts.js"></script>
<script src="../js/modules/data.js"></script>
<script src="../js/modules/drilldown.js"></script>

</head>
<body>

<div id="funcionalidad_cf" style="min-width: 510px; height: 300px; margin: 0 auto"></div>
<hr>
<div id="disfuncionalidad_cf" style="min-width: 510px; height: 300px; margin: 0 auto"></div>
<hr>
<div id="evaluacion_funcionalidad" style="height: 300px"></div>




	</body>
</html>
