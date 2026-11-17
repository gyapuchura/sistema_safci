<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php include("../comun/inc_persona.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

// Datos de la búsqueda de historias clínicas (valida_persona_ncf.php?b=); una sola vez: F5 deja el formulario vacío
$ncf_precarga = per_ncf_precarga_tomar();

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
    <link rel="stylesheet" href="../css/boton_mic.css">

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
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">                          

                    <hr>             
                    <h4 class="text-info">REGISTRO DE ATENCIÓN INTEGRAL - PSAFCI</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

    
        <!-- VENTANA DE ATENCION INTEGRAL ---->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">ATENCIÓN INTEGRAL SAFCI</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">    
                <div class="col-sm-12">
                <h6 class="text-info">TIPO DE ATENCIÓN SAFCI:</h6>
                <select name="idtipo_atencion" id="idtipo_atencion" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql_at = " SELECT idtipo_atencion, tipo_atencion FROM tipo_atencion WHERE idtipo_atencion !='6' ";
                $result_at = mysqli_query($link,$sql_at);
                if ($row_at = mysqli_fetch_array($result_at)){
                mysqli_field_seek($result_at,0);
                while ($field_at = mysqli_fetch_field($result_at)){
                } do {
                echo "<option value=".$row_at[0].">".$row_at[1]."</option>";
                } while ($row_at = mysqli_fetch_array($result_at));
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
                </div>
            </div>
        </div>
        <div class="card-body" id="tipo_atencion_nfc"></div> 
        
    
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
    <!-- Más abajo se vuelve a cargar jquery.js (sin el plugin de ventanas de Bootstrap): se guarda este jQuery para la ventana de cédula -->
    <script>window.jqBootstrap = window.jQuery;</script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- scripts para calendario -->
<script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/datepicker-es.js"></script>
    <script src="../js/funciones.js"></script>

    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/datepicker-es.js"></script>
    <script src="../js/funciones.js"></script>

    <script language="javascript">
    $(document).ready(function(){
        
        // 1. Obtenemos los datos de la fecha actual (Hoy)
        var date = new Date();
        var diaHoy = date.getDate().toString().padStart(2, '0');
        var mesFormato = (date.getMonth() + 1).toString().padStart(2, '0');
        var anioFormato = date.getFullYear();
        
        // 2. MODIFICACIÓN MAESTRA: Cambiamos el límite máximo para que sea HOY
        // minDateHTML5 = El día 1 de este mes (Permite días atrás del mismo mes)
        // maxDateHTML5 = El día de HOY (Bloquea por completo el futuro)
        var minDateHTML5 = anioFormato + '-' + mesFormato + '-01';
        var maxDateHTML5 = anioFormato + '-' + mesFormato + '-' + diaHoy;

        $("#idtipo_atencion").change(function () {
            $("#idtipo_atencion option:selected").each(function () {
                var tipo_atencion = $(this).val();
                
                $.post("tipo_atencion_nfc.php", {tipo_atencion: tipo_atencion}, function(data){
                    
                    // Insertamos el formulario cargado
                    $("#tipo_atencion_nfc").html(data);
                    
                    // =======================================================
                    // BLOQUE 1: BLINDAJE DE LA FECHA DE ATENCIÓN
                    // =======================================================
                    var inputsFecha = $("#tipo_atencion_nfc").find("input[name='fecha_registro'], input[name='fecha1'], #fecha1, #fecha_registro");
                    
                    if (inputsFecha.length > 0) {
                        inputsFecha.attr('type', 'date');
                        
                        // Aplicamos los nuevos límites: Desde el día 1 del mes hasta HOY
                        inputsFecha.attr('min', minDateHTML5);
                        inputsFecha.attr('max', maxDateHTML5);
                        
                        // Autocompletamos por defecto con la fecha de hoy
                        inputsFecha.val(maxDateHTML5);
                    }

                    // =======================================================
                    // BLOQUE 2: FLEXIBILIDAD EN AMBOS APELLIDOS
                    // =======================================================
                    var inputsApellidos = $("#tipo_atencion_nfc").find("input[name='paterno'], input[name='materno']");
                    
                    if (inputsApellidos.length > 0) {
                        
                        // A. Modificamos el patrón HTML para admitir letras con acentos, eñes y ESPACIOS (\s)
                        inputsApellidos.attr('pattern', '[a-zA-ZáéíóúÁÉÍÓÚñÑ\\s]+');
                        
                        // B. Validación en tiempo real: Filtra y borra números o caracteres especiales al instante, pero permite la barra espaciadora
                        inputsApellidos.on('input', function() {
                            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                        });

                        // C. Remoción estricta del atributo requerido en AMBOS inputs (Paterno y Materno)
                        inputsApellidos.removeAttr('required');
                    }

                    // BLOQUE 3: datos de la búsqueda y revisión de la cédula (script de abajo)
                    ncfPreparar($("#tipo_atencion_nfc"));
                });
            });
        });
    });
    </script>

    <!-- Cédula ya registrada: se avisa ANTES de llenar la atención (ncf_verificar_ci.php, comun/inc_persona.php per_ncf_*) -->
    <style>
        /* Ventana de cédula: centrada sobre el recuadro de datos del paciente (no la pantalla) y arrastrable */
        #modalCiNcf .modal-dialog { position: absolute; margin: 0; width: 800px; max-width: calc(100vw - 20px); transition: none; }
        #modalCiNcf .modal-header { cursor: move; user-select: none; }
        #modalCiNcf .modal-header .close { cursor: pointer; opacity: .85; text-shadow: none; }
        #modalCiNcf .modal-header .close:hover { opacity: 1; }
        /* Cédula revisada como "otra persona": verde claro de la paleta (success #1cc88a) */
        input.ncf-ci-ok { background-color: #e3f8ef !important; border-color: #1cc88a !important; }
    </style>
    <div class="modal fade" id="modalCiNcf" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning" title="Arrastre para mover la ventana">
                    <h5 class="modal-title text-white font-weight-bold"><i class="fas fa-exclamation-triangle"></i> ESTA CÉDULA YA ESTÁ REGISTRADA</h5>
                    <!-- Cerrar sin decidir: la cédula queda escrita; al guardar, el sistema vuelve a preguntar -->
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar" title="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">La cédula <b id="ncfCi"></b> ya pertenece a:</p>
                    <div id="ncfLista"></div>
                    <div id="ncfMisma" class="alert alert-success py-2 small d-none">
                        Los datos que escribió coinciden con una persona registrada: es el mismo paciente. Elija <b>ES ESTA PERSONA</b>.
                    </div>
                    <p class="small text-muted mb-0">Compare con el paciente: nombres, apellidos y fecha de nacimiento.
                        Si es <b>otra persona</b>, se registrará como paciente nuevo con la misma cédula.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="ncfCorregir">CORREGIR EL NÚMERO</button>
                    <button type="button" class="btn btn-warning" id="ncfOtra">NO ES NINGUNA: REGISTRAR COMO NUEVO</button>
                </div>
            </div>
        </div>
    </div>
    <form id="ncfIrPersona" action="valida_cedula_hc.php" method="post" style="display:none">
        <input type="hidden" name="b"><input type="hidden" name="idnombre">
    </form>

    <script>
    var ncfPrecarga = <?php echo json_encode($ncf_precarga, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var ncfRevisado = {};   // cédula -> 'libre' | 'confirmado' (no se vuelve a preguntar)

    function ncfEsc(t) { return $('<div>').text(t == null ? '' : String(t)).html(); }

    // Cédula ya revisada ("es otra persona"): el campo queda con fondo verde claro (sin texto adicional)
    function ncfNota(cont, mostrar) {
        cont.find("input[name='ci']").toggleClass('ncf-ci-ok', !!mostrar)
            .attr('title', mostrar ? 'Cédula revisada: otra persona con la misma cédula. Se registrará como paciente nuevo.' : null);
    }

    function ncfVerificar(cont) {
        var f = function (n) { var x = cont.find("[name='" + n + "']"); return x.length ? $.trim(x.val()) : ''; };
        var ci = f('ci');
        ncfNota(cont, false);
        if (ci === '' || ci === '0') return;
        if (ncfRevisado[ci] === 'confirmado') { ncfNota(cont, true); return; }
        if (ncfRevisado[ci] === 'libre') return;
        $.getJSON('ncf_verificar_ci.php', { ci: ci, complemento: f('complemento'), nombre: f('nombre'), paterno: f('paterno'),
                                            materno: f('materno'), fecha_nac: f('fecha_nac') }, function (r) {
            if (f('ci') !== ci) return;   // cambiaron el número mientras se consultaba
            if (!r || !r.personas || !r.personas.length) { ncfRevisado[ci] = 'libre'; return; }
            if (r.confirmado) { ncfRevisado[ci] = 'confirmado'; ncfNota(cont, true); return; }
            ncfVentana(cont, ci, r);
        });
    }

    function ncfVentana(cont, ci, r) {
        var html = '', misma = false;
        $.each(r.personas, function (i, p) {
            misma = misma || p.parecido;
            html += '<div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center' + (p.parecido ? ' border-success' : '') + '">'
                 +  '<div><b>' + ncfEsc(p.nombre) + '</b>'
                 +  (p.parecido ? ' <span class="badge badge-success">Coincide con los datos escritos</span>' : '')
                 +  '<div class="small text-gray-700">C.I. ' + ncfEsc(p.ci)
                 +  (p.fecha_nac ? ' · Nac. ' + ncfEsc(p.fecha_nac) + (p.edad !== '' ? ' (' + ncfEsc(p.edad) + ' años)' : '') : '')
                 +  (p.genero ? ' · ' + ncfEsc(p.genero) : '') + '</div>'
                 +  '<div class="small">'
                 +  (p.carpeta ? '<span class="badge badge-warning">Carpeta ' + ncfEsc(p.carpeta) + '</span>' : '<span class="badge badge-secondary">Sin carpeta familiar</span>')
                 +  (p.ultima_fecha ? ' <span class="text-muted">Última atención: ' + ncfEsc(p.ultima_fecha) + (p.ultimo_eess ? ' - ' + ncfEsc(p.ultimo_eess) : '') + '</span>' : ' <span class="text-muted">Sin atenciones</span>')
                 +  '</div></div>'
                 +  '<button type="button" class="btn btn-primary btn-sm ml-2 ncf-ir" data-id="' + p.idnombre + '">ES ESTA PERSONA</button>'
                 +  '</div>';
        });
        $('#ncfCi').text(ci);
        $('#ncfLista').html(html);
        $('#ncfMisma').toggleClass('d-none', !misma);
        $('#ncfOtra').prop('disabled', misma);

        $('#ncfLista .ncf-ir').off('click').on('click', function () {
            var fm = $('#ncfIrPersona');
            fm.find("[name='b']").val(r.token);
            fm.find("[name='idnombre']").val($(this).data('id'));
            fm.submit();
        });
        $('#ncfCorregir').off('click').on('click', function () {
            jqBootstrap('#modalCiNcf').modal('hide');
            cont.find("input[name='ci']").val('').focus();
        });
        $('#ncfOtra').off('click').on('click', function () {
            $.post('ncf_verificar_ci.php', { accion: 'confirmar', ci: ci }, function () {
                ncfRevisado[ci] = 'confirmado';
                jqBootstrap('#modalCiNcf').modal('hide');
                ncfNota(cont, true);
            }, 'json');
        });
        ncfUbicar(cont);
        jqBootstrap('#modalCiNcf').modal('show');
    }

    // Ancho: centrada sobre el recuadro donde se escriben los datos del paciente. Alto: centrada en la pantalla.
    // Sin salirse de la pantalla. ncfMover = lo que el médico la arrastró.
    var ncfMover = { x: 0, y: 0 };
    function ncfUbicar(cont) {
        var campo = cont.find("input[name='ci']"), caja = campo.closest('.card');
        var el = (caja.length ? caja : (campo.length ? campo : cont))[0];
        var r = el.getBoundingClientRect(), d = document.querySelector('#modalCiNcf .modal-dialog');
        d.dataset.cx = r.left + r.width / 2;
        d.dataset.cy = window.innerHeight / 2;
        ncfMover = { x: 0, y: 0 };
        ncfPintar();
    }
    function ncfPintar() {
        var d = document.querySelector('#modalCiNcf .modal-dialog');
        d.style.left = d.dataset.cx + 'px';
        d.style.top  = d.dataset.cy + 'px';
        d.style.transform = 'translate(calc(-50% + ' + ncfMover.x + 'px), calc(-50% + ' + ncfMover.y + 'px))';
    }
    // Al mostrarse: si por su alto quedara cortada arriba o abajo, se acomoda dentro de la pantalla
    jqBootstrap('#modalCiNcf').on('shown.bs.modal', function () {
        var r = document.querySelector('#modalCiNcf .modal-dialog').getBoundingClientRect();
        if (r.top < 10) { ncfMover.y += 10 - r.top; }
        else if (r.bottom > window.innerHeight - 10 && r.height < window.innerHeight - 20) { ncfMover.y -= r.bottom - (window.innerHeight - 10); }
        if (r.left < 10) { ncfMover.x += 10 - r.left; }
        else if (r.right > window.innerWidth - 10) { ncfMover.x -= r.right - (window.innerWidth - 10); }
        ncfPintar();
    });

    // Arrastrar la ventana desde su barra de título (mismo comportamiento que la ventana "Corregir datos")
    (function () {
        var arr = null, pend = null;
        document.addEventListener('mousedown', function (e) {
            if (e.button !== 0 || !e.target.closest || !e.target.closest('#modalCiNcf .modal-header') || e.target.closest('.close')) return;
            arr = { x0: e.clientX, y0: e.clientY, x: ncfMover.x, y: ncfMover.y };
            e.preventDefault();
        });
        document.addEventListener('mousemove', function (e) {
            if (!arr) return;
            ncfMover = { x: arr.x + e.clientX - arr.x0, y: arr.y + e.clientY - arr.y0 };
            if (!pend) { pend = requestAnimationFrame(function () { pend = null; ncfPintar(); }); }
        });
        document.addEventListener('mouseup', function () { arr = null; });
    })();

    // Se llama cada vez que se carga el formulario del tipo de atención elegido
    function ncfPreparar(cont) {
        if (ncfPrecarga) {
            $.each(['ci', 'complemento', 'nombre', 'paterno', 'materno', 'fecha_nac'], function (i, k) {
                if (ncfPrecarga[k]) cont.find("[name='" + k + "']").val(ncfPrecarga[k]);
            });
            if (ncfPrecarga.confirmado && ncfPrecarga.ci) ncfRevisado[ncfPrecarga.ci] = 'confirmado';
        }
        cont.find("input[name='ci']").on('change', function () { ncfVerificar(cont); });
        ncfVerificar(cont);
    }
    </script>

</body>
</html>