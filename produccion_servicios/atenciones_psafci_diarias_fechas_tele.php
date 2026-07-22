<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram  = date("Ymd");
$fecha      = date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

// =========================================================================
// 1. CAPTURA DE FECHAS SEGURA (ANTI-INYECCIÓN)
// =========================================================================
$inicio_raw = isset($_GET['inicio']) && !empty($_GET['inicio']) ? $_GET['inicio'] : date("Y-m-01");
$fin_raw    = isset($_GET['finalizacion']) && !empty($_GET['finalizacion']) ? $_GET['finalizacion'] : date("Y-m-d");

$inicio       = mysqli_real_escape_string($link, $inicio_raw);
$finalizacion = mysqli_real_escape_string($link, $fin_raw);

$fecha_i = explode('-',$inicio);
$f_inicio = isset($fecha_i[2]) ? $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0] : $inicio;

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = isset($fecha_f[2]) ? $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0] : $finalizacion;

// =========================================================================
// 2. MOTOR DE FILTROS DINÁMICOS
// =========================================================================
$iddepartamento    = isset($_GET['iddepartamento']) ? mysqli_real_escape_string($link, $_GET['iddepartamento']) : '';
$idmunicipio       = isset($_GET['idmunicipio']) ? mysqli_real_escape_string($link, $_GET['idmunicipio']) : '';
$idestablecimiento = isset($_GET['idestablecimiento']) ? mysqli_real_escape_string($link, $_GET['idestablecimiento']) : '';
$idusuario_medico  = isset($_GET['idusuario_medico']) ? mysqli_real_escape_string($link, $_GET['idusuario_medico']) : ''; 

$filtro_extra = "";
if($iddepartamento != '') { $filtro_extra .= " AND atencion_psafci.iddepartamento = '$iddepartamento' "; }
if($idmunicipio != '') { $filtro_extra .= " AND atencion_psafci.idmunicipio = '$idmunicipio' "; }
if($idestablecimiento != '') { $filtro_extra .= " AND atencion_psafci.idestablecimiento_salud = '$idestablecimiento' "; }
if($idusuario_medico != '') { $filtro_extra .= " AND atencion_psafci.idusuario = '$idusuario_medico' "; }

// Filtro para Contrarreferencias del Especialista (Fase 2 de la matriz)
$filtro_extra_cref = "";
if($iddepartamento != '') { $filtro_extra_cref .= " AND departamento.iddepartamento = '$iddepartamento' "; }
if($idmunicipio != '') { $filtro_extra_cref .= " AND municipios.idmunicipio = '$idmunicipio' "; }
if($idestablecimiento != '') { $filtro_extra_cref .= " AND establecimiento_salud.idestablecimiento_salud = '$idestablecimiento' "; }
if($idusuario_medico != '') { $filtro_extra_cref .= " AND der.idusuario_o = '$idusuario_medico' "; }

