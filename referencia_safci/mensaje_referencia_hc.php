<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idreferencia_hc_ss         = $_SESSION['idreferencia_hc_ss'];
$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];
$idestablecimiento_salud_r_ss = $_SESSION['idestablecimiento_salud_r_ss'];

// La referencia que se muestra llega en la URL (guarda_referencia.php); solo si la registró este usuario.
// La sesión se actualiza con ESA referencia para que "MOSTRAR REGISTRO" abra la correcta.
$aviso_duplicado = isset($_GET['dup']);
$aviso_adjunto   = isset($_GET['adj']) && $_GET['adj'] === '0';
if (isset($_GET['idref']) && (int)$_GET['idref'] > 0) {
    $st_ref = mysqli_prepare($link, "SELECT idreferencia_hc, idnombre, idatencion_psafci, idestablecimiento_receptor, codigo FROM referencia_hc WHERE idreferencia_hc = ? AND idusuario = ?");
    $idref_get = (int)$_GET['idref'];
    $idusu_get = (int)$idusuario_ss;
    mysqli_stmt_bind_param($st_ref, 'ii', $idref_get, $idusu_get);
    mysqli_stmt_execute($st_ref);
    mysqli_stmt_bind_result($st_ref, $r_id, $r_nombre, $r_atencion, $r_receptor, $r_codigo);
    if (mysqli_stmt_fetch($st_ref)) {
        $idreferencia_hc_ss           = $r_id;
        $idestablecimiento_salud_r_ss = $r_receptor;
        $_SESSION['idreferencia_hc_ss']           = $r_id;
        $_SESSION['idnombre_integrante_ss']       = $r_nombre;
        $_SESSION['idatencion_psafci_ss']         = $r_atencion;
        $_SESSION['idestablecimiento_salud_r_ss'] = $r_receptor;
    }
    mysqli_stmt_close($st_ref);
}
$idestablecimiento_salud_r_ss = (int)$idestablecimiento_salud_r_ss;

    $sql =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
    $sql.=" subsector_salud.subsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
    $sql.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
    $sql.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio  AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.idestablecimiento_salud = '$idestablecimiento_salud_r_ss' ";
    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SISTEMA MEDI-SAFCI</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("../menu.php");?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("../top_bar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
  
                <body class="bg-gradient-primary">

    <div class="container">
    </br>
        <div class="card o-hidden border-0 shadow-lg my-2">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">   
                    
                    <hr>                     
                    <h4 class="text-success">SE HA REFERIDO AL PACIENTE</h4>
                    <h4 class="text-success">AL ESTABLECIMIENTO RECEPTOR:</h4>
                    <h4 class="text-secundary">"<?php echo htmlspecialchars((string)$row[1], ENT_QUOTES, 'UTF-8');?>"</h4>
                    <h4 class="text-secundary"><?php echo htmlspecialchars((string)$row[2], ENT_QUOTES, 'UTF-8');?></h4>
                    <h4 class="text-secundary"><?php echo htmlspecialchars((string)$row[3], ENT_QUOTES, 'UTF-8');?> - <?php echo htmlspecialchars((string)$row[4], ENT_QUOTES, 'UTF-8');?></h4>
                    <h4 class="text-warning">AÚN SE DEBE ESPERAR LA ADMISIÓN AL MISMO</h4>
                    <?php if ($aviso_duplicado) { ?>
                    <div class="alert alert-info mt-3 mb-0">Esta referencia ya había sido registrada; no se volvió a registrar.</div>
                    <?php } ?>
                    <?php if ($aviso_adjunto) { ?>
                    <div class="alert alert-warning mt-3 mb-0">La referencia se registró, pero el archivo adjunto no se pudo guardar. Comuníquese con el administrador si necesita adjuntarlo.</div>
                    <?php } ?>
                    </br>
                    <a href="mostrar_referencia_hc.php"><h6>MOSTRAR REGISTRO DE LA REFERENCIA -></h6></a>
                    <h4><?php echo "";?></h4>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="form-group row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>                  
                    
<!-- END aqui va el comntenido de la pagina ---->
                </div>
               
                <div class="text-center">
                <hr>
                    <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                </div>
                <div class="text-center">
                    <a class="small" href="#">Ministerio de Salud y Deportes</a>
                <hr>
                </div>
               
            </div>   
        </div> 
    </div>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE SALIR?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione la opcion Salir para cerrar sesion tendrá que volver a introducir su password.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../salir.php">Salir de Sistema</a>
                </div>
            </div>
        </div>
    </div>

   
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- scripts para calendario -->
   
</body>

</html>

