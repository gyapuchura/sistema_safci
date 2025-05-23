<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 
$idestablecimiento_salud = $_POST["establecimiento_salud"];
?>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CÓDIGO CARPETA</th>
                                            <th>VER SEGUIMIENTO</th>
                                            <th>FAMILIA</th>   
                                            <th>RIESGO FAMILIAR</th>                                           
                                            <th>ÁREA DE INFLUENCIA</th>
                                            <th>NÚMERO DE INTEGRANTES</th>
                                            <th>UBICACIÓN GEOGRÁFICA</th>
                                            <th>MÉDICO</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, ";
                        $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
                        $sql.=" FROM seguimiento_cf, carpeta_familiar, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar  ";
                        $sql.=" AND carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.estado='CONSOLIDADO' ";
                        $sql.=" AND carpeta_familiar.idmunicipio=municipios.idmunicipio AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud' AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia GROUP BY carpeta_familiar.idcarpeta_familiar ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                                        <tr>
                                            <td><?php echo $numero;?></td>
                                            <td>
                                            <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1280,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                            <h6 class="text-primary"><?php echo $row[1];?></h6></a>     
                                            </td>
                                            <td>
                                            <a href="imprime_seguimiento_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                            <h6 class="text-info">ESTADO DE SEGUIMIENTO</h6></a>     
                                            </td>
                                            <td><?php echo $row[2];?></td>    
                                            <td><?php                                             
                                            $sql_r =" SELECT determinante_salud, salud_integrantes, funcionalidad_familiar, evaluacion_familiar FROM evaluacion_familiar_cf WHERE idcarpeta_familiar='$row[0]' ";
                                            $result_r = mysqli_query($link,$sql_r);
                                            $row_r = mysqli_fetch_array($result_r);

                                            if ($row_r[3] == 'FAMILIA CON RIESGO BAJO') {
                                                echo "<h6 class='text-success'> ".$row_r[3]."</h6>";
                                                echo "<h6 class='text-success'>- ".$row_r[0]."</h6>";
                                                echo "<h6 class='text-success'>- ".$row_r[1]."</h6>";
                                                echo "<h6 class='text-success'>- ".$row_r[2]."</h6>";
                                            } else {
                                                if ($row_r[3] == 'FAMILIA CON RIESGO MEDIANO') {
                                                    echo "<h6 class='text-warning'> ".$row_r[3]."</h6>";
                                                    echo "<h6 class='text-warning'>- ".$row_r[0]."</h6>";
                                                    echo "<h6 class='text-warning'>- ".$row_r[1]."</h6>";
                                                    echo "<h6 class='text-warning'>- ".$row_r[2]."</h6>";
                                                } else {
                                                    if ($row_r[3] == 'FAMILIA CON RIESGO ALTO') {
                                                        echo "<h6 class='text-danger'> ".$row_r[3]."</h6>";
                                                        echo "<h6 class='text-danger'>- ".$row_r[0]."</h6>";
                                                        echo "<h6 class='text-danger'>- ".$row_r[1]."</h6>";
                                                        echo "<h6 class='text-danger'>- ".$row_r[2]."</h6>";
                                                    } else { } } } ?>
                                            </td>                                         
                                            <td><?php echo $row[6];?></br><?php echo $row[7];?></td>
                                            <td>
                                            <?php 
                                            $sql_i = " SELECT count(idintegrante_cf) FROM integrante_cf WHERE idcarpeta_familiar='$row[0]' ";
                                            $result_i = mysqli_query($link,$sql_i);
                                            $row_i = mysqli_fetch_array($result_i); 
                                            echo $row_i[0];
                                            ?>                                             
                                            </td>
                                            <td>                                                     
                                                    <a href="../carpetas_familiares/imprime_mapa_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=700,top=50, left=600, scrollbars=YES'); return false;">
                                                    <h6 class="text-info">UBICACIÓN FAMILIAR</h6></a>                                                                                                              
                                        </td>
                                        <td>
                                            <?php 
                                                $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                                                $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[11]' ";
                                                $result_r = mysqli_query($link,$sql_r);
                                                $row_r = mysqli_fetch_array($result_r);                    
                                            echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?> 
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
                        <a class="btn btn-info btn-icon-split" href="valida_visitas_establecimiento.php?idestablecimiento_salud=<?php echo $idestablecimiento_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1400,height=900,scrollbars=YES,top=50,left=200'); return false;">
                        <span class="icon text-white-50">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="text">CALENDARIO DE VISITAS FAMILIARES ESTABLECIMIENTO</span></a>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>   
                <hr>

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
