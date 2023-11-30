<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idpersonal_ss = $_SESSION['idpersonal_ss'];
$codigo_ss     = $_SESSION['codigo_ss'];

$sql = " SELECT personal.idpersonal, personal.idusuario, personal.idnombre, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, ";
$sql.= " nombre.ci, nombre.complemento, nombre.exp, nombre.idnacionalidad, nombre.idgenero, nombre_datos.idformacion_academica, nombre_datos.idprofesion, nombre_datos.idespecialidad_medica,";
$sql.= " nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, personal.idnombre_datos, nombre_datos.celular_emergencia, personal.codigo, personal.url ";
$sql.= " FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica ";
$sql.= " WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero ";
$sql.= " AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
$sql.= " AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica  ";
$sql.= " AND personal.idpersonal='$idpersonal_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

$sql_l = " SELECT iddato_laboral, idusuario, idnombre, iddependencia, entidad, cargo_entidad, idministerio, iddireccion, idarea, cargo_mds,";
$sql_l.= " iddepartamento, idred_salud, idestablecimiento_salud, cargo_red_salud, item_mds, item_red_salud, idcargo_organigrama ";
$sql_l.= " FROM dato_laboral WHERE iddato_laboral='$row[19]' ORDER BY iddato_laboral DESC LIMIT 1 ";
$result_l = mysqli_query($link,$sql_l);
$row_l = mysqli_fetch_array($result_l);

