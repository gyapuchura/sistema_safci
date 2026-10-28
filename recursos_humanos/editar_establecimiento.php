<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];

$sql = " SELECT idestablecimiento_salud, iddepartamento, idred_salud, idmunicipio, codigo_establecimiento, establecimiento_salud, ";
$sql.= " idtipo_establecimiento, idnivel_establecimiento, idsubsector_salud, iddependencia_institucion, idambito_local, ";
$sql.= " latitud, longitud, idusuario, fecha_registro FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);

/****** sello actual del establecimiento (consulta aparte para no romper la página si falta la columna sello_eess) ****/
$sello_eess_actual = '';
$result_se = @mysqli_query($link," SELECT sello_eess FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ");
if ($result_se && $row_se = mysqli_fetch_array($result_se)) {
    $sello_eess_actual = $row_se[0];
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

    <style>
    .filtro {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: center;
      margin-bottom: 10px;
    }
    select {
      margin-right: 10px;
    }
    #location {
      margin-top: 10px;
    }
  </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
<!-- BEGIN aqui va el TITULO de la pagina ---->
                <div class="row">
                    <div class="col-lg-12">
                    <div class="p-3">               
                    <div class="text-center">   
                <a href="registro_establecimiento.php"><h6 class="text-info"><i class="fas fa-fw fa-arrow-left"></i>VOLVER</h6></a>                   
                    <hr>   
                    <h4 class="text-info">MODIFICAR REGISTRO </h4>                  
                    <h4 class="text-info">ESTABLECIMIENTO DE SALUD</h4>
                    <hr>  
                    <h4 class="text-secundary"><?php echo $row[5]; ?></h4>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

<form name="ESTABLECIMIENTO" action="guarda_establecimiento_mod.php" method="post">  
                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
 
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddepartamento, departamento FROM departamento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[1]) echo "selected";?> ><?php echo $rowv[1];?></option>
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

                    <select name="idred_salud"  id="idred_salud" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idred_salud, red_salud FROM red_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[2]) echo "selected";?> ><?php echo $rowv[1];?></option>
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
                    <h6 class="text-primary">MUNICIPIO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="idmunicipio"  id="idmunicipio" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idmunicipio, municipio FROM municipios ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[3]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">CÓDIGO DE ESTABLECIMIENTO:</h6>
                        <input type="text" class="form-control" name="codigo_establecimiento" value="<?php echo $row[4];?>" required >
                    </div>
                    <div class="col-sm-8">
                    <h6 class="text-primary">NOMBRE DEL ESTABLECIMIENTO DE SALUD:</h6>
                    <textarea class="form-control" rows="2" name="establecimiento_salud" required ><?php echo $row[5];?></textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">NIVEL DE ESTABLECIMIENTO:</h6>

                    <select name="idnivel_establecimiento"  id="idnivel_establecimiento" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idnivel_establecimiento, nivel_establecimiento FROM nivel_establecimiento WHERE nivel_oficial='NIVEL' ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[7]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                 
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-primary">TIPO DE ESTABLECIMIENTO:</h6>

                    <select name="idtipo_establecimiento"  id="idtipo_establecimiento" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idtipo_establecimiento, tipo_establecimiento FROM tipo_establecimiento ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[6]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-primary">SUB-SECTOR SALUD:</h6>

                    <select name="idsubsector_salud"  id="idsubsector_salud" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idsubsector_salud, subsector_salud FROM subsector_salud ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[8]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                  
                    </div>
                </div>
                <hr>
                <div class="form-group row">                               
                    <div class="col-sm-6">
                    <h6 class="text-primary">DEPENDENCIA INSTITUCIONAL:</h6>

                    <select name="iddependencia_institucion"  id="iddependencia_institucion" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT iddependencia_institucion, dependencia_institucion FROM dependencia_institucion ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[9]) echo "selected";?> ><?php echo $rowv[1];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>

                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-primary">ÁMBITO LOCAL:</h6>

                    <select name="idambito_local"  id="idambito_local" class="form-control" required >
                        <option selected>Seleccione</option>
                        <?php
                        $sqlv = " SELECT idambito_local, ambito_local, descripcion FROM ambito_local ";
                        $resultv = mysqli_query($link,$sqlv);
                        if ($rowv = mysqli_fetch_array($resultv)){
                        mysqli_field_seek($resultv,0);
                        while ($fieldv = mysqli_fetch_field($resultv)){
                        } do {
                        ?>
                        <option value="<?php echo $rowv[0];?>" <?php if ($rowv[0]==$row[10]) echo "selected";?> ><?php echo $rowv[1];?>.- <?php echo $rowv[2];?></option>
                        <?php
                        } while ($rowv = mysqli_fetch_array($resultv));
                        } else {
                        }
                        ?>
                    </select>
                    
                    </div>
                </div>
                <hr>
                <div class="depa"></div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <h4 class="text-primary">ACTUALIZAR UBICACIÓN GEOGRÁFICA DEL ESTABLECIMIENTO</h4>
                    </div>
                </div>   

                <div class="form-group row">
                    <div class="col-sm-6">
                        <h6 class="text-primary">LATITUD</h6>
                        <input type="NUMBER" name="latitud" class="form-control" id="lat" placeholder=" Seleccione LATITUD en el mapa" value="<?php if ($row[11] != '') {echo $row[11];} else {echo "-17.567775";}?>" min="-9.662687" max="-22.908152" title="Debe ingresar latitud correspondiente a Bolivia" readonly required>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">LONGITUD</h6>
                        <input type="number"  name="longitud" class="form-control" id="lng" placeholder="Seleccione LONGITUD en el mapa" value="<?php if ($row[11] != '') {echo $row[12];} else {echo "-66.346216";}?>" min="-57.452675" max="-69.626293" title="Debe ingresar Longitud correspondiente a Bolivia" readonly required>
                       <!-- <input type="number" style="display:none" id="COD_MUN" readonly="readonly" > --->
                    </div>
                </div>   
                <hr>
                <div class="form-group row">
                    <div class="col-sm-12">
                    <h6>Arrastre el marcador azul para seleccionar la ubicacion del ESTABLECIMIENTO DE SALUD</h6>
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="col-sm-12" id="safci" style="width: 700px; height: 500px;">
                    </div>
                </div>  
                 
                <hr>

                
    <!-------- begin rejilla --------->   
                <div class="form-group row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>


    <!-------- end rejilla --------->                      
 
    <div class="text-center">
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    MODIFICAR REGISTRO
                    </button>  
                </div> 
            </div>                              
                            
                   <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">REGISTRAR ESTABLECIMIENTO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            Esta seguro de Registrar el Establecimiento de Salud?
                            posteriormenete no se podran realizar cambios.

                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>
                   <!-- modal de confirmacion de envio de datos-->

