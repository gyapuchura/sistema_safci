<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idnivel_discapacidad_cf = $_GET['idnivel_discapacidad_cf']; 
$idtipo_discapacidad_cf  = $_GET['idtipo_discapacidad_cf']; 
$idusuario               = $_GET['idusuario'];

$sql_op = " SELECT nombre.nombre, nombre.paterno, nombre.materno FROM nombre, usuarios WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario' ";
$result_op = mysqli_query($link,$sql_op);
$row_op = mysqli_fetch_array($result_op);
$operativo = mb_strtoupper($row_op[0]." ".$row_op[1]." ".$row_op[2]);


$sql_n = " SELECT idnivel_discapacidad_cf, nivel_discapacidad_cf FROM nivel_discapacidad_cf WHERE idnivel_discapacidad_cf='$idnivel_discapacidad_cf' ";
$result_n = mysqli_query($link,$sql_n);
$row_n = mysqli_fetch_array($result_n);
$nivel = $row_n[1];

$sql_t = " SELECT idtipo_discapacidad_cf, tipo_discapacidad_cf FROM tipo_discapacidad_cf WHERE idtipo_discapacidad_cf='$idtipo_discapacidad_cf' ";
$result_t = mysqli_query($link,$sql_t);
$row_t = mysqli_fetch_array($result_t);
$tipo_dis = $row_t[1];

$sqlav = " SELECT count(integrante_discapacidad.idintegrante_discapacidad) FROM integrante_discapacidad, carpeta_familiar ";
$sqlav.= " WHERE integrante_discapacidad.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
$sqlav.= " AND integrante_discapacidad.idnivel_discapacidad_cf='$idnivel_discapacidad_cf' AND integrante_discapacidad.idtipo_discapacidad_cf='$idtipo_discapacidad_cf' AND carpeta_familiar.idusuario='$idusuario'";
$resultav = mysqli_query($link,$sqlav);
$rowav = mysqli_fetch_array($resultav);

$regulador = $rowav[0]/10;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>PIRÁMIDE DISCAPACIDAD - MEDICO OPERATIVO</title>

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
                text: 'PIRÁMIDE DISCAPACIDAD <?php echo mb_strtoupper($tipo_dis);?> <?php echo mb_strtoupper($nivel);?> - MÉDICO: <?php echo $operativo;?>'
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
                    $sql7 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_discapacidad, integrante_cf, nombre, carpeta_familiar  ";
                    $sql7.= " WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar   ";
                    $sql7.= " AND integrante_discapacidad.idintegrante_cf=integrante_cf.idintegrante_cf";
                    $sql7.= " AND integrante_cf.idgrupo_etareo_cf='$row2[0]' AND nombre.idgenero='2' AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.estado='CONSOLIDADO' ";
                    $sql7.= " AND integrante_discapacidad.idnivel_discapacidad_cf='$idnivel_discapacidad_cf' AND integrante_discapacidad.idtipo_discapacidad_cf='$idtipo_discapacidad_cf' AND carpeta_familiar.idusuario='$idusuario' ";
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
                        $sql7 = " SELECT count(integrante_cf.idintegrante_cf) FROM integrante_discapacidad, integrante_cf, nombre, carpeta_familiar  ";
                        $sql7.= " WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql7.= " AND integrante_discapacidad.idintegrante_cf=integrante_cf.idintegrante_cf";
                        $sql7.= " AND integrante_cf.idgrupo_etareo_cf='$row3[0]' AND nombre.idgenero='1' AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.estado='CONSOLIDADO' ";
                        $sql7.= " AND integrante_discapacidad.idnivel_discapacidad_cf='$idnivel_discapacidad_cf' AND integrante_discapacidad.idtipo_discapacidad_cf='$idtipo_discapacidad_cf' AND carpeta_familiar.idusuario='$idusuario' ";
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


	</body>
</html>