<?php include("../inc.config.php"); 

$idmunicipio_salud = $_POST["municipio_salud"];
?>

<div class="table-responsive">
    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
        <thead>
            <tr>  
                <th>N°</th>                                     
                <th>CÉDULA DE IDENTIDAD</th>
                <th>PATERNO</th>
                <th>MATERNO</th>
                <th>NOMBRES</th>
                <th>RED DE SALUD</th>
                <th>ESTABLECIMIENTO DE SALUD</th>
                <th>PERFIL</th>
                <th>ACCIÓN</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $numero=1;
        $sql =" SELECT personal.idpersonal, personal.idusuario, personal.idnombre, personal.codigo, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, nombre.ci, ";
        $sql.=" nombre.complemento, nombre.exp, nacionalidad.nacionalidad, genero.genero, formacion_academica.formacion_academica, profesion.profesion, especialidad_medica.especialidad_medica, ";
        $sql.=" nombre_datos.correo, nombre_datos.celular, nombre_datos.direccion_dom, nombre_datos.idprofesion, personal.iddato_laboral, departamento.departamento, usuarios.perfil, municipios.municipio, establecimiento_salud.establecimiento_salud, red_salud.red_salud ";
        $sql.=" FROM personal, nombre, nacionalidad, genero, nombre_datos, formacion_academica, profesion, especialidad_medica, departamento, usuarios, dato_laboral, red_salud, establecimiento_salud, municipios ";
        $sql.=" WHERE personal.idnombre=nombre.idnombre AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idgenero=genero.idgenero AND personal.idusuario=usuarios.idusuario ";
        $sql.=" AND personal.idnombre_datos=nombre_datos.idnombre_datos AND nombre_datos.idformacion_academica=formacion_academica.idformacion_academica AND nombre_datos.iddepartamento=departamento.iddepartamento ";
        $sql.=" AND nombre_datos.idprofesion=profesion.idprofesion AND nombre_datos.idespecialidad_medica=especialidad_medica.idespecialidad_medica AND personal.iddato_laboral=dato_laboral.iddato_laboral AND dato_laboral.idred_salud=red_salud.idred_salud  ";
        $sql.=" AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idmunicipio=municipios.idmunicipio AND usuarios.condicion='ACTIVO' AND establecimiento_salud.idmunicipio='$idmunicipio_salud' ORDER BY personal.idpersonal DESC ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <tr>
                <td><?php echo $numero;?></td>
                <td><?php echo $row[8];?></td>
                <td><?php echo mb_strtoupper($row[5]);?></td>
                <td><?php echo mb_strtoupper($row[6]);?></td>
                <td><?php echo mb_strtoupper($row[4]);?></td>
                <td><?php echo $row[25];?></td>
                <td><?php echo $row[24];?></td>
                <td><?php echo $row[22];?></td>
                <td>
                <form name="FORM_P" action="valida_personal_mun_adm.php" method="post">
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
    </br>
    </hr>
        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-primary btn-icon-split" href="detalle_personal_municipio.php?idmunicipio_salud=<?php echo $idmunicipio_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=700,scrollbars=YES,top=50,left=200'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GENERAR LISTADO MUNICIPIO</span></a>
            </div>
            <div class="col-sm-6">
            <form name="INDIV" action="reporte_personal_municipio_excel.php" method="post">
                <input type="hidden" name="idmunicipio_salud" value="<?php echo $idmunicipio_salud;?>">
                <button type="submit" class="btn btn-success">REPORTE EN EXCEL</button>
            </form>
            </div>
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