<!---------------- SUBIDA DEL SELLO DEL ESTABLECIMIENTO (PNG SIN FONDO), FORMULARIO APARTE ----------->
                <hr>
            <div class="form-group row" id="sello_eess">
                <div class="col-sm-12 text-left">
                <h4 class="text-primary">SELLO DEL ESTABLECIMIENTO DE SALUD</h4>
                </div>
            </div>

            <?php if (isset($_GET['sello_eess'])) { ?>
                <?php if ($_GET['sello_eess'] == 'ok') { ?>
                <div class="alert alert-success">EL SELLO DEL ESTABLECIMIENTO SE GUARDÓ CORRECTAMENTE.</div>
                <?php } else { ?>
                <div class="alert alert-danger">NO SE PUDO GUARDAR EL SELLO DEL ESTABLECIMIENTO, VUELVA A INTENTAR CON OTRA IMAGEN.</div>
                <?php } ?>
            <?php } ?>

            <form name="SELLO_EESS" id="form_sello_eess" action="subir_sello_eess_mod.php" method="post">
            <input type="hidden" name="sello_eess_png" id="sello_eess_png">
            <div class="form-group row text-left">
                <div class="col-sm-6">
                <h6 class="text-primary">SUBIR FOTOGRAFÍA DEL SELLO DEL ESTABLECIMIENTO (JPG o PNG):</br></br>1.- Sellar sobre una hoja blanca.</br>2.- Tomar la foto de frente, con buena luz y sin sombras.</br>3.- El sistema quitará el fondo y lo guardará como PNG transparente.</h6>
                </br>
                <input type="file" id="file_sello_eess" accept="image/png, image/jpeg, image/webp">
                </br></br>
                <h6 class="text-primary">LIMPIEZA DEL FONDO: <span id="nivel_valor_eess">-</span>
                    <a href="#" id="nivel_auto_eess" class="small ml-2" style="display:none;">(volver a automático)</a></h6>
                <input type="range" class="custom-range" id="nivel_limpieza_eess" min="0" max="100" value="30" disabled>
                <small class="text-muted">El sistema elige el valor automáticamente. Súbalo si quedan restos o sombras del papel; bájelo si se borra parte del sello.</small>
                <div id="aviso_sello_eess" class="alert alert-warning small mt-2" style="display:none;"></div>
                </div>
                <div class="col-sm-6">
                <h6 class="text-primary">VISTA PREVIA (SIN FONDO):</h6>
                <div class="btn-group btn-group-sm mb-2" role="group" id="vista_sello_eess">
                    <button type="button" class="btn btn-outline-primary active" data-vista="cuadros">Transparente</button>
                    <button type="button" class="btn btn-outline-primary" data-vista="blanco">Sobre blanco</button>
                    <button type="button" class="btn btn-outline-primary" data-vista="original">Foto original</button>
                </div>
                <div id="fondo_vista_eess" class="border rounded p-2 text-center" style="min-height:150px; background-color:#fff; background-image:linear-gradient(45deg,#ddd 25%,transparent 25%),linear-gradient(-45deg,#ddd 25%,transparent 25%),linear-gradient(45deg,transparent 75%,#ddd 75%),linear-gradient(-45deg,transparent 75%,#ddd 75%); background-size:20px 20px; background-position:0 0,0 10px,10px -10px,-10px 0;">
                    <canvas id="canvas_sello_eess" style="max-width:100%; display:none;"></canvas>
                    <img id="img_original_eess" style="max-width:100%; display:none;" alt="Foto original">
                    <span id="sin_sello_eess" class="text-muted small">Seleccione una imagen para ver la vista previa.</span>
                </div>
                <?php if ($sello_eess_actual != '') { ?>
                </br>
                <h6 class="text-primary">SELLO ACTUAL DEL ESTABLECIMIENTO:</h6>
                <img src="../<?php echo htmlspecialchars($sello_eess_actual);?>?v=<?php echo time();?>" style="max-width:100%; max-height:150px;" alt="Sello actual">
                <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                <a class="btn btn-primary" href="#" id="btn_sello_eess" data-toggle="modal" data-target="#sello_eess_modal">
                    GUARDAR SELLO DEL ESTABLECIMIENTO
                </a>
                </div>

                <div class="modal fade" id="sello_eess_modal" tabindex="-1" role="dialog" aria-labelledby="selloEessModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="selloEessModalLabel">¿ESTA SEGURO DE GUARDAR EL SELLO DEL ESTABLECIMIENTO?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Se guardará la imagen tal como se ve en la vista previa. Si el establecimiento ya tenía un sello registrado, será reemplazado.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit">CONFIRMAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
<!---------------- FIN SUBIDA DEL SELLO DEL ESTABLECIMIENTO ----------->

        <div class="form-group row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
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

    <!-- scripts para calendario -->

    <script type="text/javascript" src="../js/municipios.js"></script>
    <script type="text/javascript" src="../js/establecimientos.js"></script>

    <script>
/** ubicacion actual de acuerdo a la ubicacion del establecimiento de salud = -16.5113374610014, -68.13400675671315 */
/** ubicacion prueba -16.536361, -68.154571*/

  var map = L.map('safci').setView([<?php if ($row[11] != '') {echo $row[11];} else {echo "-17.567775";}?>, <?php if ($row[11] != '') {echo $row[12];} else {echo "-66.346216";}?>], <?php if ($row[11] != '') {echo "16";} else {echo "6";}?>);

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: ' ',
    maxZoom: 18
  }).addTo(map);
  
  var datosGjson; // Asegúrate de cargar correctamente tus datos GeoJSON

  function Filtrarnivel(DEPARTAMEN) {
    return datosGjson.features.filter(function(feature) {
      return feature.properties.DEPARTAMEN === DEPARTAMEN;
    });
  }

  document.getElementsByClassName('depa')[0].addEventListener('change', function() {
    var depsel = this.value;
    var municipiosel = Filtrarnivel(depsel);
    var selectmun = document.getElementsByClassName('Mun')[0];
    selectmun.innerHTML = ''; // Limpiar opciones actuales

    municipiosel.forEach(function(munis) {
      var option = document.createElement('option');
      option.value = munis.properties.MUNICIPIO;
      option.textContent = munis.properties.MUNICIPIO; // Agregar texto de visualización
      selectmun.appendChild(option);
    });
  });

  function getColor(d) {
    return  d === 'Beni' ? '#E37CA8' :
            d === 'Chuquisaca' ? '#FD8D3C' : 
            d === 'Cochabamba' ? '#FC4E2A' :
            d === 'La Paz' ? '#E3E17C' : 
            d === 'Oruro' ? '#BD0026' :
            d === 'Pando' ? '#7CE3A8' : 
            d === 'Potosí' ? '#00A65A' :  
            d === 'Santa Cruz' ? '#7C7FE3' :
            d === 'Tarija' ? '#800026' :
            '#FFEDA0'; 
  }

  function style(feature) { 
    return { 
      fillColor: getColor(feature.properties.DEPARTAMEN), 
      weight: 1, 
      opacity: 1, 
      color: 'black', 
      dashArray: '2', 
      fillOpacity: 0.1 
    }; 
  }

  function popup(feature, layer) { 
    layer.bindPopup('<h3> Municipio: ' + feature.properties.MUNICIPIO + '</h3><h4> Departamento: ' + feature.properties.DEPARTAMEN + '</h4>');
  }
  
  L.geoJson(municipios, { style: style, onEachFeature: popup }).addTo(map);
  L.control.scale().addTo(map); 

  // Crear un marcador
  var marker = L.marker([<?php if ($row[11] != '') {echo $row[11];} else {echo "-17.567775";}?>, <?php if ($row[11] != '') {echo $row[12];} else {echo "-66.346216";}?>], { draggable: true }).addTo(map);

  // Listener para el movimiento del marcador
  marker.on('dragend', function(event) {
    var position = marker.getLatLng();
    document.getElementById('lat').value = position.lat.toFixed(6); // Mostrar latitud
    document.getElementById('lng').value = position.lng.toFixed(6); // Mostrar longitud
  });
