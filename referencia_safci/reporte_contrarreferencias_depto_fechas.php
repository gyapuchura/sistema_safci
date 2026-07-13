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

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>REPORTE DIAGNOSTICOS DE EGRESO - CONTRARREFERENCIA</title>

        <script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
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
            text: 'REPORTE DIAGNÓSTICOS DE EGRESO PARA CONTRARREFERENCIA - <?php echo $row_dep[1];?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Integrado MEDI-APS del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>'
        },
        xAxis: {
            categories: [
                <?php 
$numero = 0;
$sql = " SELECT diagnostico_egreso.idpatologia, patologia.patologia, patologia.cie, COUNT(diagnostico_egreso.iddiagnostico_egreso) AS total_diag ";
$sql.= " FROM diagnostico_egreso, patologia, referencia_hc ";
$sql.= " WHERE diagnostico_egreso.idpatologia=patologia.idpatologia AND diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc   ";
$sql.= "  AND referencia_hc.iddepartamento = '$iddepartamento' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$sql.= " GROUP BY diagnostico_egreso.idpatologia ";
// UNIFICADO A DESC: Envía el mayor al índice 0 para que Highcharts lo dibuje Arriba
$sql.= " ORDER BY total_diag DESC, diagnostico_egreso.idpatologia ASC ";
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
                text: ' Diagnósticos de Egreso ',
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
name: 'DIAGNÓSTICOS DE EGRESO PARA CONTRARREFERENCIA ',
data: [
    
    <?php 
$numero3 = 0;
$sql3 = " SELECT diagnostico_egreso.idpatologia, patologia.patologia, patologia.cie, COUNT(diagnostico_egreso.iddiagnostico_egreso) AS total_diag ";
$sql3.= " FROM diagnostico_egreso, patologia, referencia_hc ";
$sql3.= " WHERE diagnostico_egreso.idpatologia=patologia.idpatologia AND diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc   ";
$sql3.= "  AND referencia_hc.iddepartamento = '$iddepartamento' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
$sql3.= " GROUP BY diagnostico_egreso.idpatologia ";
// UNIFICADO A DESC: Para mantener sincronía exacta con las categorías
$sql3.= " ORDER BY total_diag DESC, diagnostico_egreso.idpatologia ASC ";
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

</head>
    <body>

<script src="../js/contrarreferencia.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 850px; height: <?php echo ($numero3*60) + 150;?>px; margin: 0 auto"></div>

<h4 align="center" style="font-family: Arial;">DIAGNÓSTICOS DE EGRESO PARA CONTRARREFERENCIA - DEPARTAMENTO : <?php echo $row_dep[1];?> = 
                <?php
                $sql_dgto = " SELECT count(diagnostico_egreso.iddiagnostico_egreso) FROM diagnostico_egreso, patologia, referencia_hc ";
                $sql_dgto.= " WHERE diagnostico_egreso.idpatologia=patologia.idpatologia AND diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc ";
                $sql_dgto.= " AND referencia_hc.iddepartamento='$iddepartamento' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
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
            $sql_m = " SELECT referencia_hc.idmunicipio, municipios.municipio FROM referencia_hc, municipios, diagnostico_egreso, patologia ";
            $sql_m.= " WHERE referencia_hc.idmunicipio=municipios.idmunicipio AND diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc ";
            $sql_m.= " AND diagnostico_egreso.idpatologia=patologia.idpatologia  ";
            $sql_m.= " AND referencia_hc.iddepartamento='$iddepartamento' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY referencia_hc.idmunicipio ORDER BY municipios.municipio ";
            $result_m = mysqli_query($link,$sql_m);
            if ($row_m = mysqli_fetch_array($result_m)){
            mysqli_field_seek($result_m,0);
            while ($field_m = mysqli_fetch_field($result_m)){
            } do { ?>
                <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">              
                <a href="reporte_contrarreferencias_mun_fechas.php?idmunicipio=<?php echo $row_m[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;"><?php echo $row_m[1];?></a>
                </span></td>
            <?php                  
            } while ($row_m = mysqli_fetch_array($result_m));
            } else {  }
            ?>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">TOTAL</span></td>
        </tr>
            <?php
            $numero = 1;
            $sql = " SELECT diagnostico_egreso.idpatologia, patologia.patologia, patologia.cie, COUNT(diagnostico_egreso.iddiagnostico_egreso) AS total_diag ";
            $sql.= " FROM diagnostico_egreso, patologia, referencia_hc ";
            $sql.= " WHERE diagnostico_egreso.idpatologia=patologia.idpatologia AND diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc   ";
            $sql.= "  AND referencia_hc.iddepartamento = '$iddepartamento' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
            $sql.= " GROUP BY diagnostico_egreso.idpatologia ";
            // ESTO SE MANTIENE EN DESC PARA LA TABLA HTML
            $sql.= " ORDER BY total_diag DESC, diagnostico_egreso.idpatologia ASC ";
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
            $sql_m = " SELECT referencia_hc.idmunicipio, municipios.municipio FROM referencia_hc, municipios, diagnostico_egreso, patologia ";
            $sql_m.= " WHERE referencia_hc.idmunicipio=municipios.idmunicipio AND diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc ";
            $sql_m.= " AND diagnostico_egreso.idpatologia=patologia.idpatologia  ";
            $sql_m.= " AND referencia_hc.iddepartamento='$iddepartamento' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' GROUP BY referencia_hc.idmunicipio ORDER BY municipios.municipio ";
            $result_m = mysqli_query($link,$sql_m);
            if ($row_m = mysqli_fetch_array($result_m)){
            mysqli_field_seek($result_m,0);
            while ($field_m = mysqli_fetch_field($result_m)){
            } do {
                
                $sql_dg = " SELECT count(diagnostico_egreso.iddiagnostico_egreso) FROM diagnostico_egreso, referencia_hc ";
                $sql_dg.= " WHERE diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc AND referencia_hc.idmunicipio='$row_m[0]' ";
                $sql_dg.= " AND diagnostico_egreso.idpatologia = '$row[0]' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
                $result_dg = mysqli_query($link,$sql_dg);
                $row_dg = mysqli_fetch_array($result_dg);
                $diagnosticos = $row_dg[0];
                
                ?>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                        
                    <a href="patologias_diario_mun_cref_fechas.php?idpatologia=<?php echo $row[0];?>&idmunicipio=<?php echo $row_m[0];?>&inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1420,height=820,scrollbars=YES,top=50,left=200'); return false;">
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
                $sql_dgt = " SELECT count(diagnostico_egreso.iddiagnostico_egreso) FROM diagnostico_egreso, referencia_hc ";
                $sql_dgt.= " WHERE diagnostico_egreso.idreferencia_hc=referencia_hc.idreferencia_hc AND referencia_hc.iddepartamento='$iddepartamento' ";
                $sql_dgt.= " AND diagnostico_egreso.idpatologia = '$row[0]' AND diagnostico_egreso.fecha_registro BETWEEN '$inicio' AND '$finalizacion' ";
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
    </body>
</html>