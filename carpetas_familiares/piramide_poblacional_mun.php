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

$sqlav = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sqlav.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$resultav = mysqli_query($link,$sqlav);
$rowav = mysqli_fetch_array($resultav);

$regulador = $rowav[0]/10;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PIRÁMIDE POBLACIONAL MUNICIPAL</title>

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
                text: 'PIRÁMIDE POBLACIONAL MUNICIPIO <?php echo mb_strtoupper($row_mun[1]);?>'
            },
            subtitle: {
                text: 'Fuente: Sistema Medi-Safci'
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
                    $sql2 = " SELECT idgrupo_etareo_cf, grupo_etareo_cf FROM grupo_etareo_cf ORDER BY idgrupo_etareo_cf ";
                    $result2 = mysqli_query($link,$sql2);
                    $total2 = mysqli_num_rows($result2);
                    if ($row2 = mysqli_fetch_array($result2)){
                    mysqli_field_seek($result2,0);
                    while ($field2 = mysqli_fetch_field($result2)){
                    } do {
                    ?>

                    <?php
                    $sql7 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, nombre, carpeta_familiar ";
                    $sql7.= " WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar   ";
                    $sql7.= " AND integrante_cf.idgrupo_etareo_cf='$row2[0]' AND nombre.idgenero='2' ";
                    $sql7.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                    $result7 = mysqli_query($link,$sql7);
                    $row7 = mysqli_fetch_array($result7);
                    $cifra_masculino = $row7[0];
                    ?>
                                <?php echo "-".$cifra_masculino; ?>

                        <?php    
                        $numero2++;
                        if ($numero2 == $total2) { echo "";} else {echo ",";}

                    } while ($row2 = mysqli_fetch_array($result2));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>                   
                ]
            }, {
                name: 'FEMENINO',
                data: [
                    <?php
                        $numero3 = 0;
                        $sql3 = " SELECT idgrupo_etareo_cf, grupo_etareo_cf FROM grupo_etareo_cf ORDER BY idgrupo_etareo_cf ";
                        $result3 = mysqli_query($link,$sql3);
                        $total3 = mysqli_num_rows($result3);
                        if ($row3 = mysqli_fetch_array($result3)){
                        mysqli_field_seek($result3,0);
                        while ($field3 = mysqli_fetch_field($result3)){
                        } do {
                        ?>

                        <?php
                        $sql7 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, nombre, carpeta_familiar ";
                        $sql7.= " WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar   ";
                        $sql7.= " AND integrante_cf.idgrupo_etareo_cf='$row3[0]' AND nombre.idgenero='1' ";
                        $sql7.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                        $result7 = mysqli_query($link,$sql7);
                        $row7 = mysqli_fetch_array($result7);
                        $cifra_femenino = $row7[0];
                        ?>
                                    <?php echo $cifra_femenino; ?>

                            <?php    
                            $numero3++;
                            if ($numero3 == $total3) { echo "";} else {echo ",";}

                        } while ($row3 = mysqli_fetch_array($result3));
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

});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 410px; max-width: 800px; height: 600px; margin: 0 auto"></div>


<?php
$sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' ";

$result_cf = mysqli_query($link,$sql_cf);
$row_cf = mysqli_fetch_array($result_cf);  
$total_cf = $row_cf[0];
?>

<span style="font-family: Arial; font-size: 12px;"><h4 align="center">TOTAL DE CARPETAS FAMILIARES MUNICIPIO = <?php echo $total_cf;?> </h4></spam>

<?php
$sql_mun =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' GROUP BY idestablecimiento_salud  ";
$result_mun = mysqli_query($link,$sql_mun);
$establecimientos = mysqli_num_rows($result_mun);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE ESTABLECIMIENTOS DE SALUD EN EL MUNICIPIO = <?php echo $establecimientos;?> </h4></spam>

<?php
$sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
$sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
$result_int = mysqli_query($link,$sql_int);
$row_int = mysqli_fetch_array($result_int);  
$integrantes = $row_int[0];
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE INTEGRANTES DE FAMILIA REGISTRADOS EN EL MUNICIPIO= <?php echo $integrantes;?> </h4></spam>

<?php
$sql_per = " SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' GROUP BY idusuario ";
$result_per = mysqli_query($link,$sql_per);
$personal = mysqli_num_rows($result_per);  
?>
<span style="font-family: Arial; font-size: 12px;"><h4 align="center">N° DE PERSONAL SAFCI EN EL MUNICIPIO = <?php echo $personal;?> </h4></spam>
	</body>
</html>
