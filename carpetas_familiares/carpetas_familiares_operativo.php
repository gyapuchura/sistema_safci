<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idusuario_op = $_POST["medico_operativo"];
?>
<div class="table-responsive">
        <table class="table table-bordered" id="example_op" width="100%" cellspacing="0">
                <thead>
                    <tr>  
                        <th>N°</th>                                     
                        <th>CÓDIGO CARPETA</th>
                        <th>FAMILIA</th>
                        <th>NUMERO DE INTEGRANTES</th>
                        <th>ÁREA DE INFLUENCIA</th>
                        <th>OBSERVACIONES</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>MOSTRAR CARPETA</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $numero=1;
    $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,";
    $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
    $sql.=" FROM carpeta_familiar, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE  ";
    $sql.=" carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idmunicipio=municipios.idmunicipio  ";
    $sql.=" AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
    $sql.=" AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND carpeta_familiar.idusuario='$idusuario_op' ORDER BY carpeta_familiar.idcarpeta_familiar ";
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
                        <td>
                        <?php                                         
                                $numero_d=0;
                                $sqld =" SELECT idcat_determinante_salud FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' GROUP BY idcat_determinante_salud ";
                                $resultd = mysqli_query($link,$sqld);
                                if ($rowd = mysqli_fetch_array($resultd)){
                                mysqli_field_seek($resultd,0);
                                while ($fieldd = mysqli_fetch_field($resultd)){
                                } do { 
                            
                                    $numero_d=$numero_d+1;
                                }
                                while ($rowd = mysqli_fetch_array($resultd));
                                } else {
                                }
                            
                                if ($numero_d == '20') {    
                                            
                                } else {
                                    echo "<h6 class='text-danger'>- AJUSTAR DETERMINANTES DE LA SALUD </h6>";
                                }

                                $sql_in = " SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar = '$row[0]' ";
                                $result_in = mysqli_query($link,$sql_in);    
                                $row_in = mysqli_fetch_array($result_in);
                                $integrantes = $row_in[0];

                                $sql_1 = " SELECT idintegrante_cf FROM integrante_datos_cf WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                $result_1 = mysqli_query($link,$sql_1);  
                                $integrantes_datos = mysqli_num_rows($result_1);  
                                if ($integrantes == $integrantes_datos) {   

                                    } else { 
                                        echo "<h6 class='text-danger'>- AJUSTAR DATOS DE TODOS LOS INTEGRANTES </h6>";
                                    }
                            
                                $sql_2 = " SELECT idintegrante_cf FROM integrante_subsector_salud WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                $result_2 = mysqli_query($link,$sql_2);  
                                $integrantes_sub = mysqli_num_rows($result_2);  
                                if ($integrantes_sub >= $integrantes) {
                            
                                    } else { 
                                        echo "<h6 class='text-danger'>- AJUSTAR DATOS DE SUBSECTOR SALUD </h6>";
                                    }
                            
                                    $sql_3 = " SELECT idintegrante_cf FROM integrante_beneficiario WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                    $result_3 = mysqli_query($link,$sql_3); 
                                    $integrante_ben = mysqli_num_rows($result_3);   
                                    if ($integrante_ben >= $integrantes) {
                                
                                        } else { 
                                            echo "<h6 class='text-danger'>- AJUSTAR DATOS DE PROGRAMAS SOCIALES </h6>";
                                        }
                                    $sql_4 = " SELECT idintegrante_cf FROM integrante_tradicional WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf ";
                                    $result_4 = mysqli_query($link,$sql_4);   
                                    $integrante_trad = mysqli_num_rows($result_4); 
                                    if ($integrante_trad >= $integrantes) {
                                
                                        } else { 
                                            echo "<h6 class='text-danger'>- AJUSTAR DATOS DE MEDICINA TRADICIONAL </h6>";
                                        }
                            
                                    $sql_5 = " SELECT idintegrante_cf FROM integrante_defuncion WHERE idcarpeta_familiar = '$row[0]' GROUP BY idintegrante_cf";
                                    $result_5 = mysqli_query($link,$sql_5);   
                                    $integrante_def = mysqli_num_rows($result_5); 
                                    if ($integrante_def >= $integrantes) {
                                
                                        } else { 
                                            echo "<h6 class='text-danger'>- AJUSTAR DATOS DE DEFUNCION DE INTEGRANTES </h6>";
                                        }
                            

                                        $sql_soc = " SELECT idsocio_economica FROM socio_economica_cf WHERE idcarpeta_familiar = '$row[0]' ";
                                        $result_soc = mysqli_query($link,$sql_soc);   
                                        $socioeconomia = mysqli_num_rows($result_soc); 
                                        if ($socioeconomia == '10') {
                                    
                                            } else { 
                                                echo "<h6 class='text-danger'>- AJUSTAR CARACTERÍSTICAS SOCIOECONÓMICAS </h6>";
                                            }
                                //----- INCORPORAR EN BANDEJA DE CARPETAS OPERATIVO END ----- //   
                                                                        
                                ?>
                        </td>
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
                        <a href="imprime_reporte_cfs_op.php?idusuario_op=<?php echo $idusuario_op;?>" target="_blank" class="text-info" style="font-size: 15px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1220,height=800,scrollbars=YES,top=60,left=400'); return false;">
                        IMPRIMIR REPORTE DE CARPETAS FAMILIARES</a>   
                        </div>
                        <div class="col-sm-6">
                    <form name="REPORTE_CF" action="reporte_cf_op_excel.php" method="post">
                        <input type="hidden" name="idusuario_op" value="<?php echo $idusuario_op;?>">
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
            $('#example_op').DataTable( {
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
