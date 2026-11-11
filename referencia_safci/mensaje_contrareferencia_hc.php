<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php include("inc_contrareferencia.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

// El caso llega por la URL desde guarda_contrareferencia.php y se verifica en la base:
// debe existir el tramo de contrarreferencia enviado DESDE el establecimiento del usuario.
$idreferencia_hc_ss = isset($_GET['idref']) ? (int)$_GET['idref'] : 0;
$adjunto_fallido    = (isset($_GET['adj']) && $_GET['adj'] === '0');

$row = null;
$codigo_referencia = '';
if ($idreferencia_hc_ss > 0) {
    $eess_usuario = cr_eess_usuario($link, $idusuario_ss);
    $tramo = cr_fila($link,
        "SELECT d.idestablecimiento_salud_r, r.codigo
           FROM deriva_referencia_hc d
     INNER JOIN referencia_hc r ON r.idreferencia_hc = d.idreferencia_hc
          WHERE d.idreferencia_hc = ? AND d.idestablecimiento_salud_o = ? AND r.idestado_referencia = '2'
       ORDER BY d.idderiva_referencia_hc DESC LIMIT 1",
        'ii', array($idreferencia_hc_ss, $eess_usuario));

    if ($tramo) {
        $codigo_referencia = $tramo['codigo'];
        $row = cr_fila($link,
            "SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento,
                    tipo_establecimiento.tipo_establecimiento, subsector_salud.subsector_salud, municipios.municipio, departamento.departamento
               FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios
              WHERE establecimiento_salud.idsubsector_salud = subsector_salud.idsubsector_salud
                AND establecimiento_salud.idnivel_establecimiento = nivel_establecimiento.idnivel_establecimiento
                AND establecimiento_salud.iddepartamento = departamento.iddepartamento
                AND establecimiento_salud.idmunicipio = municipios.idmunicipio
                AND establecimiento_salud.idtipo_establecimiento = tipo_establecimiento.idtipo_establecimiento
                AND establecimiento_salud.idestablecimiento_salud = ?",
            'i', array((int)$tramo['idestablecimiento_salud_r']));
        if ($row) {
            $row = array_values($row); // mismo acceso por posición que antes: $row[1], $row[2]...
        }
    }
}
$caso_valido = ($row !== null);
$h = function ($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); };
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
                    <?php if ($caso_valido) { ?>
                    <h4 class="text-success">SE HA CONTRARREFERIDO AL PACIENTE</h4>
                    <h4 class="text-success">AL ESTABLECIMIENTO ORIGEN:</h4>
                    <h4 class="text-secundary">"<?php echo $h($row[1]);?>"</h4>
                    <h4 class="text-secundary"><?php echo $h($row[2]);?></h4>
                    <h4 class="text-secundary"><?php echo $h($row[3]);?> - <?php echo $h($row[4]);?></h4>
                    <h5 class="text-primary">CÓDIGO DE REFERENCIA: <?php echo $h($codigo_referencia);?></h5>
                    <?php if ($adjunto_fallido) { ?>
                    <div class="alert alert-warning mt-3">La contrarreferencia se registró, pero el archivo adjunto no se pudo guardar. Comuníquese con el administrador si necesita adjuntarlo.</div>
                    <?php } ?>
                    </br>
                        <a class="btn btn-success btn-icon-split" href="../referencia_safci/imprime_formulario_d7a.php?idreferencia_hc=<?php echo (int)$idreferencia_hc_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=900,height=1000,top=50, left=600, scrollbars=YES'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">IMPRIMIR FORMULARIO D7-a</span>
                        </a>
                    <?php } else { ?>
                    <h4 class="text-danger">NO SE ENCONTRÓ LA CONTRARREFERENCIA</h4>
                    <p class="text-gray-800">No hay una contrarreferencia registrada desde su establecimiento para este caso.<br>Revise la bandeja de admitidos.</p>
                    <?php } ?>
                    </br>
                    </br>
                    <a href="admitidos_referencia.php"><h6>IR A BANDEJA DE ADMITIDOS -></h6></a>
                    <h4></h4>
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

