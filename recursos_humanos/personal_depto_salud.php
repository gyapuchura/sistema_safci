<?php include("../cabf.php");?>
<?php include("../inc.config.php"); 
$iddepartamento = $_POST["departamento"];
?>
<div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th>                                     
                                            <th>CÓDIGO PERSONAL</th>
                                            <th>PATERNO</th>
                                            <th>MATERNO</th>
                                            <th>NOMBRES</th>
                                            <th>MUNICIPIO</th>
                                            <th>PERFIL</th>
                                            <th>CONDICIÓN</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT personal.idpersonal, personal.idusuario, personal.idnombre, personal.codigo, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, nombre.ci, nombre.complemento, nombre.exp,";
                        $sql.=" nacionalidad.nacionalidad, genero.genero, formacion_academica.formacion_academica, profesion.profesion, especialidad_medica.especialidad_medica, nombre_datos.correo, nombre_datos.celular, ";
                        $sql.=" nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, departamento.departamento, usuarios.perfil, usuarios.condicion, municipios.municipio FROM personal, nombre, nacionalidad, genero, nombre_datos, ";
                        $sql.=" dato_laboral, formacion_academica, profesion, especialidad_medica, departamento, municipios, establecimiento_salud, usuarios WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad ";
                        $sql.=" AND nombre.idgenero=genero.idgenero AND personal.idusuario=usuarios.idusuario AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica ";
                        $sql.=" AND nombre_datos.iddepartamento=departamento.iddepartamento AND nombre_datos.idprofesion=profesion.idprofesion AND personal.iddato_laboral=dato_laboral.iddato_laboral AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
                        $sql.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica AND dato_laboral.iddepartamento='$iddepartamento' ORDER BY personal.idpersonal DESC ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                        <tr>
                            <td><?php echo $numero;?></td>
                            <td><?php echo $row[3];?></td>
                            <td><?php echo mb_strtoupper($row[5]);?></td>
                            <td><?php echo mb_strtoupper($row[6]);?></td>
                            <td><?php echo mb_strtoupper($row[4]);?></td>
                            <td><?php echo $row[24];?></td>
                            <td><?php echo $row[22];?></td>
                            <td><?php echo $row[23];?></td>
                            <td>
                            <form name="FORM_P" action="valida_personal.php" method="post">
                            <input name="idpersonal" type="hidden" value="<?php echo $row[0];?>">
                            <input name="codigo" type="hidden" value="<?php echo $row[3];?>">
                            <button type="submit" class="btn btn-secondary btn-icon-split">
                            <span class="icon text-white-50">
                            <i class="fas fa-fw fa-user"></i>
                            </span>
                            <span class="text">REGISTRO PERSONAL</span>    
                            </button></form>                                                                          
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
