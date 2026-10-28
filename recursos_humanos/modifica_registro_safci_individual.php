<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$sql = " SELECT personal.idpersonal, personal.idusuario, personal.idnombre, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, ";
$sql.= " nombre.ci, nombre.complemento, nombre.exp, nombre.idnacionalidad, nombre.idgenero, nombre_datos.idformacion_academica, nombre_datos.idprofesion, nombre_datos.idespecialidad_medica,";
$sql.= " nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, personal.idnombre_datos, nombre_datos.celular_emergencia, personal.codigo  ";
$sql.= " FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica ";
$sql.= " WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
$sql.= " AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
$sql.= " AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica ";
$sql.= " AND personal.idnombre='$idnombre_ss' AND personal.idusuario='$idusuario_ss'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, idministerio, iddireccion, idarea, cargo_mds,";
$sql_l.= " iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud, idcargo_organigrama ";
$sql_l.= " FROM dato_laboral WHERE iddato_laboral='$row[19]' ORDER BY iddato_laboral DESC LIMIT 1 ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

$sql_ac = " SELECT idnombre_academico, entidad_academica, gestion FROM nombre_academico ";
$sql_ac.= " WHERE idnombre='$idnombre_ss' AND idusuario='$idusuario_ss' ";
$result_ac = mysqli_query($link,$sql_ac);
$row_ac = mysqli_fetch_array($result_ac);

/****** documento PDF actual ****/
$row_doc_url = '';
$result_doc = mysqli_query($link," SELECT url FROM personal WHERE idpersonal='$row[0]' ");
if ($result_doc && $row_doc = mysqli_fetch_array($result_doc)) {
    $row_doc_url = $row_doc[0];
}

/****** sello y firma actual (consulta aparte para no romper la página si aún no existe la columna url_sello) ****/
$sello_actual = '';
$result_se = @mysqli_query($link," SELECT url_sello FROM personal WHERE idpersonal='$row[0]' ");
if ($result_se && $row_se = mysqli_fetch_array($result_se)) {
    $sello_actual = $row_se[0];
}
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
        <div class="card o-hidden border-0 shadow-lg my-2">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-3">               
                    <div class="text-center">   
                    <a href="registro_individual.php"><h6 class="text-info"><i class="fas fa-fw fa-arrow-left"></i>VOLVER</h6></a>
                    <hr>                     
                    <h4 class="text-primary">ACTUALIZAR REGISTRO SAFCI</h4>
                    <h4><?php echo $row[22];?></h4>
                    </div>
