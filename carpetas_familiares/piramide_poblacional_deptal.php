<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$iddepartamento = $_GET['iddepartamento'];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

$sqlav = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sqlav.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
$resultav = mysqli_query($link,$sqlav);
$rowav = mysqli_fetch_array($resultav);

$regulador = $rowav[0]/10;
 
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PIRÁMIDE POBLACIONAL DEPARTAMENTAL</title>

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
                text: 'PIRÁMIDE POBLACIONAL DEPARTAMENTO <?php echo mb_strtoupper($row_dep[1]);?>'
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
                    $sql7.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
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
                        $sql7.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
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
<script src="../js/piramide.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 410px; max-width: 800px; height: 600px; margin: 0 auto"></div>

<table width="446" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">GRUPO ETÁREO</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">MASCULINO</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">FEMENINO</span></td>
    </tr>
<?php
                    $numero = 1;
                    $sql = " SELECT idgrupo_etareo_cf, grupo_etareo_cf FROM grupo_etareo_cf ORDER BY idgrupo_etareo_cf ";                 
                    $result = mysqli_query($link,$sql);
                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                        $sql_m = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, nombre, carpeta_familiar ";
                        $sql_m.= " WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql_m.= " AND integrante_cf.idgrupo_etareo_cf='$row[0]' AND nombre.idgenero='2' AND integrante_cf.estado='CONSOLIDADO'  ";
                        $sql_m.= "  AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
                        $result_m = mysqli_query($link,$sql_m);
                        $row_m = mysqli_fetch_array($result_m);

                        $sql_f = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, nombre, carpeta_familiar ";
                        $sql_f.= " WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql_f.= " AND integrante_cf.idgrupo_etareo_cf='$row[0]' AND nombre.idgenero='1' AND integrante_cf.estado='CONSOLIDADO'  ";
                        $sql_f.= "  AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.iddepartamento='$iddepartamento' ";
                        $result_f = mysqli_query($link,$sql_f);
                        $row_f = mysqli_fetch_array($result_f);
                    ?>
                        <tr>
                            <td bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
                            <td align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
                            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $row_m[0];?></td>
                            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $row_f[0];?></td>
                            </tr> 

                        <?php
                        $numero++;                    
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>
                    </table>
	</body>
</html>
