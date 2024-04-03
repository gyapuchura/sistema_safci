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
$iddiagnostico_atencion_ss  = $_SESSION['iddiagnostico_atencion_ss'];
$idpatologia_ss             = $_SESSION['idpatologia_ss'];

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

$sql_sg =" SELECT idsigno_vital, frec_cardiaca, peso, talla, frec_respiratoria, presion_arterial, temperatura, saturacion, combe, imc FROM signo_vital WHERE idatencion_safci ='$idatencion_safci_ss' ";
$result_sg=mysqli_query($link,$sql_sg);
$row_sg=mysqli_fetch_array($result_sg);

$sql_esp =" SELECT especialidad_medica.especialidad_medica, especialidad_atencion.anamnesis, especialidad_atencion.prediagnostico FROM especialidad_atencion, especialidad_medica WHERE especialidad_atencion.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
$sql_esp.=" AND especialidad_atencion.idespecialidad_atencion='$idespecialidad_atencion_ss'";
$result_esp=mysqli_query($link,$sql_esp);
$row_esp=mysqli_fetch_array($result_esp);

$sql_pat =" SELECT idpatologia, patologia, cie FROM patologia WHERE idpatologia='$idpatologia_ss' ";
$result_pat=mysqli_query($link,$sql_pat);
$row_pat=mysqli_fetch_array($result_pat);
    
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
                    <a href="tratamiento_especialidad_paciente.php" class="text-info">VOLVER</a>                                            
                    <hr>          
                    <h4 class="text-secundary">CONSULTA: <?php echo $row_at[1];?></h4>
                    <h4 class="text-secundary"><?php echo $row_esp[0];?></h4>
                    <h4 class="text-info">TRATAMIENTO MÉDICO</h4>
                    <h4 class="text-primary"><?php echo $row_pat[1];?> - CIE : <?php echo $row_pat[2];?></h4>
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
<!------- datos de los signos vitales del paciente ---------->
                <hr>
                <div class="text-center">                                     
                    <h4 class="text-primary">SIGNOS VITALES:</h4>                    
                </div>
                <hr> 

                <div class="form-group row">                               
                    <div class="col-sm-3">
                    <h6 class="text-primary">FRECUENCIA CARDIACA [lpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[1];?>" 
                         name="frec_cardiaca" disabled>                
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-primary">PESO [kg]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[2];?>"            
                         name="peso" disabled>                
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-primary">TALLA [mtrs.]:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[3];?>"  
                         name="talla" disabled>                
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-primary">I.M.C.:</h6>
                        <input type="text" class="form-control" value="<?php echo $row_sg[9];?>"  
                         name="imc" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">FRECUENCIA RESPIRATORIA [cpm]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[4];?>" 
                         name="frec_respiratoria" disabled>                
                    </div>
                </div>

                <div class="form-group row">                               

                    <div class="col-sm-3">
                    <h6 class="text-primary">PRESIÓN ARTERIAL [mmHg]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[5];?>"             
                         name="presion_arterial" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">TEMPERATURA [°C]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[6];?>" 
                         name="temperatura" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">SATURACIÓN [% O2]:</h6>
                        <input type="number" class="form-control" value="<?php echo $row_sg[7];?>" 
                         name="saturacion" disabled>                
                    </div>
                    <div class="col-sm-3">
                    <h6 class="text-primary">COMBE:</h6>
                    <input type="text" class="form-control" value="<?php echo $row_sg[8];?>" name="combe" disabled>
                    </div>
                </div>

                <hr>
                <!---------- DATOS DEL TRIAGE  BEGIN ------------->

                <div class="text-center">                                     
                    <h4 class="text-primary">DATOS TRIAGE:</h4>                    
                </div>
                <hr> 

            <div class="form-group row">   
                    
                    <div class="col-sm-4">
                        <h6 class="text-primary">ESPECIALIDAD</h6>
    
                        <select name="idespecialidad_atencion"  id="idespecialidad_atencion" class="form-control" disabled>
                            <option selected>Seleccione</option>
                            <?php
                            $sqlv = " SELECT especialidad_atencion.idespecialidad_atencion, especialidad_medica.especialidad_medica FROM especialidad_atencion, especialidad_medica ";
                            $sqlv.= " WHERE especialidad_atencion.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
                            $resultv = mysqli_query($link,$sqlv);
                            if ($rowv = mysqli_fetch_array($resultv)){
                            mysqli_field_seek($resultv,0);
                            while ($fieldv = mysqli_fetch_field($resultv)){
                            } do {
                            ?>
                            <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$idespecialidad_atencion_ss) echo "selected";?> ><?php echo $rowv[1];?></option>
                            <?php
                            } while ($rowv = mysqli_fetch_array($resultv));
                            } else {
                            }
                            ?>
                        </select>
    
                        </div>
                        <div class="col-sm-4">
                        <h6 class="text-primary">ANAMNESIS</h6>
                        <textarea class="form-control" rows="3" name="anamnesis" disabled><?php echo $row_esp[1]?></textarea>
                        </div>
                        <div class="col-sm-4">
                        <h6 class="text-primary">PRE-DIAGNÓSTICO:</h6>
                        <textarea class="form-control" rows="3" name="prediagnostico" disabled><?php echo $row_esp[2]?></textarea>               
                        </div>
                    </div>
    
                    <hr>
                <!---------- DATOS DEL TRIAGE END ------------->


                <!---------- TRATAMIENTO MEDICO  BEGIN ------------->
                <div class="text-center">                                     
                    <h4 class="text-primary">PATOLOGÍA A MEDICAR:</h4>                    
                </div>
                <div class="form-group row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-primary">Nª</th>
                            <th class="text-primary">PATOLOGÍA</th>
                            <th class="text-primary">CIE</th>
                            <th class="text-primary">DIAGNOSTICO</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                        $numero=1;
                        $sql4 =" SELECT diagnostico_atencion.iddiagnostico_atencion, patologia.patologia, patologia.cie, diagnostico_atencion.diagnostico_atencion, diagnostico_atencion.etapa ";
                        $sql4.=" FROM diagnostico_atencion, patologia WHERE diagnostico_atencion.idpatologia=patologia.idpatologia ";
                        $sql4.=" AND diagnostico_atencion.idespecialidad_atencion='$idespecialidad_atencion_ss' AND diagnostico_atencion.iddiagnostico_atencion='$iddiagnostico_atencion_ss' ";
                        $result4 = mysqli_query($link,$sql4);
                        if ($row4 = mysqli_fetch_array($result4)){
                        mysqli_field_seek($result4,0);
                        while ($field4 = mysqli_fetch_field($result4)){
                        } do { 
                        ?>
                        <tr>
                            <td><?php echo $numero;?></td>
                            <td><?php echo $row4[1];?></td>
                            <td><?php echo $row4[2];?></td>
                            <td><?php echo $row4[3];?></td>
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
<!-- SECCION PARA ALIMENTAR LOS MEDICAMENTOS PARA EL TRATAMIENTO - BEGIN ---->


<div class="text-center">                                     
                    <h4 class="text-info">TRATAMIENTO:</h4>                    
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
                            <th class="text-info">INDICACIÓN</th>
                            <th class="text-info">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                        $numero=1;
                        $sql4 =" SELECT tratamiento.idtratamiento, tipo_medicamento.tipo_medicamento, medicamento.medicamento, tratamiento.cantidad_recetada, tratamiento.indicacion  ";
                        $sql4.=" FROM tratamiento, tipo_medicamento, medicamento WHERE tratamiento.idtipo_medicamento=tipo_medicamento.idtipo_medicamento AND ";
                        $sql4.=" tratamiento.idmedicamento=medicamento.idmedicamento AND tratamiento.iddiagnostico_atencion='$iddiagnostico_atencion_ss' ";
                        $result4 = mysqli_query($link,$sql4);
                        if ($row4 = mysqli_fetch_array($result4)){
                        mysqli_field_seek($result4,0);
                        while ($field4 = mysqli_fetch_field($result4)){
                        } do { 
                        ?>
                        <tr>
                            <td><?php echo $numero;?></td>
                            <td><?php echo $row4[1];?></td>
                            <td><?php echo $row4[2];?></td>
                            <td><?php echo $row4[3];?></td>
                            <td><?php echo $row4[4];?></td>
                            <td>
                            <form name="BORRAR" action="elimina_item_tratamiento.php" method="post">  
                            <input type="hidden" name="idtratamiento" value="<?php echo $row4[0];?>">
                            <button type="submit" class="btn btn-warning">RETIRAR</button></form>
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
 
<!-- BEGIN aqui va el comntenido de la pagina ---->
                <hr>
                <form name="MEDICACION" action="guarda_item_medicamento.php" method="post">                   

                <div class="form-group row">
                    <div class="col-sm-4">
                    <h6 class="text-info">TIPO MEDICAMENTO:</h6>
                        <select name="idtipo_medicamento"  id="idtipo_medicamento" class="form-control" required autofocus>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $numero=1;
                        $sql1 = "SELECT idtipo_medicamento, tipo_medicamento FROM tipo_medicamento ORDER BY idtipo_medicamento";
                        $result1 = mysqli_query($link,$sql1);
                        if ($row1 = mysqli_fetch_array($result1)){
                        mysqli_field_seek($result1,0);
                        while ($field1 = mysqli_fetch_field($result1)){
                        } do {
                        echo "<option value=".$row1[0].">".$numero.".- ".$row1[1]."</option>";
                        $numero=$numero+1;
                        } while ($row1 = mysqli_fetch_array($result1));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-info">MEDICAMENTO:</h6>
                        <select name="idmedicamento"  id="idmedicamento" class="form-control" required></select>
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-info">Cantidad:</h6>
                    <input type="number" class="form-control" name="cantidad_recetada" required>  
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-8">
                    <h6 class="text-info">INDICACIÓN:</h6>
                    <textarea class="form-control" rows="3" name="indicacion"></textarea>
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-info">ACCIÓN:</h6>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModaldo">
                        AGREGAR
                        </button>  
                    </div>  
                </div>

                <!-- modal de confirmacion de envio de datos-->
                    <div class="modal fade" id="exampleModaldo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">PRESCRIPCION MÉDICA</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">                                    
                                    Esta seguro de agregar el MEDICAMENTO?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


<!-- SECCION PARA ALIMENTAR LOS MEDICAMENTOS PARA EL TRATAMIENTO - END ---->
                <hr>  
                <form name="ENVIA_CONSULTA" action="guarda_consolida_tratamiento.php" method="post">  
        <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-6">
                <h4 class="text-info">CONSOLIDAR TRATAMIENTO MÉDICO:</h4>  
                </div> 
                <div class="col-sm-6">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                    CONSOLIDAR TRATAMIENTO
                    </button>  
                </div> 
            </div>                              
                            
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">TRATAMIENTO MÉDICO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de CONSOLIDAR EL TRATAMIENTO?
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>        
    </div>
                <hr>  
<!-- SECCION PARA CONSOLIDAR LA MEDICACION PARA EL TRATAMIENTO - BEGIN ---->



<!-- SECCION PARA CONSOLIDAR LA MEDICACION PARA EL TRATAMIENTO- END ---->



                                                  
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

    <script type="text/javascript" src="../js/localizacion.js"></script>
    <script type="text/javascript" src="../js/initMap.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk&callback=initMap"></script>

    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>

        <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_medicamento").change(function () {
                    $("#idtipo_medicamento option:selected").each(function () {
                        tipo_medicamento=$(this).val();
                    $.post("tipo_medicamento.php", {tipo_medicamento:tipo_medicamento}, function(data){
                    $("#idmedicamento").html(data);
                    });
                });
        })
        });
        </script>
    
</body>
</html>