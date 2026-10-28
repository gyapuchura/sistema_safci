<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

date_default_timezone_set('America/La_Paz');

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

$volver = 'editar_establecimiento.php';

if ($idusuario_ss == '' || $idnombre_ss == '' || $idestablecimiento_salud_ss == '') {
    header("Location:../index.php");
    exit;
}

/****** el establecimiento se toma de la sesión, así nadie puede cambiar el sello de otro establecimiento ****/
$stmt = $link->prepare(" SELECT idestablecimiento_salud, sello_eess FROM establecimiento_salud WHERE idestablecimiento_salud=? LIMIT 1 ");

if (!$stmt) {
    error_log('subir_sello_eess_mod: '.$link->error);
    header("Location:".$volver."?sello_eess=error#sello_eess");
    exit;
}

$stmt->bind_param('i', $idestablecimiento_salud_ss);
$stmt->execute();
$stmt->bind_result($idestablecimiento_salud, $sello_anterior);
$encontrado = $stmt->fetch();
$stmt->close();

if (!$encontrado) {
    header("Location:".$volver."?sello_eess=error#sello_eess");
    exit;
}

/****** la imagen llega desde el navegador ya sin fondo, como data URL PNG ****/
$sello_png = isset($_POST['sello_eess_png']) ? $_POST['sello_eess_png'] : '';
$prefijo   = 'data:image/png;base64,';

if (strpos($sello_png, $prefijo) !== 0) {
    header("Location:".$volver."?sello_eess=error#sello_eess");
    exit;
}

$binario = base64_decode(substr($sello_png, strlen($prefijo)), true);

if ($binario === false || strlen($binario) > 5 * 1024 * 1024) {
    header("Location:".$volver."?sello_eess=error#sello_eess");
    exit;
}

$imagen = @imagecreatefromstring($binario);

if (!$imagen) {
    header("Location:".$volver."?sello_eess=error#sello_eess");
    exit;
}

/****** se vuelve a generar el PNG con GD (conserva la transparencia y descarta cualquier contenido que no sea imagen) ****/
imagealphablending($imagen, false);
imagesavealpha($imagen, true);

$directorio = 'files_sello_EESS/';

if (!is_dir('../'.$directorio)) {
    mkdir('../'.$directorio, 0755, true);
}

$subir_archivo = $directorio.'sello_eess_'.$idestablecimiento_salud.'_'.date('YmdHis').'.png';

if (imagepng($imagen, '../'.$subir_archivo, 9)) {

    imagedestroy($imagen);

    $stmt = $link->prepare(" UPDATE establecimiento_salud SET sello_eess=? WHERE idestablecimiento_salud=? ");
    $stmt->bind_param('si', $subir_archivo, $idestablecimiento_salud);
    $stmt->execute();
    $stmt->close();

    /****** se elimina el sello anterior para no acumular archivos ****/
    if ($sello_anterior != '' && strpos($sello_anterior, $directorio) === 0 && is_file('../'.$sello_anterior)) {
        unlink('../'.$sello_anterior);
    }

    header("Location:".$volver."?sello_eess=ok#sello_eess");

} else {

    imagedestroy($imagen);
    header("Location:".$volver."?sello_eess=error#sello_eess");

}
?>
