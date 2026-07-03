<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram  = date("Ymd");
$fecha    = date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

// 1. CAPTURAMOS LAS FECHAS
$inicio = $_GET['inicio'];
$finalizacion = $_GET['finalizacion'];

$fecha_i = explode('-',$inicio);
$f_inicio = $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0];

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0];

// =========================================================================
// 2. MOTOR DE FILTROS DINÁMICOS
// =========================================================================
$iddepartamento    = isset($_GET['iddepartamento']) ? $_GET['iddepartamento'] : '';
$idmunicipio       = isset($_GET['idmunicipio']) ? $_GET['idmunicipio'] : '';
$idestablecimiento = isset($_GET['idestablecimiento']) ? $_GET['idestablecimiento'] : '';
$idusuario_medico  = isset($_GET['idusuario_medico']) ? $_GET['idusuario_medico'] : ''; 

$filtro_extra = "";
if($iddepartamento != '') { $filtro_extra .= " AND atencion_psafci.iddepartamento = '$iddepartamento' "; }
if($idmunicipio != '') { $filtro_extra .= " AND atencion_psafci.idmunicipio = '$idmunicipio' "; }
if($idestablecimiento != '') { $filtro_extra .= " AND atencion_psafci.idestablecimiento_salud = '$idestablecimiento' "; }
if($idusuario_medico != '') { $filtro_extra .= " AND atencion_psafci.idusuario = '$idusuario_medico' "; }

// =========================================================================
// 3. PUENTE DE DATOS EN MEMORIA (ARQUITECTURA PARA CASCADA INMEDIATA)
// =========================================================================
$sql_all_d = "SELECT iddepartamento, departamento FROM departamento";
$res_all_d = mysqli_query($link, $sql_all_d);
$arr_deptos = array();
while($row = mysqli_fetch_array($res_all_d)){
    $arr_deptos[] = '{ "id": "'.$row[0].'", "nombre": "'.addslashes(trim($row[1])).'" }';
}

$sql_all_m = "SELECT idmunicipio, iddepartamento, municipio FROM municipios";
$res_all_m = mysqli_query($link, $sql_all_m);
$arr_munis = array();
while($row = mysqli_fetch_array($res_all_m)){
    $arr_munis[] = '{ "id": "'.$row[0].'", "idDepto": "'.$row[1].'", "nombre": "'.addslashes(trim($row[2])).'" }';
}

