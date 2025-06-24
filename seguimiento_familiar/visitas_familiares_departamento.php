<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$iddepartamento = $_POST["departamento"];
?>
                <div class="text-center">
                <div class="form-group row"> 
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-info btn-icon-split" href="visitas_safci_diarias_dep.php?iddepartamento=<?php echo $iddepartamento;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=1000,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">REPORTE DE VISITAS EN EL DEPARTAMENTO</span></a>
                    </div>
                </div>   
                <hr>

    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#example_dep').DataTable( {
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]] ,
                        "language": {
                            "lengthMenu": "Mostrar _MENU_ registros por pagina",
                            "zeroRecords": "No se encontraron resultados en su busqueda",
                            "searchPlaceholder": "Buscar registros",
                            "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                            "infoEmpty": "No existen registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "search": "Buscar:",
                            "paginate": {
                                "first":    "Primero",
                                "last":    "Último",
                                "next":    "Siguiente",
                                "previous": "Anterior"
                            },
                        }
                    } );
                } );
        </script>
