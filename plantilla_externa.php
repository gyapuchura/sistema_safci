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
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                <img src="../img/banner_safci_index2.jpg" alt="10" class="img-thumbnail">
                <!-- End of Topbar -->
            <br> <br> 
                <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-2">     
                        </div>
                        <div class="col-md-2">
                        </div>
                </div>
                <div class="card shadow mb-4">
                        <div class="card-header py-3">                            
                        <div class="card-body">                        
                         
                        </div>  

                        <div class="card-body">

                        </div>                      

                        <div class="card-body">

                        </div>                    

                        <div class="card-body">                    
                        <!-- DESDE AQUI APARECE LA TABLA DE MACROCURRICULAS -->


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
                        <span>Ministerio de Salud y Deportes &copy; MSYD 2023</span>
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
