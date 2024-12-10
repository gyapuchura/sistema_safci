<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$idmunicipio = $_GET['idmunicipio']; 

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);
$municipio_cf = $row_mun[1];

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$sqlav = " SELECT count(integrante_factor_riesgo.idintegrante_factor_riesgo) FROM integrante_factor_riesgo, carpeta_familiar  ";
$sqlav.= " WHERE integrante_factor_riesgo.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sqlav.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$resultav = mysqli_query($link,$sqlav);
$rowav = mysqli_fetch_array($resultav);

$regulador = $rowav[0]/10;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PIRÁMIDE FACTORES DE RIESGO - MUNICI[PAL</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    var categories = [
                    <?php
                    $numero = 0;
                    $sql = " SELECT idgrupo_etareo_cf, grupo_etareo_cf FROM grupo_etareo_cf ORDER BY idgrupo_etareo_cf ";
                    $result = mysqli_query($link,$sql);
                    $total = mysqli_num_rows($result);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {
                    ?>
                    '<?php  echo $row[1];?>'

                        <?php    
                        $numero++;
                        if ($numero == $total) { echo "";} else {echo ",";}

                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>
        ];
    $(document).ready(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'PIRÁMIDE FACTORES DE RIESGO - MUNICIPIO DE <?php echo mb_strtoupper($municipio_cf);?>'
            },
            subtitle: {
                text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 0
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: categories,
                linkedTo: 0,
                labels: {
                    step: 1
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return (Math.abs(this.value) / 100) + 'x100';
                    }
                },
                min: -<?php echo $regulador;?>,
                max: <?php echo $regulador;?>
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ',  ' + this.point.category + '</b><br/>' +
                        'Integrantes: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                }
            },

            series: [{
                name: 'MASCULINO',
                data: [
                    <?php
                    $numero2 = 0;
                    for ($idgrupo_etareo = 1; $idgrupo_etareo <= 20; $idgrupo_etareo++) {
                    ?>

                    <?php
                    $sql7 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_factor_riesgo, integrante_cf, nombre, carpeta_familiar WHERE integrante_cf.idnombre=nombre.idnombre  ";
                    $sql7.= " AND integrante_factor_riesgo.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                    $sql7.= " AND integrante_cf.idgrupo_etareo_cf='$idgrupo_etareo' AND nombre.idgenero='2' AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                    $result7 = mysqli_query($link,$sql7);
                    $row7 = mysqli_fetch_array($result7);
                    $cifra_masculino = $row7[0];
                    ?>
                                <?php echo "-".$cifra_masculino; ?>

                        <?php    
                        $numero2++;
                        if ($numero2 == '20') { echo "";} else {echo ",";}
                    }
                    ?>                   
                ]
            }, {
                name: 'FEMENINO',
                data: [
                    <?php
                        $numero3 = 0;
                        for ($idgrupo_etareo = 1; $idgrupo_etareo <= 20; $idgrupo_etareo++) {
                        ?>

                        <?php
                        $sql7 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_factor_riesgo, integrante_cf, nombre, carpeta_familiar WHERE integrante_cf.idnombre=nombre.idnombre ";
                        $sql7.= " AND integrante_factor_riesgo.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                        $sql7.= " AND integrante_cf.idgrupo_etareo_cf='$idgrupo_etareo' AND nombre.idgenero='1' AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                        $result7 = mysqli_query($link,$sql7);
                        $row7 = mysqli_fetch_array($result7);
                        $cifra_femenino = $row7[0];
                        ?>
                                    <?php echo $cifra_femenino; ?>

                            <?php    
                            $numero3++;
                            if ($numero3 == '20') { echo "";} else {echo ",";}

                        }
                        ?>                   
                ]
            }]
        });
    });

});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 410px; max-width: 800px; height: 600px; margin: 0 auto"></div>

	</body>
</html>