<?php
/**
 * Catálogo CIE-10 compartido por todo el sistema.
 *
 * Uso en un formulario (ver referencia_safci/formulario_contrareferencia_hc.php):
 *   include("../comun/inc_cie10.php");
 *   ...
 *   <input type="text" class="form-control buscador-cie-inteligente" data-target="idpatologia_0" autocomplete="off">
 *   <div class="lista-flotante-cie" style="display:none; position:absolute; ..."></div>
 *   <input type="hidden" name="idpatologia[0]" id="idpatologia_0" value="">
 *   ...
 *   <script src="../comun/buscador_cie10.js"></script>
 *   <script>BuscadorCIE10.iniciar('<?php echo cie10_url_catalogo($link); ?>');</script>
 */

/**
 * Versión del catálogo: cambia si se agrega, renombra o elimina una patología.
 * Va en la URL del catálogo para que el navegador lo vuelva a descargar solo cuando cambió.
 */
function cie10_version($link)
{
    $res = mysqli_query($link, "SELECT COUNT(*), COALESCE(MAX(idpatologia),0), COALESCE(SUM(CRC32(CONCAT_WS('|', idpatologia, patologia, cie))),0) FROM patologia");
    $fila = $res ? mysqli_fetch_row($res) : array(0, 0, 0);
    return substr(md5(implode('-', $fila)), 0, 12);
}

/** URL del catálogo (relativa a una página que está en una carpeta de primer nivel, ej. referencia_safci/). */
function cie10_url_catalogo($link, $prefijo = '../comun/')
{
    return $prefijo . 'ajax_cie10.php?v=' . cie10_version($link);
}
