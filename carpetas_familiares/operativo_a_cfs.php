<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$semana     = date("W");
$gestion    =  date("Y");

$idusuario = $_GET["idusuario_op"];

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ANALITICA MEDICO OPERATIVO</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES DEL MÉDICO OPERATIVO :</h6>
                    </div>

                    <div class="card-header py-3">
                    <h6 class="text-info">CUADRO INFORMATIVO PARA SEGUIMIENTO</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-3">
                            <h6 class="text-info">TOTAL DE CARPETAS FAMILIARES:</h6>
                            <?php
                            $sql_f =" SELECT sum(familias) FROM area_influencia WHERE idusuario='$idusuario' ";   
                            $result_f = mysqli_query($link,$sql_f);
                            $row_f = mysqli_fetch_array($result_f);
                            $meta_cf = $row_f[0];

                            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar ";
                            $sql_cf.=" WHERE  estado='CONSOLIDADO' ";
                            $sql_cf.=" AND idusuario='$idusuario' ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $carpetizacion = $row_cf[0];

                            $porcentaje_op   = ($carpetizacion*100)/$meta_cf;
                            $p_operativo    = number_format($porcentaje_op, 2, '.', '');

                            ?>
                            <?php echo $carpetizacion;?>
                            <h6 class="text-info">De <?php echo $meta_cf;?> Familias</h6>
                            <h6 class="text-primary"><?php echo $p_operativo;?> %</h6>
                            </div>

                            <div class="col-sm-3">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php
                            $sql_h =" SELECT sum(habitantes) FROM area_influencia WHERE idusuario='$idusuario' ";   
                            $result_h = mysqli_query($link,$sql_h);
                            $row_h = mysqli_fetch_array($result_h);

                            $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar  ";
                            $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO'  ";
                            $sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
                            $result_int = mysqli_query($link,$sql_int);
                            $row_int = mysqli_fetch_array($result_int);  
                            $integrantes = $row_int[0];

                            $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                            $integrantes_meta = number_format($row_h[0], 0, '.', '.');

                            $porcentaje_hab   = ($integrantes*100)/$row_h[0];
                            $p_habitantes = number_format($porcentaje_hab, 2, '.', ' ');
                            ?>
                            <?php echo $integrantes_cf;?> 
                            <h6 class="text-info">De <?php echo $integrantes_meta;?> Habitantes</h6>
                            <h6 class="text-primary"><?php echo $p_habitantes;?> %</h6>
                            </div>
                            <div class="col-sm-6">
                            <h6 class="text-info">PERSONAL SAFCI REGISTRADOR:</h6>
                            <?php
                                $numero = 1;
                                $sql =" SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idusuario='$idusuario' GROUP BY idusuario ";   
                                $result = mysqli_query($link,$sql);
                                if ($row = mysqli_fetch_array($result)){
                                mysqli_field_seek($result,0);
                                while ($field = mysqli_fetch_field($result)){
                                } do {
                                    $sql_p =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[0]'  ";
                                    $result_p = mysqli_query($link,$sql_p);
                                    $row_p = mysqli_fetch_array($result_p);
                                  
                                    echo mb_strtoupper("<h6 class='text-info'>".$numero.".- ". $row_p[0]." ".$row_p[1]." ".$row_p[2]."</h6>");

                                    $sql_af =" SELECT tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM tipo_area_influencia, area_influencia, carpeta_familiar  WHERE carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia";   
                                    $sql_af.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idusuario='$row[0]' GROUP BY area_influencia.area_influencia ";
                                    $result_af = mysqli_query($link,$sql_af);
                                    if ($row_af = mysqli_fetch_array($result_af)){
                                    mysqli_field_seek($result_af,0);
                                    while ($field_af = mysqli_fetch_field($result_af)){
                                    } do {  ?>

                                        <h6 class="text-info"><?php echo mb_strtoupper(" - ". $row_af[0]." ".$row_af[1]);?></h6>

                                        <?php
                                    }
                                    while ($row_af = mysqli_fetch_array($result_af));
                                    } else {
                                    }

                                    echo "</br>";

                                    $numero = $numero+1;
                                }
                                while ($row = mysqli_fetch_array($result));
                                } else {
                                }
                            ?>
                            <h6></h6>
                            </div>
                        </div>   
                    </div>
                </div>    
                     
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">I. POBLACIÓN DE COBERTURA:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL </h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">II. IDIOMA DE LAS FAMILIAS:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="idioma_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=850,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">IDIOMA </h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (a). ESTADO CIVIL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estado_civil_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTADO CIVIL</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (b). NIVEL DE INSTRUCCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_nivel_instruccion_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=660,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">NIVEL DE INSTRUCCIÓN</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (c). PROFESIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_profesion_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROFESIÓN</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (d). OCUPACIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ocupacion_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">OCUPACIÓN</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (e). AUTO-PERTENENCIA CULTURAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_pertenencia_cultural_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AUTO-PERTENENCIA CULTURAL</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (f). SUSTENTO FAMILIAR:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_sustento_familiar_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUSTENTO FAMILIAR</h6></a>  
                        </div>
                    </div>    

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">II. UBICACIÓN GEOGRÁFICA DE LAS FAMILIAS:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="ubicacion_familias_medico.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">UBICACIÓN GEOGRÁFICA DE LAS FAMILIAS </h6></a>  
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">V. SALUD DE LOS INTEGRANTES DE LA FAMILIA :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="salud_integrantes_grafica_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">GRUPOS DE SALUD FAMILIAR  </h6></a>  
                        </div>
                    </div>
                 <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VI. SUBSECTOR SALUD - MÉDICO OPERATIVO:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_subsector_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=1000,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUBSECTOR SALUD </h6></a>  
                        </div>
                    </div>
                       <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VII. BENEFICIARIOS DE PROGRAMAS SOCIALES:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_programa_social_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=760,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROGRAMAS SOCIALES </h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VIII. MEDICINA TRADICIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_medicina_tradicional_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=780,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">MEDICINA TRADICIONAL </h6></a>  
                        </div>
                    </div>
                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IX. DEFUNCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_defuncion_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=780,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">DEFUNCIÓN </h6></a>  
                        </div>
                    </div>
                </div>

               <div class="card-body">
                   


               <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XI. DETERMINANTES DE LA SALUD</h6>
                        </div>
                        <div class="col-sm-6">
                         
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">SERVICIOS BÁSICOS</h6> 
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_op_1.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Abastecimiento de agua para consumo</h6></a>  
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_op_2.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Manejo de la Basura</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_op_3.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Uso de servicio higienico o baño</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_op_4.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Eliminación de escretas</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_op_5.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Iluminación de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_op_6.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Combustible para cocinar</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_op_7.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Acceso a comunicación</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">ESTRUCTURA DE LA VIVIENDA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_1.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tipo de vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_2.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Techo de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_3.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Paredes de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_4.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Pisos de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_5.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Revoque en las paredes interiores</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_6.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Tiene cuarto solo para cocinar</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_7.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Riésgos externos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_op_8.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">h) Riésgos internos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_op_1.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tenencia de la vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_op_2.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Índice de hacinamiento</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_op_3.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Tenencia de animales en la vivienda</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">SALUD ALIMENTARIA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_op_1.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Grados de la seguridad alimentaria:</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_op_2.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Consumo diario de alimentos</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-8">
                        <a href="riesgo_determinante_salud_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">RIÉSGO DE LAS DETERMINANTES DE LA SALUD </h6></a>  
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XII. CARACTERÍSTICAS SOCIOECONÓMICAS</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_socioeconomica_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SOCIOECONOMÍA DE LOS HOGARES </h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIII. TENENCIA DE ANIMALES DOMÉSTICOS DE COMPAÑÍA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_tenencia_animales_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANIMALES DOMESTICOS EN CADA HOGAR </h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. ESTRUCTURA FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estructura_familiar_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA FAMILIAR </h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XV. ETAPA DEL CICLO VITAL FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ciclo_vital_familiar_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">CICLO VITAL FAMILIAR </h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVI. FUNCIONALIDAD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_funcionalidad_cf_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=1000,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD FAMILIAR </h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVIII. FORMA DE AYUDA FAMILIAR NECESARIA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ayuda_familiar_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AYUDA FAMILIAR NECESARIA </h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. EVALUACIÓN DE SALUD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_salud_familiar_op.php?idusuario=<?php echo $idusuario;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=620,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">EVALUACIÓN SALUD FAMILIAR </h6></a>  
                        </div>
                    </div> 
                    </div>
   

                </div>
                <!-- End Page Content -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>