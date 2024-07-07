<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idcarpeta_familiar =  $_SESSION['idcarpeta_familiar'];

$sql_t =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad ";
$sql_t.="  ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$total = $row_t[0];

$sql_a =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='1'";
$sql_a.="  ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
$tuberculosis = $row_a[0];

$sql_b =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='2'";
$sql_b.="  ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$sexual = $row_b[0];

$sql_c =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='3'";
$sql_c.="  ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$malaria =$row_c[0];

$sql_d =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='4'";
$sql_d.="  ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);
$lepra = $row_d[0];

$sql_e =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='5'";
$sql_e.="  ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);
$leishmaniasis = $row_e[0];

$sql_f =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='6'";
$sql_f.="  ";
$result_f = mysqli_query($link,$sql_f);
$row_f = mysqli_fetch_array($result_f);
$chagas = $row_f[0];

$sql_g =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='7'";
$sql_g.="  ";
$result_g = mysqli_query($link,$sql_g);
$row_g = mysqli_fetch_array($result_g);
$hepatitis =$row_g[0];

$sql_h =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='8'";
$sql_h.="  ";
$result_h = mysqli_query($link,$sql_h);
$row_h = mysqli_fetch_array($result_h);
$cardiovascular = $row_h[0];

$sql_i =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='9'";
$sql_i.="  ";
$result_i = mysqli_query($link,$sql_i);
$row_i = mysqli_fetch_array($result_i);
$hipertension = $row_i[0];

$sql_j =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='10'";
$sql_j.="  ";
$result_j = mysqli_query($link,$sql_j);
$row_j = mysqli_fetch_array($result_j);
$diabetes = $row_j[0];

$sql_k =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='11'";
$sql_k.="  ";
$result_k = mysqli_query($link,$sql_k);
$row_k = mysqli_fetch_array($result_k);
$obesidad =$row_k[0];

$sql_l =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='12'";
$sql_l.="  ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);
$renal = $row_l[0];

$sql_m =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='13'";
$sql_m.="  ";
$result_m = mysqli_query($link,$sql_m);
$row_m = mysqli_fetch_array($result_m);
$reumatica = $row_m[0];

$sql_n =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='14'";
$sql_n.="  ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);
$pulmonar = $row_n[0];

$sql_o =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='15'";
$sql_o.="  ";
$result_o = mysqli_query($link,$sql_o);
$row_o = mysqli_fetch_array($result_o);
$autoinmune = $row_o[0];

$sql_p =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='16'";
$sql_p.="  ";
$result_p = mysqli_query($link,$sql_p);
$row_p = mysqli_fetch_array($result_p);
$hematologica = $row_p[0];

$sql_q =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='17'";
$sql_q.="  ";
$result_q = mysqli_query($link,$sql_q);
$row_q = mysqli_fetch_array($result_q);
$asma = $row_q[0];

$sql_r =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='18'";
$sql_r.="  ";
$result_r = mysqli_query($link,$sql_r);
$row_r = mysqli_fetch_array($result_r);
$cancer = $row_r[0];

$sql_s =" SELECT COUNT(idintegrante_morbilidad) FROM integrante_morbilidad WHERE idmorbilidad_cf='19'";
$sql_s.="  ";
$result_s = mysqli_query($link,$sql_s);
$row_s = mysqli_fetch_array($result_s);
$otra = $row_s[0];


$tuberculosis_p   = ($tuberculosis*100)/$total;
$sexual_p         = ($sexual*100)/$total;
$malaria_p        = ($malaria*100)/$total;
$lepra_p          = ($lepra*100)/$total;
$leishmaniasis_p  = ($leishmaniasis*100)/$total;
$chagas_p         = ($chagas*100)/$total;
$hepatitis_p      = ($hepatitis*100)/$total;
$cardiovascular_p = ($cardiovascular*100)/$total;
$hipertension_p   = ($hipertension*100)/$total;
$diabetes_p       = ($diabetes*100)/$total;
$obesidad_p       = ($obesidad*100)/$total;
$renal_p          = ($renal*100)/$total;
$reumatica_p      = ($reumatica*100)/$total;
$pulmonar_p       = ($pulmonar*100)/$total;
$autoinmune_p     = ($autoinmune*100)/$total;
$hematologica_p   = ($hematologica*100)/$total;
$asma_p           = ($asma*100)/$total;
$cancer_p         = ($cancer*100)/$total;
$otra_p         = ($otra*100)/$total;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MORBILIDAD - GRUPO II</title>

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
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'GRUPO III - MORBILIDAD'
                },
                subtitle: {
                    text: 'SALUD DE LOS INTEGRANTES DE LA FAMILIA'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'PORCENTAJE DE INTEGRANTES'
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
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total de Integrantes<br/>'
                },

                series: [{
                    name: 'Grupo de Salud',
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
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/data.js"></script>
<script src="../js/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->

<pre id="tsv" style="display:none">Browser Version	Total Market Share
TUBERCULOSIS	    <?php echo $tuberculosis_p;?>%
INFECCIÓN DE TRANSMISIÓN SEXUAL 	<?php echo $sexual_p;?>%
MALARIA 	<?php echo $malaria_p;?>%
LEPRA	<?php echo $lepra_p;?>%
LEISHMANIASIS	    <?php echo $leishmaniasis_p;?>%
CHAGAS	<?php echo $chagas_p;?>%
HEPATITIS B o C	<?php echo $hepatitis_p;?>%
ENF. CARDIOVASCULAR	<?php echo $cardiovascular_p;?>%
HIPERTENSIÓN ARTERIAL 	<?php echo $hipertension_p;?>%
DIABETES MELLITUS  	<?php echo $diabetes_p;?>%
OBESIDAD	<?php echo $obesidad_p;?>%
INSUF. RENAL CRÓNICA	    <?php echo $renal_p;?>%
ENF. REUMÁTICAS DEFORMANTES	<?php echo $reumatica_p;?>%
ENF. PULMONAR OBSTRUCTIVA CRÓNICA	<?php echo $pulmonar_p;?>%
ENF. AUTOINMUNES	<?php echo $autoinmune_p;?>%
ENF. HEMATOLÓGICAS	    <?php echo $hematologica_p;?>%
ASMA	<?php echo $asma_p;?>%
CÁNCER	<?php echo $cancer_p;?>%
OTRAS ENFERMEDADES CRONICAS	<?php echo $otra_p;?>%
</pre>
	</body>
</html>