</script>


    <!-- scripts para calendario -->
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>

    <!-- quitar fondo del sello del establecimiento (se procesa en el navegador y se envía como PNG) -->
    <script src="../js/sello_sin_fondo.js"></script>
    <script>
    (function () {
        var MAX_LADO = 1000;   // tamaño máximo del sello guardado (px)

        var entrada    = document.getElementById('file_sello_eess');
        var nivel      = document.getElementById('nivel_limpieza_eess');
        var nivelValor = document.getElementById('nivel_valor_eess');
        var nivelAuto  = document.getElementById('nivel_auto_eess');
        var aviso      = document.getElementById('aviso_sello_eess');
        var canvas     = document.getElementById('canvas_sello_eess');
        var imgOrig    = document.getElementById('img_original_eess');
        var fondoVista = document.getElementById('fondo_vista_eess');
        var sinSello   = document.getElementById('sin_sello_eess');
        var botones    = document.querySelectorAll('#vista_sello_eess button');
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

        /* sin jQuery: esta página carga jQuery dos veces y el segundo reemplaza al primero */
        for (var i = 0; i < botones.length; i++) {
            botones[i].addEventListener('click', function () {
                for (var j = 0; j < botones.length; j++) botones[j].classList.remove('active');
                this.classList.add('active');
                vista = this.getAttribute('data-vista');
                actualizarVista();
            });
        }

        entrada.addEventListener('change', function () {
            var archivo = this.files[0];
            prep = null;
            hayResultado = false;
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
                canvas.width = res.imageData.width;
                canvas.height = res.imageData.height;
                canvas.getContext('2d').putImageData(res.imageData, 0, 0);
            } else {
                sinSello.textContent = 'No se detectó el sello, baje el nivel de limpieza.';
            }
            actualizarVista();
        }

        document.getElementById('form_sello_eess').addEventListener('submit', function (e) {
            if (!prep || !hayResultado) {
                e.preventDefault();
                document.querySelector('#sello_eess_modal [data-dismiss="modal"]').click();
                alert('Primero seleccione la fotografía del sello y revise la vista previa.');
                return;
            }
            document.getElementById('sello_eess_png').value = canvas.toDataURL('image/png');
        });
    })();
    </script>
</body>

</html>

