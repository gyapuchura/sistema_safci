<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

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
                <div class="container-fluid">

                    <!-- Page Heading -->

                    <h1 class="h3 mb-2 text-gray-800">ANALÍTICA DE CARPETAS FAMILIARES SAFCI</h1>
                    <p class="mb-4">En esta seccion se puede encontrar los resultados de los registros de CARPETAS FAMILIARES del PROGRAMA NACIONAL SAFCI - MI SALUD.</p>

                    <!-- Analitica de Carpetas Familiares -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL DE ESTABLECIMIENTO</h6>
                    </div>
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT ubicacion_cf.iddepartamento, departamento.departamento FROM ubicacion_cf, departamento ";
                            $sql1.= " WHERE ubicacion_cf.iddepartamento=departamento.iddepartamento GROUP BY ubicacion_cf.iddepartamento ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">MUNICIPIO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idmunicipio_salud" id="idmunicipio_salud" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_salud" id="idestablecimiento_salud" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                    <div class="card-body" id="establecimiento_a_cf">                    
                    </div>
                    </div>

                 <!-- ANALITICA A NIVEL DE AREA DE INFLUENCIA BEGIN -->

                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL DE ÁREA DE INFLUENCIA</h6>
                    </div>
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_af"  id="iddepartamento_af" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT ubicacion_cf.iddepartamento, departamento.departamento FROM ubicacion_cf, departamento ";
                            $sql1.= " WHERE ubicacion_cf.iddepartamento=departamento.iddepartamento GROUP BY ubicacion_cf.iddepartamento ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">MUNICIPIO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idmunicipio_af" id="idmunicipio_af" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idestablecimiento_af" id="idestablecimiento_af" class="form-control" required></select>
                    </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">ÁREA DE INFLUENCIA:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idarea_influencia_af" id="idarea_influencia_af" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                    <div class="card-body" id="area_influencia_a_cf">                    
                    </div>
                    </div>

              
                <!-- ANALITICA A NIVEL MUNICIPAL BEGIN -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL DE MUNICIPIO</h6>
                    </div>
           
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_m"  id="iddepartamento_m" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT ubicacion_cf.iddepartamento, departamento.departamento FROM ubicacion_cf, departamento ";
                            $sql1.= " WHERE ubicacion_cf.iddepartamento=departamento.iddepartamento GROUP BY ubicacion_cf.iddepartamento ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">MUNICIPIO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idmunicipio_salud_m" id="idmunicipio_salud_m" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                    <div class="card-body" id="municipio_a_cf">                    
                    </div>
                    </div>

                <!-- ANALITICA A NIVEL MUNICIPAL END -->

                <!-- ANALITICA POR RED DE SALUD - BEGIN -->
                
      <!--          <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES POR RED DE SALUD</h6>
                    </div>
           
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="iddepartamento_red"  id="iddepartamento_red" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT ubicacion_cf.iddepartamento, departamento.departamento FROM ubicacion_cf, departamento ";
                            $sql1.= " WHERE ubicacion_cf.iddepartamento=departamento.iddepartamento GROUP BY ubicacion_cf.iddepartamento ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">RED DE SALUD:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="idred_salud_cf" id="idred_salud_cf" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                    <div class="card-body" id="red_salud_a_cf">                    
                    </div>
                    </div>  -->

                <!-- ANALITICA POR RED DE SALUD - END -->
       
                       <!-- ANALITICA A N9VEL DEPARTAMENTAL BEGIN -->

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL DEPARTAMENTAL</h6>
                    </div>
 
                    <form name="DEPTAL" action="departamento_a_cf.php" method="post"> 
                    
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">DEPARTAMENTO:</h6>
                        </div>
                        <div class="col-sm-9">
                        <select name="departamento_d"  id="departamento_d" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = " SELECT ubicacion_cf.iddepartamento, departamento.departamento FROM ubicacion_cf, departamento ";
                            $sql1.= " WHERE ubicacion_cf.iddepartamento=departamento.iddepartamento GROUP BY ubicacion_cf.iddepartamento ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">     
                        </div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">VER ANALITICA DEPARTAMENTAL</button>
                            </form>
                        </div>
                    </div> 

                </div>
                </div>
                <!-- ANALITICA A N9VEL DEPARTAMENTAL END -->
             

                       <!-- ANALITICA A N9VEL NACIONAL BEGIN -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES A NIVEL NACIONAL</h6>
                    </div>


                    <div class="card-header py-3">
                    <h6 class="text-info">CUADRO INFORMATIVO PARA SEGUIMIENTO</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-2">
                            <h6 class="text-info">TOTAL DE CARPETAS FAMILIARES:</h6>
                            <?php
                            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO'  ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $total_cf = $row_cf[0];
                            ?>
                            <?php echo $total_cf;?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE MUNICIPIOS:</h6>
                            <?php
                            $sql_p = " SELECT idmunicipio FROM ubicacion_cf WHERE ubicacion_actual='SI' GROUP BY idmunicipio ";
                            $result_p = mysqli_query($link,$sql_p);
                            $municipios = mysqli_num_rows($result_p);  
                            ?>
                            <?php echo $municipios;?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE ESTABLECIMIENTOS DE SALUD:</h6>
                            <?php
                            $sql_mun =" SELECT idestablecimiento_salud FROM ubicacion_cf WHERE ubicacion_actual='SI' GROUP BY idestablecimiento_salud ";
                            $result_mun = mysqli_query($link,$sql_mun);
                            $establecimientos = mysqli_num_rows($result_mun);  
                            ?>
                            <?php echo $establecimientos;?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php
                            $sql_int =" SELECT count(idintegrante_cf) FROM integrante_cf WHERE estado='CONSOLIDADO' ";
                            $result_int = mysqli_query($link,$sql_int);
                            $row_int = mysqli_fetch_array($result_int);  
                            $integrantes = $row_int[0];
                            ?>
                            <?php echo $integrantes;?> 
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE PERSONAL SAFCI REGISTRADOR:</h6>

                            <?php
                            $sql_per = " SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' GROUP BY idusuario ";
                            $result_per = mysqli_query($link,$sql_per);
                            $personal = mysqli_num_rows($result_per);  
                            ?>
                            <?php echo $personal;?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>   
                    </div>
                </div>

                  
                <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">I. POBLACIÓN NIVEL NACIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_nal.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (a). ESTADO CIVIL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estado_civil_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTADO CIVIL</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (b). NIVEL DE INSTRUCCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_nivel_instruccion_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">NIVEL DE INSTRUCCIÓN</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (c). AUTO-PERTENENCIA CULTURAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_pertenencia_cultural_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AUTO-PERTENENCIA CULTURAL</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (d). SUSTENTO FAMILIAR:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_sustento_familiar_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUSTENTO FAMILIAR</h6></a>  
                        </div>
                    </div>

                </div>
                
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">V. SALUD DE LOS INTEGRANTES DE LA FAMILIA:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="salud_integrantes_grafica.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">GRUPOS DE SALUD FAMILIAR</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VI. SUBSECTOR SALUD:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_subsector_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUBSECTOR SALUD</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VII. BENEFICIARIOS DE PROGRAMAS SOCIALES:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_programa_social_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROGRAMAS SOCIALES</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VIII. MEDICINA TRADICIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_medicina_tradicional_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">MEDICINA TRADICIONAL</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IX. DEFUNCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_defuncion_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">DEFUNCIÓN</h6></a>  
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XI. DETERMINANTES DE LA SALUD - NACIONAL</h6>
                        </div>
                        <div class="col-sm-6">
                         
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">SERVICIOS BÁSICOS - NACIONAL</h6> 
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_1.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Abastecimiento de agua para consumo</h6></a>  
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_2.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Manejo de la Basura</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_3.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Uso de servicio higienico o baño</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_4.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Eliminación de escretas</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_5.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Iluminación de la vivienda </h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_6.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Combustible para cocinar</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_7.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Acceso a comunicación</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">ESTRUCTURA DE LA VIVIENDA - NACIONAL</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_1.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tipo de vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_2.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Techo de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_3.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Paredes de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_4.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Pisos de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_5.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Revoque en las paredes interiores</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_6.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Tiene cuarto solo para cocinar</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_7.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Riésgos externos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_8.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">h) Riésgos internos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA - NACIONAL</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_1.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tenencia de la vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_2.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Índice de hacinamiento</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_3.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Tenencia de animales en la vivienda</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">SALUD ALIMENTARIA - NACIONAL</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_1.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Grados de la seguridad alimentaria:</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_2.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Consumo diario de alimentos</h6></a>  
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XII. CARACTERÍSTICAS SOCIOECONÓMICAS</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_socioeconomica_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SOCIOECONOMÍA DE LOS HOGARES</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIII. TENENCIA DE ANIMALES DOMÉSTICOS DE COMPAÑÍA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_tenencia_animales_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANIMALES DOMESTICOS EN CADA HOGAR</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. ESTRUCTURA FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estructura_familiar_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA FAMILIAR</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XV. ETAPA DEL CICLO VITAL FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ciclo_vital_familiar_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">CICLO VITAL FAMILIAR</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVI. FUNCIONALIDAD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_funcionalidad_cf.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=1000,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD FAMILIAR</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVIII. FORMA DE AYUDA FAMILIAR NECESARIA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ayuda_familiar.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AYUDA FAMILIAR NECESARIA</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. EVALUACIÓN DE SALUD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_salud_familiar.php" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=620,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">EVALUACIÓN SALUD FAMILIAR</h6></a>  
                        </div>
                    </div>

                    </div>
                </div>
            </div>
                <!-- ANALITICA A NIVEL NACIONAL END -->

            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Ministerio de Salud y Deportes &copy; MSYD 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <a class="btn btn-primary" href="salir.php">Salir de Sistema</a>
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
    <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("municipio_cf.php", {departamento:departamento}, function(data){
                    $("#idmunicipio_salud").html(data);
                    });
                });
        })
        });
    </script> 

    <script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud").change(function () {
                    $("#idmunicipio_salud option:selected").each(function () {
                        municipio_salud=$(this).val();
                    $.post("establecimientos_cf.php", {municipio_salud:municipio_salud}, function(data){
                    $("#idestablecimiento_salud").html(data);
                    });
                });
        })
        });
    </script>