$sql_all_e = "SELECT idestablecimiento_salud, idmunicipio, establecimiento_salud FROM establecimiento_salud";
$res_all_e = mysqli_query($link, $sql_all_e);
$arr_eess = array();
while($row = mysqli_fetch_array($res_all_e)){
    $arr_eess[] = '{ "id": "'.$row[0].'", "idMuni": "'.$row[1].'", "nombre": "'.addslashes(trim($row[2])).'" }';
}
// =========================================================================
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>MEDI-SAFCI ATENCIONES - DIARIAS</title>

    <script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
    <style type="text/css">
        ${demo.css}
        
        .barra-filtros {
            background-color: #f8f9fa; border: 1px solid #d1d3e2; border-radius: 6px; 
            padding: 15px; margin: 10px auto; width: 90%; font-family: Arial; font-size: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .barra-filtros form { display: flex; flex-direction: column; align-items: center; gap: 15px; margin: 0; }
        .filtros-dropdowns { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; width: 100%; }
        .filtros-dropdowns > div { display: flex; align-items: center; gap: 5px; position: relative; }
        .barra-filtros label { margin: 0; font-weight: bold; color: #4a4a4a; }
        
        .barra-filtros input[list] { 
            padding: 6px 8px; border-radius: 4px; border: 1px solid #b7b9cc; font-size: 12px; color: #333; outline: none; width: 220px;
        }
        
        .btn-filtrar { 
            background-color: #0d6efd; color: white; padding: 8px 25px; border: none; 
            border-radius: 4px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease; box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
        }
        .btn-filtrar:hover { background-color: #0b5ed7; }

        .btn-excel {
            background-color: #1cc88a; color: #ffffff; border: none; padding: 10px 24px;
            font-size: 14px; font-family: Arial; font-weight: bold; border-radius: 5px;
            cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .btn-excel:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(28, 200, 138, 0.3); }

        .tabla-matriz { width: 100%; border-collapse: collapse; font-family: Arial; font-size: 11px; background-color: #fff; }
        .tabla-matriz th { background-color: #2D56CF; color: white; padding: 8px 4px; border: 1px solid #b7b9cc; text-align: center; font-size: 11px; }
        .tabla-matriz td { padding: 6px 4px; border: 1px solid #d1d3e2; text-align: center; color: #333; }
        .tabla-matriz .td-izq { text-align: left; font-weight: bold; color: #4a4a4a; background-color: #f8f9fa;}
        .tabla-matriz .td-tot { font-weight: bold; background-color: #eaecf4; color: #2D56CF; }
        .tabla-matriz tr:hover td { background-color: #eaecf4; }

        /* CSS DEL TOOLTIP */
        .celda-interactiva { position: relative; cursor: crosshair; color: #0d6efd; font-weight: bold; background-color: #f1f8ff; }
        .celda-interactiva .tooltip-hc {
            visibility: hidden; opacity: 0; position: absolute;
            bottom: 80%; left: 50%; transform: translateX(-50%);
            background-color: rgba(255, 255, 255, 0.98);
            border: 1px solid #7cb5ec; border-radius: 5px;
            padding: 10px 15px; box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
            z-index: 99999; white-space: nowrap; text-align: left;
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, sans-serif; 
            font-size: 12px; color: #333; transition: all 0.2s ease-in-out; pointer-events: none;
        }
        .celda-interactiva .tooltip-hc::after {
            content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
            border-width: 6px; border-style: solid; border-color: #7cb5ec transparent transparent transparent;
        }
        .celda-interactiva:hover .tooltip-hc { visibility: visible; opacity: 1; bottom: 120%; }
        .tooltip-hc span.f-hc { font-size: 11px; color: #666; display: block; margin-bottom: 6px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 4px;}
        .tooltip-hc span.dot-tc { color: #7cb5ec; font-size: 16px; margin-right: 5px;}
        .tooltip-hc span.dot-tm { color: #434348; font-size: 16px; margin-right: 5px;}
        .tooltip-hc span.dot-ta { color: #90ed7d; font-size: 16px; margin-right: 5px;}
        .tooltip-hc div { margin-bottom: 4px; font-weight: normal; }
    </style>
    <script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: { type: 'areaspline' },
        title: { text: 'ATENCIONES POR DIA - PROGRAMA TELESALUD' },
        subtitle: { text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>' },
        legend: { layout: 'vertical', align: 'left', verticalAlign: 'top', x: 150, y: 100, floating: true, borderWidth: 1, backgroundColor: '#FFFFFF' },
        xAxis: {
            categories: [
 <?php
$numero = 0;
$sql = " SELECT fecha_registro FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){ } do {
    $fecha_s = explode('-',$row[0]);
    $fecha_log = $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0];
    ?> '<?php echo $fecha_log;?>' <?php
$numero++;
if ($numero == $total) { echo ""; } else { echo ","; }
} while ($row = mysqli_fetch_array($result));
} else { echo ","; }
?>
            ],
            plotBands: [{ from: 4.5, to: 6.5, color: 'rgba(68, 170, 213, .2)' }]
        },
        yAxis: { title: { text: 'ATENCIONES TELESALUD DIARIAS' } },
        tooltip: { shared: true, valueSuffix: ' Atenciones' },
        credits: { enabled: false },
        plotOptions: { areaspline: { fillOpacity: 0.5 } },
        series: [{
            name: 'TELECONSULTA',
            data: [
             <?php
$numero = 0;
$sql = " SELECT fecha_registro FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){ } do {
?>
<?php
$sql7 = " SELECT idatencion_psafci, fecha_registro FROM atencion_psafci WHERE fecha_registro='$row[0]' AND idtipo_atencion='3' $filtro_extra ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_num_rows($result7);
$cifra_diaria = $row7;
?>
             <?php echo $cifra_diaria; ?>
<?php
$numero++;
if ($numero == $total) { echo ""; } else { echo ","; }
} while ($row = mysqli_fetch_array($result));
} else { echo ","; }
?>
            ]
        },
        {
            name: 'TELEMETRÍA',
            data: [
             <?php
$numero = 0;
$sql = " SELECT fecha_registro FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra GROUP BY fecha_registro ORDER BY fecha_registro ";
$result = mysqli_query($link,$sql);
$total = mysqli_num_rows($result);
 if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){ } do {
?>
<?php
// INGENIERÍA DE DATOS: Usamos COUNT(DISTINCT) de Paciente+Dispositivo para matar los datos duplicados
$sql7 = " SELECT COUNT(DISTINCT examen_teleconsulta.idatencion_psafci, examen_teleconsulta.idexamen_complementario) as total_equipos
          FROM examen_teleconsulta 
          INNER JOIN atencion_psafci ON examen_teleconsulta.idatencion_psafci = atencion_psafci.idatencion_psafci 
          INNER JOIN examen_complementario ON examen_teleconsulta.idexamen_complementario = examen_complementario.idexamen_complementario 
          WHERE atencion_psafci.fecha_registro='$row[0]' 
          AND atencion_psafci.idtipo_atencion = '4' 
          AND UPPER(examen_complementario.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%' 
          AND UPPER(examen_complementario.examen_complementario) NOT LIKE '%ESTETOSCOPIO DIGITAL%' 
          AND UPPER(examen_complementario.examen_complementario) NOT LIKE '%OTRO%' 
          $filtro_extra ";
$result7 = mysqli_query($link,$sql7);
$row7 = mysqli_fetch_array($result7);
$cifra_diaria2 = $row7['total_equipos'];
?>
             <?php echo $cifra_diaria2; ?>
<?php
$numero++;
if ($numero == $total) { echo ""; } else { echo ","; }
} while ($row = mysqli_fetch_array($result));
} else { echo ","; }
?>
            ]
        } ]
    });
});
    </script>
  </head>
  <body>
<script src="../js/salud_integrantes.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 300px; height: 350px; margin: 0 auto"></div>

<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center; margin-top: 20px;">INFORME DE ATENCIONES MÉDICAS POR TELESALUD DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>

<div class="barra-filtros">
    <form action="" method="get" id="form-filtros">
        <input type="hidden" name="inicio" id="val-inicio" value="<?php echo $inicio;?>">
        <input type="hidden" name="finalizacion" id="val-finalizacion" value="<?php echo $finalizacion;?>">
        
        <input type="hidden" name="iddepartamento" id="val-iddepartamento" value="<?php echo $iddepartamento;?>">
        <input type="hidden" name="idmunicipio" id="val-idmunicipio" value="<?php echo $idmunicipio;?>">
        <input type="hidden" name="idestablecimiento" id="val-idestablecimiento" value="<?php echo $idestablecimiento;?>">
        <input type="hidden" name="idusuario_medico" id="val-idusuario_medico" value="<?php echo $idusuario_medico;?>">
        
        <div class="filtros-dropdowns">
            <div>
                <label>Departamento:</label>
                <input list="dl-deptos" id="inp-depto" value="" placeholder="Seleccione..." autocomplete="off">
                <datalist id="dl-deptos"></datalist>
            </div>
            <div>
                <label>Municipio:</label>
                <input list="dl-munis" id="inp-muni" value="" placeholder="Todos los municipios..." autocomplete="off">
                <datalist id="dl-munis"></datalist>
            </div>
            <div>
                <label>Establecimiento:</label>
                <input list="dl-ests" id="inp-est" value="" placeholder="Todos los establecimientos..." autocomplete="off">
                <datalist id="dl-ests"></datalist>
            </div>
            <div>
                <label>Médico:</label>
                <?php
                    $nombre_med_sel = "";
                    $lista_meds = "";
                    $sql_u = "SELECT usuarios.idusuario, nombre.nombre, nombre.paterno, nombre.materno 
                              FROM usuarios INNER JOIN nombre ON usuarios.idnombre = nombre.idnombre 
                              ORDER BY nombre.nombre";
                    $res_u = mysqli_query($link, $sql_u);
                    while($row_u = mysqli_fetch_array($res_u)){
                        $nombre_completo = mb_strtoupper($row_u[1]." ".$row_u[2]." ".$row_u[3]);
                        if($idusuario_medico == $row_u[0]) $nombre_med_sel = $nombre_completo;
                        $lista_meds .= "<option data-id='".$row_u[0]."' value='".$nombre_completo."'></option>";
                    }
                ?>
                <input list="dl-meds" id="inp-med" value="<?php echo $nombre_med_sel; ?>" placeholder="Escriba para buscar..." autocomplete="off">
                <datalist id="dl-meds"><?php echo $lista_meds; ?></datalist>
            </div>
            
            <div style="margin-left:10px;">
                <button type="button" class="btn-filtrar" style="background-color: #6c7a89;" title="Limpiar todos los campos" onclick="window.location.href=window.location.pathname+'?inicio=' + document.getElementById('val-inicio').value + '&finalizacion=' + document.getElementById('val-finalizacion').value;">LIMPIAR</button>
            </div>
        </div>
        <button type="submit" class="btn-filtrar">APLICAR FILTRO</button>
    </form>
</div>



<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="444"><span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">    
      <a href="estadisticas_telemetria.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=800,left=600, scrollbars=YES'); return false;">
         N° TOTAL ATENCIONES REGISTRADAS</a> = 
          <?php 
    $sql_ps =" SELECT count(idatencion_psafci) FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '5' $filtro_extra ";
    $result_ps = mysqli_query($link,$sql_ps);
    $row_ps = mysqli_fetch_array($result_ps);
    $atenciones_ps  = number_format($row_ps[0], 0, '.', '.');
    echo $atenciones_ps;?>
      </span></td>
      <td width="446">
        <span style="font-family: Arial; font-size: 16px; color: #ff70c6 ; text-align: center;">N° ATENCIONES NUEVAS = 
          <?php 
    $sql_vf =" SELECT count(idatencion_psafci) FROM atencion_psafci WHERE idrepeticion ='1' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '5' $filtro_extra ";
    $result_vf = mysqli_query($link,$sql_vf);
    $row_vf = mysqli_fetch_array($result_vf);
    $visita  = number_format($row_vf[0], 0, '.', '.');
    echo $visita;?></span>
      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #008f39 ; text-align: center;">N° ATENCIONES EN CONSULTA = 
            <?php 
            $sql_con =" SELECT count(idatencion_psafci) FROM atencion_psafci WHERE idtipo_consulta='1' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '5' $filtro_extra ";
            $result_con = mysqli_query($link,$sql_con);
            $row_con = mysqli_fetch_array($result_con);
            $consulta  = number_format($row_con[0], 0, '.', '.');
            echo $consulta?>
      </span></td>
      <td>
        <span style="font-family: Arial; font-size: 16px; color: #ff70c6 ; text-align: center;">N° ATENCIONES REPETIDAS = 
            <?php 
            $sql_vf =" SELECT count(idatencion_psafci) FROM atencion_psafci WHERE idrepeticion ='2' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '3' $filtro_extra ";
            $result_vf = mysqli_query($link,$sql_vf);
            $row_vf = mysqli_fetch_array($result_vf);
            $visita  = number_format($row_vf[0], 0, '.', '.');
            echo $visita;?></span>
      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #008f39 ; text-align: center;">N° ATENCIONES EN VISITA FAMILIAR =
          <?php 
    $sql_vf =" SELECT count(idatencion_psafci) FROM atencion_psafci WHERE idtipo_consulta='2' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '5' $filtro_extra ";
    $result_vf = mysqli_query($link,$sql_vf);
    $row_vf = mysqli_fetch_array($result_vf);
    $visita  = number_format($row_vf[0], 0, '.', '.');
    echo $visita;?>
      </span></td>
      <td>
          <span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">N° DE MUNICIPIOS =
          <?php 
            $sql_mun =" SELECT idmunicipio FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '5' $filtro_extra GROUP BY idmunicipio ";
            $result_mun = mysqli_query($link,$sql_mun);
            $municipios = mysqli_num_rows($result_mun);
            echo $municipios;?>
      </td>
    </tr>
        <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">N° ATENCIONES POR TELECONSULTA =
          <?php 
    $sql_vf =" SELECT count(idatencion_psafci) FROM atencion_psafci WHERE idtipo_atencion='3' AND fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra ";
    $result_vf = mysqli_query($link,$sql_vf);
    $row_vf = mysqli_fetch_array($result_vf);
    $visita  = number_format($row_vf[0], 0, '.', '.');
    echo $visita;?>
      </span></td>
      <td>
          <span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">N° DE ESTABLECIMIENTOS DE SALUD =
          <?php 
            $sql_es =" SELECT idestablecimiento_salud FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '5' $filtro_extra GROUP BY idestablecimiento_salud ";
            $result_es = mysqli_query($link,$sql_es);
            $establecimientos = mysqli_num_rows($result_es);
            echo $establecimientos;?>
      </td>
    </tr>
    <tr>
      <td><span style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">        
        <a href="reporte_telemetria_nal.php?inicio=<?php echo $inicio;?>&finalizacion=<?php echo $finalizacion;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=800,left=400, scrollbars=YES'); return false;">
        N° DE TELEMETRÍAS REALIZADAS</a> =
          <?php 
          // INGENIERÍA DE DATOS: Deduplicación con DISTINCT para contar aparatos únicos por paciente
          $sql_vf =" SELECT COUNT(DISTINCT examen_teleconsulta.idatencion_psafci, examen_teleconsulta.idexamen_complementario) 
                     FROM examen_teleconsulta 
                     INNER JOIN atencion_psafci ON examen_teleconsulta.idatencion_psafci = atencion_psafci.idatencion_psafci 
                     INNER JOIN examen_complementario ON examen_teleconsulta.idexamen_complementario = examen_complementario.idexamen_complementario 
                     WHERE atencion_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' 
                     AND atencion_psafci.idtipo_atencion = '4' 
                     AND UPPER(examen_complementario.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%' 
                     AND UPPER(examen_complementario.examen_complementario) NOT LIKE '%ESTETOSCOPIO DIGITAL%' 
                     AND UPPER(examen_complementario.examen_complementario) NOT LIKE '%OTRO%' 
                     $filtro_extra ";
          $result_vf = mysqli_query($link,$sql_vf);
          $row_vf = mysqli_fetch_array($result_vf);
          $visita  = number_format($row_vf[0], 0, '.', '.');
          echo $visita;?>
      </span></td>
      <td>
          <span style="font-family: Arial; font-size: 16px; color: #000000; text-align: center;">N° DE MÉDICOS =
          <?php 
            $sql_op =" SELECT idusuario FROM atencion_psafci WHERE fecha_registro BETWEEN '$inicio' AND '$finalizacion' AND idtipo_atencion != '1' AND idtipo_atencion != '2' AND idtipo_atencion != '5' $filtro_extra GROUP BY idusuario ";
            $result_op = mysqli_query($link,$sql_op);
            $medicos = mysqli_num_rows($result_op);
            echo $medicos;?>
      </td>
    </tr>
  </tbody>
</table>
<p style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">&nbsp;</p>

<div align="center" style="margin-bottom: 20px; display: flex; justify-content: center; gap: 15px;">
  <button type="button" id="btn-mostrar-matriz" class="btn-excel" style="background-color: #2D56CF; box-shadow: 0 4px 6px rgba(45, 86, 207, 0.2);">
    VER PRODUCCIÓN DIARIA
  </button>

  <form action="reporte_telesalud_excel.php" method="post" style="margin: 0;">
    <input type="hidden" name="inicio" value="<?php echo $inicio;?>">
    <input type="hidden" name="finalizacion" value="<?php echo $finalizacion;?>">
    <input type="hidden" name="iddepartamento" value="<?php echo $iddepartamento;?>">
    <input type="hidden" name="idmunicipio" value="<?php echo $idmunicipio;?>">
    <input type="hidden" name="idestablecimiento" value="<?php echo $idestablecimiento;?>">
    <input type="hidden" name="idusuario_medico" value="<?php echo $idusuario_medico;?>">
    <button type="submit" class="btn-excel">DESCARGAR EN EXCEL</button>
  </form>
</div>
<div id="contenedor-matriz" style="display: none; padding-bottom: 50px;">
    <h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">MATRIZ DE PRODUCCIÓN</h4>
    <div style="overflow-x: auto; width: 95%; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding-top: 60px; margin-top: -40px;">
        <table class="tabla-matriz" id="tabla-matriz-estrategica">
            <thead>
                <tr>
                    <th>DEPARTAMENTO</th>
                    <th>MUNICIPIO</th>
                    <th>ESTABLECIMIENTO</th>
                    <th>MÉDICO OPERATIVO</th> <?php
                    $dias_matriz = array();
                    $current_time = strtotime($inicio);
                    $last_time = strtotime($finalizacion);
                    while($current_time <= $last_time) {
                        $dias_matriz[] = date('Y-m-d', $current_time);
                        $dia_format = date('d/m', $current_time);
                        echo "<th>$dia_format</th>";
                        $current_time = strtotime('+1 day', $current_time);
                    }
                    ?>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // CONSULTA DATA WAREHOUSE: Integramos una subconsulta anidada para no duplicar datos
            $sql_matriz = "
                SELECT 
                    departamento.departamento, 
                    municipios.municipio, 
                    establecimiento_salud.establecimiento_salud, 
                    CONCAT(IFNULL(nombre.nombre,''), ' ', IFNULL(nombre.paterno,''), ' ', IFNULL(nombre.materno,'')) as medico,
                    atencion_psafci.fecha_registro, 
                    COUNT(atencion_psafci.idatencion_psafci) as cantidad,
                    SUM(CASE WHEN atencion_psafci.idtipo_atencion = '3' THEN 1 ELSE 0 END) as teleconsulta,
                    SUM(CASE WHEN atencion_psafci.idtipo_atencion = '4' THEN 1 ELSE 0 END) as telemetria_atenciones,
                    SUM(CASE WHEN atencion_psafci.idtipo_atencion = '4' THEN IFNULL(dispositivos.cant_dispositivos, 0) ELSE 0 END) as tecnoasistida
                FROM atencion_psafci
                INNER JOIN departamento ON atencion_psafci.iddepartamento = departamento.iddepartamento
                INNER JOIN municipios ON atencion_psafci.idmunicipio = municipios.idmunicipio
                INNER JOIN establecimiento_salud ON atencion_psafci.idestablecimiento_salud = establecimiento_salud.idestablecimiento_salud
                LEFT JOIN usuarios ON atencion_psafci.idusuario = usuarios.idusuario
                LEFT JOIN nombre ON usuarios.idnombre = nombre.idnombre
                LEFT JOIN (
                    SELECT et.idatencion_psafci, COUNT(DISTINCT et.idexamen_complementario) as cant_dispositivos
                    FROM examen_teleconsulta et
                    INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario
                    WHERE UPPER(ec.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%' 
                    AND UPPER(ec.examen_complementario) NOT LIKE '%ESTETOSCOPIO DIGITAL%'
                    AND UPPER(ec.examen_complementario) NOT LIKE '%OTRO%'
                    GROUP BY et.idatencion_psafci
                ) as dispositivos ON atencion_psafci.idatencion_psafci = dispositivos.idatencion_psafci
                WHERE atencion_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion'
                AND atencion_psafci.idtipo_atencion != '1' AND atencion_psafci.idtipo_atencion != '2' AND atencion_psafci.idtipo_atencion != '5'
                $filtro_extra
                GROUP BY departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, medico, atencion_psafci.fecha_registro
                ORDER BY departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, medico
            ";
            $res_matriz = mysqli_query($link, $sql_matriz);
            
            $data_agrupada = array();
            while($rm = mysqli_fetch_assoc($res_matriz)) {
                $dep = $rm['departamento'];
                $mun = $rm['municipio'];
                $est = $rm['establecimiento_salud'];
                $med = mb_strtoupper($rm['medico']); 
                $fec = $rm['fecha_registro'];
                $cant = $rm['cantidad'];
                
                if(!isset($data_agrupada[$dep][$mun][$est][$med])) {
                    $data_agrupada[$dep][$mun][$est][$med] = array();
                }
                // Guardamos el desglose completo
                $data_agrupada[$dep][$mun][$est][$med][$fec] = array(
                    'tc' => $rm['teleconsulta'],
                    'tm' => $rm['telemetria_atenciones'],
                    'ta' => $rm['tecnoasistida']
                );
            }

            $gran_total = 0;
            $totales_por_dia = array();

            if(count($data_agrupada) > 0) {
                foreach($data_agrupada as $dep => $muns) {
                    foreach($muns as $mun => $ests) {
                        foreach($ests as $est => $medicos) {
                            foreach($medicos as $med => $fechas) { 
                                    echo "<tr>";
                                    echo "<td class='td-izq'>$dep</td>";
                                    echo "<td class='td-izq'>$mun</td>";
                                    echo "<td class='td-izq'>$est</td>";
                                    echo "<td class='td-izq'>$med</td>"; 
                                    
                                    $suma_fila = 0;
                                    foreach($dias_matriz as $d) {
                                        // --- INICIO DEL BLOQUE 3 (TOOLTIP ESTILO HIGHCHARTS) ---
                                        if(isset($fechas[$d])) {
                                            $tc  = $fechas[$d]['tc'];
                                            $tm  = $fechas[$d]['tm']; // N° Atenciones Telemetría
                                            $ta  = $fechas[$d]['ta']; // N° Dispositivos Reales
                                            
                                            // La celda SUMA: Teleconsultas + Dispositivos
                                            $val = $tc + $ta;

                                            $suma_fila += $val;
                                            $gran_total += $val;
                                            if(!isset($totales_por_dia[$d])) $totales_por_dia[$d] = 0;
                                            $totales_por_dia[$d] += $val;
                                            
                                            // ARMADO DEL TOOLTIP (Clon de Highcharts)
                                            $fecha_form = date('d/m/Y', strtotime($d));
                                            $tooltip_html = "<div class='tooltip-hc'>
                                                                <div><span class='dot-tc'>●</span> N° Teleconsultas: <b>$tc</b></div>
                                                                <div><span class='dot-ta'>●</span> N° Atenciones Telemetría: <b>$ta</b></div>
                                                             </div>";
                                            
                                            // Dibujamos la celda aplicando nuestra clase interactiva
                                            echo "<td class='celda-interactiva'>" . ($val > 0 ? $val : '0') . $tooltip_html . "</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }
                                        // --- FIN DEL BLOQUE 3 ---
                                    }
                                    echo "<td class='td-tot'>$suma_fila</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    }
                
                echo "<tr>";
                echo "<td colspan='4' class='td-tot' style='text-align: right;'>TOTAL GENERAL:</td>";
                foreach($dias_matriz as $d) {
                    $t_dia = isset($totales_por_dia[$d]) ? $totales_por_dia[$d] : 0;
                    echo "<td class='td-tot'>" . ($t_dia > 0 ? $t_dia : '-') . "</td>";
                }
                echo "<td class='td-tot' style='font-size:14px;'>$gran_total</td>";
                echo "</tr>";
                
            } else {
                $cols = count($dias_matriz) + 5;
                echo "<tr><td colspan='$cols'>No hay datos de producción en los parámetros seleccionados.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <div style="width: 95%; margin: 15px auto; text-align: right;">
        <button type="button" onclick="exportarMatrizExcel('tabla-matriz-estrategica')" style="background-color: #1D6F42; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 14px; box-shadow: 0 4px 6px rgba(0,0,0,0.15);">
            ⬇ DESCARGAR PRODUCCIÓN DIARIA
        </button>
    </div>
</div>

<div id="contenedor-pacientes">
    <table width="1000" border="1" align="center" cellspacing="0">
          <tbody>
            <tr>
              <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
                  <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO ATENCIÓN</td>
                  <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">PERSONA ATENDIDA</td>
                  <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
                  <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
                  <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
                  <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONSULTA/VISITA</td>
                  <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TIPO ATENCIÖN</td>
                  <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">MÉDICO OPERATIVO</td>
                  <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CARGO ORGANIZACIONAL</td>
                  <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>
             </tr>
                <?php
        $numero=1; 
        $sql =" SELECT atencion_psafci.idatencion_psafci, atencion_psafci.codigo, nombre.nombre, nombre.paterno, nombre.materno, ";
        $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, tipo_consulta.tipo_consulta,  ";
        $sql.=" tipo_atencion.tipo_atencion,atencion_psafci.fecha_registro, atencion_psafci.hora_registro, atencion_psafci.idusuario  ";
        $sql.=" FROM atencion_psafci, nombre, tipo_consulta, tipo_atencion, departamento, municipios, establecimiento_salud WHERE atencion_psafci.idnombre=nombre.idnombre ";
        $sql.=" AND atencion_psafci.idtipo_consulta=tipo_consulta.idtipo_consulta AND atencion_psafci.iddepartamento=departamento.iddepartamento  ";
        $sql.=" AND atencion_psafci.idmunicipio=municipios.idmunicipio AND atencion_psafci.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
        $sql.=" AND atencion_psafci.idtipo_atencion=tipo_atencion.idtipo_atencion AND atencion_psafci.idtipo_atencion != '1' AND atencion_psafci.idtipo_atencion != '2' AND atencion_psafci.idtipo_atencion != '5' ";
        $sql.=" AND atencion_psafci.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra ORDER BY atencion_psafci.idatencion_psafci DESC LIMIT 2000 ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);           
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <tr>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
                  <td style="font-size: 12px; font-family: Arial; text-align: center;">
                  <a href="imprime_atencion_psafci.php?idatencion_psafci=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=200, scrollbars=YES'); return false;">
                  <?php echo $row[1];?></a>  
                  <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[2]." ".$row[3]." ".$row[4]);?></td>
                  </td>
                  <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[5];?></td>
                  <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?></td>
                  <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[7];?></td>
                  <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[8];?></td>
                  <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[9];?></td>
                  <td style="font-size: 12px; font-family: Arial;">
                  <?php 
                    $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                    $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[12]' ";
                    $result_r = mysqli_query($link,$sql_r);
                    $row_r = mysqli_fetch_array($result_r);                    
                    echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
                  </td>
                  <td style="font-size: 12px; font-family: Arial;">
                  <?php 
                    $sql_c =" SELECT dato_laboral.idcargo_organigrama, cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama  ";
                    $sql_c.=" WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama ";
                    $sql_c.=" AND usuarios.idusuario='$row[12]' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1 ";
                    $result_c = mysqli_query($link,$sql_c);
                    $row_c = mysqli_fetch_array($result_c);                    
                    echo $row_c[1];?>
                </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                  <?php 
                    $fecha_r = explode('-',$row[10]);
                    $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                    <?php echo $f_registro;?> - <?php echo $row[11];?></td>
              </tr>
                <?php
            $numero=$numero+1;
            }
            while ($row = mysqli_fetch_array($result));
            } else { }
            ?>
            </tbody>
        </table>
</div>

<script>
    const dbDeptos = [<?php echo implode(',', $arr_deptos); ?>];
    const dbMunis = [<?php echo implode(',', $arr_munis); ?>];
    const dbEess = [<?php echo implode(',', $arr_eess); ?>];

    const initDepto = "<?php echo $iddepartamento; ?>";
    const initMuni = "<?php echo $idmunicipio; ?>";
    const initEess = "<?php echo $idestablecimiento; ?>";

    function exportarMatrizExcel(tablaID) {
        const tabla = document.getElementById(tablaID);
        if (!tabla) return alert("No se encontró la tabla para exportar.");
        
        const uri = 'data:application/vnd.ms-excel;base64,';
        const template = `
            <html xmlns:o="urn:schemas-microsoft-com:office:office" 
                  xmlns:x="urn:schemas-microsoft-com:office:excel" 
                  xmlns="http://www.w3.org/TR/REC-html40">
            <head><meta charset="UTF-8">
            <style>
                table { border-collapse: collapse; font-family: Arial, sans-serif; }
                table, td, th { border: 1px solid #4a4a4a; }
                th { background-color: #2D56CF; color: white; font-weight: bold; font-size: 11px; padding: 5px; }
                td { padding: 5px; font-size: 11px; }
                .td-izq { text-align: left; background-color: #f8f9fa; font-weight: bold; }
                .td-tot { background-color: #eaecf4; font-weight: bold; color: #2D56CF; }
            </style></head>
            <body><table>${tabla.innerHTML}</table></body></html>`;

        const base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))); };
        const enlace = document.createElement("a");
        enlace.href = uri + base64(template);
        const fechaStr = new Date().toISOString().split('T')[0];
        enlace.download = "Matriz_Estrategica_Telesalud_" + fechaStr + ".xls";
        document.body.appendChild(enlace);
        enlace.click();
        document.body.removeChild(enlace);
    }

    document.addEventListener('DOMContentLoaded', () => {
        
        // 1. CORRECCIÓN BOTÓN MOSTRAR MATRIZ (VANILLA JS - LIBRE DE ERRORES)
        const btnMostrarMatriz = document.getElementById('btn-mostrar-matriz');
        const contMatriz = document.getElementById('contenedor-matriz');
        const contPacientes = document.getElementById('contenedor-pacientes');

        if(btnMostrarMatriz) {
            btnMostrarMatriz.addEventListener('click', function() {
                if (contMatriz.style.display === 'none') {
                    contMatriz.style.display = 'block';
                    contPacientes.style.display = 'none';
                    this.innerText = 'VER LISTA DE PACIENTES';
                    this.style.backgroundColor = '#e74a3b';
                    this.style.boxShadow = '0 4px 6px rgba(231, 74, 59, 0.2)';
                } else {
                    contMatriz.style.display = 'none';
                    contPacientes.style.display = 'block';
                    this.innerText = 'VER PRODUCCIÓN DIARIA';
                    this.style.backgroundColor = '#2D56CF';
                    this.style.boxShadow = '0 4px 6px rgba(45, 86, 207, 0.2)';
                }
            });
        }

        // 2. CORRECCIÓN DE CASCADA DE FILTROS 
        const inpDepto = document.getElementById('inp-depto');
        const inpMuni = document.getElementById('inp-muni');
        const inpEst = document.getElementById('inp-est');
        const inpMed = document.getElementById('inp-med');
        
        const valDepto = document.getElementById('val-iddepartamento');
        const valMuni = document.getElementById('val-idmunicipio');
        const valEst = document.getElementById('val-idestablecimiento');
        const valMed = document.getElementById('val-idusuario_medico');

        const dlDeptos = document.getElementById('dl-deptos');
        const dlMunis = document.getElementById('dl-munis');
        const dlEess = document.getElementById('dl-ests');

        function poblarLista(datalist, arrayData) {
            let html = '';
            arrayData.forEach(item => {
                html += `<option data-id="${item.id}" value="${item.nombre}"></option>`;
            });
            datalist.innerHTML = html;
        }

        function initListas() {
            poblarLista(dlDeptos, dbDeptos);
            
            if(initDepto) {
                const dObj = dbDeptos.find(d => d.id == initDepto);
                if(dObj) inpDepto.value = dObj.nombre;
                poblarLista(dlMunis, dbMunis.filter(m => m.idDepto == initDepto));
            } else {
                poblarLista(dlMunis, dbMunis);
            }

            if(initMuni) {
                const mObj = dbMunis.find(m => m.id == initMuni);
                if(mObj) inpMuni.value = mObj.nombre;
                poblarLista(dlEess, dbEess.filter(e => e.idMuni == initMuni));
            } else {
                poblarLista(dlEess, dbEess);
            }
            
            if(initEess) {
                const eObj = dbEess.find(e => e.id == initEess);
                if(eObj) inpEst.value = eObj.nombre;
            }
        }

        initListas();

        // AL SELECCIONAR DEPARTAMENTO
        inpDepto.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            const obj = dbDeptos.find(d => d.nombre.toLowerCase() === val);
            
            if (obj) {
                valDepto.value = obj.id;
                poblarLista(dlMunis, dbMunis.filter(m => m.idDepto == obj.id));
                
                inpMuni.value = ""; valMuni.value = "";
                inpEst.value = ""; valEst.value = "";
                poblarLista(dlEess, []); // Vacia EESS temporalmente
            } else {
                valDepto.value = "";
                poblarLista(dlMunis, dbMunis);
                poblarLista(dlEess, dbEess);
            }
        });

        // AL SELECCIONAR MUNICIPIO (Autocompleta Depto)
        inpMuni.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            const mObj = dbMunis.find(m => m.nombre.toLowerCase() === val);
            
            if (mObj) {
                valMuni.value = mObj.id;
                
                const dObj = dbDeptos.find(d => d.id == mObj.idDepto);
                if(dObj) {
                    inpDepto.value = dObj.nombre;
                    valDepto.value = dObj.id;
                }

                poblarLista(dlEess, dbEess.filter(e => e.idMuni == mObj.id));
                inpEst.value = ""; valEst.value = "";
            } else {
                valMuni.value = "";
            }
        });

        // AL SELECCIONAR EESS (Autocompleta Municipio y Depto)
        inpEst.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            const eObj = dbEess.find(e => e.nombre.toLowerCase() === val);
            
            if (eObj) {
                valEst.value = eObj.id;
                
                const mObj = dbMunis.find(m => m.id == eObj.idMuni);
                if(mObj) {
                    inpMuni.value = mObj.nombre;
                    valMuni.value = mObj.id;
                    
                    const dObj = dbDeptos.find(d => d.id == mObj.idDepto);
                    if(dObj) {
                        inpDepto.value = dObj.nombre;
                        valDepto.value = dObj.id;
                    }
                }
            } else {
                valEst.value = "";
            }
        });

        // MEDICO
        inpMed.addEventListener('input', function() {
            const option = document.querySelector(`#dl-meds option[value="${this.value}"]`);
            if(option) valMed.value = option.getAttribute('data-id');
            else valMed.value = "";
        });
    });
</script>

  </body>
</html>