$sql_ac = " SELECT idnombre_academico, entidad_academica, gestion FROM nombre_academico ";
$sql_ac.= " WHERE idnombre='$row[2]' AND idusuario='$row[1]' ";
$result_ac = mysqli_query($link,$sql_ac);
$row_ac = mysqli_fetch_array($result_ac);

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
                    <a href="mostrar_registro_safci_mun.php"><h6 class="text-info"><i class="fas fa-fw fa-arrow-left"></i>VOLVER</h6></a>
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
                        <form name="FORMREG" action="guarda_personal_mod_mun.php" method="post">  

                        <input type="hidden" name="idnombre_mod" value="<?php echo $row[2];?>">
                        <input type="hidden" name="idusuario_mod" value="<?php echo $row[1];?>">
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
                    <form name="COMPLEMENTARIOS" action="guarda_complementarios_mod_mun.php" method="post"> 
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
                                    <input type="text" class="form-control" name="direccion_dom" value="<?php echo $row[17];?>" >
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
                $sql_ac.= " idformacion_academica_p, descripcion_academica_p, entidad_academica_p, gestion_p ";
                $sql_ac.= " FROM nombre_academico WHERE idnombre='$row[2]'  AND posgrado !='' ORDER BY idnombre_academico";
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
                    <form name="FORM11" action="elimina_academico.php" method="post">
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
 
            <form name="POSGRADO" action="guarda_posgrado_mod_mun.php" method="post"> 
                <input type="hidden" name="idpersonal" value="<?php echo $row[0];?>">
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
                    <h5 class="text-primary">3.- DATOS LABORALES:</h5>                                 
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
                    <a class="btn btn-primary" href="datos_laborales_mun.php" >
                        ACTUALIZAR DATOS LABORALES                                
                    </a>                                    
                    </div>
                </div>
                </div>

                <hr>
                <div class="form-group row">
                    <h5 class="text-primary">4.- CONDICIÓN Y PERFIL ACTUAL:</h5>                                 
                </div>  

                <?php
                $sql_c = " SELECT idusuario, idnombre, usuario, password, fecha, condicion, perfil";
                $sql_c.= " FROM usuarios WHERE idusuario = '$row[1]' ";
                $result_c = mysqli_query($link,$sql_c);
                $row_c = mysqli_fetch_array($result_c);
                ?>

            <div class="form-group row">
                <div class="col-sm-3">
                <h6 class="text-primary">CONDICIÓN ACTUAL:</h6>
                </div>
                <div class="col-sm-3">
                <input type="text" class="form-control" name="estado_personal" value="<?php echo $row_c[5];?>" disabled>
                </div>
                <div class="col-sm-3">
                <h6 class="text-primary">PERFIL ACTUAL:</h6>
                </div>
                <div class="col-sm-3">
                <input type="text" class="form-control" name="estado_personal" value="<?php echo $row_c[6];?>" disabled>
                </div>
            </div>  
            <hr>
            <div class="form-group row">
                <div class="col-sm-6">
                <h4 class="text-primary">OPCIONES:</h4>
                </div>
                <div class="col-sm-6">
                </div>
            </div> 

        <form name="POSGRADO" action="guarda_estado_mod_mun.php" method="post">
        <input type="hidden" name="idusuario_mod" value="<?php echo $row[1];?>">
            <div class="form-group row">
                <div class="col-sm-3">
                <h6 class="text-primary">ACTUALIZAR CONDICIÓN A:</h6>
                </div>
                <div class="col-sm-3">

                <select name="condicion_mod"  id="condicion_mod" class="form-control" required >
                    <option selected>Seleccione</option>
                    <?php
                    $sqlv = " SELECT idcondicion, condicion FROM condicion ";
                    $resultv = mysqli_query($link,$sqlv);
                    if ($rowv = mysqli_fetch_array($resultv)){
                    mysqli_field_seek($resultv,0);
                    while ($fieldv = mysqli_fetch_field($resultv)){
                    } do {
                    ?>
                    <option value="<?php echo $rowv[1];?>" <?php if ($rowv[1]==$row_c[5]) echo "selected";?> ><?php echo $rowv[1];?></option>
                    <?php
                    } while ($rowv = mysqli_fetch_array($resultv));
                    } else {
                    }
                    ?>
                </select>

                </div>
                <div class="col-sm-3">
                <h6 class="text-primary">ACTUALIZAR PERFIL A:</h6>
                </div>
                <div class="col-sm-3">

                <select name="perfil_mod"  id="perfil_mod" class="form-control" required >
                    <option selected>Seleccione</option>
                    <?php
                    $sqlv = " SELECT idperfil, perfil FROM perfil ";
                    $resultv = mysqli_query($link,$sqlv);
                    if ($rowv = mysqli_fetch_array($resultv)){
                    mysqli_field_seek($resultv,0);
                    while ($fieldv = mysqli_fetch_field($resultv)){
                    } do {
                    ?>
                    <option value="<?php echo $rowv[1];?>" <?php if ($rowv[1]==$row_c[6]) echo "selected";?> ><?php echo $rowv[1];?></option>
                    <?php
                    } while ($rowv = mysqli_fetch_array($resultv));
                    } else {
                    }
                    ?>
                </select>
    
                </div>
            </div>  
            <div class="form-group row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                </div>
            </div>   

            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="text-center">
                    <a class="btn btn-info" href="#" data-toggle="modal" data-target="#estado">
                        ACTUALIZAR ESTADO DE PERSONAL                                
                    </a>                                    
                    </div>
                </div>
            </div>

                <!-- BEGIN Datos ESTADO PERSONAL Modal-->
                <div class="modal fade" id="estado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">¿ESTA SEGURO DE MODIFICAR EL ESTADO DEL USUARIO PERSONAL?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Seleccione la opcion para confirmar la modificación.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-info" type="submit">Confirmar Cambios</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                                <!-- END Datos ESTADO PERSONAL Modal-->  


                <hr>
<!------ SUBIDA DE DOCUMENTOS PERSONALES (BEGIN)----->
            <div class="form-group row">
                <div class="col-sm-6">
                <h5 class="text-primary">5.- DOCUMENTACIÓN:</h5></br>
                </div>
                <div class="col-sm-6">
                </div>
            </div> 
            <form name="FORM9" action="subir_documento_safci_mun.php" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <div class="col-sm-6">
                <h6 class="text-primary">SUBIR DOCUMENTOS EN UN SOLO ARCHIVO PDF:</br></br>1.- Fotocopia de CI (anverso y reverso)</br>2.- Primer Memorándun de designación.</br>3.- Memorandum actual.</h6>
                </div>
                <div class="col-sm-6">

                <input type="hidden" name="idpersonal" value="<?php echo $row[0];?>">
                  <input type="file" name="file" id="file" > 
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
<!------ SUBIDA DE DOCUMENTOS PERSONALES (BEGIN)----->     
                    

            <div class="form-group row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                </div>
            </div>     
            
            <hr>
                    
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
   
</body>

</html>