<script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_salud").change(function () {
                    $("#idestablecimiento_salud option:selected").each(function () {
                        establecimiento_salud=$(this).val();
                    $.post("establecimiento_a_cf.php", {establecimiento_salud:establecimiento_salud}, function(data){
                    $("#establecimiento_a_cf").html(data);
                    });
                });
        })
        });
</script>

<script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_m").change(function () {
                    $("#iddepartamento_m option:selected").each(function () {
                        departamento_m=$(this).val();
                    $.post("municipio_cfa.php", {departamento_m:departamento_m}, function(data){
                    $("#idmunicipio_salud_m").html(data);
                    });
                });
        })
        });
</script> 


<script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_red").change(function () {
                    $("#iddepartamento_red option:selected").each(function () {
                        departamento_red=$(this).val();
                    $.post("red_salud_cf.php", {departamento_red:departamento_red}, function(data){
                    $("#idred_salud_cf").html(data);
                    });
                });
        })
        });
</script> 

<script language="javascript">
        $(document).ready(function(){
        $("#idred_salud_cf").change(function () {
                    $("#idred_salud_cf option:selected").each(function () {
                        red_salud_cf=$(this).val();
                    $.post("red_salud_a_cf.php", {red_salud_cf:red_salud_cf}, function(data){
                    $("#red_salud_a_cf").html(data);
                    });
                });
        })
        });
