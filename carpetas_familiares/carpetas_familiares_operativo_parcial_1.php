<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$semana     = date("W");
$gestion    =  date("Y");

$idusuario = $_POST["medico_operativo"];

if ($idusuario != '') {

?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="text-info">CUADRO INFORMATIVO DE CARPETAS FAMILIARES DEL OPERATIVO A INTERCAMBIAR</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-3">
                            <h6 class="text-info">TOTAL DE CARPETAS FAMILIARES:</h6>
                            <?php
                            $sql_f =" SELECT sum(familias) FROM area_influencia WHERE idusuario='$idusuario' ";   
                            $result_f = mysqli_query($link,$sql_f);
                            $row_f = mysqli_fetch_array($result_f);
                            $meta_cf = $row_f[0];

                            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar ";
                            $sql_cf.=" WHERE  estado='CONSOLIDADO' ";
                            $sql_cf.=" AND idusuario='$idusuario' ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $carpetizacion = $row_cf[0];

                            $porcentaje_op   = ($carpetizacion*100)/$meta_cf;
                            $p_operativo    = number_format($porcentaje_op, 2, '.', '');

                            ?>
                            <?php echo $carpetizacion;?>
                            <h6 class="text-info">De <?php echo $meta_cf;?> Familias</h6>
                            <h6 class="text-primary"><?php echo $p_operativo;?> %</h6>
                            </div>

                            <div class="col-sm-3">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php
                            $sql_h =" SELECT sum(habitantes) FROM area_influencia WHERE idusuario='$idusuario' ";   
                            $result_h = mysqli_query($link,$sql_h);
                            $row_h = mysqli_fetch_array($result_h);

                            $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar  ";
                            $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO'  ";
                            $sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idusuario='$idusuario' ";
                            $result_int = mysqli_query($link,$sql_int);
                            $row_int = mysqli_fetch_array($result_int);  
                            $integrantes = $row_int[0];

                            $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                            $integrantes_meta = number_format($row_h[0], 0, '.', '.');

                            $porcentaje_hab   = ($integrantes*100)/$row_h[0];
                            $p_habitantes = number_format($porcentaje_hab, 2, '.', ' ');
                            ?>
                            <?php echo $integrantes_cf;?> 
                            <h6 class="text-info">De <?php echo $integrantes_meta;?> Habitantes</h6>
                            <h6 class="text-primary"><?php echo $p_habitantes;?> %</h6>
                            </div>
                            <div class="col-sm-6">
                            <h6 class="text-info">PERSONAL SAFCI REGISTRADOR:</h6>
                            <?php
                                $numero = 1;
                                $sql =" SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idusuario='$idusuario' GROUP BY idusuario ";   
                                $result = mysqli_query($link,$sql);
                                if ($row = mysqli_fetch_array($result)){
                                mysqli_field_seek($result,0);
                                while ($field = mysqli_fetch_field($result)){
                                } do {
                                    $sql_p =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[0]'  ";
                                    $result_p = mysqli_query($link,$sql_p);
                                    $row_p = mysqli_fetch_array($result_p);
                                  
                                    echo mb_strtoupper("<h6 class='text-info'>".$numero.".- ". $row_p[0]." ".$row_p[1]." ".$row_p[2]."</h6>");

                                    $sql_af =" SELECT tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM tipo_area_influencia, area_influencia, carpeta_familiar  WHERE carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia";   
                                    $sql_af.=" AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND carpeta_familiar.idusuario='$row[0]' GROUP BY area_influencia.area_influencia ";
                                    $result_af = mysqli_query($link,$sql_af);
                                    if ($row_af = mysqli_fetch_array($result_af)){
                                    mysqli_field_seek($result_af,0);
                                    while ($field_af = mysqli_fetch_field($result_af)){
                                    } do {  ?>

                                        <h6 class="text-info"><?php echo mb_strtoupper(" - ". $row_af[0]." ".$row_af[1]);?></h6>

                                        <?php
                                    }
                                    while ($row_af = mysqli_fetch_array($result_af));
                                    } else {
                                    }

                                    echo "</br>";

                                    $numero = $numero+1;
                                }
                                while ($row = mysqli_fetch_array($result));
                                } else {
                                }
                            ?>
                            
                            </div>
                        </div>   
               

<div class="table-responsive">
        <table class="table table-bordered" id="example_op" width="100%" cellspacing="0">
                <thead>
                    <tr>  
                        <th>N°</th>                                     
                        <th>CÓDIGO CARPETA</th>
                        <th>FAMILIA</th>
                        <th>DEPARTAMENTO</th>
                        <th>MUNICIPIO</th>
                        <th>ESTABLECIMIENTO DE SALUD</th>
                        <th>ÁREA DE INFLUENCIA</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>SELECCIONAR</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $numero=0;
    $sql =" SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.codigo, carpeta_familiar.familia, departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud,";
    $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, carpeta_familiar.fecha_registro, carpeta_familiar.hora_registro, carpeta_familiar.estado, carpeta_familiar.idusuario ";
    $sql.=" FROM carpeta_familiar, departamento, municipios, establecimiento_salud, area_influencia, tipo_area_influencia WHERE  ";
    $sql.=" carpeta_familiar.iddepartamento=departamento.iddepartamento AND carpeta_familiar.idmunicipio=municipios.idmunicipio AND carpeta_familiar.estado='CONSOLIDADO' ";
    $sql.=" AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
    $sql.=" AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND carpeta_familiar.idusuario='$idusuario' ORDER BY carpeta_familiar.idcarpeta_familiar ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
                    <tr>
                        <td><?php echo $numero+1;?></td>
                        <td><a href="imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1280,height=800,top=50, left=200, scrollbars=YES'); return false;">
                        <h6 class="text-info"><?php echo $row[1];?></h6></a>
                        </td>
                        <td><?php echo $row[2];?></td>
                        <td><?php echo $row[3];?></td>
                        <td><?php echo $row[4];?></td>
                        <td><?php echo $row[5];?></td>
                        <td><?php echo $row[6];?></br><?php echo $row[7];?></td>
                        <td>
                        <?php 
                            $fecha_r = explode('-',$row[8]);
                            $f_apertura = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                        <?php echo $f_apertura;?></br><?php echo $row[9];?>   
                        </td>
                        <td>
                            <input type="checkbox" name="idcarpeta_familiar[]" value="<?php echo $row[0];?>" >   
                                                    
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
              
 </div>

<?php 
} else { } ?>


<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#example_op').DataTable( {
                        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] ,
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