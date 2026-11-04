<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram      = date("Ymd");
$fecha          = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

$iddepartamento = $_GET['iddepartamento'];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);


if (isset($_GET['patologias'])) {
    // 1. Decodificar y unserializar el array
    $array_patologia = unserialize($_GET['patologias']);
    
    // 2. Usar el array normalmente

    $ids_seguros = array_map('intval', $array_patologia);

    $patologias = implode(',', $ids_seguros);



?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>REPORTE DIAGNOSTICOS PREVENTIVOS</title>

        <script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
        <script src="../js/highcharts.js"></script>
        <script src="../js/highcharts-3d.js"></script>
        <script src="../js/modules/exporting.js"></script>
    <style type="text/css">
    ${demo.css}
            </style>
            <script type="text/javascript">
    $(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'REPORTE DIAGNÓSTICOS PREVENTIVOS PSAFCI - <?php echo $row_dep[1];?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie, COUNT(diagnostico_psafci.iddiagnostico_psafci) AS total_diag ";
$sql.= " FROM diagnostico_psafci, patologia, atencion_psafci ";
$sql.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci   ";
$sql.= " AND cie LIKE '%Z%' AND atencion_psafci.iddepartamento = '$iddepartamento' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$sql.= " AND patologia.idpatologia IN ($patologias) GROUP BY diagnostico_psafci.idpatologia ";
// UNIFICADO A DESC: Envía el mayor al índice 0 para que Highcharts lo dibuje Arriba
$sql.= " ORDER BY total_diag DESC, diagnostico_psafci.idpatologia ASC ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {
    ?>
 '<?php  echo $row[1];?> - <?php  echo $row[2];?>'

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
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ' Atenciones Preventivas PSAFCI ',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Diagnósticos'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
      
        series: [
{
name: 'DIAGNÓSTICOS PREVENTIVOS',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie, COUNT(diagnostico_psafci.iddiagnostico_psafci) AS total_diag ";
$sql3.= " FROM diagnostico_psafci, patologia, atencion_psafci ";
$sql3.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci   ";
$sql3.= " AND cie LIKE '%Z%' AND atencion_psafci.iddepartamento = '$iddepartamento' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$sql3.= " AND patologia.idpatologia IN ($patologias) GROUP BY diagnostico_psafci.idpatologia ";
// UNIFICADO A DESC: Para mantener sincronía exacta con las categorías
$sql3.= " ORDER BY total_diag DESC, diagnostico_psafci.idpatologia ASC ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
?>

<?php  echo $row3[3]; ?>

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

}
?> 

] } ]

    });
});
        </script>


<!---------- grafica de municipios por porcion CIE 10 --- BEGIN -------->

		<script type="text/javascript">
$(function () {
    $('#municipios').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ATENCIONES PREVENTIVAS - <?php echo $row_dep[1];?> '
        },
        subtitle: {
            text: 'Fuente: REGISTRO SISTEMA MEDI-SAFCI'
        },
        xAxis: {
            categories: [

                <?php 
$numero2 = 0;
$sql2 = " SELECT m.idmunicipio, m.municipio, COUNT(i.iddiagnostico_psafci) as total  ";
$sql2.= " FROM diagnostico_psafci i, municipios m, atencion_psafci a, patologia p ";
$sql2.= " WHERE m.idmunicipio=a.idmunicipio AND i.idatencion_psafci=a.idatencion_psafci AND i.idpatologia=p.idpatologia AND a.iddepartamento='$iddepartamento' ";
$sql2.= " AND p.cie LIKE '%Z%' AND i.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND p.idpatologia IN ($patologias)  GROUP BY m.idmunicipio ORDER BY total DESC  ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

 '<?php  echo $row2[1];?>'

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
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'ATENCIONES PREVENTIVAS'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} ATENCIONES </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: { enabled: true } 
            }
         
        },
        series: [


{ name: 'Atenciones Preventivas',

    data: [
<?php 
$numero4 = 0;
$sql4 = " SELECT m.idmunicipio, m.municipio, COUNT(i.iddiagnostico_psafci) as total  ";
$sql4.= " FROM diagnostico_psafci i, municipios m, atencion_psafci a, patologia p ";
$sql4.= " WHERE m.idmunicipio=a.idmunicipio AND i.idatencion_psafci=a.idatencion_psafci AND i.idpatologia=p.idpatologia AND a.iddepartamento='$iddepartamento' ";
$sql4.= " AND p.cie LIKE '%Z%' AND i.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND p.idpatologia IN ($patologias)  GROUP BY m.idmunicipio ORDER BY total DESC  ";
$result4 = mysqli_query($link,$sql4);
$total4 = mysqli_num_rows($result4);
 if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do {
	?>
 
<?php echo $row4[2]; ?>

<?php 
$numero4++;
if ($numero4 == $total4) {
echo "";
}
else {
echo ",";
}
} while ($row4 = mysqli_fetch_array($result4));
} else {
}
?>

        ]
}
  
    ]
    });
});
		</script>

