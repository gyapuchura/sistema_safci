<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];
        
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
                    <h4 class="text-info">REGISTRO DE ENCUESTA MÉDICA</h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

    
        <!-- VENTANA DE ATENCION INTEGRAL ---->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">ENCUESTA MÉDICA</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">    
                <div class="col-sm-12">
                <h6 class="text-info">TEMA DE LA ENCUESTA MÉDICA:</h6>
                <select name="idtema_encuesta" id="idtema_encuesta" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql_at = " SELECT idtema_encuesta, tema_encuesta FROM tema_encuesta ";
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
        <div class="card-body" id="formulario_encuesta_new"></div> 
        
    
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

        $("#idtema_encuesta").change(function () {
            $("#idtema_encuesta option:selected").each(function () {
                var tema_encuesta = $(this).val();
                
                $.post("formulario_encuesta_new.php", {tema_encuesta: tema_encuesta}, function(data){
                    
                    // Insertamos el formulario cargado
                    $("#formulario_encuesta_new").html(data);
                    
                    // =======================================================
                    // BLOQUE 1: BLINDAJE DE LA FECHA DE ATENCIÓN
                    // =======================================================
                    var inputsFecha = $("#formulario_encuesta_new").find("input[name='fecha_registro'], input[name='fecha1'], #fecha1, #fecha_registro");
                    
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
                    var inputsApellidos = $("#formulario_encuesta_new").find("input[name='paterno'], input[name='materno']");
                    
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
                    // =======================================================
                    // BLOQUE 3: AUTOMATIZACIÓN Y SEMAFORIZACIÓN (CÁNCER)
                    // =======================================================
                    var selectClasificacion = $("#idclasificacion_riesgo_cancer");
                    
                    if (selectClasificacion.length > 0) {
                        var clasificacionManual = false;

                        // Aviso bajo el select cuando la elección manual no coincide con la guía
                        var avisoGuia = $("<small>").css({"display": "block", "margin-top": "5px", "color": "#b91817", "font-weight": "bold"});
                        selectClasificacion.after(avisoGuia);

                        // Clasificación según CUADRO N° 2 de la "Guía de Diagnóstico Oportuno del Cáncer
                        // en la Niñez y la Adolescencia" (MSyD, Publicación 544, 2024)
                        // Ítems (iditem_senal_cancer) que por sí solos son POSIBLE CÁNCER
                        var ITEMS_POSIBLE_CANCER = ["1", "2", "24",              // Moretes, sangrado, petequias
                                                    "4",                         // Palidez intensa
                                                    "5", "6", "7", "8", "9", "10", // Anormalidad en los ojos
                                                    "13", "14", "15", "16", "17", "18", "19", // Signos neurológicos focales / visión
                                                    "20",                        // Masa palpable abdominal
                                                    "21", "22",                  // Hepatomegalia / esplenomegalia
                                                    "23"];                       // Masa en alguna región del cuerpo

                        function autoClassificar() {
                            // 1. Preguntas respondidas SI, identificadas por su idpregunta_encuesta
                            const si = {};
                            $("#formulario_encuesta_new input[name='idpregunta_encuesta[]']").each(function(i) {
                                si[$(this).val()] = $("#formulario_encuesta_new input[type='radio'][name='respuesta[" + i + "]'][value='SI']").is(":checked");
                            });

                            // 2. Signos marcados en OBSERVAR Y DETERMINAR
                            const item = {};
                            $("#formulario_encuesta_new input[type='checkbox'][name='iditem_senal_cancer[]']:checked").each(function() {
                                item[$(this).val()] = true;
                            });
                            const ganglioMayor = !!item["11"]; // Tamaño mayor a 2,5 cm sin dolor ni inflamación
                            const ganglioDuro  = !!item["12"]; // Consistencia dura y firme mayor a 4 semanas

                            // POSIBLE CÁNCER
                            const riesgoAlto =
                                si["1"] ||                               // Fiebre > 7 días y/o sudoración importante
                                (si["2"] && (si["3"] || si["4"])) ||     // Cefalea progresiva que despierta al niño y/o con vómitos
                                (si["5"] && si["6"] && si["7"]) ||       // Dolor óseo en el último mes, progresivo, que interrumpe su actividad
                                si["10"] ||                              // Cambios en la marcha / detención del desarrollo psicomotor
                                ITEMS_POSIBLE_CANCER.some(function(id) { return item[id]; }) ||
                                (ganglioMayor && ganglioDuro);           // Ganglio > 2,5 cm, no doloroso, duro, >= 4 semanas

                            // ALGÚN RIESGO DE CÁNCER
                            const riesgoMedio =
                                si["8"] ||                               // Pérdida de apetito, peso o fatiga en los últimos 3 meses
                                !!item["3"] ||                           // Palidez leve
                                (ganglioMayor !== ganglioDuro);          // Linfoadenopatía que no cumple todos los criterios de posible cáncer

                            // 1 = POSIBLE CÁNCER, 2 = ALGÚN RIESGO, 3 = NO TIENE CÁNCER
                            const sugerida = riesgoAlto ? "1" : (riesgoMedio ? "2" : "3");

                            // 3. Autoselección: si el médico eligió la clasificación a mano se respeta y solo se avisa
                            if (clasificacionManual && selectClasificacion.val() !== "") {
                                avisoGuia.text(selectClasificacion.val() !== sugerida
                                    ? "Según la guía corresponde: " + selectClasificacion.find("option[value='" + sugerida + "']").text() + " (clasificación cambiada manualmente)"
                                    : "");
                            } else {
                                clasificacionManual = false;
                                selectClasificacion.val(sugerida);
                                avisoGuia.text("");
                            }
                            pintarSemaforo();
                        }

                        function pintarSemaforo() {
                            const val = selectClasificacion.val();
                            if (val === "1") { selectClasificacion.css({"background-color": "#fdf0f0", "color": "#b91817", "font-weight": "bold"}); }
                            else if (val === "2") { selectClasificacion.css({"background-color": "#fff8e1", "color": "#b59545", "font-weight": "bold"}); }
                            else if (val === "3") { selectClasificacion.css({"background-color": "#e8f5e9", "color": "#28a745", "font-weight": "bold"}); }
                            else { selectClasificacion.css({"background-color": "#fff", "color": "#495057", "font-weight": "normal"}); }
                        }

                        // Delegación de eventos usando jQuery (.off evita duplicaciones de memoria en recargas AJAX)
                        $("#formulario_encuesta_new").off("change.semaforo").on("change.semaforo", "input[type='radio'], input[type='checkbox']", function() {
                            autoClassificar();
                        });

                        // Si el médico cambia el select manualmente, su elección ya no se sobrescribe.
                        // Volver a "-SELECCIONE-" reactiva la clasificación automática.
                        selectClasificacion.off("change.semaforo").on("change.semaforo", function() {
                            clasificacionManual = ($(this).val() !== "");
                            autoClassificar();
                        });

                        // Ejecución inicial para aplicar colores si el formulario ya trae datos por defecto
                        autoClassificar();
                    }
                });
            });
        });
    });
    </script>

</body>
</html>