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
                    <hr>                     
                    <h4 class="text-primary">NUEVA ÁREA DE INFLUENCIA</h4>
                    </div>
<!-- END Del TITULO de la pagina ---->

<!-- BEGIN aqui va el comntenido de la pagina ---->

        <form name="INFLUENCIA" action="guarda_area_influencia.php" method="post">  
                <div class="col-lg-12">  
                    <div class="p-5"> 

                    <div class="form-group row">
                    <div class="col-sm-3">
                    <h6 class="text-primary">DEPARTAMENTO:</h6>
                    </div>
                    <div class="col-sm-9">
                    <select name="iddepartamento"  id="iddepartamento" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT iddepartamento, departamento FROM departamento";
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
                    <select name="idred_salud" id="idred_salud" class="form-control" required></select>
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

                <hr>
                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">TIPO DE ÁREA DE INFLUENCIA:</h6>
                    <select name="idtipo_area_influencia"  id="idtipo_area_influencia" class="form-control" required>
                        <option value="">ELEGIR</option>
                        <?php
                        $sql1 = "SELECT idtipo_area_influencia, tipo_area_influencia FROM tipo_area_influencia ";
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
                    <div class="col-sm-8">
                    <h6 class="text-primary">NOMBRE O DENOMINACIÓN:</h6>
                    <textarea class="form-control" rows="2" name="area_influencia" required></textarea>
                    </div>
                </div>
                <div class="form-group row"> 
                    <div class="col-sm-12" id="nacion">                 
                    </div>
                </div>


                <hr>

                <div class="form-group row">                               
                    <div class="col-sm-4">
                    <h6 class="text-primary">CANTIDAD DE HABITANTES (Según lista de afiliados):</h6>
                        <input type="text" class="form-control" 
                        placeholder="Cantidad de habitantes" name="habitantes" required>
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-primary">NÚMERO DE FAMILIAS (Según lista de afiliados):</h6>
                        <input type="text" class="form-control" 
                        placeholder="Cantidad de Familias" name="familias" required>                
                    </div>
                    <div class="col-sm-4">
                    <h6 class="text-primary">DISTANCIA HACIA EL ESTABLECIMIENTO DE SALUD EN Km (Vía Terrestre):</h6>
                        <input type="text" class="form-control" 
                        placeholder="Kilometros" name="distancia" required>                
                    </div>
                </div>
                <div class="depa"></div> 

                <div class="form-group row">
                    <div class="col-sm-12">
                        <h4 class="text-primary">UBICACIÓN GEOGRÁFICA CENTRAL DEL ÁREA DE INFLUENCIA</h4>
                    </div>
                </div>   
                <div class="form-group row">
                    <div class="col-sm-6">
                        <h6 class="text-primary">LATITUD</h6>
                        <input type="NUMBER" name="latitud" class="form-control" id="lat" placeholder=" Seleccione LATITUD en el mapa" min="-9.662687" max="-22.908152" title="Debe ingresar latitud correspondiente a Bolivia" readonly required>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary">LONGITUD</h6>
                        <input type="number"  name="longitud" class="form-control" id="lng" placeholder="Seleccione LONGITUD en el mapa" min="-57.452675" max="-69.626293" title="Debe ingresar Longitud correspondiente a Bolivia" readonly required>
                       <!-- <input type="number" style="display:none" id="COD_MUN" readonly="readonly" > --->
                    </div>
                </div>   
                <hr>
                <div class="form-group row">
                <div class="col-sm-12" id="safci" style="width: 700px; height: 500px;">
                    </div>
                    <div class="col-sm-3">
                    <h6>Arrastre el marcador rojo para seleccionar la ubicacion de su Establecimiento de salud</h6>
                    </div>
                </div>  
                
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
                            REGISTRAR ÁREA DE INFLUENCIA
                            </button>  
                        </div>                              
                    </div>
                </div>          

                   <!-- modal de confirmacion de envio de datos-->
                   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR ÁREA DE INFLUENCIA</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                    Esta seguro de Registrar el Área de Influencia?
                                    posteriormenete no se podrán realizar cambios.

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-primary pull-center">CONFIRMAR REGISTRO</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <!-- Modal -->
                
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

    <!-- scripts para uso de mapas -->

        <script type="text/javascript" src="../js/municipios.js"></script>
        <script type="text/javascript" src="../js/establecimientos.js"></script>
        <script>
            /** ubicacion actual de acuerdo a la ubicacion del establecimiento de salud = -16.5113374610014, -68.13400675671315 */
            /** ubicacion prueba -16.536361, -68.154571*/

            var map = L.map('safci').setView([-16.5113374610014, -68.13400675671315], 6);

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
            var marker = L.marker([-16.5113374610014, -68.13400675671315], { draggable: true }).addTo(map);

            // Listener para el movimiento del marcador
            marker.on('dragend', function(event) {
                var position = marker.getLatLng();
                document.getElementById('lat').value = position.lat.toFixed(6); // Mostrar latitud
                document.getElementById('lng').value = position.lng.toFixed(6); // Mostrar longitud
            });
            </script>
            
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/datepicker-es.js"></script>
        <script>$("#fecha1").datepicker($.datepicker.regional[ "es" ]);</script>


        <script language="javascript">
        $(document).ready(function(){
        $("#idtipo_area_influencia").change(function () {
                    $("#idtipo_area_influencia option:selected").each(function () {
                        tipo_area_influencia=$(this).val();
                    $.post("nacion.php", {tipo_area_influencia:tipo_area_influencia}, function(data){
                    $("#nacion").html(data);
                    });
                });
        })
        });
        </script>

        <script language="javascript">
        $(document).ready(function(){
        $("#iddepartamento").change(function () {
                    $("#iddepartamento option:selected").each(function () {
                        departamento=$(this).val();
                    $.post("red_salud_o.php", {departamento:departamento}, function(data){
                    $("#idred_salud").html(data);
                    });
                });
        })
        });
        </script>
        <script language="javascript">
        $(document).ready(function(){
        $("#idred_salud").change(function () {
                    $("#idred_salud option:selected").each(function () {
                        red_salud=$(this).val();
                    $.post("establecimiento_salud_o.php", {red_salud:red_salud}, function(data){
                    $("#idestablecimiento_salud").html(data);
                    });
                });
        })
        });
        </script>
      

   
</body>

</html>