<!---------- grafica de municipios por porcion CIE 10 --- END -------->

<!---------- grafica por patologias y municipios CIE 10 --- BEGIN -------->

<script type="text/javascript">
$(function () {
    $('#patologias').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ATENCIONES PREVENTIVAS - <?php echo $row_dep[1];?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [

                <?php 
$numero7 = 0;
$sql7 = " SELECT atencion_psafci.idmunicipio, municipios.municipio FROM diagnostico_psafci, atencion_psafci, municipios  ";
$sql7.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.idmunicipio=municipios.idmunicipio ";
$sql7.= " AND diagnostico_psafci.idpatologia IN ($patologias) AND atencion_psafci.iddepartamento='$iddepartamento'  ";
$sql7.= " AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion'  GROUP BY atencion_psafci.idmunicipio ";
$result7 = mysqli_query($link,$sql7);
$total7 = mysqli_num_rows($result7);
 if ($row7 = mysqli_fetch_array($result7)){
mysqli_field_seek($result7,0);
while ($field7 = mysqli_fetch_field($result7)){
} do {
	?>
 '<?php  echo $row7[1]; ?>'

<?php 
$numero7++;
if ($numero7 == $total7) {
echo "";
}
else {
echo ",";
}
} while ($row7 = mysqli_fetch_array($result7));
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
                text: 'ATENCIONES PREVENTIVAS - <?php echo $row_dep[1];?>'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} ATENCIONES </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: { enabled: true } 
            }
        },
        series: [

<?php 
$numero2 = 0;
$sql2 = " SELECT idpatologia, patologia, cie FROM patologia WHERE idpatologia IN ($patologias) ORDER BY idpatologia ";
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
$sql3 = " SELECT atencion_psafci.idmunicipio, municipios.municipio FROM diagnostico_psafci, atencion_psafci, municipios  ";
$sql3.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.idmunicipio=municipios.idmunicipio ";
$sql3.= " AND diagnostico_psafci.idpatologia IN ($patologias) AND atencion_psafci.iddepartamento='$iddepartamento'  ";
$sql3.= " AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion'  GROUP BY atencion_psafci.idmunicipio ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>

<?php
$sql_a =" SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
$sql_a.=" WHERE  diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.idmunicipio='$row3[0]' ";
$sql_a.=" AND diagnostico_psafci.idpatologia='$row2[0]' AND atencion_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion'";

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

<!---------- grafica por patologias y municipios CIE 10 --- END -------->

</head>
    <body>

  <style>
    #pantalla-carga {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.95);
        z-index: 9999999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: opacity 0.5s ease;
        font-family: Arial, sans-serif;
    }
    .spinner-loader {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #7cb5ec; /* Turquesa corporativo de referencias */
        border-radius: 50%;
        animation: girar 1s linear infinite;
        margin-bottom: 20px;
    }
    .texto-loader {
        color: #7cb5ec;
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 1px;
    }
    @keyframes girar {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    body.bloqueado { overflow: hidden; }
</style>
<div id="pantalla-carga">
    <div class="spinner-loader"></div>
    <div class="texto-loader">Procesando ATENCIONES PREVENTIVAS, por favor espere...</div>
</div>

<?php
    // MAGIA BACKEND: Obligamos a Apache/PHP a pintar esto en la pantalla del usuario YA
    if (ob_get_level() == 0) ob_start();
    echo str_pad('', 4096); // Hack de 4KB para forzar el vaciado en servidores con GZIP
    ob_flush();
    flush();
?>  

<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo ($numero3*60) + 150;?>px; margin: 0 auto"></div>
</br>
<div id="municipios" style="min-width: 510px; height: 400px; margin: 0 auto"></div>
</br>
<div id="patologias" style="min-width: 510px; height: 400px; margin: 0 auto"></div>
</br>
<h4 align="center" style="font-family: Arial;">DIAGNÓSTICOS PREVENTIVOS DEPARTAMENTO : <?php echo $row_dep[1];?> = 
                <?php
                $sql_dgto = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, patologia, atencion_psafci ";
                $sql_dgto.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND patologia.idpatologia IN ($patologias) ";
                $sql_dgto.= " AND patologia.cie LIKE '%Z%' AND atencion_psafci.iddepartamento='$iddepartamento' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                $result_dgto = mysqli_query($link,$sql_dgto);
                $row_dgto = mysqli_fetch_array($result_dgto);
                $diagnostico_nal = $row_dgto[0];
                echo $diagnostico_nal;
                ?>
                
</h4>

<h4 align="center" style="font-family: Arial;">DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>
<h4 align="center" style="font-family: Arial;">MUNICIPIOS</h4>
<table width="1400" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="400" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">DIAGNÓSTICOS PSAFCI</span></td>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">CIE</span></td>
            <?php
            $sql_m = " SELECT atencion_psafci.idmunicipio, municipios.municipio FROM atencion_psafci, municipios, diagnostico_psafci, patologia ";
            $sql_m.= " WHERE atencion_psafci.idmunicipio=municipios.idmunicipio AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
            $sql_m.= " AND diagnostico_psafci.idpatologia=patologia.idpatologia AND patologia.cie LIKE '%Z%' AND patologia.idpatologia IN ($patologias) ";
            $sql_m.= " AND atencion_psafci.iddepartamento='$iddepartamento' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY atencion_psafci.idmunicipio ORDER BY municipios.municipio ";
            $result_m = mysqli_query($link,$sql_m);
            if ($row_m = mysqli_fetch_array($result_m)){
            mysqli_field_seek($result_m,0);
            while ($field_m = mysqli_fetch_field($result_m)){
            } do { ?>
                <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">              
                <a href="reporte_psafci_diag_mun_dos_fechas.php?idmunicipio=<?php echo $row_m[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_m[1];?></a>
                </span></td>
            <?php                  
            } while ($row_m = mysqli_fetch_array($result_m));
            } else {  }
            ?>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">TOTAL</span></td>
        </tr>
            <?php
            $numero = 1;
            $sql = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie, COUNT(diagnostico_psafci.iddiagnostico_psafci) AS total_diag ";
            $sql.= " FROM diagnostico_psafci, patologia, atencion_psafci ";
            $sql.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci   ";
            $sql.= " AND cie LIKE '%Z%' AND atencion_psafci.iddepartamento = '$iddepartamento' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
            $sql.= " AND patologia.idpatologia IN ($patologias) GROUP BY diagnostico_psafci.idpatologia ";
            // ESTO SE MANTIENE EN DESC PARA LA TABLA HTML
            $sql.= " ORDER BY total_diag DESC, diagnostico_psafci.idpatologia ASC ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
           ?>
                <tr>
                    <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
                    <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
                    <td width="50" bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
            <?php
            $sql_m = " SELECT atencion_psafci.idmunicipio, municipios.municipio FROM atencion_psafci, municipios, diagnostico_psafci, patologia ";
            $sql_m.= " WHERE atencion_psafci.idmunicipio=municipios.idmunicipio AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci ";
            $sql_m.= " AND diagnostico_psafci.idpatologia=patologia.idpatologia AND patologia.cie LIKE '%Z%' AND patologia.idpatologia IN ($patologias) ";
            $sql_m.= " AND atencion_psafci.iddepartamento='$iddepartamento' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY atencion_psafci.idmunicipio ORDER BY municipios.municipio ";
            $result_m = mysqli_query($link,$sql_m);
            if ($row_m = mysqli_fetch_array($result_m)){
            mysqli_field_seek($result_m,0);
            while ($field_m = mysqli_fetch_field($result_m)){
            } do {
                
                $sql_dg = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
                $sql_dg.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.idmunicipio='$row_m[0]' ";
                $sql_dg.= " AND diagnostico_psafci.idpatologia = '$row[0]' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND diagnostico_psafci.idpatologia IN ($patologias)  ";
                $result_dg = mysqli_query($link,$sql_dg);
                $row_dg = mysqli_fetch_array($result_dg);
                $diagnosticos = $row_dg[0];
                
                ?>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                        
                    <a href="patologias_diario_mun_fechas.php?idpatologia=<?php echo $row[0];?>&idmunicipio=<?php echo $row_m[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;">
                        <?php 
                        if ($diagnosticos == '0') {
                            
                        } else {
                            echo $diagnosticos;
                        }  
                        ?></a>

                    
                                
                </td>
            <?php                  
            } while ($row_m = mysqli_fetch_array($result_m));
            } else {  }
            ?>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                <?php
                $sql_dgt = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, atencion_psafci ";
                $sql_dgt.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.iddepartamento='$iddepartamento' ";
                $sql_dgt.= " AND diagnostico_psafci.idpatologia = '$row[0]' AND diagnostico_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND diagnostico_psafci.idpatologia IN ($patologias) ";
                $result_dgt = mysqli_query($link,$sql_dgt);
                $row_dgt = mysqli_fetch_array($result_dgt);
                $diagnostico_pat = $row_dgt[0];
                echo $diagnostico_pat;
                ?>
            </td>
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
</br>

<?php } ?>
<script>
    // Evitamos que el usuario baje por la página mientras carga
    document.body.classList.add('bloqueado');

    // Escuchamos el evento 'load', que se dispara solo cuando TODO ha cargado
    window.addEventListener('load', function() {
        const loader = document.getElementById('pantalla-carga');
        if(loader) {
            // Animación de desvanecimiento
            loader.style.opacity = '0';
            setTimeout(function() {
                loader.style.display = 'none';
                document.body.classList.remove('bloqueado');
            }, 500); // Se remueve del DOM tras medio segundo
        }
    });
</script>
    </body>
</html>