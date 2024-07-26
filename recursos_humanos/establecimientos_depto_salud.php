<?php include("../cabf.php");?>
<?php include("../inc.config.php"); 

$iddepartamento = $_POST["departamento"];
?>
<div class="table-responsive">
    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
        <thead>
            <tr>  
                <th>N°</th>                                    
                <th>CÓDIGO</th>
                <th>DEPARTAMENTO</th>
                <th>RED DE SALUD</th>
                <th>MUNICIPIO</th>
                <th>ESTABLECIMIENTO DE SALUD</th>
                <th>NIVEL</th>  
                <th>ACTUALIZADO POR:</th>                
                <th>ACCIÓN</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $numero=1;
    $sql =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.codigo_establecimiento, municipios.municipio,  ";
    $sql.=" establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, red_salud.red_salud, departamento.departamento, ";
    $sql.=" establecimiento_salud.idusuario FROM establecimiento_salud, municipios, nivel_establecimiento, red_salud, departamento";
    $sql.=" WHERE establecimiento_salud.idmunicipio=municipios.idmunicipio AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
    $sql.=" AND red_salud.iddepartamento=departamento.iddepartamento AND establecimiento_salud.idred_salud=red_salud.idred_salud ";
    $sql.=" AND establecimiento_salud.iddepartamento='$iddepartamento' ORDER BY establecimiento_salud.idestablecimiento_salud ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
        <tr>
            <td><?php echo $numero;?></td>
            <td><?php echo $row[1];?></td>
            <td><?php echo $row[6];?></td>
            <td><?php echo $row[5];?></td>
            <td><?php echo $row[2];?></td>
            <td><?php echo $row[3];?></td>
            <td><?php echo $row[4];?></td>
            <td><?php                                
            $sqlu =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre ";
            $sqlu.=" WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[7]'";
            $resultu = mysqli_query($link,$sqlu);
            if ($rowu = mysqli_fetch_array($resultu)){                            
            echo mb_strtoupper($rowu[0]." ".$rowu[1]." ".$rowu[2]);
            }
            else{ 
                echo '<p class="text-warning">SIN ACTUALIZAR</p>';
            }
            ?></td>
            <td>
            <form name="FORM_RED" action="valida_establecimiento_salud.php" method="post">
            <input name="idestablecimiento_salud" type="hidden" value="<?php echo $row[0];?>">
                <button type="submit" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-hospital"></i>
                </span>
                <span class="text">VER E.E.S.S.</span>    
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
