<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); 

$idarea_influencia_hc = $_POST["area_influencia_hc"];
?>
<div class="table-responsive">
     
 <table class="table table-bordered" id="example_af" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>  
                                            <th>N°</th> 
                                            <th>HISTORIA CLÍNICA</th>                                     
                                            <th>CÉDULA DE IDENTIDAD</th>
                                            <th>NOMBRE</th>
                                            <th>PRIMER APELLIDO</th>  
                                            <th>SEGUNDO APELLIDO</th>  
                                            <th>EDAD</th>   
                                            <th>GRUPO DE SALUD</th>                                            
                                            <th>CARPETA FAMILIAR</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                        <?php
                        $numero=1;
                        $sql =" SELECT integrante_cf.idintegrante_cf, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno, nombre.fecha_nac, carpeta_familiar.codigo, carpeta_familiar.idcarpeta_familiar, ";
                        $sql.=" nombre.idnombre FROM carpeta_familiar, integrante_cf, nombre WHERE integrante_cf.idnombre=nombre.idnombre  ";
                        $sql.=" AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                        $sql.=" AND carpeta_familiar.idarea_influencia ='$idarea_influencia_hc' ";
                        $result = mysqli_query($link,$sql);
                        if ($row = mysqli_fetch_array($result)){
                        mysqli_field_seek($result,0);
                        while ($field = mysqli_fetch_field($result)){
                        } do {
                        ?>
                                        <tr>
                                            <td><?php echo $numero;?></td>
                                            <td>        
                                                <a href="imprime_historia_clinica_ps.php?idcarpeta_familiar=<?php echo $row[7];?>&idintegrante_cf=<?php echo $row[0];?>&idnombre_integrante=<?php echo $row[8];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1000,height=1000,top=50, left=400, scrollbars=YES'); return false;">        
                                                HISTORIA CLÍNICA</a></td>
                                            <td>
                                                <?php echo $row[1];?>
                                            </td>
                                            <td><?php echo $row[2];?></td>
                                            <td><?php echo $row[3];?></td>
                                            <td><?php echo $row[4];?></td>
                                            <td><?php 

                                                    $fecha_nacimiento = $row[5];
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
                                                    
                                                    ?></td>
                                                    <td><?php 
                                                                
                                                        $sql1 ="  SELECT idintegrante_ap_sano FROM integrante_ap_sano WHERE idintegrante_cf='$row[0]' LIMIT 1 ";
                                                        $result1 = mysqli_query($link,$sql1);
                                                        if ($row1 = mysqli_fetch_array($result1)){
                                                        mysqli_field_seek($result1,0);
                                                        while ($field1 = mysqli_fetch_field($result1)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-primary'>- GRUPO I</h6>";?>
                                                        <?php
                                                        
                                                        }
                                                        while ($row1 = mysqli_fetch_array($result1));
                                                        } else {
                                                        }
                                                        ?>
                                                        <?php
                                                        $sql2 =" SELECT idintegrante_factor_riesgo FROM integrante_factor_riesgo WHERE idintegrante_cf='$row[0]' LIMIT 1  ";
                                                        $result2 = mysqli_query($link,$sql2);
                                                        if ($row2 = mysqli_fetch_array($result2)){
                                                        mysqli_field_seek($result2,0);
                                                        while ($field2 = mysqli_fetch_field($result2)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-warning'>- GRUPO II</h6>";?>
                                                        <?php
                                                        }
                                                        while ($row2 = mysqli_fetch_array($result2));
                                                        } else {
                                                        }
                                                        ?>
                                                        <?php
                                                        $sql3 =" SELECT idintegrante_morbilidad FROM integrante_morbilidad WHERE idintegrante_cf='$row[0]' LIMIT 1  ";
                                                        $result3 = mysqli_query($link,$sql3);
                                                        if ($row3 = mysqli_fetch_array($result3)){
                                                        mysqli_field_seek($result3,0);
                                                        while ($field3 = mysqli_fetch_field($result3)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-danger'>- GRUPO III</h6>";?>
                                                        <?php
                                                        }
                                                        while ($row3 = mysqli_fetch_array($result3));
                                                        } else {
                                                        }
                                                        ?>
                                                        <?php
                                                        $sqld ="  SELECT idintegrante_discapacidad FROM integrante_discapacidad WHERE idintegrante_cf='$row[0]' LIMIT 1  ";
                                                        $resultd = mysqli_query($link,$sqld);
                                                        if ($rowd = mysqli_fetch_array($resultd)){
                                                        mysqli_field_seek($resultd,0);
                                                        while ($fieldd = mysqli_fetch_field($resultd)){
                                                        } do { 
                                                        ?>
                                                           <?php echo "<h6 class='text-info'>- GRUPO IV</h6>";?>
                                                        <?php
                                                        }
                                                        while ($rowd = mysqli_fetch_array($resultd));
                                                        } else {
                                                        }
                                                        
                                            ?></td>
                                            <td>
                                            <a href="../carpetas_familiares/imprime_carpeta_familiar.php?idcarpeta_familiar=<?php echo $row[7];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=1400,height=800,top=50, left=200, scrollbars=YES'); return false;">
                                            <h6 class="text-info"><?php echo $row[6];?></h6></a> 
                                            </td>                                           
                                        <td>
                                    <form name="ATENCION-SAFCI" action="valida_persona_hc.php" method="post">
                                    <input name="idintegrante_cf" type="hidden" value="<?php echo $row[0];?>">
                                    <input name="idcarpeta_familiar" type="hidden" value="<?php echo $row[7];?>">
                                    <input name="idestablecimiento_salud" type="hidden" value="<?php echo $idestablecimiento_salud;?>">
                                    <input name="iddepartamento" type="hidden" value="<?php echo $iddepartamento;?>">
                                    <input name="idnombre_integrante" type="hidden" value="<?php echo $row[8];?>">
                                    <input name="edad" type="hidden" value="<?php echo $edad;?>">
                                        <button type="submit" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-hospital"></i>
                                        </span>
                                        <span class="text">HISTORIA CLÍNICA SAFCI</span>    
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
                             
                <hr>

    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#example_af').DataTable( {
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
