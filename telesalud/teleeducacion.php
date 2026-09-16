<?php 
include("../cabf.php"); 
include("../inc.config.php"); 

// Blindaje de sesiones para evitar errores en menu.php y top_bar.php
$idusuario_ss = $_SESSION['idusuario_ss'];
$perfil_ss    = $_SESSION['perfil_ss'];
$idnombre_ss  = $_SESSION['idnombre_ss']; 
$gestion      = date("Y"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Módulo de Teleeducación">
    <meta name="author" content="Arreglo SAFCI">

    <title>SISTEMA MEDI-SAFCI - Teleeducación</title>

    <!-- Fuentes e iconos personalizados para esta plantilla -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- Estilos personalizados nativos de tu sistema -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Contenedor Principal -->
    <div id="wrapper">
        
        <!-- Menú Lateral -->
        <?php include("../menu.php"); ?>
        
        <!-- Envoltorio de Contenido -->
        <div id="content-wrapper" class="d-flex flex-column">
            
            <!-- Contenido Principal -->
            <div id="content">
                
                <!-- Barra Superior (Top Bar) -->
                <?php include("../top_bar.php"); ?>
                
                <!-- INICIO DEL CONTENIDO DE LA PÁGINA -->
                <div class="container-fluid mt-5 pt-5">
                    
                    <!-- Pantalla centralizada de Módulo en Desarrollo -->
                    <div class="text-center mt-5">
                        <div class="mx-auto mb-4" style="font-size: 6rem; color: #4e73df; opacity: 0.8;">
                            <i class="fas fa-tools fa-spin-hover"></i>
                        </div>
                        <h2 class="text-gray-800 font-weight-bold mb-4">MÓDULO EN DESARROLLO</h2>
                        <p class="lead text-gray-600 mb-5">
                            Esta sección de <b>Teleeducación</b> estará disponible muy pronto.<br>
                            Estamos trabajando para brindarte las mejores herramientas.
                        </p>
                        
                        <a href="../promocion_safci/sesiones_educativas.php" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Volver a Promoción de la Salud</span>
                        </a>
                    </div>

                </div>
                <!-- FIN DEL CONTENIDO DE LA PÁGINA -->
                
            </div>
            <!-- Fin de Main Content -->
            
            <!-- Footer de la plataforma -->
            <footer class="sticky-footer bg-white mt-auto">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes © MSYD <?php echo date("Y"); ?></span>
                    </div>
                </div>
            </footer>
            <!-- Fin del Footer -->
            
        </div>
    </div>

    <!-- Botón flotante para subir (Scroll to Top) -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts nativos de Bootstrap y SB Admin 2 -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
</body>
</html>