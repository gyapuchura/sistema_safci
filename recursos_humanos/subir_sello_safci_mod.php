<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];

$volver = 'modifica_registro_safci_individual.php';

if ($idusuario_ss == '' || $idnombre_ss == '') {
    header("Location:../index.php");
    exit;
}

/****** el idpersonal se toma de la sesión, así nadie puede cambiar el sello de otro personal ****/
$stmt = $link->prepare(" SELECT idpersonal, url_sello FROM personal WHERE idnombre=? AND idusuario=? LIMIT 1 ");

/****** si falla la consulta (p. ej. falta la columna url_sello) se vuelve con mensaje de error ****/
if (!$stmt) {
    error_log('subir_sello_safci_mod: '.$link->error);
    header("Location:".$volver."?sello=error#sello");
    exit;
}

$stmt->bind_param('ii', $idnombre_ss, $idusuario_ss);
$stmt->execute();
$stmt->bind_result($idpersonal, $sello_anterior);
$encontrado = $stmt->fetch();
$stmt->close();

if (!$encontrado) {
    header("Location:".$volver."?sello=error#sello");
    exit;
}

/****** la imagen llega desde el navegador ya sin fondo, como data URL PNG ****/
$sello_png = isset($_POST['sello_png']) ? $_POST['sello_png'] : '';
$prefijo   = 'data:image/png;base64,';

if (strpos($sello_png, $prefijo) !== 0) {
    header("Location:".$volver."?sello=error#sello");
    exit;
}

$binario = base64_decode(substr($sello_png, strlen($prefijo)), true);

if ($binario === false || strlen($binario) > 5 * 1024 * 1024) {
    header("Location:".$volver."?sello=error#sello");
    exit;
}

$imagen = @imagecreatefromstring($binario);

if (!$imagen) {
    header("Location:".$volver."?sello=error#sello");
    exit;
}

/****** se vuelve a generar el PNG con GD (conserva la transparencia y descarta cualquier contenido que no sea imagen) ****/
imagealphablending($imagen, false);
imagesavealpha($imagen, true);

$directorio = 'files_sello/';

if (!is_dir('../'.$directorio)) {
    mkdir('../'.$directorio, 0755, true);
}

$subir_archivo = $directorio.'sello_'.$idpersonal.'_'.date('YmdHis').'.png';

if (imagepng($imagen, '../'.$subir_archivo, 9)) {

    imagedestroy($imagen);

    $stmt = $link->prepare(" UPDATE personal SET url_sello=? WHERE idpersonal=? ");
    $stmt->bind_param('si', $subir_archivo, $idpersonal);
    $stmt->execute();
    $stmt->close();

    /****** se elimina el sello anterior para no acumular archivos ****/
    if ($sello_anterior != '' && strpos($sello_anterior, $directorio) === 0 && is_file('../'.$sello_anterior)) {
        unlink('../'.$sello_anterior);
    }

    header("Location:".$volver."?sello=ok#sello");

} else {

    imagedestroy($imagen);
    header("Location:".$volver."?sello=error#sello");

}
?>
