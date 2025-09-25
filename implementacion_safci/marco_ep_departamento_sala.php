<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$idsospecha_diag_estab = $_GET['idsospecha_diag_estab'];
$iddepartamento = $_GET['iddepartamento'];

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag_estab' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);


$sql_e = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_e = mysqli_query($link,$sql_e);
$row_e = mysqli_fetch_array($result_e);

$sqlav = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, genero ";
$sqlav.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.idgenero=genero.idgenero ";
$sqlav.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab'  ";
$sqlav.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.iddepartamento='$iddepartamento' ";
$resultav = mysqli_query($link,$sqlav);
$rowav = mysqli_fetch_array($resultav);
$regulador = $rowav[0]/2;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>VIGILANCIA EPIDEMIOLOGICA POR DEPARTAMENTO</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container_perfil').highcharts({
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'VIGILANCIA: <?php echo mb_strtoupper($row_sos[1]);?> - DEPARTAMENTO : <?php echo mb_strtoupper($row_e[1]);?>'
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
$sql = " SELECT notificacion_ep.semana_ep FROM notificacion_ep, registro_enfermedad WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND notificacion_ep.iddepartamento='$iddepartamento' AND notificacion_ep.gestion ='$gestion'  ";
$sql.= " AND notificacion_ep.estado='CONSOLIDADO' GROUP BY notificacion_ep.semana_ep ORDER BY notificacion_ep.semana_ep ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>
             'SEMANA <?php echo $row[0];?>'

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
                text: 'CASOS REGISTRADOS'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' CASOS '
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
            name: 'SOSPECHAS ',
            data: [

             <?php

$numero = 0;
$sql = " SELECT notificacion_ep.semana_ep FROM notificacion_ep, registro_enfermedad WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND notificacion_ep.iddepartamento='$iddepartamento' AND notificacion_ep.gestion ='$gestion'  ";
$sql.= " AND notificacion_ep.estado='CONSOLIDADO' GROUP BY notificacion_ep.semana_ep ORDER BY notificacion_ep.semana_ep ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

 if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
	?>

<?php
$sql7 = " SELECT sum(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep ";
$sql7.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql7.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND notificacion_ep.semana_ep='$row[0]' ";
$sql7.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.iddepartamento='$iddepartamento' AND notificacion_ep.estado='CONSOLIDADO'";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$cifra_semanal = $row7[0];
?>
             <?php echo $cifra_semanal; ?>

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
    name: 'RECUPERADOS',
    data: [

<?php
$numero = 0;
$sql_r = " SELECT seguimiento_ep.idsemana_ep FROM seguimiento_ep, notificacion_ep WHERE seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep  ";
$sql_r.= " AND notificacion_ep.estado='CONSOLIDADO' AND seguimiento_ep.idsospecha_diag='$idsospecha_diag_estab' AND notificacion_ep.iddepartamento='$iddepartamento' ";
$sql_r.= " AND notificacion_ep.gestion='$gestion' GROUP BY seguimiento_ep.idsemana_ep ";
$result = mysqli_query($link,$sql);

$total = mysqli_num_rows($result);

if ($row = mysqli_fetch_array($result)){

mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
?>

<?php
$sql7 = " SELECT count(seguimiento_ep.idseguimiento_ep) FROM seguimiento_ep, notificacion_ep ";
$sql7.= " WHERE seguimiento_ep.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND seguimiento_ep.idestado_paciente='2' AND notificacion_ep.gestion='$gestion' ";
$sql7.= " AND seguimiento_ep.idsospecha_diag='$idsospecha_diag_estab' AND seguimiento_ep.idsemana_ep='$row[0]' AND notificacion_ep.iddepartamento='$iddepartamento' ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$recuperados = $row7[0];
?>
<?php echo $recuperados; ?>

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
]   }
        
    ]
    });
});
		</script>

<!------ piramide epidemiologica ------>

	<script type="text/javascript">
$(function () {
    var categories = [
                    <?php
                    $numero = 0;
                    $sql = " SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ORDER BY idgrupo_etareo ";
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
                text: 'GRUPOS ETÁREOS <?php echo $row_sos[1];?> - DEPARTAMENTO : <?php echo $row_e[1];?> '
            },
            subtitle: {
                text: 'Fuente: Sistema Medi-Safci'
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 1
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
                        return (Math.abs(this.value) / 10) + 'x10';
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
                    return '<b>' + this.series.name + ', Grupo: ' + this.point.category + '</b><br/>' +
                        'Sospechas: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                }
            },

            series: [{
                name: 'MASCULINO',
                data: [
                    <?php
                    $numero2 = 0;
                    $sql2 = " SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ORDER BY idgrupo_etareo ";
                    $result2 = mysqli_query($link,$sql2);
                    $total2 = mysqli_num_rows($result2);
                    if ($row2 = mysqli_fetch_array($result2)){
                    mysqli_field_seek($result2,0);
                    while ($field2 = mysqli_fetch_field($result2)){
                    } do {
                    ?>

                    <?php
                    $sql7 = " SELECT sum(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, genero  ";
                    $sql7.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.idgenero=genero.idgenero  ";
                    $sql7.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND registro_enfermedad.idgenero='2' AND registro_enfermedad.idgrupo_etareo='$row2[0]'";
                    $sql7.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.iddepartamento='$iddepartamento' ";
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
                        $sql3 = " SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ORDER BY idgrupo_etareo ";
                        $result3 = mysqli_query($link,$sql3);
                        $total3 = mysqli_num_rows($result3);
                        if ($row3 = mysqli_fetch_array($result3)){
                        mysqli_field_seek($result3,0);
                        while ($field3 = mysqli_fetch_field($result3)){
                        } do {
                        ?>

                        <?php
                        $sql7 = " SELECT sum(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, genero  ";
                        $sql7.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND registro_enfermedad.idgenero=genero.idgenero  ";
                        $sql7.= " AND registro_enfermedad.idsospecha_diag='$idsospecha_diag_estab' AND registro_enfermedad.idgenero='1' AND registro_enfermedad.idgrupo_etareo='$row3[0]'";
                        $sql7.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' AND notificacion_ep.iddepartamento='$iddepartamento' ";
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
<div id="container_perfil" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

</br>

<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>



</body>
</html>