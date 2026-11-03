<?php
include("../cabf.php");
include("../inc.config.php");
define('TM_SOLO_ALCANCE', true);
include("../telesalud/inc_telemedicina.php");   // alcance del usuario (tm_alcance)
include("inc_teleeducacion.php");

// =========================================================================
// FICHA IMPRIMIBLE DE UNA SESIÓN DE TELEEDUCACIÓN (mismo modelo que imprime_atencion_psafci.php)
//   La ve quien la registró y quien tiene alcance sobre ella en Telemedicina
//   (nacional y departamental: todo el país; municipal: su municipio)
// =========================================================================
date_default_timezone_set('America/La_Paz');
$idusuario_ss = $_SESSION['idusuario_ss'];

$id = isset($_REQUEST['idteleeducacion']) ? (int)$_REQUEST['idteleeducacion'] : 0;
$t  = $id > 0 ? te_leer($link, $id) : null;

$permitido = false;
if ($t) {
    $alc = tm_alcance($link);
    $permitido = (string)$t['idusuario'] === (string)$idusuario_ss
        || in_array($alc['nivel'], ['nacional', 'departamental'], true)
        || ($alc['nivel'] === 'municipal' && (string)$alc['fijos']['idmunicipio'] === (string)$t['idmunicipio']);
}
if (!$t || !$permitido) {
    http_response_code(404);
    echo '<!doctype html><html><head><meta charset="UTF-8"><title>TELEEDUCACIÓN</title></head><body style="font-family: Arial; text-align: center; padding: 60px;">'
        . '<p style="font-size: 16px;">SESIÓN NO DISPONIBLE</p><p style="font-size: 12px;">La sesión no existe o no tiene permiso para verla.</p></body></html>';
    exit;
}

$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };
$f_corta = function ($f) { $x = strtotime((string)$f); return $x ? date('d/m/Y', $x) : ''; };

// Catálogos desde la base de datos
$cat  = te_catalogos($link);
$idt  = (int)$t['idtipo_teleeducacion'];
$tipo = isset($cat['tipos'][$idt]) ? $cat['tipos'][$idt]
    : ['nombre' => 'TELEEDUCACIÓN', 'color_hex' => '#4e73df', 'titulo_asistentes' => 'PARTICIPANTES POR GRUPO Y GÉNERO', 'etiqueta_grupo' => 'GRUPO', 'requiere_recursos' => false];
$tipo_txt = mb_strtoupper($tipo['nombre']);
$color = preg_match('/^#[0-9a-fA-F]{6}$/', $tipo['color_hex']) ? $tipo['color_hex'] : '#4e73df';   // mismo color del formulario
$color_suave = 'rgba(' . hexdec(substr($color, 1, 2)) . ', ' . hexdec(substr($color, 3, 2)) . ', ' . hexdec(substr($color, 5, 2)) . ', .14)';
$responsable = mb_strtoupper(trim($t['nombre'] . ' ' . $t['paterno'] . ' ' . $t['materno']));

// Filas de asistentes: los grupos activos del tipo y los que tienen datos en esta sesión (encabezados agrupan)
$filas = te_filas_grupos($cat, $idt, true, array_keys($t['grupos']));
$n_generos = count($cat['generos']);
$cantidad = function ($idgrupo, $idgenero) use ($t) { return isset($t['grupos'][$idgrupo][$idgenero]) ? (int)$t['grupos'][$idgrupo][$idgenero] : 0; };
// Total por género en texto: "8 M · 12 F"
$partes_genero = [];
foreach ($cat['generos'] as $idg => $gen) { $partes_genero[] = (isset($t['por_genero'][$idg]) ? (int)$t['por_genero'][$idg] : 0) . ' ' . te_genero_corto($gen); }

