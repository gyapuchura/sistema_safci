<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="inicio.php">
    <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-fw fa-folder"></i>   
    </div>
    <div class="sidebar-brand-text mx-3">OPCIONES DE SISTEMA-SAFCI</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="../administrar_sistema/inicio.php">
        <i class="fas fa-bahai"></i>
        <span>ADMINISTRACION DE SISTEMA</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
   ÁREA DE IMPLEMENTACIÓN SAFCI
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-users"></i>
        <span>RECURSOS HUMANOS SAFCI</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">ELEGIR:</h6>
            
    <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR'  ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?> 

        <a class="collapse-item" href="../recursos_humanos/recursos_humanos.php">RECURSOS HUMANOS</a>
        <a class="collapse-item" href="../recursos_humanos/nuevo_personal.php">NUEVO PERSONAL</a>

    <?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>
       <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'PERSONAL' || $row_menu[0] == 'PARTICIPANTE' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?> 

    <a class="collapse-item" href="../recursos_humanos/registro_individual.php">REGISTRO PERSONAL</a>

    <?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>
        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#coberturaSafci"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-hospital"></i>
        <span>COBERTURA SAFCI</span>
    </a>
    <div id="coberturaSafci" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">ELEGIR:</h6>
            <a class="collapse-item" href="../recursos_humanos/redes_salud.php">REDES DE SALUD</a>
            <a class="collapse-item" href="../recursos_humanos/establecimientos_salud.php">ESTABLECIMIENTOS </br> DE SALUD NACIONAL</a>
            <a class="collapse-item" href="../recursos_humanos/nuevo_establecimiento.php">NUEVO</br>ESTABLECIMIENTO</br>DE SALUD</a>
            <a class="collapse-item" href="../recursos_humanos/areas_influencia.php">ÁREAS DE INFLUENCIA</a>
            <a class="collapse-item" href="../recursos_humanos/nueva_area_influencia.php">NUEVA ÁREA</br>INFLUENCIA</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#salaSituacional"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-laptop-medical"></i>   
        <span>SALA SITUACIONAL</span>
    </a>
    <div id="salaSituacional" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SALAS:</h6>
            <a class="collapse-item" href="#">NACIONAL</a>
            <a class="collapse-item" href="#">DEPARTAMENTAL</a>
            <a class="collapse-item" href="#">MUNICIPAL</a>
            <a class="collapse-item" href="#">VECINAL</a>
            <a class="collapse-item" href="../sala_situacional/sala_establecimientos.php">ESTABLECIMIENTOS</a>
            <a class="collapse-item" href="../sala_situacional/sala_personal_safci.php">PERSONAL SAFCI</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2"
        aria-expanded="true" aria-controls="collapseUtilities2">
        <i class="fas fa-clinic-medical"></i>   
        <span>SALUD FAMILIAR</span>
    </a>
    <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SAFCI:</h6>
            <a class="collapse-item" href="../carpetas_familiares/carpetas_familiares.php">CARPETAS FAMILIARES</a>
            <a class="collapse-item" href="../carpetas_familiares/nueva_carpeta_familiar.php">NUEVA CARPETA</br>FAMILIAR</a>
            <a class="collapse-item" href="#">REGISTRO FAMILIAR</a>
        </div>
    </div>
</li>


<!-- Divider -->
<hr class="sidebar-divider">

<!----------------------------   INICIO MENU SISTEMA DISEÑO CURRICULAR ------------------>


<!----------------------------   END  MENU SISTEMA DISEÑO CURRICULAR ------------------>

<!-- Heading -->


<!-- Nav Item - Charts -->

<!-- Nav Item - Tables -->
<li class="nav-item active">
    <a class="nav-link" href="../salir.php">
        <i class="fas fa-fw fa-out"></i>
        <span>Cerrar Sesion</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>