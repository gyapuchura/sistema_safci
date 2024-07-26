<?php include("cabf.php");?>
<?php include("inc.config.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SISTEMA SAFCI</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                <!-- Topbar -->
                <img src="img/banner_index.png" alt="10" class="img-thumbnail">
                <!-- End of Topbar -->
            <br> <br> 
                <div class="row">
                        <div class="col-md-4">
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary">ÁREA DE CONOCIMIENTO -> MACROCURRICULAS --> MICROCURRÍCULAS</h6>
                        <br>
                        </div>
                        <div class="col-md-4">

                        <input type="text" class="form-control" placeholder="ESCRIBA LA TEMÁTICA DE INTERÉS" id="busqueda" />
					    <div id="resultado"></div>

                        </div>
                        <div class="col-md-2">
                        <form class="user" method="post" action="login_cge.php" >
                                <button type="submit" class="btn btn-primary">
                                    INGRESO A SISTEMA 
                                </button>                                
                        </form>      
                        </div>
                        <div class="col-md-2">
                        <form class="user" method="post" action="index.php" >
                                <button type="submit" class="btn btn-link">
                                    VOLVER
                                </button>                                
                        </form> 
                        </div>
                </div>
                <div class="card shadow mb-4">
                        <div class="card-header py-3">                            
                        <div class="card-body">                        
                        <select name="gestion" id="gestion" class="form-control">
                                    <option value="">Elegir Gestión</option>
                                    <?php
                                    /*
                                    Realizamos una consulta ala tabla autor
                                    para mostrar los datos en un combo
                                    */
                                    $sql1 = "SELECT gestion FROM macrocurricula WHERE correlativo!='0' GROUP BY gestion ";
                                    $result1 = mysqli_query($link,$sql1);
                                    if ($row1 = mysqli_fetch_array($result1)){
                                    mysqli_field_seek($result1,0);
                                    while ($field1 = mysqli_fetch_field($result1)){
                                    } do {
                                    echo "<option value=". $row1[0]. ">". $row1[0]. "</option>";
                                    } while ($row1 = mysqli_fetch_array($result1));
                                    } else {
                                    echo "No se encontraron resultados!";
                                    }
                                    ?>
                                    </select>                           
                        </div>  

                        <div class="card-body">
                        <select name="idarea_conocimiento"  id="idarea_conocimiento" class="form-control"></select>
                        </div>                      

                        <div class="card-body">
                        <select name="idmacrocurricula" id="idmacrocurricula" class="form-control"></select>
                        </div>                    

                        <div class="card-body">                    
                        <!-- DESDE AQUI APARECE LA TABLA DE MACROCURRICULAS -->

                        <div id="microcurricula_index"> </div>

                        <!-- HASTA AQUI APARECE LA TABLA DE MACROCURRICULAS -->

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
               
             

              



                </div>

                </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Centro de Capacitación &copy; CENCAP 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

  <!-- script para filtrar macrocurricula  -->
    <script language="javascript">
        $(document).ready(function(){
        $("#gestion").change(function () {
            $("#gestion option:selected").each(function () {
                gestion_area=$(this).val();
                $.post("areas.php", {gestion_area:gestion_area}, function(data){
                $("#idarea_conocimiento").html(data);
                });
                });
            })
            });
    </script>


    <script language="javascript">
        $(document).ready(function(){
        $("#idarea_conocimiento").change(function () {
            $("#idarea_conocimiento option:selected").each(function () {
                area_conocimiento=$(this).val();
                $.post("macros.php", {area_conocimiento:area_conocimiento}, function(data){
                $("#idmacrocurricula").html(data);
                });
                });
            })
            });
    </script>

<!-- script para aprecer datatables con combo  -->
    <script language="javascript">
    $(document).ready(function(){
    $("#idmacrocurricula").change(function () {
            $("#idmacrocurricula option:selected").each(function () {
                macrocurricula=$(this).val();
                $.post("micro_index.php", {macrocurricula:macrocurricula}, function(data){
                $("#microcurricula_index").html(data);
                });
            });
    })
    });
    </script>

<script src="jquery.min.js"></script>

		<script>

			$(document).ready(function(){

				  var consulta;

				  //hacemos focus al campo de b�squeda
				  $("#busqueda").focus();

				  //comprobamos si se pulsa una tecla
				  $("#busqueda").keyup(function(e){

						//obtenemos el texto introducido en el campo de b�squeda
						consulta = $("#busqueda").val();

						 //hace la b�squeda

							 $.ajax({
								   type: "POST",
								   url: "buscar_tematica_panel.php",
								   data: "b="+consulta,
								   dataType: "html",
								   beforeSend: function(){
											  //imagen de carga
										   $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
								   },
								   error: function(){
										   alert("error petici�n ajax");
									 },
								  success: function(data){
										$("#resultado").empty();
										$("#resultado").append(data);
										//$("#busqueda").val(consulta);
									}
							});
				  });
			});

		</script>
</body>

</html>
