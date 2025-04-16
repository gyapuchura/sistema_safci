<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idusuario = $_GET['idusuario'];

$sql_op = " SELECT nombre.nombre, nombre.paterno, nombre.materno FROM nombre, usuarios WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$idusuario' ";
$result_op = mysqli_query($link,$sql_op);
$row_op = mysqli_fetch_array($result_op);
$operativo = mb_strtoupper($row_op[0]." ".$row_op[1]." ".$row_op[2]);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ESTRUCTURA VIVIENDA - MEDICO OPERATIVO</title>

		<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>

<script type="text/javascript">
$(function () {
    $('#riesgos_externos').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'g) RIESGOS EXTERNOS CON RELACIÓN A LA VIVIENDA - MÉDICO: <?php echo $operativo;?>'
        },
        subtitle: {
            text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
        },
        xAxis: {
            categories: [

                <?php 
$numero = 0;
$sql = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='2' AND idcat_determinante_salud='14' ";
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
                text: 'RIESGOS EXTERNOS CON RELACIÓN A LA VIVIENDA'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}  Familias</b></td></tr>',
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
$sql2 = " SELECT determinante_salud_cf.valor_cf FROM determinante_salud_cf, carpeta_familiar ";
$sql2.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql2.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
$sql2.= " AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='14'  ";
$sql2.= " GROUP BY determinante_salud_cf.valor_cf ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>

{ name: '<?php  if ($row2[0] == '1') { echo "NO"; } else { echo "SI"; }?>',

    data: [
<?php 
$numero3 = 0;
$sql3 = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='2' AND idcat_determinante_salud='14' ";
$result3 = mysqli_query($link,$sql3);
$total3 = mysqli_num_rows($result3);
 if ($row3 = mysqli_fetch_array($result3)){
mysqli_field_seek($result3,0);
while ($field3 = mysqli_fetch_field($result3)){
} do {
	?>

<?php
$sql_a =" SELECT count(determinante_salud_cf.valor_cf) FROM determinante_salud_cf, carpeta_familiar ";
$sql_a.=" WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
$sql_a.=" AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
$sql_a.=" AND determinante_salud_cf.iddeterminante_salud='2' AND determinante_salud_cf.idcat_determinante_salud='14' ";
$sql_a.=" AND determinante_salud_cf.iditem_determinante_salud='$row3[0]' AND determinante_salud_cf.valor_cf='$row2[0]' ";
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

	</head>
	<body>

<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="riesgos_externos" style="height: 350px"></div>

<table width="646" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="21" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">Riésgos externos con relación a la vivienda</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">NO</span></td>
        <td width="115" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">SI</span></td>
    </tr>
<?php
            $numero = 1;
            $sql = " SELECT iditem_determinante_salud, item_determinante_salud FROM item_determinante_salud WHERE iddeterminante_salud='2' AND idcat_determinante_salud='14' ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {

            $sql_si = " SELECT count(determinante_salud_cf.valor_cf) FROM determinante_salud_cf, carpeta_familiar ";
            $sql_si.= " WHERE  determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
            $sql_si.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
            $sql_si.= " AND determinante_salud_cf.iditem_determinante_salud='$row[0]' AND determinante_salud_cf.valor_cf='5'  ";
            $result_si = mysqli_query($link,$sql_si);
            $row_si = mysqli_fetch_array($result_si);
            $res_si = $row_si[0];

            $sql_no = " SELECT count(determinante_salud_cf.valor_cf) FROM determinante_salud_cf, carpeta_familiar ";
            $sql_no.= " WHERE determinante_salud_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
            $sql_no.= " AND carpeta_familiar.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
            $sql_no.= " AND determinante_salud_cf.iditem_determinante_salud='$row[0]' AND determinante_salud_cf.valor_cf='1'  ";
            $result_no = mysqli_query($link,$sql_no);
            $row_no = mysqli_fetch_array($result_no);
            $res_no = $row_no[0];

            ?>
                <tr>
                    <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
                    <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $res_no;?></td>
                    <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $res_si;?></td>
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
