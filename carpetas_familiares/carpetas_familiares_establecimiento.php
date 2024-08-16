<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idestablecimiento_salud = $_POST["establecimiento_salud"];
?>
<div class="table-responsive">
        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>  
                        <th>N°</th>                                     
                        <th>CÓDIGO CARPETA</th>
                        <th>FAMILIA</th>
                        <th>ÁREA DE INFLUENCIA</th>
                        <th>PERSONAL REGISTRADOR</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>MOSTRAR CARPETA</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $numero=1;
    $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,";
    $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
    $sql.=" FROM carpeta_familiar, ubicacion_cf, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
    $sql.=" AND ubicacion_cf.iddepartamento=departamento.iddepartamento AND ubicacion_cf.idmunicipio=municipios.idmunicipio ";
    $sql.=" AND ubicacion_cf.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
    $sql.=" AND ubicacion_cf.idarea_influencia=area_influencia.idarea_influencia AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idestablecimiento_salud='$idestablecimiento_salud' ORDER BY carpeta_familiar.idcarpeta_familiar ";
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
                        <td><?php echo $row[6];?></br><?php echo $row[7];?></td>
                        <td><?php 
                            $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                            $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[11]' ";
                            $result_r = mysqli_query($link,$sql_r);
                            $row_r = mysqli_fetch_array($result_r);                    
                        echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?></td>
                        <td>
                        <?php 
                            $fecha_r = explode('-',$row[8]);
                            $f_apertura = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                        <?php echo $f_apertura;?></br><?php echo $row[9];?>   
                        </td>
                        <td>
                            <?php if ($row[10] == 'CONSOLIDADO') { ?>
                                
                    <a href="imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1280,height=800,top=50, left=200, scrollbars=YES'); return false;">
                    <h6 class="text-info">IMPRIMIR CARPETA FAMILIAR</h6></a>
                 
                            <?php } else { 
                            
                            if ($row[11] == $idusuario_ss) { ?>

                            <h6 class="text-primary">EN LA BANDEJA DE CARPETAS FAMILIARES DEL OPERATIVO</h6>

                            <?php } else {  ?>

                            <h6 class="text-primary">EN PROCESO DE LLENADO</h6>
                            
                                <?php }} ?>                                                                      
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
