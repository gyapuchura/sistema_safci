<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$iddepartamento = $_POST["departamento"];
?>
<div class="table-responsive">
        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
            <thead>
                <tr>  
                    <th>N°</th>  
                    <th>CÓDIGO NOTIFICACIÓN</th>                                  
                    <th>DEPTO</th>
                    <th>MUNICIPIO</th>
                    <th>ESTABLECIMIENTO</th>                                      
                    <th>SEMANA EPIDEM.</th>
                    <th>USUARIO:</th>
                    <th>FECHA</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $numero=1; 
    $sql =" SELECT notificacion_ep.idnotificacion_ep, notificacion_ep.codigo, departamento.departamento, red_salud.red_salud,  ";
    $sql.=" municipios.municipio, establecimiento_salud.establecimiento_salud, notificacion_ep.semana_ep, ";
    $sql.=" notificacion_ep.fecha_registro, notificacion_ep.hora_registro, nombre.nombre, nombre.paterno, nombre.materno, ";
    $sql.=" notificacion_ep.iddepartamento, notificacion_ep.idred_salud, notificacion_ep.idmunicipio, notificacion_ep.idestablecimiento_salud, notificacion_ep.estado ";
    $sql.=" FROM notificacion_ep, departamento, red_salud, municipios, establecimiento_salud, usuarios, nombre ";
    $sql.=" WHERE notificacion_ep.iddepartamento=departamento.iddepartamento AND notificacion_ep.idred_salud=red_salud.idred_salud ";
    $sql.=" AND notificacion_ep.idmunicipio=municipios.idmunicipio AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sql.=" AND notificacion_ep.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND notificacion_ep.iddepartamento='$iddepartamento' ORDER BY notificacion_ep.idnotificacion_ep ";
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
            <td><?php echo $row[4];?></td>
            <td><?php echo mb_strtoupper($row[5]);?></td>
            <td><?php echo mb_strtoupper($row[6]);?></td>
            <td><?php echo mb_strtoupper($row[9]." ".$row[10]." ".$row[11]);?></td>
            <td><?php 
                $fecha_r = explode('-',$row[7]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
            <?php echo $f_registro;?></td>
            <td>

            <?php
            if ($row[16] == 'CONSOLIDADO') { ?>
            <form name="DES_FORM_EP" action="valida_notificacion_ep_adm.php" method="post">
            <input name="idnotificacion_ep" type="hidden" value="<?php echo $row[0];?>">
            <input name="iddepartamento" type="hidden" value="<?php echo $row[12];?>">
            <input name="idred_salud" type="hidden" value="<?php echo $row[13];?>">
            <input name="idmunicipio" type="hidden" value="<?php echo $row[14];?>">
            <input name="idestablecimiento_salud" type="hidden" value="<?php echo $row[15];?>">
            <button type="submit" class="btn btn-success btn-icon-split">
            <span class="icon text-yellow-600">
            <i class="fas fa-fw fa-book"></i>
            </span>
            <span class="text">CONSOLIDADO</span>
            </button>
            </form> 
            <?php } else { echo "EN ELABORACIÓN"; } ?>
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