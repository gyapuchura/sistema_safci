<?php include("../cabf.php");?>
<?php include("../inc.config.php"); 
$idmunicipio = $_POST["municipio_salud"];
?>
<div class="table-responsive">
        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
            <thead>
                <tr>  
                    <th>N°</th> 
                    <th>ESTABLECIMIENTO DE SALUD</th> 
                    <th>ÁREA DE INFLUENCIA</th>                                   
                    <th>CODIGO CARPETA FAMILIAR</th>
                    <th>HISTORIA CLINICA DIGITAL</th>
                    <th>FAMILIA</th>
                    <th>NOMBRE DEL INTEGRANTE BENEFICIARIO</th>
                    <th>EDAD</th>
                    <th>PARENTESCO</th>
                    <th>ACCIÓN</th> 

                </tr>
            </thead>
            <tbody>
        <?php
        $numero=1; 
        $sql =" SELECT integrante_cf.idintegrante_cf, integrante_cf.idnombre, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,   ";
        $sql.=" carpeta_familiar.codigo, carpeta_familiar.familia, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, parentesco.parentesco, carpeta_familiar.idcarpeta_familiar,  ";
        $sql.=" carpeta_familiar.idestablecimiento_salud, carpeta_familiar.iddepartamento, integrante_cf.idparentesco FROM integrante_beneficiario, integrante_cf, nombre, carpeta_familiar, parentesco, establecimiento_salud,  tipo_area_influencia, area_influencia ";
        $sql.=" WHERE integrante_beneficiario.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.idparentesco=parentesco.idparentesco ";
        $sql.=" AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND integrante_cf.idnombre=nombre.idnombre ";
        $sql.=" AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
        $sql.=" AND carpeta_familiar.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia";
        $sql.=" AND integrante_beneficiario.idprograma_social='2' AND carpeta_familiar.idmunicipio='$idmunicipio'  ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <tr>
                <td><?php echo $numero;?></td>
                <td><?php echo $row[2];?></td>
                <td><?php echo mb_strtoupper($row[3]." ".$row[4]);?></td>
                <td>
                    <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[12];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
                    <h6 class="text-primary"><?php echo $row[5];?></h6></a> 
                </td>
                <td>
                    <a class="btn btn-primary btn-icon-split" href="../produccion_servicios/imprime_historia_clinica_ps.php?idcarpeta_familiar=<?php echo $row_[12];?>&idintegrante_cf=<?php echo $row[0];?>&idnombre_integrante=<?php echo $row[1];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">
                    <span class="icon text-white-50">
                        <i class="fas fa-book"></i>
                    </span>
                    <span class="text">HISTORIA CLÍNICA</span></a>  
                </td>
                <td><?php echo $row[6];?></td>
                <td><?php echo mb_strtoupper($row[7]." ".$row[8]." ".$row[9]);?></td>
                <td><?php 
                
                    $fecha_nacimiento = $row[10];
                    $dia = date("d");
                    $mes = date("m");
                    $ano = date("Y");    
                    $dianaz = date("d",strtotime($fecha_nacimiento));
                    $mesnaz = date("m",strtotime($fecha_nacimiento));
                    $anonaz = date("Y",strtotime($fecha_nacimiento));         
                    if (($mesnaz == $mes) && ($dianaz > $dia)) {
                    $ano=($ano-1); }      
                    if ($mesnaz > $mes) {
                    $ano=($ano-1);}       
                    $edad=($ano-$anonaz);  
                    echo $edad ;?>
                </td>
                <td><?php echo $row[11];?></td>
                <td>
                <form name="FORM_BONO" action="valida_benficiario_bono.php" method="post">
                <input name="idintegrante_cf" type="hidden" value="<?php echo $row[0];?>">
                <input name="idcarpeta_familiar" type="hidden" value="<?php echo $row[12];?>">
                <input name="idestablecimiento_salud" type="hidden" value="<?php echo $row[13];?>">
                <input name="idmunicipio" type="hidden" value="<?php echo $idmunicipio;?>">
                <input name="iddepartamento" type="hidden" value="<?php echo $row[14];?>">
                <input name="idnombre_integrante" type="hidden" value="<?php echo $row[1];?>">
                <input name="edad" type="hidden" value="<?php echo $edad;?>">
                <input name="parentesco" type="hidden" value="<?php echo $row[11];?>">
                <input name="idparentesco" type="hidden" value="<?php echo $row[15];?>">
                <button type="submit" class="btn btn-info btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">SEGUIMIENTO</br>BENEFICIARIO</span>
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
