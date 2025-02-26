<?php  include("../cabf.php");?>
<?php  include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
$idmunicipio = $_GET['idmunicipio']; 

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SALUD DE INTEGRANTES DE LA FAMILIA - MUNICIPAL</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('grp').innerHTML,
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

            <?php
$sql_a =" SELECT COUNT(integrante_ap_sano.idintegrante_ap_sano) FROM integrante_ap_sano, carpeta_familiar  ";
$sql_a.=" WHERE integrante_ap_sano.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
$aparentemente_sano = $row_a[0];

$sql_b =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
$sql_b.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$result_b = mysqli_query($link,$sql_b);
$row_b = mysqli_fetch_array($result_b);
$factor_riesgo = $row_b[0];

$sql_c =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
$sql_c.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
$sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);
$morbilidad =$row_c[0];

$sql_d =" SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar  ";
$sql_d.=" WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
$sql_d.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$result_d = mysqli_query($link,$sql_d);
$row_d = mysqli_fetch_array($result_d);
$discapacidad = $row_d[0];

$total = $aparentemente_sano + $factor_riesgo + $morbilidad + $discapacidad;

$grupo_1       = ($aparentemente_sano*100)/$total;
$grupo_2       = ($factor_riesgo*100)/$total;
$grupo_3       = ($morbilidad*100)/$total;
$grupo_4       = ($discapacidad*100)/$total;

            ?>

            // Create the chart
            $('#grupo_salud').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ' SALUD DE LOS INTEGRANTES DE LA FAMILIA - Mun. <?php echo mb_strtoupper($row_mun[1]);?>'
                },
                subtitle: {
                    text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
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

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as grupo. -->

<pre id="grp" style="display:none">Browser Version	Total Market Share
GRUPO I  APARENTEMENTE SANOS	    <?php echo $grupo_1;?>%
GRUPO II  FACTORES DE RIESGO	<?php echo $grupo_2;?>%
GRUPO III  MORBILIDAD	<?php echo $grupo_3;?>%
GRUPO IV  DISCAPACIDAD	<?php echo $grupo_4;?>%
</pre>

<div id="grupo_salud" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!---  <h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">
<a href="cuadro_cf_municipio.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=250,scrollbars=YES,top=60,left=400'); return false;">             
MOSTRAR CUADRO</a></h2>  --->

<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="120" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">GRUPO DE SALUD</td>
              <td width="80" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTOS</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">ETÁREO</td>
		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>

		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">1</td>
              <td style="font-size: 12px; font-family: Arial;">APARENTEMENTE SANOS</td>
            <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $aparentemente_sano;?> </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="aparentemente_sanos_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_aparentemente_sanos_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">2</td>
              <td style="font-size: 12px; font-family: Arial;">CON FACTORES DE RIESGO</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $factor_riesgo;?> </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="grupo_riesgo_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_grupo_riesgo_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">3</td>
              <td style="font-size: 12px; font-family: Arial;">CON MORBILIDAD</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $morbilidad;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="grupo_morbilidad_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_grupo_morbilidad_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">4</td>
              <td style="font-size: 12px; font-family: Arial;">CON DISCAPACIDAD</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $discapacidad;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="grupo_discapacidad_deptos.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <a href="piramide_grupo_discapacidad_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
	      </tbody>
    </table>
</br>
</br>
<!----- FACTORES DE RIESGO BEGIN ------>
 
<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('rsgo').innerHTML,
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

            <?php
                $sql_t =" SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar ";
                $sql_t.=" WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_t.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_t = mysqli_query($link,$sql_t);
                $row_t = mysqli_fetch_array($result_t);
                $total = $row_t[0];

                $sql_a ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_a.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_a.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='1' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_a = mysqli_query($link,$sql_a);
                $row_a = mysqli_fetch_array($result_a);
                $sedentarismo = $row_a[0];

                $sql_b ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_b.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_b.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='2' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_b = mysqli_query($link,$sql_b);
                $row_b = mysqli_fetch_array($result_b);
                $consume_alcohol = $row_b[0];

                $sql_c ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_c.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_c.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='3' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);
                $fumar =$row_c[0];

                $sql_d ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_d.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_d.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='4' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_d = mysqli_query($link,$sql_d);
                $row_d = mysqli_fetch_array($result_d);
                $drogas = $row_d[0];

                $sql_e ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_e.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_e.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='5' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_e = mysqli_query($link,$sql_e);
                $row_e = mysqli_fetch_array($result_e);
                $promiscuidad = $row_e[0];

                $sql_f ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_f.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_f.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='6' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_f = mysqli_query($link,$sql_f);
                $row_f = mysqli_fetch_array($result_f);
                $gaseosas = $row_f[0];

                $sql_g ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_g.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_g.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='7' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_g = mysqli_query($link,$sql_g);
                $row_g = mysqli_fetch_array($result_g);
                $frituras =$row_g[0];

                $sql_h ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_h.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_h.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='8' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_h = mysqli_query($link,$sql_h);
                $row_h = mysqli_fetch_array($result_h);
                $conservas = $row_h[0];

                $sql_i ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_i.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_i.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='9' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_i = mysqli_query($link,$sql_i);
                $row_i = mysqli_fetch_array($result_i);
                $golosinas = $row_i[0];

                $sql_j ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_j.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_j.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='10' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_j = mysqli_query($link,$sql_j);
                $row_j = mysqli_fetch_array($result_j);
                $sal = $row_j[0];

                $sql_k ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_k.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_k.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='11' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_k = mysqli_query($link,$sql_k);
                $row_k = mysqli_fetch_array($result_k);
                $piezas =$row_k[0];

                $sql_l ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_l.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_l.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='12' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_l = mysqli_query($link,$sql_l);
                $row_l = mysqli_fetch_array($result_l);
                $menor = $row_l[0];

                $sql_m ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_m.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_m.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='13' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_m = mysqli_query($link,$sql_m);
                $row_m = mysqli_fetch_array($result_m);
                $embarazo = $row_m[0];

                $sql_n ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_n.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_n.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='14' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_n = mysqli_query($link,$sql_n);
                $row_n = mysqli_fetch_array($result_n);
                $mayor = $row_n[0];

                $sql_o ="  SELECT COUNT(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
                $sql_o.="  WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                $sql_o.="  AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_factor_riesgo.idfactor_riesgo_cf='15' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_o = mysqli_query($link,$sql_o);
                $row_o = mysqli_fetch_array($result_o);
                $otros = $row_o[0];

                $sedentarismo_p    = ($sedentarismo*100)/$total;
                $consume_alcohol_p = ($consume_alcohol*100)/$total;
                $fumar_p           = ($fumar*100)/$total;
                $drogas_p          = ($drogas*100)/$total;
                $promiscuidad_p    = ($promiscuidad*100)/$total;
                $gaseosas_p        = ($gaseosas*100)/$total;
                $frituras_p        = ($frituras*100)/$total;
                $conservas_p       = ($conservas*100)/$total;

                $golosinas_p       = ($golosinas*100)/$total;
                $sal_p             = ($sal*100)/$total;
                $piezas_p          = ($piezas*100)/$total;
                $menor_p           = ($menor*100)/$total;
                $embarazo_p        = ($embarazo*100)/$total;
                $mayor_p       = ($mayor*100)/$total;
                $otros_p       = ($otros*100)/$total;

            ?>
            // Create the chart
            $('#grupo_riesgo').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'GRUPO II - FACTORES DE RIESGO - Mun. <?php echo mb_strtoupper($row_mun[1]);?>'
                },
                subtitle: {
                    text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
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
                    name: 'Grupo II',
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
<pre id="rsgo" style="display:none">Browser Version	Total Market Share
SEDENTARISMO	    <?php echo $sedentarismo_p;?>%
CONSUME ALCOHOL  	<?php echo $consume_alcohol_p;?>%
HÁBITO DE FUMAR  	<?php echo $fumar_p;?>%
CONSUMO DE DROGAS ILÍCITAS	<?php echo $drogas_p;?>%
PROMISCUIDAD	    <?php echo $promiscuidad_p;?>%
CONSUME GASEOSAS	<?php echo $gaseosas_p;?>%
CONSUME FRITURAS	<?php echo $frituras_p;?>%
CONSUME CONSERVAS	<?php echo $conservas_p;?>%

CONSUME GOLOSINAS 	<?php echo $golosinas_p;?>%
EXCESO DE SAL   	<?php echo $sal_p;?>%
PIEZAS DENTARIAS INCOMPLETAS O CARIES DENTAL	<?php echo $piezas_p;?>%
MENORES DE CINCO AÑOS	    <?php echo $menor_p;?>%
EMBARAZO	<?php echo $embarazo_p;?>%
MAYOR A SESENTA AÑOS	<?php echo $mayor_p;?>%
OTROS FACTORES DE RIESGO	<?php echo $otros_p;?>%
</pre>

<div id="grupo_riesgo" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">
<a href="cuadro_cf_salud_integrantes_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=400,scrollbars=YES,top=60,left=400'); return false;">             
CUADRO FACTORES DE RIESGO</a></h2>

<table width="700" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="199" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">FACTORES DE RIESGO</td>
              <td width="110" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">N° DE INTEGRANTES</td>
		      <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;"> </td> 
          <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">PIRAMIDE</td> 
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">1</td>
              <td style="font-size: 12px; font-family: Arial;">SEDENTARISMO</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $sedentarismo;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=1" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=1" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">2</td>
              <td style="font-size: 12px; font-family: Arial;">CONSUME ALCOHOL</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $consume_alcohol;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=2" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=2" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">3</td>
              <td style="font-size: 12px; font-family: Arial;">HÁBITO DE FUMAR</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $fumar;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=3" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=3" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">4</td>
              <td style="font-size: 12px; font-family: Arial;">CONSUMO DE DROGAS ILÍCITAS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $drogas;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=4" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=4" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">5</td>
              <td style="font-size: 12px; font-family: Arial;">PROMISCUIDAD</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $promiscuidad;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=5" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=5" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">6</td>
              <td style="font-size: 12px; font-family: Arial;">CONSUME GASEOSAS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $gaseosas;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=6" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=6" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">7</td>
              <td style="font-size: 12px; font-family: Arial;">CONSUME FRITURAS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $frituras;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=7" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=7" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">8</td>
              <td style="font-size: 12px; font-family: Arial;">CONSUME CONSERVAS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $conservas;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=8" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=8" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">9</td>
              <td style="font-size: 12px; font-family: Arial;">CONSUME GOLOSINAS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $golosinas;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=9" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=9" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">10</td>
              <td style="font-size: 12px; font-family: Arial;">EXCESO DE SAL</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $sal;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=10" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=10" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">11</td>
              <td style="font-size: 12px; font-family: Arial;">PIEZAS DENTARIAS INCOMPLETAS O CARIES DENTAL</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $piezas;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=11" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=11" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">12</td>
              <td style="font-size: 12px; font-family: Arial;">MENORES DE 5 AÑOS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $menor;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=12" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=12" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">13</td>
              <td style="font-size: 12px; font-family: Arial;">EMBARAZO</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $embarazo;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=13" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=13" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">14</td>
              <td style="font-size: 12px; font-family: Arial;">MAYOR A 60 AÑOS</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $mayor;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=14" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=14" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>
            <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">15</td>
              <td style="font-size: 12px; font-family: Arial;">OTROS FACTORES DE RIESGO (DESCRIBIR)</td>
		      <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $otros;?>
              </td>
              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="factores_riesgo_deptos.php?idfactor_riesgo_cf=15" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=450,scrollbars=YES,top=60,left=500'); return false;">             
              DEPARTAMENTOS</a>
              </td>

              <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">
              <a href="piramide_factores_riesgo_nal.php?idfactor_riesgo_cf=15" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=800,scrollbars=YES,top=60,left=500'); return false;">             
              VER PIRAMIDE</a>
              </td>
	        </tr>

	      </tbody>
    </table>


<!----- FACTORES DE RIESGO END ------>
</br>
</br>
<!----- MORBILIDAD BEGIN ------>

<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('morbilidad').innerHTML,
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
            <?php
                $sql_t =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar   ";
                $sql_t.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_t.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_t = mysqli_query($link,$sql_t);
                $row_t = mysqli_fetch_array($result_t);
                $total = $row_t[0];

                $sql_a =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_a.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='1' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_a = mysqli_query($link,$sql_a);
                $row_a = mysqli_fetch_array($result_a);
                $tuberculosis = $row_a[0];

                $sql_b =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_b.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_b.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='2' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_b = mysqli_query($link,$sql_b);
                $row_b = mysqli_fetch_array($result_b);
                $sexual = $row_b[0];

                $sql_c =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_c.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_c.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='3' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);
                $malaria =$row_c[0];

                $sql_d =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_d.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_d.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='4' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_d = mysqli_query($link,$sql_d);
                $row_d = mysqli_fetch_array($result_d);
                $lepra = $row_d[0];

                $sql_e =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_e.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_e.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='5' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_e = mysqli_query($link,$sql_e);
                $row_e = mysqli_fetch_array($result_e);
                $leishmaniasis = $row_e[0];

                $sql_f =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_f.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_f.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='6' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_f = mysqli_query($link,$sql_f);
                $row_f = mysqli_fetch_array($result_f);
                $chagas = $row_f[0];

                $sql_g =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_g.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_g.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='7' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_g = mysqli_query($link,$sql_g);
                $row_g = mysqli_fetch_array($result_g);
                $hepatitis =$row_g[0];

                $sql_h =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_h.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_h.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='8' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_h = mysqli_query($link,$sql_h);
                $row_h = mysqli_fetch_array($result_h);
                $cardiovascular = $row_h[0];

                $sql_i =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_i.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_i.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='9' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_i = mysqli_query($link,$sql_i);
                $row_i = mysqli_fetch_array($result_i);
                $hipertension = $row_i[0];

                $sql_j =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_j.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_j.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='10' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_j = mysqli_query($link,$sql_j);
                $row_j = mysqli_fetch_array($result_j);
                $diabetes = $row_j[0];

                $sql_k =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_k.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_k.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='11' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_k = mysqli_query($link,$sql_k);
                $row_k = mysqli_fetch_array($result_k);
                $obesidad =$row_k[0];

                $sql_l =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_l.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_l.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='12' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_l = mysqli_query($link,$sql_l);
                $row_l = mysqli_fetch_array($result_l);
                $renal = $row_l[0];

                $sql_m =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_m.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_m.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='13' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_m = mysqli_query($link,$sql_m);
                $row_m = mysqli_fetch_array($result_m);
                $reumatica = $row_m[0];

                $sql_n =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_n.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_n.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='14' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_n = mysqli_query($link,$sql_n);
                $row_n = mysqli_fetch_array($result_n);
                $pulmonar = $row_n[0];

                $sql_o =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_o.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_o.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='15' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_o = mysqli_query($link,$sql_o);
                $row_o = mysqli_fetch_array($result_o);
                $autoinmune = $row_o[0];

                $sql_p =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_p.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_p.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='16' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_p = mysqli_query($link,$sql_p);
                $row_p = mysqli_fetch_array($result_p);
                $hematologica = $row_p[0];

                $sql_q =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_q.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_q.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='17' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_q = mysqli_query($link,$sql_q);
                $row_q = mysqli_fetch_array($result_q);
                $asma = $row_q[0];

                $sql_r =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_r.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_r.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='18' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);
                $cancer = $row_r[0];

                $sql_s =" SELECT COUNT(integrante_morbilidad.idintegrante_morbilidad) FROM integrante_morbilidad, carpeta_familiar  ";
                $sql_s.=" WHERE integrante_morbilidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
                $sql_s.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_morbilidad.idmorbilidad_cf='19' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
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
            // Create the chart
            $('#grupo_morbilidad').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'GRUPO III - MORBILIDAD - Mun. <?php echo mb_strtoupper($row_mun[1]);?>'
                },
                subtitle: {
                    text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
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
                    name: 'Grupo III',
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

            <pre id="morbilidad" style="display:none">
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

    <div id="grupo_morbilidad" style="min-width: 310px; height: 400px; margin: 0 auto"></div>  
    
    <h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">
    <a href="cuadro_cf_morbilidad_integrantes_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=400,scrollbars=YES,top=60,left=400'); return false;">             
    CUADRO MORBILIDAD</a></h2>

<!----- MORBILIDAD END ------>
</br>
<!----- DISCAPACIDAD BEGIN ------>

<script type="text/javascript">
$(function () {
    $('#grupo_discapacidad').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'GRUPO IV INTEGRANTES CON DISCAPACIDAD POR TIPO Y NIVEL - Mun. <?php echo mb_strtoupper($row_mun[1]);?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT idtipo_discapacidad_cf, tipo_discapacidad_cf FROM tipo_discapacidad_cf ORDER BY idtipo_discapacidad_cf";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
 '<?php  echo $row[1]; ?>'

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
echo "";
/*
Si no se encontraron resultados
*/
}
?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'DISCAPACIDAD - NIVEL NACIONAL'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Integrantes con Discapacidad </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [


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

{ name: '<?php  echo $row2[1]; ?>',

    data: [
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

<?php
$sql_a =" SELECT COUNT(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar ";
$sql_a.=" WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar";
$sql_a.=" AND integrante_discapacidad.idtipo_discapacidad_cf='$row3[0]' AND integrante_discapacidad.idnivel_discapacidad_cf='$row2[0]' ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio'  ";
$result_a = mysqli_query($link,$sql_a);
$row_a = mysqli_fetch_array($result_a);
?>
<?php echo $row_a[0]; ?>
<?php 
$numero3++;
if ($numero3 == $total3) {
echo "";
}
else {
echo ",";
}
} while ($row3 = mysqli_fetch_array($result3));
} else {
echo "";
/*
Si no se encontraron resultados
*/
}
?>


        ]
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
    
    ]
    });
});
		</script>

<div id="grupo_discapacidad" style="min-width: 410px; height: 400px; margin: 0 auto"></div>

<h2 style="text-align: center; font-family: Arial; font-size: 14px; color: #2D56CF;">
    <a href="cuadro_cf_discapacidad_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=350,scrollbars=YES,top=80,left=400'); return false;">             
    CUADRO DISCAPACIDAD</a></h2>
</br>
</br>

<!----- DISCAPACIDAD END ------>


        <script src="../js/highcharts.js"></script>
        <script src="../js/modules/data.js"></script>
        <script src="../js/modules/drilldown.js"></script>
	</body>
</html>
