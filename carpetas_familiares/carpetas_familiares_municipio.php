<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idmunicipio = $_POST["municipio"];
?>
<div class="table-responsive">
        <table class="table table-bordered" id="examplemun" width="100%" cellspacing="0">
                <thead>
                    <tr>  
                        <th>N°</th>                                     
                        <th>CÓDIGO CARPETA</th>
                        <th>FAMILIA</th>
                        <th>NUMERO DE INTEGRANTES</th>
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
    $sql.=" FROM carpeta_familiar, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE ";
    $sql.=" carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idmunicipio=municipios.idmunicipio  ";
    $sql.=" AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
    $sql.=" AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND carpeta_familiar.idmunicipio='$idmunicipio' ORDER BY carpeta_familiar.idcarpeta_familiar ";
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
                        <td><?php 
                            $sql_i =" SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar='$row[0]' ";
                            $result_i = mysqli_query($link,$sql_i);
                            $row_i = mysqli_fetch_array($result_i); 
                            echo $row_i[0];
                        ?></td>
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

                <hr>
                <div class="text-center">
                <div class="form-group row"> 
                        <div class="col-sm-6">
                        <a href="imprime_reporte_cfs_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="text-info" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1220,height=800,scrollbars=YES,top=60,left=400'); return false;">
                        IMPRIMIR REPORTE DE CARPETAS FAMILIARES</a>   
                        </div>
                        <div class="col-sm-6">
                    <form name="REPORTE_CF" action="reporte_cf_mun_excel.php" method="post">
                        <input type="hidden" name="idmunicipio" value="<?php echo $idmunicipio;?>">
                        <button type="submit" class="btn btn-success">REPORTE CARPETAS FAMILIARES EN EXCEL</button>
                    </form>
                    </div>
                </div>   
                <hr>

    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#examplemun').DataTable( {
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
