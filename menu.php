<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../administrar_sistema/inicio.php">
    <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-fw fa-folder"></i>   
    </div>
    <div class="sidebar-brand-text mx-3">OPCIONES DE SISTEMA MEDI-SAFCI</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="../administrar_sistema/inicio.php" data-toggle="collapse" data-target="#collapseadm"
    aria-expanded="true" aria-controls="collapseadm">
        <i class="fas fa-bahai"></i>
        <span>ADMINISTRACION DE SISTEMA</span>
    </a>
    <div id="collapseadm" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">ELEGIR:</h6>
        <a class="collapse-item" href="../recursos_humanos/reportes_sistema.php">REPORTES SISTEMA</a>
        <a class="collapse-item" href="../administrar_sistema/credenciales.php">CREDENCIALES</br>DE SISTEMA</a> 
    </div>
    </div>
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
    if ($row_menu[0] == 'ADMINISTRADOR' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?> 

        <a class="collapse-item" href="../recursos_humanos/recursos_humanos.php">RECURSOS HUMANOS</a>
    <!--<a class="collapse-item" href="../recursos_humanos/recursos_humanos_nal.php">RECURSOS HUMANOS</a>-->
        <a class="collapse-item" href="../recursos_humanos/nuevo_personal.php">NUEVO PERSONAL</a>
        <a class="collapse-item" href="../recursos_humanos/buscar_personal.php">BUSCAR PERSONAL</a>
        <a class="collapse-item" href="../recursos_humanos/personal_municipio.php">PERSONAL</br>POR MUNICIPIO</a>
        <a class="collapse-item" href="../recursos_humanos/reportes_personal.php">REPORTES PERSONAL</a>


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
    if ($row_menu[0] == 'ADM-MUNICIPAL' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?> 

    <a class="collapse-item" href="../recursos_humanos/valida_personal_mun.php">RECURSOS HUMANOS</br>MUNICIPIO</a>
    <a class="collapse-item" href="../recursos_humanos/nuevo_personal_mun.php">NUEVO PERSONAL</br>MUNICIPIO</a>
    <a class="collapse-item" href="../recursos_humanos/personal_municipio.php">PERSONAL</br>POR MUNICIPIO</a>
    <a class="collapse-item" href="../recursos_humanos/reportes_personal.php">REPORTES PERSONAL</a>

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
        <i class="fas fa-map"></i>
        <span>COBERTURA SAFCI</span>
    </a>
    <div id="coberturaSafci" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">ELEGIR:</h6>
            <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR' || $row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?> 
            <a class="collapse-item" href="../recursos_humanos/redes_salud.php">REDES DE SALUD</a>
            <a class="collapse-item" href="../recursos_humanos/establecimientos_salud.php">ESTABLECIMIENTOS </br> DE SALUD NACIONAL</a>
    <!----- <a class="collapse-item" href="../recursos_humanos/establecimientos_salud_nal.php">ESTABLECIMIENTOS </br> DE SALUD NACIONAL</a> -->
            <a class="collapse-item" href="../recursos_humanos/areas_influencia.php">ÁREAS DE INFLUENCIA</br>NACIONAL</a>
    <!----- <a class="collapse-item" href="../recursos_humanos/areas_influencia_nal.php">ÁREAS DE INFLUENCIA </br> NACIONAL</a> --->
            <a class="collapse-item" href="../recursos_humanos/valida_areas_influencia_municipio.php">ÁREAS DE INFLUENCIA</br>MUNICIPIO</a>
            <a class="collapse-item" href="../recursos_humanos/valida_nueva_area_influencia_mun.php">NUEVA ÁREA</br>INFLUENCIA OPERATIVO</a>
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
    if ($row_menu[0] == 'ADMINISTRADOR' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>             
            <a class="collapse-item" href="../recursos_humanos/nuevo_establecimiento.php">NUEVO</br>ESTABLECIMIENTO</br>DE SALUD</a>
            <a class="collapse-item" href="../recursos_humanos/nueva_area_influencia.php">NUEVA ÁREA</br>INFLUENCIA</a>
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
    if ($row_menu[0] == 'ADM-MUNICIPAL' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>
            <a class="collapse-item" href="../recursos_humanos/nuevo_establecimiento.php">NUEVO</br>ESTABLECIMIENTO</br>DE SALUD</a>             
            <a class="collapse-item" href="../recursos_humanos/valida_establecimientos_municipio.php">ESTABLECIMIENTOS</br>MUNICIPIO</a>
          <!--  <a class="collapse-item" href="../recursos_humanos/valida_nuevo_establecimiento_mun.php">NUEVO</br>ESTABLECIMIENTO</br>MUNICIPIO</a>  -->
            <a class="collapse-item" href="../recursos_humanos/valida_areas_influencia_municipio.php">ÁREAS DE INFLUENCIA</br>MUNICIPIO</a>
          <!--  <a class="collapse-item" href="../recursos_humanos/valida_nueva_area_influencia_mun.php">NUEVA ÁREA</br>INFLUENCIA MUNICIPIO</a> -->
                   
    <?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>

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

            <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR' || $row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>   

            <a class="collapse-item" href="../sala_situacional/sala_personal_safci.php">PERSONAL SAFCI</a>
            <a class="collapse-item" href="../sala_situacional/sala_establecimientos.php">ESTABLECIMIENTOS</a>
            <a class="collapse-item" href="../sala_situacional/sala_areas_influencia.php">ÁREAS DE INFLUENCIA</a>
            <a class="collapse-item" href="../sala_situacional/mapas_safci.php">MAPAS SAFCI</a>

            <?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>


        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2"
        aria-expanded="true" aria-controls="collapseUtilities2">
        <i class="fas fa-clinic-medical"></i>   
        <span>IMPLEMENTACIÓN</br>SAFCI</span>
    </a>
    <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SAFCI:</h6>
            <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>           
        <!--    <a class="collapse-item" href="../implementacion_safci/notificaciones_vigilancia_ep_adm_nal.php">NOTIFICACIONES</br>VIGILANCIA</br>EPIDEMIOLÓGICA</br>NACIONAL</a> -->
            <a class="collapse-item" href="../implementacion_safci/notificaciones_vigilancia_ep_adm.php">NOTIFICACIONES</br>VIGILANCIA</br>EPIDEMIOLÓGICA</br>NACIONAL</a>
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
    if ($row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

            <a class="collapse-item" href="../implementacion_safci/valida_municipio_ep_op.php">NOTIFICACIONES</br>REGISTRADAS</br>OPERATIVO</a>
            <a class="collapse-item" href="../implementacion_safci/valida_nueva_notificacion_ep.php">NUEVA NOTIFICACIÓN</a>


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
    if ($row_menu[0] == 'ADM-MUNICIPAL' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

            <a class="collapse-item" href="../implementacion_safci/valida_municipio_ep.php">NOTIFICACIONES</br>ADMINISTRACIÓN</br>MUNICIPAL</a>

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
    if ($row_menu[0] == 'ADMINISTRADOR' || $row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL' || $row_menu[0] == 'USUARIO EXTERNO'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>   
    
        <a class="collapse-item" href="../implementacion_safci/reportes_notificacion_ep.php">VIGILANCIA</br>EPIDEMIOLÓGICA</a>
        <a class="collapse-item" href="../implementacion_safci/seguimiento_epidemiologico.php">SEGUIMIENTO</br>EPIDEMIOLÓGICO</a>

    <?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>     
        </div>
    </div>
</li>

<!---------- MODULO DE CARPETAS FAMILIARES ------------>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities5"
        aria-expanded="true" aria-controls="collapseUtilities5">
        <i class="fas fa-file"></i>   
        <span>CARPETAS FAMILIARES</span>
    </a>
    <div id="collapseUtilities5" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SAFCI:</h6>

    <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR' ||  $row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

    <!--    <a class="collapse-item" href="../carpetas_familiares/carpetas_familiares.php">CARPETAS FAMILIARES</a>  -->
        <a class="collapse-item" href="../carpetas_familiares/carpetas_familiares.php">CARPETAS FAMILIARES </br> OPERATIVO</a>
        <a class="collapse-item" href="../carpetas_familiares/carpetas_familiares_nal.php">REPORTES</br>CARPETAS FAMILIARES</a>
        <a class="collapse-item" href="../carpetas_familiares/nueva_carpeta_familiar.php">NUEVA CARPETA</br>FAMILIAR</a>
        <a class="collapse-item" href="../carpetas_familiares/analitica_cf.php">ANALITICA CARPETAS</br>FAMILIARES</a>

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
        if ($row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'ADMINISTRADOR' ){
        mysqli_field_seek($result_menu,0);
        while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

                <a class="collapse-item" href="../carpetas_familiares/valida_cf_mun.php">ADMINISTRAR</br>CARPETAS FAMILIARES</br>MUNICIPAL</a>
                <a class="collapse-item" href="../carpetas_familiares/reasignar_transferencia_cf.php">TRANSFERENCIA</br>CARPETAS FAMILIARES</a>
                 <a class="collapse-item" href="../carpetas_familiares/reasignar_transferencia_parcial_cf.php">TRANSFERENCIA</br>PARCIAL</br>CARPETAS FAMILIARES</a>
                <a class="collapse-item" href="../carpetas_familiares/reasignar_intercambio_cf.php">INTERCAMBIO</br>CARPETAS FAMILIARES</a>

    <?php
        } while ($row_menu = mysqli_fetch_array($result_menu));
        } else {
        }
    ?> 
        </div>
    </div>
</li>

<!------ MODULO DE SEGUIMIENTO FAMILIAR SAFCI ------->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities9"
        aria-expanded="true" aria-controls="collapseUtilities9">
        <i class="fas fa-file"></i>   
        <span>SEGUIMIENTO FAMILIAR</span>
    </a>
    <div id="collapseUtilities9" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SAFCI:</h6>

    <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR' ||  $row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>
    
        <a class="collapse-item" href="../seguimiento_familiar/planificador_visitas.php">PLANIFICADOR</br>DE VISITAS</a>
        <a class="collapse-item" href="../seguimiento_familiar/visitas_familiares.php">VISITAS FAMILIARES</a>
<!--  <a class="collapse-item" href="../seguimiento_familiar/comportamiento_familiar.php">SEGUIMIENTO</br>COMPORTAMIENTO</br>FAMILIAR</a>  --->
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
    if ($row_menu[0] == 'ADMINISTRADOR' ||  $row_menu[0] == 'ADM-MUNICIPAL' ){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>
    
        <a class="collapse-item" href="../seguimiento_familiar/reportes_vf.php">REPORTES VISITAS</a>
<?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>
        </div>
    </div>
</li>

<!------ MODULO DE PRODUCCION SE SERVICIOS SAFCI ------->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities10"
        aria-expanded="true" aria-controls="collapseUtilities10">
        <i class="fas fa-clipboard-list"></i>   
        <span>PRODUCCIÓN </br>  DE SERVICIOS</span>
    </a>
    <div id="collapseUtilities10" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">BENEFICIARIOS SAFCI:</h6>
            <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'ADMINISTRADOR' || $row_menu[0] == 'PERSONAL'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

        <a class="collapse-item" href="../produccion_servicios/personas_carpetizadas.php">PERSONAS</br>CARPETIZADAS</a>
        <a class="collapse-item" href="../produccion_servicios/valida_persona_ncf.php">ATENCIÓN PERSONA</br>NO CARPETIZADA</a> 
        
<?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>
    
    <a class="collapse-item" href="../produccion_servicios/atenciones_psafci.php">ATENCIONES</br>PSAFCI</a>

<?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

    <a class="collapse-item" href="../produccion_servicios/atenciones_nacional.php">ATENCIONES</br>NACIONAL</a>
<?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>

        </div>
    </div>
</li>

<!------ MODULO DE EVENTOS SAFCI NIVEL NACIONAL ------->

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3"
        aria-expanded="true" aria-controls="collapseUtilities2">
        <i class="fas fa-users"></i>   
        <span>EJECUCIÓN DE </br> EVENTOS SAFCI</span>
    </a>
    <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SECCIONES:</h6>
            <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR' || $row_menu[0] == 'ADM-MUNICIPAL'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>           
        <!--    <a class="collapse-item" href="../implementacion_safci/notificaciones_vigilancia_ep_adm_nal.php">NOTIFICACIONES</br>VIGILANCIA</br>EPIDEMIOLÓGICA</br>NACIONAL</a> -->
            <a class="collapse-item" href="../eventos_safci/eventos_safci_registrados.php">EVENTOS REGISTRADOS</a>
            <a class="collapse-item" href="../eventos_safci/nuevo_evento_safci.php">NUEVO EVENTO SAFCI</a>
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
    if ($row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL' || $row_menu[0] == 'ADMINISTRADOR'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

            <a class="collapse-item" href="../eventos_safci/eventos_safci_atencion.php">REGISTRO </br> ATENCIONES MÉDICAS</a>
<?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities7"
        aria-expanded="true" aria-controls="collapseUtilities7">
        <i class="fas fa-users"></i>   
        <span>PREVENCIÓN SAFCI</span>
    </a>
    <div id="collapseUtilities7" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SECCIONES:</h6>
            <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADMINISTRADOR'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>           
            <a class="collapse-item" href="../eventos_safci/nuevo_evento_vacunacion.php">NUEVO EVENTO</br>VACUNACIÓN</a>
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
    if ($row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'PERSONAL' || $row_menu[0] == 'ADMINISTRADOR'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

        <a class="collapse-item" href="../eventos_safci/eventos_vacunacion.php">EVENTOS</br>DE VACUNACION</a>
<?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>
   


   <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities8"
        aria-expanded="true" aria-controls="collapseUtilities8">
        <i class="fas fa-users"></i>   
        <span>GESTIÓN PARTICIPATIVA</span>
    </a>
    <div id="collapseUtilities8" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SECCIONES:</h6>
            <?php	
    $sql_menu = "SELECT perfil  from usuarios  where idusuario = '$idusuario_ss' and perfil = '$perfil_ss' ";
    $result_menu = mysqli_query($link,$sql_menu);
    $row_menu = mysqli_fetch_array($result_menu);
    /****** Seleccionamos el perfil del suaurio que accedera a las opciones de sistema ******/	
    if ($row_menu[0] == 'ADM-MUNICIPAL' || $row_menu[0] == 'ADMINISTRADOR'){
    mysqli_field_seek($result_menu,0);
    while ($field_menu = mysqli_fetch_field($result_menu)){
    } do {	?>

        <a class="collapse-item" href="../gestion_participativa/nueva_gestion_participativa.php">NUEVA DECLARACION</br>GESTIÓN PARTICIPATIVA</a>
        <a class="collapse-item" href="../gestion_participativa/declaraciones_gp.php">DECLARACIONES</br>MUNICIPALES</a>
<?php
    } while ($row_menu = mysqli_fetch_array($result_menu));
    } else {
    }
    ?>
<a class="collapse-item" href="../gestion_participativa/declaraciones_gp_info.php">INFORMACIÓN</br>GESTIÓN PARTICIPATIVA</a>
        </div>
    </div>
</li>



<!-- Divider -->
<hr class="sidebar-divider">


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

<!---- este es el menu de backuop ---->