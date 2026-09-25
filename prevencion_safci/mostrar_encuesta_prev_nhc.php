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

$idencuesta_psafci_ss       = $_SESSION['idencuesta_psafci_ss'];
$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnombre_paciente_ss       = $_SESSION['idnombre_paciente_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_paciente_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);
        
$sql_enc =" SELECT idencuesta_psafci, idrepeticion, idtipo_consulta, idtema_encuesta, codigo, idclasificacion_riesgo_cancer, fecha_registro FROM encuesta_psafci WHERE idencuesta_psafci='$idencuesta_psafci_ss' ";
$result_enc=mysqli_query($link,$sql_enc);
$row_enc=mysqli_fetch_array($result_enc);

$sql_ps =" SELECT idatencion_psafci, idrepeticion, idtipo_consulta, idtipo_atencion, codigo, fecha_registro FROM atencion_psafci WHERE idatencion_psafci='$idatencion_psafci_ss' ";
$result_ps=mysqli_query($link,$sql_ps);
$row_ps=mysqli_fetch_array($result_ps);

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
                    <a href="encuestas_prevencion.php"><h6 class="text-info"><- VOLVER</h6></a>
                    <hr>             
                    <h4 class="text-info">ENCUESTA MÉDICA</h4>
                    <h4 class="text-secundary"><?php echo $row_enc[4]?></h4>
                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
                </div>
                <div class="card-body">

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_n[4];?>" 
                         name="ci" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">NOMBRES:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[1];?>"
                         name="nombre" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[2];?>"             
                         name="paterno" disabled >                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[3];?>" 
                         name="materno" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-info">GÉNERO</h6>

                    <select name="idgenero"  id="idgenero" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idgenero, genero FROM genero ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_n[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>

                    </div>  
                    <div class="col-sm-3">
                    <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" 
                            placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                    </div>   
                    
                    <div class="col-sm-2">
                    <h6 class="text-info">EDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $edad_ss;?>" 
                         name="edad_actual" disabled>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">HISTORIA CLÍNICA:</h6>
                            <a class="btn btn-info btn-icon-split" href="../produccion_servicios/imprime_historia_clinica_ps.php?idnombre_integrante=<?php echo $idnombre_paciente_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="text">HISTORIA CLÍNICA</span></a>    
                    </div>
                </div>  

    <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->  
             
            </div>
        </div>

    
        <!-- VENTANA DE ENCUESTA INTEGRAL ---->

        <hr>
    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ENCUESTA PREVENTIVA:</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">4.- ENCUESTA MÉDICA</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">    
                <div class="col-sm-12">
                <h6 class="text-info">TEMA DE LA ENCUESTA:</h6>

                <select name="idtema_encuesta" id="idtema_encuesta" class="form-control" disabled>
                <option selected>Seleccione</option>
                <?php
                $sqlv = " SELECT idtema_encuesta, tema_encuesta FROM tema_encuesta ";
                $resultv = mysqli_query($link,$sqlv);
                if ($rowv = mysqli_fetch_array($resultv)){
                mysqli_field_seek($resultv,0);
                while ($fieldv = mysqli_fetch_field($resultv)){
                } do {
                ?>
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_enc[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                <?php
                } while ($rowv = mysqli_fetch_array($resultv));
                } else {
                }
                ?>
            </select>

                </div>
            </div>


<!---------------------------------------------------------------->
<!------------- ENCUESTA PREVENTIVA - BEGIN ---------------------->
<!---------------------------------------------------------------->


    <div class="form-group row">  
    <div class="col-sm-6">
        <h6 class="text-info">INCIDENCIA DE LA ENCUESTA:</h6>
        <?php
        $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
        $result_i = mysqli_query($link,$sql_i);
        if ($row_i = mysqli_fetch_array($result_i)){
        mysqli_field_seek($result_i,0);
        while ($field_i = mysqli_fetch_field($result_i)){
        } do { 
        ?>

        <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>"
        <?php if ($row_i[0] == $row_ps[1]) { echo "checked";} else { } ?> disabled> </br>

        <?php }
        while ($row_i = mysqli_fetch_array($result_i));
        } else { } ?>
        </div>

        <div class="col-sm-6">
        <h6 class="text-info">LUGAR DE LA ENCUESTA:</h6>
        <?php
        $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
        $result_c = mysqli_query($link,$sql_c);
        if ($row_c = mysqli_fetch_array($result_c)){
        mysqli_field_seek($result_c,0);
        while ($field_c = mysqli_fetch_field($result_c)){
        } do { 
        ?>

        <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>"
        <?php if ($row_c[0] == $row_ps[2]) { echo "checked";} else { } ?> disabled> </br>

        <?php }
        while ($row_c = mysqli_fetch_array($result_c));
        } else { } ?>
        </div>
    </div>  
<?php
    $sql_sg =" SELECT idsigno_vital_psafci, frec_cardiaca, peso, talla, imc, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, perimetro_cefalico, alergia,  ";
    $sql_sg.="  descripcion_alergia FROM signo_vital_psafci WHERE idnombre ='$idnombre_paciente_ss  ' AND idatencion_psafci='$idatencion_psafci_ss' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
    $result_sg = mysqli_query($link,$sql_sg);
    if ($row_sg = mysqli_fetch_array($result_sg)){
    mysqli_field_seek($result_sg,0);           
    while ($field_sg = mysqli_fetch_field($result_sg)){
    } do {
?>
                <hr>
                <div class="text-center">                                     
                    <h6 class="text-info">SIGNOS VITALES:</h6>                    
                </div>
                <hr> 
                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA CARDIACA</br>[lpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[1];?>" 
                         name="frec_cardiaca" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PESO</br>[kg]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[2];?>"            
                         name="peso" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TALLA</br>[Centrimetros.]:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[3];?>"  
                         name="talla" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info"></br></h6>
               
                    </div>
                </div>

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[5];?>" 
                         name="frec_respiratoria" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PRESIÓN ARTERIAL </br>[mmHg]:</h6>

                     <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
                        <input type="text" class="form-control" value="<?php echo $row_sg[6]."/".$row_sg[7];?>"             
                         name="presion_arterial" disabled>   
                    <?php } else { echo 'MENOR DE 5 AÑOS';}?>    

                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[8];?>" 
                         name="temperatura" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-info">PERÍMETRO CEFÁLICO </br>[cm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[9];?>" 
                         name="saturacion" disabled>                
                    </div>
                </div>


           <?php
        }
        while ($row_sg = mysqli_fetch_array($result_sg));
        } else {
        }
        ?>

<!---------------------------------------------------------------->
<!------------- ENCUESTA RESPUESTAS - BEGINS  ------------------------>
<!---------------------------------------------------------------->
    <hr>

    <div class="form-group row">
        <div class="col-sm-12">
            <h6 class="text-info">RESPUESTAS A LAS PREGUNTAS DE LA ENCUESTA MÉDICA:</h6>
        </div>
    </div>

    <hr>

    <?php
        $numero=0;
        $sql5 =" SELECT pregunta_encuesta.idpregunta_encuesta, pregunta_encuesta.pregunta_encuesta, pregunta_encuesta.pregunta_complementaria, ";
        $sql5.=" respuesta_encuesta.respuesta, respuesta_encuesta.retroalimentacion FROM pregunta_encuesta, respuesta_encuesta ";
        $sql5.=" WHERE respuesta_encuesta.idpregunta_encuesta=pregunta_encuesta.idpregunta_encuesta AND respuesta_encuesta.idencuesta_psafci='$idencuesta_psafci_ss' ";
        $result5 = mysqli_query($link,$sql5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do { 
    ?>
        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info">Respuesta <?php echo $numero+1;?></h6>
                <input type="hidden" name="idpregunta_encuesta[]" value="<?php echo $row5[0];?>">
            </div>
            <div class="col-sm-8">
                <h6 class="text-secundary"><?php echo $row5[1];?></h6>
            </div>
            <div class="col-sm-2">
                <h6 class="text-info">SI <input type="radio" name="respuesta[<?php echo $numero;?>]" value="SI" <?php if ($row5[3] == 'SI') { echo "checked";} else { } ?> disabled> 
                                      NO <input type="radio" name="respuesta[<?php echo $numero;?>]" value="NO" <?php if ($row5[3] == 'NO') { echo "checked";} else { } ?> disabled></h6>
            </div>        
        </div>

        <?php

        if ($row5[4] == '') { ?>

            <input type="hidden" class="form-control" name="retroalimentacion[<?php echo $numero;?>]" value="">
  
        <?php } else { ?>
            
        <div class="form-group row">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-3">
                <h6 class="text-secundary"><?php echo $row5[2];?></h6>
            </div>
            <div class="col-sm-5">
                <textarea class="form-control" rows="2" name="retroalimentacion[<?php echo $numero;?>]" disabled><?php echo $row5[4];?></textarea>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
      
        <?php }
        $numero = $numero+1;
        }
        while ($row5 = mysqli_fetch_array($result5));
        } else {
        } ?>
<hr>
        <div class="form-group row">
            <div class="col-sm-12">
                <h6 class="text-info">OBSERVACIONES Y DETERMINACIONES MÉDICAS</h6>
                
            </div>      
        </div>
<hr>
        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info"></h6>
            </div>
            <div class="col-sm-10">

    <?php
        $numero6=0;
        $sql6 =" SELECT seccion_encuesta.idseccion_encuesta, seccion_encuesta.seccion_encuesta FROM respuesta_item_cancer, item_senal_cancer, seccion_encuesta ";
        $sql6.=" WHERE respuesta_item_cancer.iditem_senal_cancer=item_senal_cancer.iditem_senal_cancer AND item_senal_cancer.idseccion_encuesta=seccion_encuesta.idseccion_encuesta ";
        $sql6.=" AND respuesta_item_cancer.idencuesta_psafci='$idencuesta_psafci_ss' GROUP BY seccion_encuesta.idseccion_encuesta ";  
        $result6 = mysqli_query($link,$sql6);
        if ($row6 = mysqli_fetch_array($result6)){
        mysqli_field_seek($result6,0);
        while ($field6 = mysqli_fetch_field($result6)){
        } do { 
    ?>

                <h6 class="text-info"><?php echo $row6[1];?></h6>

            <?php
                $numero7=0;
                $sql7 =" SELECT respuesta_item_cancer.idrespuesta_item_cancer, item_senal_cancer.item_senal_cancer FROM respuesta_item_cancer, item_senal_cancer ";
                $sql7.=" WHERE respuesta_item_cancer.iditem_senal_cancer=item_senal_cancer.iditem_senal_cancer AND item_senal_cancer.idseccion_encuesta='$row6[0]' ";
                $sql7.=" AND respuesta_item_cancer.idencuesta_psafci='$idencuesta_psafci_ss' ";
                $result7 = mysqli_query($link,$sql7);
                if ($row7 = mysqli_fetch_array($result7)){
                mysqli_field_seek($result7,0);
                while ($field7 = mysqli_fetch_field($result7)){
                } do { 
            ?>

                <h6 class="text-secundary"> - <?php echo $row7[1];?> -> <input type="checkbox" name="iditem_senal_cancer[]" value="" checked disabled></h6>

            <?php 
                $numero7 = $numero7+1;
                }
                while ($row7 = mysqli_fetch_array($result7));
                } else {
                } 
            ?>

    <?php 
        $numero6 = $numero6+1;
        }
        while ($row6 = mysqli_fetch_array($result6));
        } else {
        } 
    ?>
    
            </div>      
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-2">
                <h6 class="text-info">CLASIFICACIÓN</h6>
            </div>  
            <div class="col-sm-10">

                <select name="idclasificacion_riesgo_cancer" id="idclasificacion_riesgo_cancer" class="form-control" disabled>
                <option selected>Seleccione</option>
                <?php
                $sqlv = " SELECT idclasificacion_riesgo_cancer, clasificacion_riesgo_cancer FROM clasificacion_riesgo_cancer ";
                $resultv = mysqli_query($link,$sqlv);
                if ($rowv = mysqli_fetch_array($resultv)){
                mysqli_field_seek($resultv,0);
                while ($fieldv = mysqli_fetch_field($resultv)){
                } do {
                ?>
                <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_enc[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
                <?php
                } while ($rowv = mysqli_fetch_array($resultv));
                } else {
                }
                ?>
                </select>

            </div>    
        </div>

                <hr>

<!---------------------------------------------------------------->
<!------------- ENCUESTA RESPUESTAS - END  ------------------------>
<!---------------------------------------------------------------->

<!---------------------------------------------------------------->
<!------------- ENCUESTA PREVENTIVA - END  ------------------------>
<!---------------------------------------------------------------->

<hr>
    <div class="form-group row"> 
    <div class="col-sm-4"> 
    </div> 
    <div class="col-sm-4">
    
        <a class="btn btn-info btn-icon-split" href="../produccion_servicios/imprime_atencion_psafci.php?idatencion_psafci=<?php echo $idatencion_psafci_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=900,top=50, left=400, scrollbars=YES'); return false;">
        <span class="icon text-white-50">
            <i class="fas fa-book"></i>
        </span>
        <span class="text">IMPRIME ENCUESTA MÉDICA</span></a> 
    
    </div> 
    <div class="col-sm-4"> 
    </div> 
    </div>


<hr>

    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">OPCIONES ADICIONALES DE ENCUESTA</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
    <form name="ELIMINA_ENCUESTA" action="elimina_encuesta_psafci.php" method="post">  
    <div class="form-group row"> 
    <div class="col-sm-4"> 
        <input type="hidden" name="idencuesta_psafci" value="<?php echo $idencuesta_psafci_ss;?>" >
        <input type="hidden" name="idatencion_psafci" value="<?php echo $idatencion_psafci_ss;?>" >
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModald">
            ELIMINAR ENCUESTA MÉDICA
        </button> 
                <!--  MODAL DE ELIMINACION DE ENCUESTA MEDICA BEGIN ---->
            <div class="modal fade" id="exampleModald" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ELIMINAR DE ENCUESTA MÉDICA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de ELIMINAR la ENCUESTA MÉDICA?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>  
 <!--  MODAL DE ELIMINACION DE ENCUESTA MEDICA BEGIN ---->
    </div> 
    <div class="col-sm-4"> 
        <a href="encuestas_prevencion.php"><h6 class="text-success"><- IR A BANDEJA DE ENCUESTAS</h6></a>
    </div> 
    <div class="col-sm-4"> 

        <form action="validacion_nombre_integrante_ref.php" method="post">

            <button type="submit" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-hospital"></i>
            </span>
            <span class="text">REFERENCIA DEL PACIENTE</span>    
            </button>

        </form>

    </div> 
    </div> 


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

    <!-- scripts para uso de mapas -->

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>



</body>
</html>