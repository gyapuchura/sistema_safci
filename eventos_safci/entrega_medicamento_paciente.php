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

$idevento_safci_ss          = $_SESSION['idevento_safci_ss'];
$idnombre_paciente_ss       = $_SESSION['idnombre_paciente_ss'];
$idatencion_safci_ss        = $_SESSION['idatencion_safci_ss'];
$idespecialidad_atencion_ss = $_SESSION['idespecialidad_atencion_ss'];

$sql_ev =" SELECT idevento_safci, iddepartamento, idmunicipio, idestablecimiento_salud, codigo, idcat_evento_safci, ";
$sql_ev.=" idtipo_evento_safci, descripcion FROM evento_safci WHERE idevento_safci='$idevento_safci_ss' ";
$result_ev=mysqli_query($link,$sql_ev);
$row_ev=mysqli_fetch_array($result_ev);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_paciente_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);

$fecha_nacimiento = $row_n[5];
    $dia=date("d");
    $mes=date("m");
    $ano=date("Y");    
    $dianaz=date("d",strtotime($fecha_nacimiento));
    $mesnaz=date("m",strtotime($fecha_nacimiento));
    $anonaz=date("Y",strtotime($fecha_nacimiento));         
    if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); }      
    if ($mesnaz > $mes) {
    $ano=($ano-1);}       
    $edad=($ano-$anonaz);  

$sql_at =" SELECT idatencion_safci, codigo, edad FROM atencion_safci WHERE idatencion_safci='$idatencion_safci_ss' ";
$result_at=mysqli_query($link,$sql_at);
$row_at=mysqli_fetch_array($result_at);

$sql_sg =" SELECT idsigno_vital, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, temperatura, saturacion, combe, imc, presion_arterial_d, alergia, descripcion_alergia FROM signo_vital WHERE idatencion_safci ='$idatencion_safci_ss' ";
$result_sg=mysqli_query($link,$sql_sg);
$row_sg=mysqli_fetch_array($result_sg);