<!-- END aqui va el TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->
                    <div class="col-lg-12">  
                    <div class="p-5"> 
 
                    <div class="form-group row">
                                    <h5 class="text-primary">1.- DATOS PERSONALES:</h5>                                 
                                </div>
                                <hr>
                        <form name="FORMREG" action="guarda_personal_mod_individual.php" method="post">  
                        <input type="hidden" name="idpersonal" value="<?php echo $row[0];?>">
                                <div class="form-group row">                             
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NOMBRES</h6>
                                    <input type="text" class="form-control" name="nombre" value="<?php echo $row[3];?>" required>                       
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">PRIMER APELLIDO:</h6>
                                    <input type="text" class="form-control" name="paterno" value="<?php echo $row[4];?>" required>                                     
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">SEGUNDO APELLIDO:</h6>
                                    <input type="text" class="form-control" name="materno" value="<?php echo $row[5];?>" required>                                    
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">FECHA DE NACIMIENTO:</h6>
                                    <input type="text" id="fecha1" class="form-control" name="fecha_nac" value="<?php 
                                        $fecha_n = explode('-',$row[6]);
                                        $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                                        echo $fecha_nac;
                                        ?>" >    
                                    </div>                              
                                </div>

                                <div class="form-group row">                            
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CÉDULA DE ID:</h6>
                                    <input type="text" class="form-control" name="ci" value="<?php echo $row[7];?>" required> 
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">COMPLEMENTO:</h6>
                                    <input type="text" class="form-control" name="complemento" value="<?php echo $row[8];?>" > 
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">EXPEDICIÓN:</h6>
                                    <select name="exp"  id="exp" class="form-control" required >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = "SELECT iddepartamento, departamento, sigla FROM departamento ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[2];?>" <?php if ($rowv[2]==$row[9]) echo "selected";?> ><?php echo $rowv[2];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">NACIONALIDAD</h6>
                                    <select name="idnacionalidad"  id="idnacionalidad" class="form-control" required >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">GÉNERO</h6>
                                    <select name="idgenero"  id="idgenero" class="form-control" required >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idgenero, genero FROM genero ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                    </select>
                                    </div>                          
                                </div>

                                </br>
                                <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="text-center">
                                    <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#personales">
                                        ACTUALIZAR DATOS PERSONALES                                
                                    </a>                                    
                                    </div>
                                </div>
                                </div>
                               

                                <!-- BEGIN Datos Personales Modal-->
                                <div class="modal fade" id="personales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE MODIFICAR LOS DATOS PERSONALES?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Seleccione la opción para confirmar la modificación.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit">Confirmar Cambios</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                                <!-- END Datos Personales Modal-->
                                </br>
                                <hr>
                <div class="form-group row">
                    <h5 class="text-primary">2.- DATOS COMPLEMENTARIOS:</h5>                                 
                </div>
                    <hr>
                    <form name="COMPLEMENTARIOS" action="guarda_complementarios_mod_individual.php" method="post"> 
                    <input type="hidden" name="idnombre_datos" value="<?php echo $row[20];?>">
                    <input type="hidden" name="idnombre_academico" value="<?php echo $row_ac[0];?>">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">FORMACIÓN ACADÉMICA:</h6>
                                    <select name="idformacion_academica"  id="idformacion_academica" class="form-control" required >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = "SELECT idformacion_academica, formacion_academica FROM formacion_academica ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[12]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                    </select>
                                     
                                    </div>
                                    <div class="col-sm-6">
                                    <h6 class="text-primary">PROFESIÓN/OCUPACIÓN:</h6>
                                    <select name="idprofesion"  id="idprofesion" class="form-control" required >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idprofesion, profesion FROM profesion ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[13]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                    </select>
                                    </div>                              
                                </div>
                                
                                <div class="form-group row">                                
                                    <div class="col-sm-12">
                                    <h6 class="text-primary">ESPECIALIDAD MÉDICA:</h6>
                                    <select name="idespecialidad_medica"  id="idespecialidad_medica" class="form-control" required >
                                        <option selected>Seleccione</option>
                                        <?php
                                        $sqlv = " SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica ";
                                        $resultv = mysqli_query($link,$sqlv);
                                        if ($rowv = mysqli_fetch_array($resultv)){
                                        mysqli_field_seek($resultv,0);
                                        while ($fieldv = mysqli_fetch_field($resultv)){
                                        } do {
                                        ?>
                                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[14]) echo "selected";?> ><?php echo $rowv[1];?></option>
                                        <?php
                                        } while ($rowv = mysqli_fetch_array($resultv));
                                        } else {
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">   
                                    <div class="col-sm-8">
                                    <h6 class="text-primary">NOMBRE DE LA ENTIDAD DE FORMACIÓN:</h6> 
                                    <textarea class="form-control" rows="2" name="entidad_academica" required><?php echo $row_ac[1]; ?></textarea>
                                    </div>
                                    <div class="col-sm-4">
                                    <h6 class="text-primary">GESTIÓN:</h6>
                                    <input type="text" class="form-control" name="gestion_ac" value="<?php echo $row_ac[2]; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">                                
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CORREO ELECTRÓNICO:</h6>
                                    <input type="text" class="form-control" name="correo" value="<?php echo $row[15];?>" >
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TELÉFONO CELULAR/WHATSAPP:</h6>
                                    <input type="text" class="form-control" name="celular" value="<?php echo $row[16];?>" >
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">TELÉFONO EMERGENCIA:</h6>
                                    <input type="text" class="form-control" name="celular_emergencia" value="<?php echo $row[21];?>" >
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">DIRECCIÓN/DOMICILIO:</h6> 
                                    <textarea name="direccion_dom" rows="3" class="form-control" ><?php echo $row[17];?></textarea>
                                    </div>
                                </div>      
                                <!-- end datos laborales -->
                                <hr>
                                </br>
                                <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="text-center">
                                    <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#complementarios">
                                        ACTUALIZAR DATOS COMPLEMENTARIOS                                
                                    </a>                                    
                                    </div>
                                </div>
                                </div>

                                <!-- BEGIN Datos Personales Modal-->
                                <div class="modal fade" id="complementarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE MODIFICAR LOS DATOS COMPLEMENTARIOS?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Seleccione la opcion para confirmar la modificación.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit">Confirmar Cambios</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </form>
                                <!-- END Datos Personales Modal-->
                                <hr>
                <div class="form-group row">
                    <h5 class="text-primary">2.1 DATOS DE POSGRADO:</h5>                                 
                </div> 
                
            <div class="form-group row">
                <div class="col-sm-3">
                <h6 class="text-primary">FORMACIÓN POSGRADO: </h6>
                </div>
                <div class="col-sm-3">
                <h6 class="text-primary">DESCRIPCIÓN DEL POSGRADO:</h6>
                </div>
                <div class="col-sm-2">
                <h6 class="text-primary">ENTIDAD EN POSGRADO:</h6>
                </div>
                <div class="col-sm-2">
                <h6 class="text-primary">AÑO:</h6>
                </div> 
                <div class="col-sm-2">
                <h6 class="text-primary">ACCIÓN:</h6>
                </div> 
            </div>

            <?php
                $sql_ac = " SELECT idnombre_academico, idformacion_academica, descripcion_academica, entidad_academica, gestion, ";
                $sql_ac.= " idformacion_academica_p, descripcion_academica_p, entidad_academica_p, gestion_p, posgrado ";
                $sql_ac.= " FROM nombre_academico WHERE idnombre='$row[2]' AND posgrado !='' ORDER BY idnombre_academico";
                $result_ac = mysqli_query($link,$sql_ac);
                if ($row_ac = mysqli_fetch_array($result_ac)){
                mysqli_field_seek($result_ac,0);
                while ($field_ac = mysqli_fetch_field($result_ac)){
                } do {
            ?>

                <div class="form-group row">
                <div class="col-sm-3">
                <select name="formacion_academica_p"  id="formacion_academica_p" class="form-control" required disabled>
                    <option selected>Seleccione</option>
                    <?php
                    $sqlv = " SELECT idformacion_academica, formacion_academica FROM formacion_academica  ";
                    $resultv = mysqli_query($link,$sqlv);
                    if ($rowv = mysqli_fetch_array($resultv)){
                    mysqli_field_seek($resultv,0);
                    while ($fieldv = mysqli_fetch_field($resultv)){
                    } do {
                    ?>
                    <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_ac[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
                    <?php
                    } while ($rowv = mysqli_fetch_array($resultv));
                    } else {
                    }
                    ?>
                </select>
                </div>
                <div class="col-sm-3">
                <textarea name="" rows="4" class="form-control" disabled><?php echo $row_ac[6];?></textarea>
                </div>
                <div class="col-sm-2">
                <textarea name="" rows="3" class="form-control" disabled><?php echo $row_ac[7];?></textarea>
                </div>
                <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $row_ac[8];?>" disabled> 
                </div> 
                <div class="col-sm-2">
                    <form name="FORM11" action="elimina_academico_individual.php" method="post">
                      <input name="idnombre_academico" type="hidden" value="<?php echo $row_ac[0];?>">
                        <button class="btn btn-danger btn-icon-split" type="submit">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Eliminar</span>
                        </button>
                    </form>
                </div> 
                </div>

                <?php
                }
                while ($row_ac = mysqli_fetch_array($result_ac));
                } else {
                }
                ?>
 
            <form name="POSGRADO" action="guarda_posgrado_mod_individual.php" method="post"> 
               
                <input type="hidden" name="idnombre_mod" value="<?php echo $row[2];?>">
                <input type="hidden" name="idusuario_mod" value="<?php echo $row[1];?>">
                <input type="hidden" name="idprofesion" value="<?php echo $row[13] ;?>">
                <input type="hidden" name="idespecialidad_medica" value="<?php echo $row[14];?>">
                <input type="hidden" name="idformacion_academica" value="<?php echo $row[12];?>">
                <input type="hidden" name="descripcion_academica" value="FORMACIÓN DE GRADO">
                <input type="hidden" name="entidad_academica" value="ENTIDAD DE FORMACIÓN DE GRADO ">
                <input type="hidden" name="gestion_ac" value="GESTION">

                <div class="form-group row">
                    <div class="col-sm-3">
                    <select name="idformacion_academica_p"  id="idformacion_academica_p" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql1 = "SELECT idformacion_academica, formacion_academica FROM formacion_academica WHERE etapa_academica='POSGRADO' ";
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
                    <div class="col-sm-4">
                    <textarea name="descripcion_academica_p" rows="3" class="form-control" required placeholder="Descripción"></textarea>
                    </div>
                    <div class="col-sm-3">
                    <textarea name="entidad_academica_p" rows="3" class="form-control" required placeholder="Entidad de Formación"></textarea>
                    </div>
                    <div class="col-sm-2">
                    <input type="text" name="gestion_p" class="form-control" required placeholder="Gestion">
                    </div>
                </div>  

                <div class="form-group row">
                <div class="col-sm-12">
                    <div class="text-center">
                    <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#posgrado">
                        ACTUALIZAR DATOS DE POSGRADO                                
                    </a>                                    
                    </div>
                </div>
                </div>

                <!-- BEGIN Datos Posgrado Modal-->
                <div class="modal fade" id="posgrado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE MODIFICAR LOS DATOS ACADÉMICOA?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Seleccione la opcion para confirmar la modificación.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-warning" type="submit">Confirmar Cambios</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                                <!-- END Datos Posgrado Modal-->  

                </br>
                <hr>
                <div class="form-group row">
                    <h5 class="text-primary">3.- LUGAR DE TRABAJO:</h5>                                 
                </div>   
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">TIPO DE DEPENDENCIA:</h6>  
                    </div>
                    <div class="col-sm-9">                  
                    <select name="iddependencia" id="iddependencia" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddependencia, dependencia FROM dependencia ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <?php if ($row_l[3] == '1') { ?>

                <?php } else { if ($row_l[3] == '2') { ?>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">DEPENDIENTE DEL:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idministerio"  id="idministerio" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idministerio, ministerio, sigla FROM ministerio ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[6]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">DIRECCIÓN/INSTITUCIÓN::</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddireccion"  id="iddireccion" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddireccion, direccion FROM direccion ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">UNIDAD ORGANIZACIONAL:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idarea"  id="idarea" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idarea, area FROM area ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[8]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">CARGO (DE ACUERDO A ORGANIGRAMA):</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idcargo_organigrama"  id="idcargo_organigrama" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idcargo_organigrama, cargo_organigrama FROM cargo_organigrama  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[16]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">CARGO (DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-9">
                    <textarea class="form-control" rows="2" name="cargo_mds" required disabled><?php echo $row_l[9];?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">NÚMERO DE ÍTEM:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="item_mds" value="<?php echo $row_l[14];?>" disabled>
                    </div>
                </div>
                <?php } else { ?>

                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[10]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">RED DE SALUD:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idred_salud"  id="idred_salud" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[11]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <select name="idestablecimiento_salud"  id="idestablecimiento_salud" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[12]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">CARGO (DE ACUERDO A ORGANIGRAMA):</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idcargo_organigrama"  id="idcargo_organigrama" class="form-control" required disabled>
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idcargo_organigrama, cargo_organigrama FROM cargo_organigrama  ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row_l[16]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">CARGO (DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN):</h6>
                    </div>
                    <div class="col-sm-9">
                    <textarea class="form-control" rows="2" name="cargo_red_salud" required disabled><?php echo $row_l[13];?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">NÚMERO DE ÍTEM:</h6>
                    </div>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="item_mds" value="<?php echo $row_l[15];?>" disabled>
                    </div>
                </div>             
              
                <?php } } ?>

                <div class="form-group row">
                <div class="col-sm-12">
                    <div class="text-center">
                    <a class="btn btn-primary" href="datos_laborales_individual.php" >
                        ACTUALIZAR DATOS LABORALES                                
                    </a>                                    
                    </div>
                </div>
                </div>

                <hr>  
            <div class="form-group row" id="documentacion">
                <div class="col-sm-6">
                <h5 class="text-primary">4.- DOCUMENTACIÓN:</h5></br>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
<!---------------- SUBIDA DE DOCUMENTOS PDF A SISTEMA ----------->

            <?php if (isset($_GET['documento'])) { ?>
                <?php if ($_GET['documento'] == 'ok') { ?>
                <div class="alert alert-success">LOS DOCUMENTOS DE RESPALDO PERSONAL SE SUBIERON CORRECTAMENTE.</div>
                <?php } else if ($_GET['documento'] == 'vacio') { ?>
                <div class="alert alert-warning">NO SELECCIONÓ NINGÚN ARCHIVO PDF.</div>
                <?php } else if ($_GET['documento'] == 'invalido') { ?>
                <div class="alert alert-danger">EL ARCHIVO DEBE SER UN PDF VÁLIDO DE MÁXIMO 20 MB.</div>
                <?php } else { ?>
                <div class="alert alert-danger">NO SE PUDO SUBIR EL DOCUMENTO, VUELVA A INTENTAR.</div>
                <?php } ?>
            <?php } ?>

            <form name="FORM9" id="form_documento" action="subir_documento_safci_mod.php" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <div class="col-sm-6">
                <h6 class="text-primary">SUBIR DOCUMENTOS EN UN SOLO ARCHIVO PDF (MÁXIMO 20 MB):</br></br>1.- Fotocopia de CI (anverso y reverso)</br>2.- Primer Memorándum de designación.</br>3.- Memorándum actual.</h6>
                </div>
                <div class="col-sm-6">
                  <input type="file" name="file" id="file" accept="application/pdf,.pdf" required>
                <?php if ($row_doc_url != '') { ?>
                </br></br>
                <h6 class="text-primary">DOCUMENTO ACTUAL:</h6>
                <a class="btn btn-outline-info btn-sm" href="#" data-toggle="modal" data-target="#ver_documento">
                    <i class="fas fa-fw fa-file-pdf"></i> VER DOCUMENTO SUBIDO
                </a>

                <div class="modal fade" id="ver_documento" tabindex="-1" role="dialog" aria-labelledby="verDocumentoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document" style="max-width:90%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verDocumentoLabel">DOCUMENTACIÓN PERSONAL</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body p-0">
                                <iframe id="iframe_documento" data-src="../<?php echo htmlspecialchars($row_doc_url);?>" style="width:100%; height:75vh; border:0;"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                </div>

            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#documento">
                    SUBIR DOCUMENTACION PERSONAL                               
                </a> 
                </div> 
                
                <div class="modal fade" id="documento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE SUBIR LA DOCUMENTACION PERSONAL?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Seleccione la opción para confirmar la subida del archivo PDF.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit">CONFIRMAR SUBIDA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
            </form>

                <hr>
            <div class="form-group row" id="sello">
                <div class="col-sm-12">
                <h5 class="text-primary">5.- SELLO Y FIRMA DEL PROFESIONAL:</h5></br>
                </div>
            </div>
<!---------------- SUBIDA DE SELLO Y FIRMA (PNG SIN FONDO) ----------->

            <?php if (isset($_GET['sello'])) { ?>
                <?php if ($_GET['sello'] == 'ok') { ?>
                <div class="alert alert-success">EL SELLO Y FIRMA SE GUARDARON CORRECTAMENTE.</div>
                <?php } else { ?>
                <div class="alert alert-danger">NO SE PUDO GUARDAR EL SELLO Y FIRMA, VUELVA A INTENTAR CON OTRA IMAGEN.</div>
                <?php } ?>
            <?php } ?>

            <form name="FORM10" id="form_sello" action="subir_sello_safci_mod.php" method="post">
            <input type="hidden" name="sello_png" id="sello_png">
            <div class="form-group row">
                <div class="col-sm-6">
                <h6 class="text-primary">SUBIR FOTOGRAFÍA DEL SELLO CON SU FIRMA (JPG o PNG):</br></br>1.- Sellar y firmar sobre una hoja blanca.</br>2.- Tomar la foto de frente, con buena luz y sin sombras.</br>3.- El sistema quitará el fondo y lo guardará como PNG transparente.</h6>
                </br>
                <input type="file" id="file_sello" accept="image/png, image/jpeg, image/webp">
                </br></br>
                <h6 class="text-primary">LIMPIEZA DEL FONDO: <span id="nivel_valor">-</span>
                    <a href="#" id="nivel_auto" class="small ml-2" style="display:none;">(volver a automático)</a></h6>
                <input type="range" class="custom-range" id="nivel_limpieza" min="0" max="100" value="30" disabled>
                <small class="text-muted">El sistema elige el valor automáticamente. Súbalo si quedan restos o sombras del papel; bájelo si se borra parte del sello o la firma.</small>
                <div id="aviso_sello" class="alert alert-warning small mt-2" style="display:none;"></div>
                </br>
                <h6 class="text-primary">ENCUADRE - TAMAÑO DEL SELLO: <span id="tamano_valor">-</span>
                    <a href="#" id="btn_centrar_sello" class="small ml-2">(centrar)</a></h6>
                <input type="range" class="custom-range" id="tamano_sello" min="40" max="100" value="88" disabled>
                <small class="text-muted">El recuadro punteado de la vista previa es el espacio del sello en los formularios impresos. Ajuste el tamaño y arrastre el sello con el mouse (o el dedo) para centrarlo.</small>
                </div>
                <div class="col-sm-6">
                <h6 class="text-primary">VISTA PREVIA (SIN FONDO):</h6>
                <div class="btn-group btn-group-sm mb-2" role="group" id="vista_sello">
                    <button type="button" class="btn btn-outline-primary active" data-vista="cuadros">Transparente</button>
                    <button type="button" class="btn btn-outline-primary" data-vista="blanco">Sobre blanco</button>
                    <button type="button" class="btn btn-outline-primary" data-vista="original">Foto original</button>
                </div>
                <div id="fondo_vista" class="border rounded p-2 text-center" style="min-height:150px; background-color:#fff; background-image:linear-gradient(45deg,#ddd 25%,transparent 25%),linear-gradient(-45deg,#ddd 25%,transparent 25%),linear-gradient(45deg,transparent 75%,#ddd 75%),linear-gradient(-45deg,transparent 75%,#ddd 75%); background-size:20px 20px; background-position:0 0,0 10px,10px -10px,-10px 0;">
                    <canvas id="canvas_sello" style="max-width:100%; display:none; outline:2px dashed #4e73df; cursor:move; touch-action:none;"></canvas>
                    <img id="img_original" style="max-width:100%; display:none;" alt="Foto original">
                    <span id="sin_sello" class="text-muted small">Seleccione una imagen para ver la vista previa.</span>
                </div>
                <?php if ($sello_actual != '') { ?>
                </br>
                <h6 class="text-primary">SELLO Y FIRMA ACTUAL:</h6>
                <img src="../<?php echo $sello_actual;?>?v=<?php echo time();?>" style="max-width:100%; max-height:150px;" alt="Sello actual">
                <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                <a class="btn btn-primary" href="#" id="btn_sello" data-toggle="modal" data-target="#sello_modal">
                    GUARDAR SELLO Y FIRMA
                </a>
                </div>

                <div class="modal fade" id="sello_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE GUARDAR EL SELLO Y FIRMA?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Se guardará la imagen tal como se ve en la vista previa. Si ya tenía un sello registrado, será reemplazado.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit">CONFIRMAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>

                    
<!-- END aqui va el comntenido de la pagina ---->
                </div>
                <div class="text-center">
                    <a class="small" href="#">PROGRAMA SAFCI - MI SALUD</a>
                </div>
                <div class="text-center">
                    <a class="small" href="#">Ministerio de Salud y Deportes</a>
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

    <!-- validar el PDF antes de enviarlo -->
    <script>
    /* el PDF se carga solo al abrir la ventana emergente */
    $('#ver_documento').on('show.bs.modal', function () {
        var iframe = document.getElementById('iframe_documento');
        if (!iframe.getAttribute('src')) iframe.setAttribute('src', iframe.getAttribute('data-src'));
    });

    document.getElementById('form_documento').addEventListener('submit', function (e) {
        var archivo = document.getElementById('file').files[0];
        var mensaje = '';
        if (!archivo) {
            mensaje = 'Primero seleccione el archivo PDF.';
        } else if (!/\.pdf$/i.test(archivo.name)) {
            mensaje = 'El archivo debe ser PDF.';
        } else if (archivo.size > 20 * 1024 * 1024) {
            mensaje = 'El archivo supera los 20 MB.';
        }
        if (mensaje != '') {
            e.preventDefault();
            $('#documento').modal('hide');
            alert(mensaje);
        }
    });
    </script>

    <!-- quitar fondo del sello y firma (se procesa en el navegador y se envía como PNG) -->
    <script src="../js/sello_sin_fondo.js"></script>
    <script>
    (function () {
        var MAX_LADO = 1000;   // tamaño máximo del sello guardado (px)
        /* marco fijo del sello guardado: misma proporción para todos, así se imprimen del mismo tamaño en los formularios */
        var MARCO_W = 1000, MARCO_H = 900;

        var tamano      = document.getElementById('tamano_sello');
        var tamanoValor = document.getElementById('tamano_valor');
        var recorte     = document.createElement('canvas');   // sello sin fondo, recortado a la tinta
        var despX = 0, despY = 0;                              // desplazamiento del sello dentro del marco (px del marco)
        var arrastre = null;

        var entrada    = document.getElementById('file_sello');
        var nivel      = document.getElementById('nivel_limpieza');
        var nivelValor = document.getElementById('nivel_valor');
        var nivelAuto  = document.getElementById('nivel_auto');
        var aviso      = document.getElementById('aviso_sello');
        var canvas     = document.getElementById('canvas_sello');
        var imgOrig    = document.getElementById('img_original');
        var fondoVista = document.getElementById('fondo_vista');
        var sinSello   = document.getElementById('sin_sello');
        var cuadros    = fondoVista.style.backgroundImage;
        var prep       = null;
        var hayResultado = false;
        var vista      = 'cuadros';
        var pendiente  = false;

        function mostrarAviso(texto) {
            aviso.textContent = texto;
            aviso.style.display = texto ? '' : 'none';
        }

        function actualizarVista() {
            fondoVista.style.backgroundImage = vista === 'cuadros' ? cuadros : 'none';
            imgOrig.style.display  = (vista === 'original' && imgOrig.getAttribute('src')) ? '' : 'none';
            canvas.style.display   = (vista !== 'original' && hayResultado) ? '' : 'none';
            sinSello.style.display = (vista === 'original' ? !imgOrig.getAttribute('src') : !hayResultado) ? '' : 'none';
        }

        $('#vista_sello button').on('click', function () {
            $('#vista_sello button').removeClass('active');
            $(this).addClass('active');
            vista = $(this).data('vista');
            actualizarVista();
        });

        entrada.addEventListener('change', function () {
            var archivo = this.files[0];
            prep = null;
            hayResultado = false;
            despX = 0; despY = 0;
            tamano.disabled = true;
            tamanoValor.textContent = '-';
            nivel.disabled = true;
            nivelValor.textContent = '-';
            nivelAuto.style.display = 'none';
            mostrarAviso('');
            if (imgOrig.getAttribute('src')) { URL.revokeObjectURL(imgOrig.src); imgOrig.removeAttribute('src'); }
            sinSello.textContent = 'Seleccione una imagen para ver la vista previa.';
            actualizarVista();
            if (!archivo) return;
            if (!/^image\/(png|jpeg|webp)$/.test(archivo.type)) {
                alert('Seleccione una imagen JPG o PNG.');
                this.value = '';
                return;
            }
            sinSello.textContent = 'Procesando imagen...';
            var img = new Image();
            img.onload = function () {
                var escala = Math.min(1, MAX_LADO / Math.max(img.width, img.height));
                var w = Math.round(img.width * escala), h = Math.round(img.height * escala);
                var tmp = document.createElement('canvas');
                tmp.width = w; tmp.height = h;
                var ctx = tmp.getContext('2d');
                /* fondo blanco: si el PNG ya trae transparencia no debe tomarse como fondo negro */
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, w, h);
                ctx.drawImage(img, 0, 0, w, h);
                prep = SelloSinFondo.preparar(ctx.getImageData(0, 0, w, h));
                imgOrig.src = img.src;
                nivel.value = prep.nivelAuto;
                nivel.disabled = false;
                if (prep.fondoOscuro) {
                    mostrarAviso('La foto parece tener fondo oscuro. Para un buen resultado, tome la foto del sello sobre una hoja blanca y con buena luz.');
                }
                procesar();
            };
            img.onerror = function () {
                sinSello.textContent = 'No se pudo leer la imagen.';
            };
            img.src = URL.createObjectURL(archivo);
        });

        nivel.addEventListener('input', function () {
            if (!prep || pendiente) return;
            pendiente = true;
            requestAnimationFrame(function () { pendiente = false; procesar(); });
        });

        nivelAuto.addEventListener('click', function (e) {
            e.preventDefault();
            if (!prep) return;
            nivel.value = prep.nivelAuto;
            procesar();
        });

        function procesar() {
            var valor = parseInt(nivel.value, 10);
            nivelValor.textContent = valor + (valor == prep.nivelAuto ? ' (automático)' : '');
            nivelAuto.style.display = valor == prep.nivelAuto ? 'none' : '';
            var res = SelloSinFondo.generar(prep, valor);
            hayResultado = !!res;
            if (res) {
                recorte.width = res.imageData.width;
                recorte.height = res.imageData.height;
                recorte.getContext('2d').putImageData(res.imageData, 0, 0);
                tamano.disabled = false;
                componer();
            } else {
                sinSello.textContent = 'No se detectó el sello, baje el nivel de limpieza.';
            }
            actualizarVista();
        }

        /* coloca el sello dentro del marco fijo según el tamaño elegido y el desplazamiento por arrastre */
        function componer() {
            var factor = parseInt(tamano.value, 10) / 100;
            tamanoValor.textContent = tamano.value + ' %';
            var escala = Math.min(MARCO_W / recorte.width, MARCO_H / recorte.height) * factor;
            var dw = recorte.width * escala, dh = recorte.height * escala;
            /* el sello no puede salir del marco */
            var maxX = (MARCO_W - dw) / 2, maxY = (MARCO_H - dh) / 2;
            despX = Math.max(-maxX, Math.min(maxX, despX));
            despY = Math.max(-maxY, Math.min(maxY, despY));
            canvas.width = MARCO_W;
            canvas.height = MARCO_H;
            var ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, MARCO_W, MARCO_H);
            ctx.imageSmoothingQuality = 'high';
            ctx.drawImage(recorte, maxX + despX, maxY + despY, dw, dh);
        }

        tamano.addEventListener('input', function () {
            if (hayResultado) componer();
        });

        document.getElementById('btn_centrar_sello').addEventListener('click', function (e) {
            e.preventDefault();
            despX = 0; despY = 0;
            if (hayResultado) componer();
        });

        /* arrastrar el sello dentro del marco (mouse o dedo) */
        canvas.addEventListener('pointerdown', function (e) {
            if (!hayResultado) return;
            arrastre = { x: e.clientX, y: e.clientY, dx: despX, dy: despY };
            canvas.setPointerCapture(e.pointerId);
        });
        canvas.addEventListener('pointermove', function (e) {
            if (!arrastre) return;
            var relacion = MARCO_W / canvas.getBoundingClientRect().width;   // px del marco por px de pantalla
            despX = arrastre.dx + (e.clientX - arrastre.x) * relacion;
            despY = arrastre.dy + (e.clientY - arrastre.y) * relacion;
            componer();
        });
        canvas.addEventListener('pointerup', function () { arrastre = null; });
        canvas.addEventListener('pointercancel', function () { arrastre = null; });

        document.getElementById('form_sello').addEventListener('submit', function (e) {
            if (!prep || !hayResultado) {
                e.preventDefault();
                $('#sello_modal').modal('hide');
                alert('Primero seleccione la fotografía del sello y revise la vista previa.');
                return;
            }
            document.getElementById('sello_png').value = canvas.toDataURL('image/png');
        });
    })();
    </script>

</body>

</html>
