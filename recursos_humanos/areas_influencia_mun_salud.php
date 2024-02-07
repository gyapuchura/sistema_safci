<?php include("../inc.config.php"); 
$idmunicipio = $_POST["municipio_salud"];
?>
<div class="table-responsive">
        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
            <thead>
                <tr>  
                    <th>N°</th>                                    
                    <th>DEPARTAMENTO</th>
                    <th>RED DE SALUD</th>
                    <th>ESTABLECIMIENTO DE SALUD</th>
                    <th>TIPO DE ÁREA DE INFLUENCIA</th>
                    <th>DENOMINACIÓN DEL ÁREA DE INFLUENCIA</th>
                    <th>REGISTRADA POR:</th>
                    <th>ACCIÓN</th>
                    <th>CARPETAS FAMILIARES</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $numero=1; 
        $sql =" SELECT area_influencia.idarea_influencia, departamento.departamento, red_salud.red_salud, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia,   ";
        $sql.=" area_influencia.area_influencia, nombre.nombre, nombre.paterno, nombre.materno FROM area_influencia, departamento, red_salud, tipo_area_influencia, establecimiento_salud, usuarios, nombre  ";
        $sql.=" WHERE area_influencia.iddepartamento=departamento.iddepartamento AND area_influencia.idred_salud=red_salud.idred_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
        $sql.=" AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ";
        $sql.=" AND establecimiento_salud.idmunicipio='$idmunicipio' ORDER BY area_influencia.idarea_influencia DESC  ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <tr>
                <td><?php echo $numero;?></td>
                <td><?php echo $row[1];?></td>
                <td><?php echo $row[2];?></td>
                <td><?php echo $row[3];?></td>
                <td><?php echo $row[4];?></td>
                <td><?php echo mb_strtoupper($row[5]);?></td>
                <td><?php echo mb_strtoupper($row[6]." ".$row[7]." ".$row[8]);?></td>
                <td>
                <form name="FORM_RED" action="valida_area_influencia.php" method="post">
                <input name="idarea_influencia" type="hidden" value="<?php echo $row[0];?>">
                <button type="submit" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">VER DETALLES</span>
                </button>
                </form>                                                                          
                </td>
                <td>
        <!--          <form name="FORM_RED" action="#valida_area_influencia_cf.php" method="post"> --->
                <input name="idarea_influencia" type="hidden" value="<?php echo $row[0];?>">
                <input name="idarea_influencia" type="hidden" value="<?php echo $row[0];?>">
                <button type="submit" class="btn btn-warning btn-icon-split">
                <span class="icon text-yellow-600">
                <i class="fas fa-fw fa-folder"></i>
                </span>
                <span class="text">CARPETAS FAMILIARES</span>
                </button>
                </form>                                                                          
                </td>
            </tr>
                        
        <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
            </tbody>
        </table>
    </div>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
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