// =========================================================================
// 3. PUENTE DE DATOS EN MEMORIA (DICCIONARIOS)
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

        /* ESTÉTICA ORIGINAL (AZUL) RESTAURADA PARA EL CÓDIGO A */
        .tabla-matriz { width: 100%; border-collapse: collapse; font-family: Arial; font-size: 11px; background-color: #fff; }
        .tabla-matriz th { background-color: #2D56CF; color: white; padding: 8px 4px; border: 1px solid #b7b9cc; text-align: center; font-size: 11px; }
        .tabla-matriz td { padding: 6px 4px; border: 1px solid #d1d3e2; text-align: center; color: #333; }
        .tabla-matriz .td-izq { text-align: left; font-weight: bold; color: #4a4a4a; background-color: #f8f9fa;}
        .tabla-matriz .td-tot { font-weight: bold; background-color: #eaecf4; color: #2D56CF; }
        .tabla-matriz tr:hover td { background-color: #eaecf4; }

        /* CELDAS INTERACTIVAS */
        .celda-interactiva { cursor: crosshair; color: #0d6efd; font-weight: bold; background-color: #f1f8ff; transition: background-color 0.2s ease; }
        .celda-interactiva:hover { background-color: #dbeafe; }

        /* TOOLTIP GLOBAL FLOTANTE (ESTO SOLUCIONA EL CORTE DE LA TABLA) */
        #global-tooltip-hc {
            position: absolute; visibility: hidden; opacity: 0;
            background-color: rgba(255, 255, 255, 0.98);
            border: 1px solid #7cb5ec; border-radius: 5px;
            padding: 10px 15px; box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
            z-index: 999999; white-space: nowrap; text-align: left;
            font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, sans-serif; 
            font-size: 12px; color: #333; pointer-events: none; transition: opacity 0.15s ease-in-out;
        }
        #global-tooltip-hc::after {
            content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
            border-width: 6px; border-style: solid; border-color: #7cb5ec transparent transparent transparent;
        }
        #global-tooltip-hc span.f-hc { font-size: 11px; color: #666; display: block; margin-bottom: 6px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 4px;}
        #global-tooltip-hc div { margin-bottom: 4px; font-weight: normal; }
    </style>

    <?php
    // =========================================================================
    // 4. OPTIMIZACIÓN SENIOR DEL GRÁFICO (1 Sola Consulta Rápida)
    // =========================================================================
    $sql_chart = "
        SELECT a.fecha_registro,
               SUM(CASE WHEN a.idtipo_atencion = '3' THEN 1 ELSE 0 END) as teleconsultas,
               SUM(CASE WHEN a.idtipo_atencion = '4' THEN IFNULL(d.cant_dispositivos, 0) ELSE 0 END) as telemetrias
        FROM atencion_psafci a
        LEFT JOIN (
            SELECT et.idatencion_psafci, COUNT(DISTINCT et.idexamen_complementario) as cant_dispositivos
            FROM examen_teleconsulta et
            INNER JOIN examen_complementario ec ON et.idexamen_complementario = ec.idexamen_complementario
            WHERE UPPER(ec.examen_complementario) NOT LIKE '%MONITOR DE SIGNOS VITALES%'
            AND UPPER(ec.examen_complementario) NOT LIKE '%ESTETOSCOPIO DIGITAL%'
            AND UPPER(ec.examen_complementario) NOT LIKE '%OTRO%'
            GROUP BY et.idatencion_psafci
        ) d ON a.idatencion_psafci = d.idatencion_psafci
        WHERE a.fecha_registro BETWEEN '$inicio' AND '$finalizacion' 
        $filtro_extra
        GROUP BY a.fecha_registro
        ORDER BY a.fecha_registro ASC
    ";
    
    $res_chart = mysqli_query($link, $sql_chart);

    $cat_arr = array();
    $tc_arr = array();
    $tm_arr = array();

    if ($res_chart && mysqli_num_rows($res_chart) > 0) {
        while ($row_c = mysqli_fetch_assoc($res_chart)) {
            $fecha_s = explode('-', $row_c['fecha_registro']);
            $fecha_log = isset($fecha_s[2]) ? $fecha_s[2].'/'.$fecha_s[1].'/'.$fecha_s[0] : $row_c['fecha_registro'];

            $cat_arr[] = "'" . $fecha_log . "'";
            $tc_arr[] = (int)$row_c['teleconsultas'];
            $tm_arr[] = (int)$row_c['telemetrias'];
        }
    } else {
        $cat_arr[] = "'Sin registros'";
        $tc_arr[] = 0;
        $tm_arr[] = 0;
    }
    ?>

    <script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: { type: 'areaspline' },
        title: { text: 'ATENCIONES POR DIA - PROGRAMA TELESALUD' },
        subtitle: { text: 'Fuente: Sistema Integrado MEDI-SAFCI del <?php echo $f_inicio;?> al <?php echo $f_finalizacion;?>' },
        legend: { layout: 'vertical', align: 'left', verticalAlign: 'top', x: 150, y: 100, floating: true, borderWidth: 1, backgroundColor: '#FFFFFF' },
        xAxis: {
            categories: [ <?php echo implode(',', $cat_arr); ?> ],
            plotBands: [{ from: 4.5, to: 6.5, color: 'rgba(68, 170, 213, .2)' }]
        },
        yAxis: { title: { text: 'ATENCIONES TELESALUD DIARIAS' } },
        tooltip: { shared: true, valueSuffix: ' Atenciones' },
        credits: { enabled: false },
        plotOptions: { areaspline: { fillOpacity: 0.5 } },
        series: [{
            name: 'TELECONSULTA',
            data: [ <?php echo implode(',', $tc_arr); ?> ]
        },
        {
            name: 'TELEMETRÍA',
            data: [ <?php echo implode(',', $tm_arr); ?> ]
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
        <input type="hidden" name="inicio" id="val-inicio" value="<?php echo htmlspecialchars($inicio);?>">
        <input type="hidden" name="finalizacion" id="val-finalizacion" value="<?php echo htmlspecialchars($finalizacion);?>">
        
        <input type="hidden" name="iddepartamento" id="val-iddepartamento" value="<?php echo htmlspecialchars($iddepartamento);?>">
        <input type="hidden" name="idmunicipio" id="val-idmunicipio" value="<?php echo htmlspecialchars($idmunicipio);?>">
        <input type="hidden" name="idestablecimiento" id="val-idestablecimiento" value="<?php echo htmlspecialchars($idestablecimiento);?>">
        <input type="hidden" name="idusuario_medico" id="val-idusuario_medico" value="<?php echo htmlspecialchars($idusuario_medico);?>">
        
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
                <input list="dl-meds" id="inp-med" value="<?php echo htmlspecialchars($nombre_med_sel); ?>" placeholder="Escriba para buscar..." autocomplete="off">
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
    <input type="hidden" name="inicio" value="<?php echo htmlspecialchars($inicio);?>">
    <input type="hidden" name="finalizacion" value="<?php echo htmlspecialchars($finalizacion);?>">
    <input type="hidden" name="iddepartamento" value="<?php echo htmlspecialchars($iddepartamento);?>">
    <input type="hidden" name="idmunicipio" value="<?php echo htmlspecialchars($idmunicipio);?>">
    <input type="hidden" name="idestablecimiento" value="<?php echo htmlspecialchars($idestablecimiento);?>">
    <input type="hidden" name="idusuario_medico" value="<?php echo htmlspecialchars($idusuario_medico);?>">
    <button type="submit" class="btn-excel">DESCARGAR EN EXCEL</button>
  </form>
</div>

<div id="contenedor-matriz" style="display: none; padding-bottom: 50px;">
    <h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">MATRIZ DE PRODUCCIÓN GLOBAL (ATENCIONES + REFERENCIAS)</h4>
    <div style="overflow-x: auto; width: 95%; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding-top: 20px;">
        <table class="tabla-matriz" id="tabla-matriz-estrategica">
            <thead>
                <tr>
                    <th>DEPARTAMENTO</th>
                    <th>MUNICIPIO</th>
                    <th>ESTABLECIMIENTO</th>
                    <th>MÉDICO OPERATIVO</th> 
                    <?php
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
            // ==============================================================================================
            // EXTRACCIÓN DE DATOS: QUERY 1 (ATENCIONES Y TELEMETRÍAS - INTACTO)
            // ==============================================================================================
            $sql_matriz = "
                SELECT 
                    departamento.departamento, 
                    municipios.municipio, 
                    establecimiento_salud.establecimiento_salud, 
                    CONCAT(IFNULL(nombre.nombre,''), ' ', IFNULL(nombre.paterno,''), ' ', IFNULL(nombre.materno,'')) as medico,
                    atencion_psafci.fecha_registro, 
                    SUM(CASE WHEN atencion_psafci.idtipo_atencion = '3' THEN 1 ELSE 0 END) as teleconsulta,
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
            ";
            $res_matriz = mysqli_query($link, $sql_matriz);
            $data_agrupada = array();
            
            if($res_matriz) {
                while($rm = mysqli_fetch_assoc($res_matriz)) {
                    $dep = trim($rm['departamento']); 
                    $mun = trim($rm['municipio']); 
                    $est = trim($rm['establecimiento_salud']);
                    $med = mb_strtoupper(trim($rm['medico'])); 
                    if(empty($med)) { $med = "SIN MÉDICO REGISTRADO"; }
                    $fec = $rm['fecha_registro'];
                    
                    if(!isset($data_agrupada[$dep][$mun][$est][$med])) { $data_agrupada[$dep][$mun][$est][$med] = array(); }
                    if(!isset($data_agrupada[$dep][$mun][$est][$med][$fec])) {
                        $data_agrupada[$dep][$mun][$est][$med][$fec] = array('tc' => 0, 'ta' => 0, 'ref' => 0, 'cref' => 0);
                    }
                    $data_agrupada[$dep][$mun][$est][$med][$fec]['tc'] += (int)$rm['teleconsulta'];
                    $data_agrupada[$dep][$mun][$est][$med][$fec]['ta'] += (int)$rm['tecnoasistida'];
                }
            }

            // ==============================================================================================
            // EXTRACCIÓN DE DATOS: QUERY 2 DIVIDIDO EN FASE 1 Y FASE 2 (MOTOR DE AGREGACIÓN POR MÉDICO)
            // ==============================================================================================
            $filtro_extra_ref = str_replace("atencion_psafci.", "referencia_hc.", $filtro_extra);
            
            // FASE 1: REFERENCIAS GENERADAS POR EL MÉDICO ORIGEN (IDA)
            $sql_matriz_ref = "
                SELECT 
                    departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, 
                    CONCAT(IFNULL(nombre.nombre,''), ' ', IFNULL(nombre.paterno,''), ' ', IFNULL(nombre.materno,'')) as medico,
                    referencia_hc.fecha_registro, 
                    COUNT(referencia_hc.idreferencia_hc) as referidas
                FROM referencia_hc
                INNER JOIN departamento ON referencia_hc.iddepartamento = departamento.iddepartamento
                INNER JOIN municipios ON referencia_hc.idmunicipio = municipios.idmunicipio
                INNER JOIN establecimiento_salud ON referencia_hc.idestablecimiento_salud = establecimiento_salud.idestablecimiento_salud
                LEFT JOIN usuarios ON referencia_hc.idusuario = usuarios.idusuario
                LEFT JOIN nombre ON usuarios.idnombre = nombre.idnombre
                WHERE referencia_hc.fecha_registro BETWEEN '$inicio' AND '$finalizacion'
                $filtro_extra_ref
                GROUP BY departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, medico, referencia_hc.fecha_registro
            ";
            $res_matriz_ref = mysqli_query($link, $sql_matriz_ref);
            
            if($res_matriz_ref) {
                while($rm = mysqli_fetch_assoc($res_matriz_ref)) {
                    $dep = trim($rm['departamento']); 
                    $mun = trim($rm['municipio']); 
                    $est = trim($rm['establecimiento_salud']);
                    $med = mb_strtoupper(trim($rm['medico'])); 
                    if(empty($med)) { $med = "SIN MÉDICO REGISTRADO"; }
                    $fec = $rm['fecha_registro'];

                    if(!isset($data_agrupada[$dep][$mun][$est][$med])) { $data_agrupada[$dep][$mun][$est][$med] = array(); }
                    if(!isset($data_agrupada[$dep][$mun][$est][$med][$fec])) {
                        $data_agrupada[$dep][$mun][$est][$med][$fec] = array('tc' => 0, 'ta' => 0, 'ref' => 0, 'cref' => 0);
                    }
                    $data_agrupada[$dep][$mun][$est][$med][$fec]['ref'] += (int)$rm['referidas'];
                }
            }

            // FASE 2: CONTRARREFERENCIAS GENERADAS POR EL ESPECIALISTA (VUELTA)
            $sql_matriz_cref = "
                SELECT 
                    departamento.departamento, 
                    municipios.municipio, 
                    establecimiento_salud.establecimiento_salud, 
                    CONCAT(IFNULL(nombre.nombre,''), ' ', IFNULL(nombre.paterno,''), ' ', IFNULL(nombre.materno,'')) as medico,
                    CASE WHEN der.fecha_deriva IS NOT NULL AND der.fecha_deriva != '' AND der.fecha_deriva != '0000-00-00' THEN der.fecha_deriva ELSE referencia_hc.fecha_registro END as fecha_registro,
                    COUNT(referencia_hc.idreferencia_hc) as contrarreferidas
                FROM referencia_hc
                INNER JOIN (
                    SELECT idreferencia_hc, MAX(idderiva_referencia_hc) as max_id
                    FROM deriva_referencia_hc
                    GROUP BY idreferencia_hc
                ) as ult_der ON referencia_hc.idreferencia_hc = ult_der.idreferencia_hc
                INNER JOIN deriva_referencia_hc der ON ult_der.max_id = der.idderiva_referencia_hc
                INNER JOIN establecimiento_salud ON der.idestablecimiento_salud_o = establecimiento_salud.idestablecimiento_salud
                INNER JOIN departamento ON establecimiento_salud.iddepartamento = departamento.iddepartamento
                INNER JOIN municipios ON establecimiento_salud.idmunicipio = municipios.idmunicipio
                LEFT JOIN usuarios ON der.idusuario_o = usuarios.idusuario
                LEFT JOIN nombre ON usuarios.idnombre = nombre.idnombre
                WHERE referencia_hc.idestado_referencia = '2'
                AND (CASE WHEN der.fecha_deriva IS NOT NULL AND der.fecha_deriva != '' AND der.fecha_deriva != '0000-00-00' THEN der.fecha_deriva ELSE referencia_hc.fecha_registro END) BETWEEN '$inicio' AND '$finalizacion'
                $filtro_extra_cref
                GROUP BY departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, medico, fecha_registro
            ";
            $res_matriz_cref = mysqli_query($link, $sql_matriz_cref);

            if($res_matriz_cref) {
                while($rm = mysqli_fetch_assoc($res_matriz_cref)) {
                    $dep = trim($rm['departamento']); 
                    $mun = trim($rm['municipio']); 
                    $est = trim($rm['establecimiento_salud']);
                    $med = mb_strtoupper(trim($rm['medico'])); 
                    if(empty($med)) { $med = "SIN MÉDICO REGISTRADO"; }
                    $fec = $rm['fecha_registro'];

                    if(!isset($data_agrupada[$dep][$mun][$est][$med])) { $data_agrupada[$dep][$mun][$est][$med] = array(); }
                    if(!isset($data_agrupada[$dep][$mun][$est][$med][$fec])) {
                        $data_agrupada[$dep][$mun][$est][$med][$fec] = array('tc' => 0, 'ta' => 0, 'ref' => 0, 'cref' => 0);
                    }
                    $data_agrupada[$dep][$mun][$est][$med][$fec]['cref'] += (int)$rm['contrarreferidas'];
                }
            }

            // ==============================================================================================
            // IMPRESIÓN DE LA MATRIZ DINÁMICA
            // ==============================================================================================
            $gran_total = 0;
            $totales_por_dia = array();

            if(count($data_agrupada) > 0) {
                ksort($data_agrupada);
                foreach($data_agrupada as $dep => $muns) {
                    ksort($muns);
                    foreach($muns as $mun => $ests) {
                        ksort($ests);
                        foreach($ests as $est => $medicos) {
                            ksort($medicos);
                            foreach($medicos as $med => $fechas) { 
                                
                                // Validación de Seguridad: Ignorar médicos con TODO en 0 absoluto
                                $suma_fila_check = 0;
                                foreach($dias_matriz as $d) {
                                    if(isset($fechas[$d])) {
                                        $suma_fila_check += $fechas[$d]['tc'] + $fechas[$d]['ta'] + $fechas[$d]['ref'] + $fechas[$d]['cref'];
                                    }
                                }
                                if ($suma_fila_check == 0) continue; 

                                echo "<tr>";
                                echo "<td class='td-izq'>$dep</td>";
                                echo "<td class='td-izq'>$mun</td>";
                                echo "<td class='td-izq'>$est</td>";
                                echo "<td class='td-izq'>$med</td>"; 
                                
                                $suma_fila = 0;
                                foreach($dias_matriz as $d) {
                                    if(isset($fechas[$d])) {
                                        $tc   = $fechas[$d]['tc'];
                                        $ta   = $fechas[$d]['ta'];
                                        $ref  = $fechas[$d]['ref'];
                                        $cref = $fechas[$d]['cref'];
                                        
                                        $val = $tc + $ta + $ref + $cref;

                                        if ($val > 0) {
                                            $suma_fila += $val;
                                            $gran_total += $val;
                                            if(!isset($totales_por_dia[$d])) $totales_por_dia[$d] = 0;
                                            $totales_por_dia[$d] += $val;
                                            
                                            $fecha_form = date('d/m/Y', strtotime($d));
                                            
                                            // Asignamos datos vía atributos HTML para que el Tooltip JS y el Excel los lean.
                                            echo "<td class='celda-interactiva' data-fecha='$fecha_form' data-tc='$tc' data-ta='$ta' data-ref='$ref' data-cref='$cref' data-val='$val'>$val</td>";
                                        } else {
                                            echo "<td>-</td>"; 
                                        }
                                    } else {
                                        echo "<td>-</td>";
                                    }
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
                    if($row_r = mysqli_fetch_array($result_r)) { echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]); } ?>
                  </td>
                  <td style="font-size: 12px; font-family: Arial;">
                  <?php 
                    $sql_c =" SELECT dato_laboral.idcargo_organigrama, cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama  ";
                    $sql_c.=" WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama ";
                    $sql_c.=" AND usuarios.idusuario='$row[12]' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1 ";
                    $result_c = mysqli_query($link,$sql_c);
                    if($row_c = mysqli_fetch_array($result_c)) { echo $row_c[1]; } ?>
                </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                  <?php 
                    $fecha_r_loop = explode('-',$row[10]);
                    $f_registro = isset($fecha_r_loop[2]) ? $fecha_r_loop[2].'/'.$fecha_r_loop[1].'/'.$fecha_r_loop[0] : $row[10];?>
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

    // =========================================================================
    // EXPORTACIÓN A EXCEL: Limpio, Total Abajo y sin código basura.
    // =========================================================================
    function exportarMatrizExcel(tablaID) {
        const tablaOriginal = document.getElementById(tablaID);
        if (!tablaOriginal) return alert("No se encontró la tabla para exportar.");
        
        const tablaClonada = tablaOriginal.cloneNode(true);
        const celdas = tablaClonada.querySelectorAll('.celda-interactiva');
        
        celdas.forEach(celda => {
            const tc = parseInt(celda.getAttribute('data-tc')) || 0;
            const ta = parseInt(celda.getAttribute('data-ta')) || 0;
            const ref = parseInt(celda.getAttribute('data-ref')) || 0;
            const cref = parseInt(celda.getAttribute('data-cref')) || 0;
            const val = parseInt(celda.getAttribute('data-val')) || 0;
            
            let desglose = "";
            desglose += "Teleconsultas: " + tc + "<br>";
            desglose += "Telemetrías: " + ta + "<br>";
            desglose += "Referencias: " + ref + "<br>";
            desglose += "Contrarreferencias: " + cref + "<br>";
            
            celda.innerHTML = desglose + "<strong>Total: " + val + "</strong>";
        });
        
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
            <body><table>${tablaClonada.innerHTML}</table></body></html>`;

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
        
        // =========================================================================
        // LÓGICA DEL TOOLTIP GLOBAL (EVITA QUE SE CORTE POR LA GUILLOTINA DE LA TABLA)
        // =========================================================================
        const tooltip = document.createElement('div');
        tooltip.id = 'global-tooltip-hc';
        document.body.appendChild(tooltip);

        document.querySelectorAll('.celda-interactiva').forEach(celda => {
            celda.addEventListener('mouseenter', function() {
                const rect = this.getBoundingClientRect();
                const tc = this.getAttribute('data-tc') || 0;
                const ta = this.getAttribute('data-ta') || 0;
                const ref = this.getAttribute('data-ref') || 0;
                const cref = this.getAttribute('data-cref') || 0;
                const fecha = this.getAttribute('data-fecha') || '';
                
                tooltip.innerHTML = `
                    <span class='f-hc'>${fecha}</span>
                    <div><span style='color: #7cb5ec; font-size: 16px; margin-right: 5px;'>●</span> N° Teleconsultas: <b>${tc}</b></div>
                    <div><span style='color: #90ed7d; font-size: 16px; margin-right: 5px;'>●</span> N° Telemetrías: <b>${ta}</b></div>
                    <div><span style='color: #f7a35c; font-size: 16px; margin-right: 5px;'>●</span> N° Referencias: <b>${ref}</b></div>
                    <div><span style='color: #434348; font-size: 16px; margin-right: 5px;'>●</span> N° Contrarreferencias: <b>${cref}</b></div>
                `;
                
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
                
                const tooltipRect = tooltip.getBoundingClientRect();
                const topPos = rect.top + window.scrollY - tooltipRect.height - 10;
                const leftPos = rect.left + window.scrollX + (rect.width / 2) - (tooltipRect.width / 2);
                
                tooltip.style.top = topPos + 'px';
                tooltip.style.left = leftPos + 'px';
            });
            
            celda.addEventListener('mouseleave', function() {
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = '0';
            });
        });

        // BOTONES DE VISTA
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

        // MOTOR JS DE FILTROS EN CASCADA
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

        inpDepto.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            const obj = dbDeptos.find(d => d.nombre.toLowerCase() === val);
            if (obj) {
                valDepto.value = obj.id;
                poblarLista(dlMunis, dbMunis.filter(m => m.idDepto == obj.id));
                inpMuni.value = ""; valMuni.value = "";
                inpEst.value = ""; valEst.value = "";
                poblarLista(dlEess, []); 
            } else {
                valDepto.value = "";
                poblarLista(dlMunis, dbMunis);
                poblarLista(dlEess, dbEess);
            }
        });

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

        inpMed.addEventListener('input', function() {
            const option = document.querySelector(`#dl-meds option[value="${this.value}"]`);
            if(option) valMed.value = option.getAttribute('data-id');
            else valMed.value = "";
        });
    });
</script>
  </body>
</html>