$sql_esp =" SELECT especialidad_medica.especialidad_medica, especialidad_atencion.anamnesis, especialidad_atencion.prediagnostico FROM especialidad_atencion, especialidad_medica WHERE especialidad_atencion.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
$sql_esp.=" AND especialidad_atencion.idespecialidad_atencion='$idespecialidad_atencion_ss'";
$result_esp=mysqli_query($link,$sql_esp);
$row_esp=mysqli_fetch_array($result_esp);
    
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
                    <a href="consultas_especialidad.php" class="text-info">VOLVER</a>                                            
                    <hr>    
                    <h4 class="text-info">ENTREGA DE MEDICAMENTOS</h4>      
                    <h4 class="text-muted"><?php echo $row_at[1];?></h4>
                    <h4 class="text-muted"><?php echo $row_esp[0];?></h4>

                    <hr> 
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">CÓDIGO EVENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $row_ev[4];?>"
                         name="evento" disabled> 
                    </div>
                    </div>
    
                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ev[1]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>

                    </div>
                </div>
   
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">MUNICIPIO DEL EVENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idmunicipio"  id="idmunicipio" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ev[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">ESTABLECIMIENTO DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" disabled >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ev[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>
    <!-------- begin NUEVO PACIENTE --------->   
                <hr>
                <div class="text-center">                                     
                    <h4 class="text-primary">DATOS PERSONALES:</h4>                    
                </div>
                <hr> 
                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-primary">CÉDULA DE IDENTIDAD:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_n[4];?>" 
                         name="ci" disabled>
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">NOMBRES:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[1];?>"
                         name="nombre" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[2];?>"             
                         name="paterno" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_n[3];?>" 
                         name="materno" disabled>                
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                    <h6 class="text-primary">GÉNERO</h6>

                    <select name="idgenero"  id="idgenero" class="form-control" disabled>
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
                    <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" 
                            placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                    </div>   
                    
                    <div class="col-sm-3">
                      <h6 class="text-primary">EDAD:</h6>
                        <input type="text" class="form-control" value="<?php echo $edad." [años]";?>" 
                         name="edad_actual" disabled> 
                    </div>
                    <div class="col-sm-3">
                    <!--- <h6 class="text-primary"> </h6>
                    <a href="modificar_paciente.php" class="text-info" >MODIFICAR DATOS PERSONALES</a> --->
                    </div>
                </div>  
              
                <hr>

                <!---------- DIAGNOSTICO MEDICO  BEGIN ------------->
                <div class="text-center">                                     
                    <h4 class="text-info">DIAGNÓSTICO MÉDICO:</h4>                    
                </div>
                <div class="form-group row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-info">Nª</th>
                            <th class="text-info">MOTIVO DE LA CONSULTA</th>
                            <th class="text-info">CIE</th>
                            <th class="text-info">DIAGNÓSTICO</th>                           
                            <th class="text-info">TRATAMIENTO</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                        $numero=1;
                        $sql4 =" SELECT diagnostico_atencion.iddiagnostico_atencion, patologia.patologia, patologia.cie, diagnostico_atencion.diagnostico_atencion, diagnostico_atencion.etapa, ";
                        $sql4.=" diagnostico_atencion.idpatologia FROM diagnostico_atencion, patologia WHERE diagnostico_atencion.idpatologia=patologia.idpatologia ";
                        $sql4.=" AND diagnostico_atencion.idespecialidad_atencion='$idespecialidad_atencion_ss' ORDER BY patologia.patologia ";
                        $result4 = mysqli_query($link,$sql4);
                        if ($row4 = mysqli_fetch_array($result4)){
                        mysqli_field_seek($result4,0);
                        while ($field4 = mysqli_fetch_field($result4)){
                        } do { 
                        ?>
                        <tr>
                            <td><?php echo $numero;?></td>
                            <td><?php echo $row4[3];?></td>
                            <td><?php echo $row4[2];?></td>
                            <td><?php echo $row4[1];?></td>
                            <td>
                            <?php
                if ($row4[4] == 'CON DIAGNOSTICO') {
                    ?>
                    <form name="TRATAMIENTO" action="valida_tratamiento_medico.php" method="post">
                    <input name="iddiagnostico_atencion" type="hidden" value="<?php echo $row4[0];?>">
                    <input name="idpatologia" type="hidden" value="<?php echo $row4[5];?>">
                        <button type="submit" class="btn btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-hospital"></i>
                        </span>
                        <span class="text">EMITIR TRATAMIENTO</span>    
                        </button>
                    </form>                     
                <?php
                } else {
                    ?>

                    <h6 class="text-info">CON TRATAMIENTO EMITIDO</h6>
                <?php
                }                
                ?>
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

<?php
$sql_t = "SELECT iddiagnostico_atencion, etapa FROM diagnostico_atencion WHERE etapa = 'CON DIAGNOSTICO' AND idespecialidad_atencion='$idespecialidad_atencion_ss' ";
$result_t = mysqli_query($link,$sql_t);
if ($row_t = mysqli_fetch_array($result_t)){
?>
<?php
} else {
    ?>
    <hr>
<div class="text-center">
 <a href="imprime_boleta_atencion.php?idatencion_safci=<?php echo $idatencion_safci_ss;?>&idespecialidad_atencion=<?php echo $idespecialidad_atencion_ss;?>" target="_blank" class="Estilo12" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=750,height=900,scrollbars=YES,top=60,left=400'); return false;">
        IMPRIME BOLETA DE ATENCION MÉDICA</a>  
<?php
}
?>
                <hr>
<!-- TABLA de ENTREGA DE MEDICAMENTOS (BEGIN) ---->


<div class="text-center">                                     
                    <h4 class="text-info">ENTREGA DE MEDICAMENTOS:</h4>                    
                </div>
                <div class="form-group row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-info">Nª</th>
                            <th class="text-info">TIPO</th>
                            <th class="text-info">MEDICAMENTO</th>                        
                            <th class="text-info">CANTIDAD</th>
                            <th class="text-info">CANTIDAD ENTREGADA</th>
                            <th class="text-info">INSUMO(S)</th>
                            <th class="text-info">INSUMOS(S) ENTREGADO(S)</th>
                            <th class="text-info">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                        $numero=1;
                        $sql5 =" SELECT tratamiento.idtratamiento, tipo_medicamento.tipo_medicamento, medicamento.medicamento, tratamiento.cantidad_recetada, tratamiento.indicacion, tratamiento.insumos ";
                        $sql5.=" FROM tratamiento, tipo_medicamento, medicamento WHERE tratamiento.idtipo_medicamento=tipo_medicamento.idtipo_medicamento AND ";
                        $sql5.=" tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.idespecialidad_atencion='$idespecialidad_atencion_ss' ";
                        $result5 = mysqli_query($link,$sql5);
                        if ($row5 = mysqli_fetch_array($result5)){
                        mysqli_field_seek($result5,0);
                        while ($field5 = mysqli_fetch_field($result5)){
                        } do { 
                        ?>
                        <tr>
                            <td><?php echo $numero;?></td>
                            <td><?php echo $row5[1];?></td>
                            <td><?php echo $row5[2];?></td>
                            <td><?php echo $row5[3];?></td>
                            <td>                        <input type="number" class="form-control"
                         name="saturacion" required> </td>
                            <td><?php echo $row5[5];?></td>
                            <td> </td>
                            <td> 
                            <form name="ENTREGA" action="guarda_entrega_medicamentos.php" method="post">
                                <input name="iddiagnostico_atencion" type="hidden" value="<?php echo $row5[0];?>">
                                <input name="idpatologia" type="hidden" value="<?php echo $row5[5];?>">
                                <button type="submit" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-hospital"></i>
                                </span>
                                <span class="text">GUARDAR</span>    
                                </button>
                            </form> 
                            </td>
                        </tr>                            
                        <?php
                        $numero=$numero+1;
                        }
                        while ($row5 = mysqli_fetch_array($result5));
                        } else {
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   



<!-- TABLA de ENTREGA DE MEDICAMENTOS (END) ---->
                </div>

<!-- END aqui va el comntenido de la pagina ---->

               
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

    <script type="text/javascript" src="../js/localizacion.js"></script>
    <script type="text/javascript" src="../js/initMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk&callback=initMap"></script>

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

    
</body>
</html>