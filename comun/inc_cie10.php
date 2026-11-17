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

/**
 * Reglas de coherencia diagnóstico / sexo / edad (opcionales: solo las aplica el formulario que las pide).
 * El catálogo usa la categoría CIE-10 de 3 caracteres (ej. O80, N40); cada regla es un rango desde-hasta.
 *   genero: 1 = FEMENINO, 2 = MASCULINO (tabla genero)
 *   edad_min / edad_max: años cumplidos (null = sin límite)
 * Las mismas reglas se envían al navegador (buscador_cie10.js) y se vuelven a revisar al guardar.
 */
function cie10_reglas_sexo_edad()
{
    $emb = array('genero' => 1, 'edad_min' => 10, 'edad_max' => 55);
    $fem = array('genero' => 1, 'edad_min' => null, 'edad_max' => null);
    $mas = array('genero' => 2, 'edad_min' => null, 'edad_max' => null);
    $r = array(
        array('O00', 'O99', $emb, 'Embarazo, parto y puerperio'),
        array('Z32', 'Z37', $emb, 'Control y resultado del embarazo'),
        array('Z39', 'Z39', $emb, 'Atención posparto'),
        array('N70', 'N98', $fem, 'Enfermedad de órganos genitales femeninos'),
        array('C51', 'C58', $fem, 'Tumor maligno de órganos genitales femeninos'),
        array('D25', 'D28', $fem, 'Tumor benigno de órganos genitales femeninos'),
        array('D39', 'D39', $fem, 'Tumor de órganos genitales femeninos'),
        array('Q50', 'Q52', $fem, 'Malformación de órganos genitales femeninos'),
        array('E28', 'E28', $fem, 'Disfunción ovárica'),
        array('R87', 'R87', $fem, 'Hallazgo en muestras de órganos genitales femeninos'),
        array('N40', 'N51', $mas, 'Enfermedad de órganos genitales masculinos'),
        array('C60', 'C63', $mas, 'Tumor maligno de órganos genitales masculinos'),
        array('D29', 'D29', $mas, 'Tumor benigno de órganos genitales masculinos'),
        array('D40', 'D40', $mas, 'Tumor de órganos genitales masculinos'),
        array('Q53', 'Q55', $mas, 'Malformación de órganos genitales masculinos'),
        array('E29', 'E29', $mas, 'Disfunción testicular'),
        array('R86', 'R86', $mas, 'Hallazgo en muestras de órganos genitales masculinos'),
    );
    $reglas = array();
    foreach ($r as $x) {
        $reglas[] = array_merge(array('desde' => $x[0], 'hasta' => $x[1], 'grupo' => $x[3]), $x[2]);
    }
    return $reglas;
}

/**
 * Motivo por el que un CIE-10 no corresponde al paciente, o '' si corresponde.
 * $idgenero distinto de 1/2 o $edad null: esa parte de la regla no se revisa.
 * (El mismo texto lo arma buscador_cie10.js; si cambia aquí, cambiarlo también allá.)
 */
function cie10_motivo_restriccion($cie, $idgenero, $edad)
{
    $cat = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string)$cie), 0, 3));
    if (strlen($cat) < 3) {
        return '';
    }
    $idgenero = (int)$idgenero;
    foreach (cie10_reglas_sexo_edad() as $r) {
        if (strcmp($cat, $r['desde']) < 0 || strcmp($cat, $r['hasta']) > 0) {
            continue;
        }
        if (($idgenero === 1 || $idgenero === 2) && $idgenero !== (int)$r['genero']) {
            return $r['grupo'] . ': diagnóstico exclusivo de ' . ((int)$r['genero'] === 1 ? 'mujeres' : 'hombres')
                 . ' y el paciente es de sexo ' . ($idgenero === 1 ? 'femenino' : 'masculino') . '.';
        }
        if ($edad !== null && (($r['edad_min'] !== null && $edad < $r['edad_min']) || ($r['edad_max'] !== null && $edad > $r['edad_max']))) {
            return $r['grupo'] . ': solo corresponde de ' . $r['edad_min'] . ' a ' . $r['edad_max']
                 . ' años y el paciente tiene ' . (int)$edad . ' años.';
        }
        return '';
    }
    return '';
}
