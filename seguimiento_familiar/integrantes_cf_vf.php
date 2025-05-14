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

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);
          
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
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="card-body p-0">
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">                          
                    <a href="planificador_visitas.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">PLANIFICACIÓN DE VISITA FAMILIAR</h4>
                    <h4 class="text-secundary">CARPETA FAMILIAR : <?php echo $row_cf[1]; ?></h4>
                    <h4 class="text-info">FAMILIA : <?php echo $row_cf[2];?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->


                <div class="col-lg-12">  
                    <div class="p-2"> 

<!------- DATOS DEL AREA DE INFLUENCIA ---------->
              
                <div class="form-group row">   
                    <div class="col-sm-3">
                    <h6 class="text-info">FECHA DE APERTURA:</h6>
                    </div>
                    <div class="col-sm-3">                    
                    <input type="date" class="form-control" name="fecha_apertura" value="<?php echo $row_cf[3];?>" disabled>                
                    </div>    
                    <div class="col-sm-2">
                    <h6 class="text-info">FAMILIA:</h6>
                    </div>                        
                    <div class="col-sm-4">    
                    <input type="text" class="form-control" name="familia" value="<?php echo $row_cf[2];?>" disabled>                                
                    </div>
                </div>
            <hr>

            <div class="text-center">                                     
                <h4 class="text-info">INTEGRANTES:</h4>                    
            </div>
            <div class="text-center">                                                    
            <?php                                             
                $sql_r =" SELECT determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar FROM evaluacion_familiar_cf WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                $result_r = mysqli_query($link,$sql_r);
                $row_r = mysqli_fetch_array($result_r);

                if ($row_r[3] == 'FAMILIA CON RIESGO BAJO') {
                    echo "<h6 class='text-success'> ".$row_r[3]."</h6>";
                    echo "<h6 class='text-success'>- ".$row_r[0]."</h6>";
                    echo "<h6 class='text-success'>- ".$row_r[1]."</h6>";
                    echo "<h6 class='text-success'>- ".$row_r[2]."</h6>";
                } else {
                    if ($row_r[3] == 'FAMILIA CON RIESGO MEDIANO') {
                        echo "<h6 class='text-warning'> ".$row_r[3]."</h6>";
                        echo "<h6 class='text-warning'>- ".$row_r[0]."</h6>";
                        echo "<h6 class='text-warning'>- ".$row_r[1]."</h6>";
                        echo "<h6 class='text-warning'>- ".$row_r[2]."</h6>";
                    } else {
                        if ($row_r[3] == 'FAMILIA CON RIESGO ALTO') {
                            echo "<h6 class='text-danger'> ".$row_r[3]."</h6>";
                            echo "<h6 class='text-danger'>- ".$row_r[0]."</h6>";
                            echo "<h6 class='text-danger'>- ".$row_r[1]."</h6>";
                            echo "<h6 class='text-danger'>- ".$row_r[2]."</h6>";
                        } else { } } }
                    ?>                  
            </div>   
            
            <form name="PLANIFICACION" action="guarda_planificacion_vf.php" method="post">
            <input type="hidden" name="idintegrante_cf" value="idintegrante_cf_valor">
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-info">Nª</th>
                                    <th class="text-info">NOMBRES Y APELLIDOS</th>
                                    <th class="text-info">PARENTESCO</th>
                                    <th class="text-info">GÉNERO</th>
                                    <th class="text-info">EDAD</th>
                                    <th class="text-info">GRUPO(S) DE SALUD</th>
                                    <th class="text-info">DESCRIPCION</th>
                                    <th class="text-info">RIESGO PERSONAL/FRECUENCIA</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $numero=0;
                                    $sql4 =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.complemento, nombre.paterno, nombre.materno, nombre.nombre, parentesco.parentesco, genero.genero, ";
                                    $sql4.=" integrante_cf.edad, integrante_cf.estado, integrante_cf.idnombre, nombre.idgenero, nombre.fecha_nac FROM integrante_cf, nombre, parentesco, genero ";
                                    $sql4.=" WHERE integrante_cf.idnombre=nombre.idnombre AND integrante_cf.idparentesco=parentesco.idparentesco AND nombre.idgenero=genero.idgenero ";
                                    $sql4.=" AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.edad DESC ";
                                    $result4 = mysqli_query($link,$sql4);
                                    if ($row4 = mysqli_fetch_array($result4)){
                                    mysqli_field_seek($result4,0);
                                    while ($field4 = mysqli_fetch_field($result4)){
                                    } do { 
                                    ?>
                                    <tr>
                                    <td><?php echo $numero+1;?> 
                                    <input type="hidden" name="idintegrante_cf[<?php echo $numero;?>]" value="<?php echo $row4[0];?>">
                                    <input type="hidden" name="fecha_nac[<?php echo $numero;?>]" value="<?php echo $row4[12];?>"></td>
                                        <td><?php echo mb_strtoupper($row4[5]." ".$row4[3]." ".$row4[4]);?> </td>
                                        <td><?php echo $row4[6];?></td>
                                        <td><?php echo $row4[7];?></td>
                                        <td><?php echo $row4[8];?></td>
                                        <td><?php 
                                            $sql1 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_ap_sano, grupo_cf WHERE integrante_ap_sano.idgrupo_cf=grupo_cf.idgrupo_cf ";
                                            $sql1.="  AND integrante_ap_sano.idintegrante_cf='$row4[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                            $result1 = mysqli_query($link,$sql1);
                                            if ($row1 = mysqli_fetch_array($result1)){
                                            mysqli_field_seek($result1,0);
                                            while ($field1 = mysqli_fetch_field($result1)){
                                            } do { 
                                            ?>
                                                <?php echo "<h6 class='text-primary'>- ".$row1[1]."</h6>";?>
                                            <?php
                                            
                                            }
                                            while ($row1 = mysqli_fetch_array($result1));
                                            } else {
                                            }
                                            ?>
                                            <?php
                                            $sql2 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_factor_riesgo, grupo_cf WHERE integrante_factor_riesgo.idgrupo_cf=grupo_cf.idgrupo_cf ";
                                            $sql2.=" AND integrante_factor_riesgo.idintegrante_cf='$row4[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                            $result2 = mysqli_query($link,$sql2);
                                            if ($row2 = mysqli_fetch_array($result2)){
                                            mysqli_field_seek($result2,0);
                                            while ($field2 = mysqli_fetch_field($result2)){
                                            } do { 
                                            ?>
                                                <?php echo "<h6 class='text-warning'>- ".$row2[1]."</h6>";?>
                                            <?php
                                            }
                                            while ($row2 = mysqli_fetch_array($result2));
                                            } else {
                                            }
                                            ?>
                                            <?php
                                            $sql3 =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_morbilidad, grupo_cf WHERE integrante_morbilidad.idgrupo_cf=grupo_cf.idgrupo_cf  ";
                                            $sql3.="  AND integrante_morbilidad.idintegrante_cf='$row4[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                            $result3 = mysqli_query($link,$sql3);
                                            if ($row3 = mysqli_fetch_array($result3)){
                                            mysqli_field_seek($result3,0);
                                            while ($field3 = mysqli_fetch_field($result3)){
                                            } do { 
                                            ?>
                                                <?php echo "<h6 class='text-danger'>- ".$row3[1]."</h6>";?>
                                            <?php
                                            }
                                            while ($row3 = mysqli_fetch_array($result3));
                                            } else {
                                            }
                                            ?>
                                            <?php
                                            $sqld =" SELECT grupo_cf.idgrupo_cf, grupo_cf.grupo_cf FROM integrante_discapacidad, grupo_cf WHERE integrante_discapacidad.idgrupo_cf=grupo_cf.idgrupo_cf  ";
                                            $sqld.=" AND integrante_discapacidad.idintegrante_cf='$row4[0]' GROUP BY grupo_cf.idgrupo_cf ";
                                            $resultd = mysqli_query($link,$sqld);
                                            if ($rowd = mysqli_fetch_array($resultd)){
                                            mysqli_field_seek($resultd,0);
                                            while ($fieldd = mysqli_fetch_field($resultd)){
                                            } do { 
                                            ?>
                                                <?php echo "<h6 class='text-info'>- ".$rowd[1]."</h6>";?>
                                            <?php
                                            }
                                            while ($rowd = mysqli_fetch_array($resultd));
                                            } else {
                                            }
                                        ?>
                                        </td>
                                        <td><?php 
                                        $numeroa=1;
                                        $sqla =" SELECT idintegrante_ap_sano, integrante_ap_sano FROM integrante_ap_sano WHERE idintegrante_cf='$row4[0]' ";
                                        $resulta = mysqli_query($link,$sqla);
                                        if ($rowa = mysqli_fetch_array($resulta)){
                                        mysqli_field_seek($resulta,0);
                                        while ($fielda = mysqli_fetch_field($resulta)){
                                        } do { 
                                        ?>
                                        <?php echo "".$rowa[1];?>
                                        <?php
                                        $numeroa=$numeroa+1;
                                        }
                                        while ($rowa = mysqli_fetch_array($resulta));
                                        } else {
                                        }

                                        $numerob=1;
                                        $sqlb =" SELECT integrante_factor_riesgo.idintegrante_factor_riesgo, factor_riesgo_cf.factor_riesgo_cf,  ";
                                        $sqlb.=" factor_riesgo_cf.vulnerable, integrante_factor_riesgo.otro_factor_riesgo  FROM integrante_factor_riesgo, factor_riesgo_cf ";
                                        $sqlb.=" WHERE integrante_factor_riesgo.idfactor_riesgo_cf=factor_riesgo_cf.idfactor_riesgo_cf ";
                                        $sqlb.=" AND integrante_factor_riesgo.idintegrante_cf='$row4[0]' ";
                                        $resultb = mysqli_query($link,$sqlb);
                                        if ($rowb = mysqli_fetch_array($resultb)){
                                        mysqli_field_seek($resultb,0);
                                        while ($fieldb = mysqli_fetch_field($resultb)){
                                        } do { 
                                        ?>
                                          <?php echo "- ".$rowb[1];
                                          if ($rowb[2] == 'SI') { echo " - VULNERABLE"; } else { } ?>                    
                                          <?php  echo $rowb[3];?></br>
                                        <?php
                                        $numerob=$numerob+1;
                                        }
                                        while ($rowb = mysqli_fetch_array($resultb));
                                        } else {
                                        }

                                        $numeroc=1;
                                        $sqlc =" SELECT integrante_morbilidad.idintegrante_morbilidad, morbilidad_cf.morbilidad_cf, tipo_enfermedad_cf.tipo_enfermedad_cf, integrante_morbilidad.otra_enfermedad  ";
                                        $sqlc.=" FROM integrante_morbilidad, morbilidad_cf, tipo_enfermedad_cf WHERE integrante_morbilidad.idmorbilidad_cf=morbilidad_cf.idmorbilidad_cf ";
                                        $sqlc.=" AND morbilidad_cf.idtipo_enfermedad_cf=tipo_enfermedad_cf.idtipo_enfermedad_cf AND integrante_morbilidad.idintegrante_cf='$row4[0]' ";
                                        $resultc = mysqli_query($link,$sqlc);
                                        if ($rowc = mysqli_fetch_array($resultc)){
                                        mysqli_field_seek($resultc,0);
                                        while ($fieldc = mysqli_fetch_field($resultc)){
                                        } do { 
                                        ?>
                                            <?php echo $rowc[1];?> - <?php  echo $rowc[2];?> 
                                            <?php if ($rowc[3] != ' ') { echo " - ".$rowc[3]; } else { } ?> </br>
                                        <?php
                                        $numeroc=$numeroc+1;
                                        }
                                        while ($rowc = mysqli_fetch_array($resultc));
                                        } else {
                                        }

                                        $numerod=1;
                                        $sqld =" SELECT integrante_discapacidad.idintegrante_discapacidad, tipo_discapacidad_cf.tipo_discapacidad_cf, ";
                                        $sqld.=" nivel_discapacidad_cf.nivel_discapacidad_cf FROM integrante_discapacidad, tipo_discapacidad_cf, nivel_discapacidad_cf ";
                                        $sqld.=" WHERE integrante_discapacidad.idtipo_discapacidad_cf=tipo_discapacidad_cf.idtipo_discapacidad_cf ";
                                        $sqld.=" AND integrante_discapacidad.idnivel_discapacidad_cf=nivel_discapacidad_cf.idnivel_discapacidad_cf AND integrante_discapacidad.idintegrante_cf='$row4[0]' ";
                                        $resultd = mysqli_query($link,$sqld);
                                        if ($rowd = mysqli_fetch_array($resultd)){
                                        mysqli_field_seek($resultd,0);
                                        while ($fieldd = mysqli_fetch_field($resultd)){
                                        } do { 
                                        ?>
                                           <?php echo "- DISCAPACIDAD : ".$rowd[1];?> - <?php  echo $rowd[2];?></br>
                                        <?php
                                        $numerod=$numerod+1;
                                        }
                                        while ($rowd = mysqli_fetch_array($resultd));
                                        } else {
                                        }

                                        ?></td>
                                        <td> 
                                        <h6 class="text-info">RIÉSGO PERSONAL</h6>
                                        <select name="idriesgo_personal_vf[<?php echo $numero;?>]"  id="idriesgo_personal_vf" class="form-control" required>
                                            <option value="">ELEGIR</option>
                                            <?php
                                            $sql1 = "SELECT idriesgo_personal_vf, riesgo_personal_vf FROM riesgo_personal_vf ";
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
                                        </br>
                                        <h6 class="text-info">FRECUENCIA DE VISITA</h6>
                                        <select name="idfrecuencia_vf[<?php echo $numero;?>]"  id="idfrecuencia_vf" class="form-control" required>
                                            <option value="">ELEGIR</option>
                                            <?php
                                            $sql1 = "SELECT idfrecuencia_vf, frecuencia_vf FROM frecuencia_vf ";
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
                                        </td>
                                    </tr> 

                                    <?php
                                    $numero=$numero+1;
                                    }
                                    while ($row4 = mysqli_fetch_array($result4));
                                    } else {
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
             <!-------- DESCONSOLIDAR LISTA DE INTEGRANTES (Begin) --------->   
            
             <hr>
                      
<div class="form-group row">  
<div class="col-sm-4"></div> 
<div class="col-sm-4">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
    GUARDAR LA PLANIFICACIÓN DE VISITAS
    </button>  </div> 
<div class="col-sm-4"></div> 
</div> 
                        
            
   <!-- modal de confirmacion de envio de datos-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PLANIFICACIÓN DE VISITA FAMILIAR - SAFCI</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            
            Esta seguro de GUARDAR LA PLANIFICACIÓN DE VISITAS PARA ESTA FAMILIA?
        
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
        </div>
    </div>
</div>
</div>
</form>                
        <hr>
    <!-------- INGRESA NUEVO INTEGRANTE DE LA FAMILIA (End) --------->  

    
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

    <!-- scripts para uso de mapas -->

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

    
</body>
</html>