<?php include("../cabf.php");?>
<?php
session_start();
if(empty($_SESSION['active']))
{
  header('location: ../login.php');
}else{
  if($_SESSION['nivel'] != "2")
  {
    header('location: ../login.php');
}
require_once("../bd/database.php");
}

?>
<!doctype html>
    <html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>SAFCI Establecimientos</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="../CSS/regrrhh.css"> 
        <link rel="stylesheet" type="text/css" href="../assets/datatables/datatables.min.css"/>
        <!--<link rel="stylesheet" href="../assets/CSS/cuadernos.css"> -->
        
        <!--datables estilo bootstrap 4 CSS-->  
        <link rel="stylesheet"  type="text/css" href="../assets/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.min.css">
        
        <script src="../assets/jquery/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/localizacion.js"></script>
        <script type="text/javascript" src="../js/initMap.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk&callback=initMap"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>   

        <!--datables CSS básico-->

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet">  
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">  
        <!-- CSS only -->

    </head>

    <body>

        <div class="cont">
            <a class="brand pull-left" href="../ingreso.php"> -->
                <img width="100%" class="banner" src="../img/banner050620.jpg" alt="Ministerio de Salud y Deportes de Bolivia">
            </a>
        </div>
        <br>

        <!-- <div id="particles-js"></div> -->
        <div class="container11">
            <a href="../ingreso.php" id="btnhome" type="button" class="btn btn-info"><i class="material-icons">home</i>PROGRAMA SAFCI</a>
            <button id="btnNuevo" type="button" class="btn btn-info"><i class="material-icons">add_location</i>AÑADA SU ESTABLECIMIENTO DE SALUD</button>
            <a href="rrhhdirect.php" id="estab" type="button" class="btn btn-info"><i class="material-icons">person_add</i>AÑADA REGISTRO DE RRHH</a>
        </div>

        <div class="table-responsive">        
            <table id="tablaEst" class="table table-striped table-bordered table-condensed" style="width:100%" >
                <thead class="text-center">
                    <tr>
                        <th>ACCIONES</th>
                        <th>ESTID</th>
                        <th>DEPARTAMENTO</th>
                        <th>PROVINCIA</th>
                        <th>RED</th>
                        <th>MUNICIPIO</th>
                        <th>COD_MUN</th>
                        <th>TIPO</th>
                        <th>ESTABLECIMIENTO</th>
                        <th>SUBSECTOR</th>
                        <th>AMBITO</th>
                        <th>DEPENDENCIA</th>
                        <th>NIVEL</th>
                        <th>CODSNIS</th>
                        <th>LAT</th>
                        <th>LONGI</th>
                        <th>SOAPS</th>
                    </tr>
                </thead>
                <tbody>                           
                </tbody>        
            </table>               
        </div>

        <div class="overlay" id="overlay">
            <div class="popup" id="popup">
                <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="material-icons">clear</i></a>
                <h3>REGISTRO DE ESTABLECIMIENTOS DE SALUD</h3>
                <h4>* Use solo Mayúsculas  </h4>
                <form action="" id="formUsuarios">
                    <div class="contenedor-inputs">
                        <?php echo '<input type="hidden" name="USER" id="USER" value="'.$_SESSION['ID'].'"> '; ?>
                        <label for="DEPARTAMENTO">DEPARTAMENTO</label>
                        <select id="DEPARTAMENTO" class="form-control" name="DEPARTAMENTO" required>
                           <option value="">SELECCIONE DEPARTAMENTO</option>
                           <option value="1">LA PAZ</option>
                           <option value="2">ORURO</option>
                           <option value="3">POTOSI</option>
                           <option value="4">COCHABAMBA</option>
                           <option value="5">CHUQUISACA</option>
                           <option value="6">TARIJA</option>
                           <option value="7">PANDO</option>
                           <option value="8">BENI</option>
                           <option value="9">SANTA CRUZ</option>
                       </select>

                       <label for="MUNICIPIO">MUNICIPIO</label>
                       <select id="MUNICIPIO" class="form-control" required>
                        <option value="">MUNICIPIO</option>
                    </select>

                    <label for="RED">RED</label>
                    <select id="RED" class="form-control" required>
                        <option value="">RED DE SALUD</option>
                    </select>

                    <label for="PROVINCIA">PROVINCIA</label>
                    <select id="PROVINCIA" class="form-control" required>
                        <option value="">PROVINCIA</option>
                    </select>

                    <label for="TIPO">TIPO DE ESTABLECIMIENTO</label>
                    <select id="TIPO" class="form-control" required>
                        <option value="">TIPO DE ESTABLECIMIENTO</option>
                        <option value="CENTRO DE SALUD AMBULATORIO">CENTRO DE SALUD AMBULATORIO</option>
                        <option value="CENTRO DE SALUD CON INTERNACION">CENTRO DE SALUD CON INTERNACION</option>
                        <option value="CENTRO DE SALUD INTEGRAL">CENTRO DE SALUD INTEGRAL</option>
                        <option value="CONSULTORIO VECINAL">CONSULTORIO VECINAL</option>
                        <option value="PUESTO DE SALUD">PUESTO DE SALUD</option>
                        <option value="HOSPITAL DE SEGUNDO NIVEL">HOSPITAL DE SEGUNDO NIVEL</option>
                        <option value="HOSPITAL DE TERCER NIVEL">HOSPITAL DE TERCER NIVEL</option>
                        <option value="CENTRO DE AISLAMIENTO">CENTRO DE AISLAMIENTO</option>
                        <option value="ATENCION POR BRIGADA MOVIL">ATENCION POR BRIGADA MOVIL</option>
                        <option value="OFICINA DE COORDINACION">OFICINA DE COORDINACION</option>
                    </select>
                    <label for="SUBSECTOR">SUBSECTOR</label>
                    <select id="SUBSECTOR" class="form-control"required>
                        <option value="">SUB-SECTOR</option>
                        <option value="A">PUBLICO</option>
                        <option value="B">SEGURIDAD SOCIAL(CAJAS)</option>
                        <option value="C">ORGANISMOS NO GUBERNAMENTALES</option>
                        <option value="D">ORGANISMOS PRIVADOS</option>
                        <option value="E">FF.AA. DE LA NACION</option>
                        <option value="F">IGLESIA</option>
                        <option value="G">POLICIA NACIONAL</option>
                        <option value="H">UNIVERSIDAD</option>
                    </select>
                    <label for="ESTABLECIMIENTO">ESTABLECIMIENTO</label>
                    <input type="text" class="form-control" id="ESTABLECIMIENTO" placeholder="ESTABLECIMIENTO DE SALUD" minlength="4" style="text-transform:uppercase;" required>
                    <label for="AMBITO">AMBITO</label>
                    <select id="AMBITO" class="form-control" required>
                        <option value="">AMBITO</option>
                        <option value="R">RURAL</option>
                        <option value="U">URBANO</option>
                    </select>
                    <label for="DEPENDENCIA">DEPENDENCIA</label>
                    <select id="DEPENDENCIA" class="form-control" required>
                        <option value="">FINANCIAMIENTO DEL ESTABLECIMIENTO</option>
                        <option value="MINISTERIO DE SALUD">MINISTERIO DE SALUD</option>
                        <option value="GOBERNACION">GOBERNACION</option>
                        <option value="ALCALDIA MUNICIPAL">H. ALCALDÍA MUNICIPAL</option>
                        <option value="IGLESIA CATOLICA">IGLESIA CATOLICA</option>
                        <option value="UNIVERSIDAD">UNIVERSIDAD</option>
                        <option value="POLICIA NACIONAL">POLICIA NACIONAL</option>
                        <option value="OTRAS ONGS">OTRAS ONGS</option>                
                        <option value="C.I.E.S.">C.I.E.S.</option>
                        <option value="IGLESIA NO CATOLICA"> IGLESIA NO CATOLICA</option>
                        <option value="ARMADA">ARMADA</option>
                        <option value="CEMES">CEMES</option>
                        <option value="UNICEF-IGLESIA">UNICEF-IGLESIA</option>
                        <option value="CABILDO INDIGENAL">CABILDO INDIGENAL</option>
                    </select>
                    <label for="NIVEL">NIVEL</label>
                    <select id="NIVEL" class="form-control" required>
                        <option value="">NIVEL DE ATENCION</option>
                        <option value="1er NIVEL">1er NIVEL</option>
                        <option value="2do NIVEL">2do NIVEL</option>
                        <option value="3er NIVEL">3er NIVEL</option>
                        <option value="N/C">NO CORRESPONDE</option>
                    </select>
                    <label for="CODSNIS">CODIGO SNIS</label>
                    <input type="NUMBER" class="form-control" placeholder="CÓDIGO SNIS" min="0" max="999999" title="el valor del Código SNIS no debe ser inferior a 100000 ni superior a 999999" id="CODSNIS" required>
                    <label for="SOAPS">SOAPS</label>
                    <select id="SOAPS" class="form-control" required>
                        <option value="">SELECCIONE VERSION SOAPS</option>
                        <option value="NO CUENTA CON SOAPS">NO CUENTA CON SOAPS</option>
                        <option value="NO CORRESPONDE">NO CORRESPONDE</option>
                        <option value="SOAPS V.4.0.1">SOAPS V.4.0.1</option>
                        <option value="SOAPS V.5.0.0">SOAPS V.5.0.0</option>
                        <option value="SOAPS V.5.0.1">SOAPS V.5.0.1</option>
                        <option value="SOAPS V.5.0.1">SOAPS V.6.0.1</option>
                    </select>
                    <label for="LAT">LATITUD</label>
                    <input type="NUMBER" class="form-control" id="LAT" placeholder=" SELECCIONE LATITUD EN EL MAPA" min="-9.662687" max="-22.908152" title="Debe ingresar latitud correspondiente a Bolivia" readonly>
                    <label for="LONGI">LONGITUD</label>
                    <input type="number" class="form-control" id="LONGI" placeholder="Seleccione LONGITUD en el mapa" min="-57.452675" max="-69.626293" title="Debe ingresar Longitud correspondiente a Bolivia" readonly>
                    <input type="number" style="display:none" id="COD_MUN" readonly="readonly" >
                    <div class="formgroup">
                        <div id="safci" style="width: 860px; height: 250px;">

                        </div>
                        <h6>Arrastre el marcador rojo para seleccionar la ubicacion de su Establecimiento de salud</h6>
                    </div>
                </div>
                <input type="submit" class="btn btn-dark btn-block" action="" name="guardar" value="GUARDAR REGISTRO">
                <input type="reset" class="btn btn-light btn-block" name="limpiar" value="Limpiar formulario">
            </form>
        </div>
    </div>

    <div id="footer"></div>
    <!-- jQuery, Popper.js, Bootstrap JS -->

    <script type="text/javascript" src="../assets/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../js/estabdep.js"></script>
    <script type="text/javascript" src="../js/mainrrhh.js"></script>
    <script type="text/javascript" src="../js/ajaxestablecimiento2.js"></script>
    <script src="../js/particles.js"></script>
    <script src="../js/app.js"></script>
    <script type="text/javascript" src="../js/foot.js"></script>

</body>
</html>