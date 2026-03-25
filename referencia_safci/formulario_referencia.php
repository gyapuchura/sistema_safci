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

$idatencion_psafci_ss       = $_SESSION['idatencion_psafci_ss'];

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);
        
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

    <title>FORMULARIO DE REFERENCIA - SAFCI</title>

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

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!---------------------- FORMULARIO DE REFERENCIA D7 (begin) ------------->
                    </br>          
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="text-center">
                        <h4 class="m-0 font-weight-bold text-primary">FORMULARIO DE REFERENCIA</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">1.- IDENTIFICACIÓN DEL PACIENTE</h6>
                            </div>
                            <div class="card-body">

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
                                        name="paterno" disabled >                
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
                                <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                                    <input type="date"  class="form-control" 
                                        placeholder="ingresar fecha" name="fecha_nac" value="<?php echo $row_n[5];?>" disabled>
                                </div>   
                                
                                <div class="col-sm-2">
                                <h6 class="text-primary">EDAD:</h6>
                                    <input type="number" class="form-control" value="<?php echo $edad_ss;?>" 
                                    name="edad_actual" disabled>
                                </div>
                                <div class="col-sm-4">
                                <h6 class="text-primary">VER CARPETA FAMILIAR:</h6>
                                <a class="btn btn-info btn-icon-split" href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">              
                                <span class="icon text-white-50">
                                    <i class="fas fa-file"></i>
                                </span>
                                <span class="text"><?php echo $row_cf[1];?></span></a> 
                                </div>
                                </div>  

                                <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->  

                                <?php
                                $sql4 =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, profesion.profesion, integrante_datos_cf.ocupacion, contribuye_cf.contribuye_cf ";
                                $sql4.=" FROM integrante_datos_cf, estado_civil, nivel_instruccion, profesion, contribuye_cf WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil ";
                                $sql4.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idprofesion=profesion.idprofesion ";
                                $sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$idintegrante_cf_ss'";
                                $result4 = mysqli_query($link,$sql4);
                                if ($row4 = mysqli_fetch_array($result4)){
                                mysqli_field_seek($result4,0);
                                while ($field4 = mysqli_fetch_field($result4)){
                                } do { 
                                ?>
                                <div class="form-group row">                               
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">ESTADO CIVIL:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[1];?>" 
                                        name="" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">NIVEL DE INSTRUCCIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[2];?>"
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">PROFESIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[3];?>"             
                                        name="" disabled >                
                                    </div>

                                </div>
                                <div class="form-group row"> 
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">OCUPACIÓN:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[4];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">CONTRIBUYE AL SUSTENTO FAMILIAR:</h6>
                                        <input type="text" class="form-control" value="<?php echo $row4[5];?>" 
                                        name="" disabled>                
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">HISTORIA CLÍNICA:</h6>
                                        <a class="btn btn-primary btn-icon-split" href="imprime_historia_clinica.php?idcarpeta_familiar=<?php echo $idcarpeta_familiar_ss;?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">                        
                                        <span class="icon text-white-50">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <span class="text">HISTORIA CLÍNICA DIGITAL</span>
                                            </a>                                      
                                    </div>
                                </div> 
                                <?php
                                }
                                while ($row4 = mysqli_fetch_array($result4));
                                } else {
                                }
                                ?>

                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">NOMBRE DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value="" 
                                        name="acompanante" >
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">PARENTESCO:</h6>
                                    <select name="idparentesco_acomp" id="idparentesco_acomp" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $sql1 = "SELECT idparentesco, parentesco FROM parentesco ";
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
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ACOMPAÑANTE:</h6>
                                        <input type="text" class="form-control" value=""             
                                        name="celular_acompanante"  >                
                                    </div>

                                    <div class="col-sm-6">
                                    <h6 class="text-primary">TEL/CEL DEL ESTABLECIMIENTO DE SALUD:</h6>
                                        <input type="text" class="form-control" value=""             
                                        name="celular_acompanante"  >                
                                    </div>
                                </div>
                                
                            </div>                                
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.- RESUMEN DE ANAMNESIS Y EXAMEN FISICO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">¿ESTUVO INTERNADO?:</h6>
                                        SI <input type="radio" name="alergia" value="SI" > </br>
                                        NO <input type="radio" name="alergia" value="NO" checked >                
                                    </div>

                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DÍAS DE INTERNACIÓN:</h6>
                                        <input type="number" class="form-control" value=""             
                                        name="celular_acompanante"  >                
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">RESUMEN ANAMNESIS</h6>
                                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">3.- REALIZO EXÁMENES COMPLEMENTARIOS DE DIAGNÓSTICO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row"> 
                                    <div class="col-sm-12">
                                    <div class="text-center">
                                        <h6 class="text-primary">HALLAZGOS LLAMATIVOS:</h6>
                                    </div>
                                    <hr>
                                    </div>
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">RX : <input type="checkbox" name="rayos_x" id="rx"></h6>    
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">LABORATORIO : <input type="checkbox" name="laboratorio" id="laboratorio" ></h6>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">ECOGRAFÍA : <input type="checkbox" name="ecografia" id="ecografia"  ></h6>                   
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TOMOGRAFÍA : <input type="checkbox" name="tomografia" id="tomografia"></h6>                       
                                    </div>
                                </div>
                                <div class="form-group row">  

                                    <div class="col-sm-3">
                                    <h6 class="text-primary">OTROS : <input type="checkbox" name="otros" id="otros"></h6>           
                                    </div>
                                    <div class="col-sm-9">
                                    <h6 class="text-primary">ESPECIFIQUE : </h6>  
                                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">4.- DIAGNÓSTICOS PRESUNTIVOS</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-8">
                                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea>    
                                    </div>
                                    <div class="col-sm-1">
                                    <h6 class="text-primary">CIE : </h6>         
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" value=""  name="cie" />
                                    </div>
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-8">
                                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea>    
                                    </div>
                                    <div class="col-sm-1">
                                    <h6 class="text-primary">CIE : </h6>         
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" value=""  name="cie" />
                                    </div>
                                </div>
                                <div class="form-group row">                               
                                    <div class="col-sm-8">
                                    <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea>    
                                    </div>
                                    <div class="col-sm-1">
                                    <h6 class="text-primary">CIE : </h6>         
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" value=""  name="cie" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">5.- TRATAMIENTO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="3" name="tratamiento_ref"></textarea>    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">6.- OBSERVACIONES</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">
                                    <textarea class="form-control" rows="2" name="observaciones_ref"></textarea>    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">7.- CONSENTIMIENTO</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-6">
                                        <h6 class="m-0 font-weight-bold text-primary">SELECCIONE QUIEN FIRMARÁ EL CONSENTIMIENTO : </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="idconsentimiento"  id="idconsentimiento" class="form-control" required >
                                        <option value="">Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idconsentimiento, consentimiento FROM consentimiento ";
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
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">8.- ESTABLECIMIENTO RECEPTOR</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                               
                                    <div class="col-sm-12">  
                                        <h6 class="m-0 font-weight-bold text-primary">SELECCIONE EL ESTABLECIMIENTO RECEPTOR : </h6>  </br>                               
                                        <select name="idestablecimiento_salud" id="idestablecimiento_salud" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $numero=1;
                                        $sql1 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, departamento.departamento FROM establecimiento_salud, departamento ";
                                        $sql1.= " WHERE establecimiento_salud.iddepartamento=departamento.iddepartamento AND establecimiento_salud.idnivel_establecimiento != '1' "; 
                                        $sql1.= " AND establecimiento_salud.idnivel_establecimiento != '4' AND establecimiento_salud.idnivel_establecimiento != '5' "; 
                                        $sql1.= " AND establecimiento_salud.idnivel_establecimiento != '6' AND establecimiento_salud.idnivel_establecimiento != '7'  "; 
                                        $sql1.= " AND establecimiento_salud.idnivel_establecimiento != '8'  AND establecimiento_salud.idnivel_establecimiento != '9' "; 
                                        $sql1.= " AND establecimiento_salud.idnivel_establecimiento != '10' AND establecimiento_salud.idsubsector_salud = '6' ORDER BY establecimiento_salud.idestablecimiento_salud  "; 
                                        $result1 = mysqli_query($link,$sql1);
                                        if ($row1 = mysqli_fetch_array($result1)){
                                        mysqli_field_seek($result1,0);
                                        while ($field1 = mysqli_fetch_field($result1)){
                                        } do {
                                        echo "<option value=".$row1[0].">".$numero.".- ".$row1[1]." - Departamento : ".$row1[2]."</option>";
                                        $numero=$numero+1;
                                        } while ($row1 = mysqli_fetch_array($result1));
                                        } else {
                                        echo "No se encontraron resultados!";
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">9.- MOTIVO DE REFERENCIA</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">                              
                                    <div class="col-sm-4">                                
                                        <select name="idmotivo_referencia" id="idmotivo_referencia" class="form-control" required>
                                        <option value="">-SELECCIONE-</option>
                                        <?php
                                        $numero_m=1;
                                        $sql_m = " SELECT idmotivo_referencia, motivo_referencia FROM motivo_referencia ORDER BY idmotivo_referencia"; 
                                        $result_m = mysqli_query($link,$sql_m);
                                        if ($row_m = mysqli_fetch_array($result_m)){
                                        mysqli_field_seek($result_m,0);
                                        while ($field_m = mysqli_fetch_field($result_m)){
                                        } do {
                                        echo "<option value=".$row_m[0].">".$numero_m.".- ".$row_m[1]." </option>";
                                        $numero_m=$numero_m+1;
                                        } while ($row_m = mysqli_fetch_array($result_m));
                                        } else {
                                        echo "No se encontraron resultados!";
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-8" id="motivo_referencia">
                                    </div>   
                    
                                </div>
                            </div>
                            
                        </div>





                    </div>
                </div>
            </div>
                <!-- /.container-fluid -->
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


<script language="javascript"> 
    $(document).ready(function(){
    $("#idmotivo_referencia").change(function () {
                $("#idmotivo_referencia option:selected").each(function () {
                    motivo_referencia=$(this).val();
                $.post("motivo_referencia.php", {motivo_referencia:motivo_referencia}, function(data){
                $("#motivo_referencia").html(data);
                });
            });
    })
    });
</script>

</body>

</html>