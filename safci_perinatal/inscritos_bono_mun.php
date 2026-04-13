<?php include("../cabf.php");?>
<?php include("../inc.config.php"); 

$idmunicipio = $_POST["municipio_salud"];
?>
<div class="table-responsive">
        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
            <thead>
                <tr>  
                    <th>N°</th> 
                    <th>CODIGO DE INSCRIPCIÓN</th> 
                    <th>ESTABLECIMIENTO DE SALUD</th> 
                    <th>ÁREA DE INFLUENCIA</th>                                   
                    <th>FORMULARIO DE CONTROL</th>
                    <th>NOMBRE DEL INSCRITO (NIÑO/NIÑA)</th>
                    <th>EDAD</th>
                    <th>NOMBRE DE LA MADRE</th>
                    <th>NÚMERO DE CONTROLES</th>
                    <th>CARPETA FAMILIAR</th>
                    <th>ACCIÓN</th> 
                </tr>
            </thead>
            <tbody>
        <?php
        $numero=1; 
        $sql =" SELECT bono_nino_sano.idbono_nino_sano, bono_nino_sano.codigo, departamento.departamento, municipios.municipio, red_salud.red_salud, establecimiento_salud.establecimiento_salud, ";
        $sql.=" tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, bono_nino_sano.idnombre_nino, bono_nino_sano.idnombre_madre, bono_nino_sano.numero_controles, ";
        $sql.=" bono_nino_sano.nino_carpetizado, bono_nino_sano.direccion_domicilio, bono_nino_sano.celular_madre, bono_nino_sano.cuenta_madre, bono_nino_sano.fecha_inscripcion_bono ";
        $sql.=" FROM bono_nino_sano, departamento, municipios, red_salud, establecimiento_salud, area_influencia, tipo_area_influencia WHERE bono_nino_sano.iddepartamento=departamento.iddepartamento ";
        $sql.=" AND bono_nino_sano.idmunicipio=municipios.idmunicipio AND bono_nino_sano.idred_salud=red_salud.idred_salud AND bono_nino_sano.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
        $sql.=" AND bono_nino_sano.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
        $sql.=" AND bono_nino_sano.idmunicipio='$idmunicipio' ORDER BY bono_nino_sano.idbono_nino_sano DESC ";
        $result = mysqli_query($link,$sql);
        if ($row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);
        while ($field = mysqli_fetch_field($result)){
        } do {
        ?>
            <tr>
                <td><?php echo $numero;?></td>
                <td><?php echo $row[1];?></td>
                <td><?php echo $row[5];?></td>
                <td><?php echo mb_strtoupper($row[6]." ".$row[7]);?></td>
                <td>
                    <a class="btn btn-primary btn-icon-split" href="../safci_perinatal/imprime_bja_nino.php?idbono_nino_sano=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=950,height=900,top=50, left=600, scrollbars=YES'); return false;">
                    <span class="icon text-white-50">
                        <i class="fas fa-book"></i>
                    </span>
                    <span class="text">CONTROL NIÑO SANO</span></a>  
                </td>
                <td>
                <?php
                $sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row[8]' ";
                $result_n=mysqli_query($link,$sql_n);
                $row_n=mysqli_fetch_array($result_n); 
                echo mb_strtoupper($row_n[1]." ".$row_n[2]." ".$row_n[3]);?>
                </td>
                <td><?php 
                
                    $fecha_nacimiento = $row_n[5];
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
                    echo $edad ;
                    ?>
                </td>
                <td>
                <?php
                $sql_m =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row[9]' ";
                $result_m=mysqli_query($link,$sql_m);
                $row_m=mysqli_fetch_array($result_m); 
                echo mb_strtoupper($row_m[1]." ".$row_m[2]." ".$row_m[3]);?>
                </td>               
                <td><?php echo $row[10];?></td>
                <td><?php echo $row[11];?></td>
                <td>
                <form name="FORM_BONO" action="valida_inscrito_bono.php" method="post">
                <input name="idbono_nino_sano" type="hidden" value="<?php echo $row[0];?>">             
                <button type="submit" class="btn btn-info btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">VER</br>INSCRIPCIÓN</span>
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

            <hr>
            <div class="text-center">
            <div class="form-group row"> 
                    <div class="col-sm-4"> 
                    </div>
                    <div class="col-sm-4"> 
                    </div>
                    <div class="col-sm-4">
                <form name="REPORTE_CF" action="reporte_beneficiarios_bono_mun.php" method="post">
                    <input type="hidden" name="idmunicipio" value="<?php echo $idmunicipio;?>">
                    <button type="submit" class="btn btn-success">REPORTE DE CONTROL BENEFICIARIOS</button>
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