// Código QR de verificación (mismo procedimiento que imprime_atencion_psafci.php)
$PNG_TEMP_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = 'temp/';
$qr = '';
if ((is_dir($PNG_TEMP_DIR) || @mkdir($PNG_TEMP_DIR)) && is_writable($PNG_TEMP_DIR)) {
    include_once "../implementacion_safci/phpqrcode.php";
    $dato_qr = 'https://virtual-safci.minsalud.gob.bo/medi-safci/promocion_safci/imprime_teleeducacion.php?idteleeducacion=' . $id;
    $archivo_qr = 'teleedu_' . md5($dato_qr) . '.png';
    if (!is_file($PNG_TEMP_DIR . $archivo_qr)) { QRcode::png($dato_qr, $PNG_TEMP_DIR . $archivo_qr, 'M', 2, 2); }
    $qr = $PNG_WEB_DIR . $archivo_qr;
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>TELEEDUCACIÓN - <?php echo $h($t['codigo']); ?></title>
<style>
  body { font-family: Arial, Helvetica, sans-serif; color: #222; }
  #formulario_teleeducacion { border-collapse: collapse; }
  #formulario_teleeducacion td { font-family: Arial; font-size: 12px; }
  /****** encabezado ****/
  .titulo-doc { text-align: center; font-size: 16px; }
  .titulo-doc .nombre { font-size: 17px; font-weight: bold; letter-spacing: .5px; margin: 6px 0 4px; }
  .titulo-doc .codigo { display: inline-block; margin: 4px 0; padding: 3px 12px; border: 1px solid #4e73df; border-radius: 12px; font-size: 13px; color: #224abe; font-weight: bold; }
  .tipo-doc { display: inline-block; margin-top: 4px; padding: 2px 12px; border-radius: 10px; font-size: 11px; font-weight: bold; color: #fff; background: <?php echo $color; ?>; }
  /****** barras de título de sección ****/
  .barra-titulo td { padding-top: 12px; }
  .seccion { background: #4e73df; color: #fff; text-align: center; font-size: 13px !important; font-weight: bold; letter-spacing: .6px; padding: 5px; border-radius: 3px; }
  /****** tablas de datos ****/
  .datos { width: 680px; border-collapse: collapse; margin: 4px auto 0; }
  .datos td, .datos th { border: 1px solid #b7c3dd; padding: 4px 6px; font-family: Arial; font-size: 12px; }
  .datos .etq { text-align: right; background: #f3f6fd; color: #3a3b45; width: 170px; }
  .datos th { background: <?php echo $color_suave; ?>; text-align: center; font-weight: bold; }
  .datos .grupo td { background: #f8f9fc; font-weight: bold; color: #224abe; }
  .datos .sub td:first-child { padding-left: 18px; }
  .datos .cero td { color: #9a9cab; }
  .datos .n { text-align: center; width: 85px; }
  .datos tfoot td { font-weight: bold; background: #f3f6fd; border-top: 2px solid #4e73df; }
  .cab-lugar td { padding: 2px 4px; }
  .recursos span { display: inline-block; margin: 2px 4px 2px 0; padding: 2px 10px; border: 1px solid #1cc88a; border-radius: 10px; font-size: 11px; }
  .firma { text-align: center; font-size: 9px; font-family: Arial; }
  .firma .linea { border-top: 1px solid #222; margin: 0 18px; padding-top: 4px; }
  .pie-doc { text-align: center; font-size: 9px; color: #858796; }
  /****** impresión por defecto en tamaño carta ****/
  @page { size: letter portrait; margin: 5mm; }
  .generando-pdf tr.no-print { display: none; }
  @media print {
    body { margin: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .no-print { display: none; }
    tr, img { break-inside: avoid; page-break-inside: avoid; }
    tr.barra-titulo { break-after: avoid; page-break-after: avoid; }
  }
</style>
</head>

<body>

<table width="680" border="0" align="center" id="formulario_teleeducacion">
  <tbody>
    <tr>
      <td width="166"><img src="../implementacion_safci/mds_logo.jpg" width="193" height="85" alt=""/></td>
      <td width="323" class="titulo-doc">
        <div class="nombre">REGISTRO DE TELEEDUCACIÓN</div>
        <div class="codigo">CÓDIGO : <?php echo $h($t['codigo']); ?></div><br>
        <span class="tipo-doc"><?php echo $h($tipo_txt); ?></span>
        <p style="font-size: 12px; margin: 6px 0 0;"><a href="#" id="btn_descargar_pdf" class="no-print" onclick="descargarPDF(); return false;">DESCARGAR EN PDF</a>
          <span class="no-print"> · </span><a href="#" class="no-print" onclick="window.print(); return false;">IMPRIMIR</a></p>
      </td>
      <td width="177" style="text-align: center"><img src="../implementacion_safci/logo_safci_doc.png" width="116" height="84" alt=""/></td>
    </tr>
    <tr>
      <td colspan="3">
        <table width="680" border="0" class="cab-lugar">
          <tbody>
            <tr>
              <td colspan="2" style="text-align: right;">FECHA DE REGISTRO:</td>
              <td colspan="2" style="font-size: 14px;"><?php echo $h($f_corta($t['fecha_registro'])); ?> - <?php echo $h($t['hora_registro']); ?>
                <?php if (!empty($t['fecha_modificacion'])) { ?><span style="font-size: 10px; color: #858796;"> (modificado el <?php echo date('d/m/Y H:i', strtotime($t['fecha_modificacion'])); ?>)</span><?php } ?></td>
            </tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr>
              <td style="text-align: right;">DEPARTAMENTO:</td>
              <td><?php echo $h(mb_strtoupper((string)$t['departamento'])); ?></td>
              <td style="text-align: right;">MUNICIPIO:</td>
              <td><?php echo $h(mb_strtoupper((string)$t['municipio'])); ?></td>
            </tr>
            <tr>
              <td style="text-align: right;">ESTABLECIMIENTO DE SALUD:</td>
              <td colspan="3"><?php echo $h(mb_strtoupper($t['establecimiento_salud'])); ?></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>

    <tr class="barra-titulo"><td colspan="3"><div class="seccion">INFORMACIÓN DE LA ACTIVIDAD</div></td></tr>
    <tr>
      <td colspan="3">
        <table class="datos">
          <tbody>
            <tr><td class="etq">NOMBRE DE LA ACTIVIDAD:</td><td colspan="3"><b><?php echo $h($t['nombre_actividad']); ?></b></td></tr>
            <tr>
              <td class="etq">TIPO DE ACTIVIDAD:</td><td><?php echo $h(te_nombre($cat['actividades'], $t['idactividad_teleeducacion'])); ?></td>
              <td class="etq">FECHA DE SESIÓN:</td><td><?php echo $h($f_corta($t['fecha_sesion'])); ?></td>
            </tr>
            <tr>
              <td class="etq">MODALIDAD:</td><td><?php echo $h(te_nombre($cat['modalidades'], $t['idmodalidad_teleeducacion'])); ?></td>
              <td class="etq">DURACIÓN:</td><td><?php echo $h(te_duracion($t['duracion_minutos'])); ?></td>
            </tr>
            <tr>
              <td class="etq">MEDIO DIGITAL:</td><td><?php echo $h(te_nombre($cat['medios'], $t['idmedio_digital'])); ?></td>
              <td class="etq">TOTAL PARTICIPANTES:</td><td><b><?php echo (int)$t['asistentes']; ?></b> (<?php echo $h(implode(' · ', $partes_genero)); ?>)</td>
            </tr>
            <?php if ($tipo['requiere_recursos'] || $t['recursos']) { ?>
            <tr>
              <td class="etq">RECURSOS USADOS:</td>
              <td colspan="3" class="recursos"><?php foreach ($t['recursos'] as $r) { ?><span><?php echo $h(te_nombre($cat['recursos'], $r)); ?></span><?php } ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </td>
    </tr>

    <tr class="barra-titulo"><td colspan="3"><div class="seccion"><?php echo $h($tipo['titulo_asistentes']); ?></div></td></tr>
    <tr>
      <td colspan="3">
        <table class="datos">
          <thead><tr><th style="text-align: left;"><?php echo $h($tipo['etiqueta_grupo']); ?></th><?php foreach ($cat['generos'] as $gen) { ?><th class="n"><?php echo $h($gen); ?></th><?php } ?><th class="n">TOTAL</th></tr></thead>
          <tbody>
          <?php foreach ($filas as $f) { $g = $f['g'];
              if ($f['nivel'] === 'encabezado') { ?><tr class="grupo"><td colspan="<?php echo 2 + $n_generos; ?>"><?php echo $h(mb_strtoupper($g['nombre'])); ?></td></tr><?php continue; }
              $suma = 0; foreach (array_keys($cat['generos']) as $idg) { $suma += $cantidad($g['id'], $idg); } ?>
            <tr class="<?php echo trim(($f['nivel'] === 'sub' ? 'sub ' : '') . ($suma === 0 ? 'cero' : '')); ?>">
              <td><?php echo $h($f['nivel'] === 'sub' ? $g['nombre'] : mb_strtoupper($g['nombre'])); ?></td>
              <?php foreach (array_keys($cat['generos']) as $idg) { ?><td class="n"><?php echo $cantidad($g['id'], $idg); ?></td><?php } ?>
              <td class="n"><b><?php echo $suma; ?></b></td>
            </tr>
          <?php } ?>
          </tbody>
          <tfoot><tr><td>TOTAL</td><?php foreach (array_keys($cat['generos']) as $idg) { ?><td class="n"><?php echo isset($t['por_genero'][$idg]) ? (int)$t['por_genero'][$idg] : 0; ?></td><?php } ?><td class="n"><?php echo (int)$t['asistentes']; ?></td></tr></tfoot>
        </table>
      </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
      <td class="firma">
        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
        <div class="linea">FIRMA Y SELLO<br>ESTABLECIMIENTO DE SALUD</div>
      </td>
      <td class="firma">
        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
        <div class="linea">FIRMA RESPONSABLE DEL REGISTRO<br><?php echo $h($responsable); ?></div>
      </td>
      <td class="firma">
        <?php if ($qr !== '') { ?><img src="<?php echo $h($qr); ?>" alt="Código QR de verificación"/><?php } ?>
        <p>Verificacion MEDI-SAFCI</p>
      </td>
    </tr>
    <tr><td colspan="3" class="pie-doc">PROGRAMA NACIONAL DE TELESALUD · MINISTERIO DE SALUD Y DEPORTES · Impreso el <?php echo date('d/m/Y H:i'); ?></td></tr>
  </tbody>
</table>

<!----- descarga en PDF: se genera a partir de esta misma página para que quede idéntica (tamaño carta) ------>
<script src="../js/modules/html2canvas.min.js"></script>
<script src="../js/modules/jspdf.umd.min.js"></script>
<script>
/****** alturas (en px de pantalla, desde el inicio del formulario) donde se puede cortar la hoja sin partir ninguna celda ****/
function cortesPermitidos(formulario) {
  var base = formulario.getBoundingClientRect().top;
  var filas = formulario.querySelectorAll('tr');
  var celdas = [], cortes = [];
  for (var i = 0; i < filas.length; i++) {
    var fila = filas[i];
    if (fila.classList.contains('no-print')) continue;
    //no se corta justo debajo de un título de sección, para que no quede solo al pie de la hoja
    if (!fila.classList.contains('barra-titulo'))
      cortes.push(fila.getBoundingClientRect().bottom - base);
    for (var j = 0; j < fila.cells.length; j++) {
      if (fila.cells[j].querySelector('table')) continue;
      var r = fila.cells[j].getBoundingClientRect();
      celdas.push([r.top - base, r.bottom - base]);
    }
  }
  return cortes.filter(function (y) {
    return !celdas.some(function (c) { return c[0] < y - 1 && c[1] > y + 1; });
  });
}

function descargarPDF() {
  var boton = document.getElementById('btn_descargar_pdf');
  var formulario = document.getElementById('formulario_teleeducacion');
  boton.textContent = 'GENERANDO PDF...';
  document.body.classList.add('generando-pdf');

  var margen = 5, anchoHoja = 215.9, altoHoja = 279.4;
  var anchoUtil = anchoHoja - 2*margen, altoUtil = altoHoja - 2*margen;
  var escala = 3;   //resolución de la captura, para que el texto se vea nítido
  var cortes = cortesPermitidos(formulario);

  html2canvas(formulario, {
    scale: escala, useCORS: true, backgroundColor: '#ffffff',
    onclone: function (doc) {
      //los enlaces de la cabecera se ocultan sin quitarles su espacio, para no mover las alturas medidas
      var botones = doc.querySelectorAll('.no-print');
      for (var j = 0; j < botones.length; j++) botones[j].style.visibility = 'hidden';
    }
  }).then(function (canvas) {
    var pdf = new jspdf.jsPDF({ unit: 'mm', format: 'letter', orientation: 'portrait' });
    var anchoPx = formulario.getBoundingClientRect().width;
    var altoTotal = canvas.height / escala;
    var altoHojaPx = altoUtil * anchoPx / anchoUtil;
    var inicio = 0, primera = true;

    while (inicio < altoTotal - 1) {
      var fin = Math.min(inicio + altoHojaPx, altoTotal);
      if (fin < altoTotal) {
        var validos = cortes.filter(function (y) { return y > inicio + 20 && y <= fin; });
        if (validos.length) fin = validos[validos.length - 1];
      }
      var trozo = document.createElement('canvas');
      trozo.width = canvas.width;
      trozo.height = Math.round((fin - inicio) * escala);
      var ctx = trozo.getContext('2d');
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, trozo.width, trozo.height);
      ctx.drawImage(canvas, 0, Math.round(inicio * escala), canvas.width, trozo.height, 0, 0, canvas.width, trozo.height);

      if (!primera) pdf.addPage();
      pdf.addImage(trozo, 'PNG', margen, margen, anchoUtil, (fin - inicio) * anchoUtil / anchoPx, undefined, 'FAST');
      primera = false;
      inicio = fin;
    }
    pdf.save('teleeducacion_<?php echo preg_replace('/[^A-Za-z0-9_-]/', '-', $t['codigo']); ?>.pdf');
  }).catch(function (e) {
    alert('No se pudo generar el PDF: ' + e);
  }).then(function () {
    document.body.classList.remove('generando-pdf');
    boton.textContent = 'DESCARGAR EN PDF';
  });
}
</script>
</body>
</html>