</script>



<script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_salud_m").change(function () {
                    $("#idmunicipio_salud_m option:selected").each(function () {
                        municipio_salud_m=$(this).val();
                    $.post("municipio_a_cf.php", {municipio_salud_m:municipio_salud_m}, function(data){
                    $("#municipio_a_cf").html(data);
                    });
                });
        })
        });
</script>

<!---------- Scripts para CFs por area de influencia Begin ---------->

<script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento_af").change(function () {
                    $("#iddepartamento_af option:selected").each(function () {
                        departamento_af=$(this).val();
                    $.post("municipio_af.php", {departamento_af:departamento_af}, function(data){
                    $("#idmunicipio_af").html(data);
                    });
                });
        })
        });
</script> 

<script language="javascript">
        $(document).ready(function(){
        $("#idmunicipio_af").change(function () {
                    $("#idmunicipio_af option:selected").each(function () {
                        municipio_af=$(this).val();
                    $.post("establecimientos_af.php", {municipio_af:municipio_af}, function(data){
                    $("#idestablecimiento_af").html(data);
                    });
                });
        })
        });
</script>

<script language="javascript">
        $(document).ready(function(){
        $("#idestablecimiento_af").change(function () {
                    $("#idestablecimiento_af option:selected").each(function () {
                        establecimiento_af=$(this).val();
                    $.post("areas_influencia_af.php", {establecimiento_af:establecimiento_af}, function(data){
                    $("#idarea_influencia_af").html(data);
                    });
                });
        })
        });
</script>

<script language="javascript">
        $(document).ready(function(){
        $("#idarea_influencia_af").change(function () {
                    $("#idarea_influencia_af option:selected").each(function () {
                        area_influencia_af=$(this).val();
                    $.post("area_influencia_a_cf.php", {area_influencia_af:area_influencia_af}, function(data){
                    $("#area_influencia_a_cf").html(data);
                    });
                });
        })
        });
</script>

<!---------- Scripts para CFs por area de influencia End  ---------->
</body>
</html>