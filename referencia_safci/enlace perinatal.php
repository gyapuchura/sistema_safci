 <?php include("../cabf.php");?>
<?php include("../inc.config.php");?>

                <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.1.- ANTECEDENTES GINECO OBTETRICOS</h6>
                            </div>
                            <div class="card-body">
                               
                            <!------ VERIFICAMOS PARA MUJERES QUE YA TENGAN REGISTRO DE HISTORIA PERINATAL ----->
                                <?php
                                $sql_h =" SELECT idhistoria_perinatal, fecha_registro FROM historia_perinatal WHERE idnombre='$idnombre_integrante_ss' ";
                                $result_h = mysqli_query($link,$sql_h);
                                if ($row_h = mysqli_fetch_array($result_h)){
                                mysqli_field_seek($result_h,0);
                                while ($field_h = mysqli_fetch_field($result_h)){
                                } do { 
                                ?>      
                                    <div class="form-group row">  
                                    <div class="col-sm-6"> 
                                        <h6 class="text-info">ESTA PERSONA YA CUENTA CON HISTORIA CLÍNICA PERINTAL</h6> 
                                        <h6 class="text-secundary">PUEDE ACTUALIZAR LOS DATOS PARA LA REFERENCIA</h6> 
                                    </div>
                                    <div class="col-sm-6"> 
                                        <h6 class="text-info">INICIADA EL:</h6>  
                                        <input type="date" name="fecha_reg_hc" value="<?php echo $row_h[1];?>" disabled>
                                    </div>
                                    </div>
                                    
                                       <hr>   
                            <?php
                            $sql_g = " SELECT idgestacion, fecha_fum, fecha_pp, controles_prenatales FROM gestacion WHERE idhistoria_perinatal='$row_h[0]' ORDER BY idgestacion DESC LIMIT 1 ";
                            $result_g = mysqli_query($link,$sql_g);
                            $row_g = mysqli_fetch_array($result_g);

                            $sql_a =" SELECT idantecedente_obstetrico, gestaciones, partos, abortos, cesareas  FROM antecedente_obstetrico WHERE idhistoria_perinatal='$row_h[0]' ";
                            $result_a = mysqli_query($link,$sql_a);
                            $row_a = mysqli_fetch_array($result_a);

                            ?> 
                                    <div class="form-group row">  
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.U.M. </br>[fecha]</h6>
                                        <input type="date" class="form-control" value="<?php echo $row_g[1]?>"
                                            name="fecha_fum" required>                
                                    </div>                             
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">G</br>[Gestaciones]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Gestaciones" value="<?php echo $row_a[1]?>"         
                                            name="gestaciones" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">P</br>[Partos]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Partos" value="<?php echo $row_a[2]?>"
                                            name="partos" placeholder="" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">A</br>[Abortos]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Abortos" value="<?php echo $row_a[3]?>"
                                            name="abortos" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">C</br>[Cesáreas]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Cesáreas" value="<?php echo $row_a[4]?>"
                                            name="cesareas" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.P.P.</br>[fecha]</h6>
                                        <input type="date" class="form-control" value="<?php echo $row_g[2]?>"
                                            name="fecha_pp" disabled>                
                                    </div>
                                </div>

                                <?php
                                    $sql_p =" SELECT idparto, hora_rpm, maduracion_pulmonar, idtipo_parto, fecha_parto, hora_parto FROM parto WHERE idnombre='$idnombre_integrante_ss' AND idgestacion='$row_g[0]' ORDER BY idparto DESC LIMIT 1  ";
                                    $result_p = mysqli_query($link,$sql_p);
                                    if ($row_p = mysqli_fetch_array($result_p)){
                                    mysqli_field_seek($result_p,0);
                                    while ($field_p = mysqli_fetch_field($result_p)){
                                    } do { 

                                        $sql_ca =" SELECT idconsulta_antenatal, frecuencia_fcf, edad_gestacional FROM consulta_antenatal WHERE idnombre='$idnombre_integrante_ss' AND idgestacion='$row_g[0]' ORDER BY idconsulta_antenatal DESC LIMIT 1 ";
                                        $result_ca = mysqli_query($link,$sql_ca);
                                        $row_ca = mysqli_fetch_array($result_ca);

                                ?>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <h6 class="text-info">YA SE HAN REGISTRADO LOS DATOS DEL PARTO ANTES DE LA REFERENCIA</h6> 
                                    </div> 
                                </div> 
                            
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">R.P.M. </br>[hrs.]:</h6> 
                                        <input type="time" class="form-control" value="<?php echo $row_p[1]?>"
                                            name="hora_rpm" value="0" required>                
                                    </div> 
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.C.F.</h6>
                                        <input type="number" class="form-control"              
                                            name="frecuencia_fcf"  placeholder="" value="<?php echo $row_ca[1]?>" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">Nº CONTROLES</br>PRENATALES</h6>
                                        <input type="number" class="form-control"              
                                            name="controles_prenatales"  placeholder="" value="<?php echo $row_g[3]?>" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">MADURACIÓN PULMONAR:</h6>
                                    SI <input type="radio" name="maduracion_pulmonar" value="SI" <?php if ($row_p[2] =='NO') { echo 'checked'; } ?> > </br> 
                                    NO <input type="radio" name="maduracion_pulmonar" value="NO" <?php if ($row_p[2] =='SI') { echo 'checked'; } ?> > 
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">PARTO:</h6>
                                        <input type="text" name="parto" value="SI" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">           
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">2.2.- PARTO</h6>
                            </div>
                            <div class="card-body">                    
                                    <div class="form-group row">  
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">PARTO</br></h6>
                                    EUTOCICO <input type="radio" name="idtipo_parto" value="1" <?php if ($row_p[3] =='1') { echo 'checked'; } ?> > </br> 
                                    CESÁREA <input type="radio" name="idtipo_parto" value="2" <?php if ($row_p[3] =='2') { echo 'checked'; } ?> >               
                                    </div>                             
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">FECHA DEL PARTO</br>[Fecha]:</h6>
                                        <input type="date" class="form-control" value="<?php echo $row_p[4]?>"             
                                            name="fecha_parto"  required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">HORA DEL PARTO</br>[hrs]:</h6>
                                        <input type="time" class="form-control" value="<?php echo $row_p[5]?>" 
                                            name="hora_parto" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">EDAD GESTACIONAL</br>[Semanas]:</h6>
                                        <input type="number" class="form-control" value="<?php echo $row_ca[2]?>"
                                            name="edad_gestacional" required>                 
                                    </div>

                                        <?php
                                            $sql_rn =" SELECT idrecien_nacido, liq_amniotico, peso_rn, talla_rn, pc_rn, pt_rn, apgar_uno, apgar_cinco, indice_choque, criterio_sofa FROM recien_nacido WHERE idgestacion='$row_g[0]' ORDER BY idrecien_nacido DESC LIMIT 1 ";
                                            $result_rn = mysqli_query($link,$sql_rn);
                                            $row_rn = mysqli_fetch_array($result_rn);
                                        ?>

                                    <div class="col-sm-2">
                                    <h6 class="text-primary">LÍQUIDO AMNIÓTICO:</br></h6> 
                                        <input type="checkbox" name="liq_amniotico" value="<?php echo $row_rn[1];?>">             
                                    </div> 
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">PESO</br>[gramos]</h6>
                                        <input type="number" class="form-control"              
                                            name="peso_rn" value="<?php echo $row_rn[2];?>" required>               
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">TALLA</br>[centímetros]</h6>
                                        <input type="number" class="form-control"              
                                            name="talla_rn" value="<?php echo $row_rn[3];?>" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">P.C.:</br>[perimetro]</h6>
                                        <input type="number" class="form-control"              
                                            name="pc_rn" value="<?php echo $row_rn[4];?>" required>  
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">P.T.:</br>[perimetro]</h6>
                                        <input type="number" class="form-control"              
                                            name="pt_rn" value="<?php echo $row_rn[5];?>" required>  
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">APGAR:</br>[Primer Minuto]</h6>
                                        <input type="number" class="form-control"              
                                            name="apgar_uno" value="<?php echo $row_rn[6];?>" required>  
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">APGAR:</br>[5 minutos]</h6>
                                        <input type="number" class="form-control"              
                                            name="apgar_cinco" value="<?php echo $row_rn[7];?>" required>  
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">INDICE DE CHOQUE:</br>[indice]</h6>
                                        <input type="number" class="form-control"              
                                            name="indice_choque" value="<?php echo $row_rn[8];?>" required>               
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary">CRITERIOS SOFA:</br>[indice]</h6>
                                        <input type="number" class="form-control"              
                                            name="criterio_sofa" value="<?php echo $row_rn[9];?>" required>  
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary"></h6>
                                    </div>
                                    <div class="col-sm-3">
                                    <h6 class="text-primary"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        }
                        while ($row_p = mysqli_fetch_array($result_p));
                        } else {  ?>

                        <!---- llenar si no hay PARTO----->

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <h6 class="text-danger">SE DEBE REGISTRAR TODOS LOS DATOS ANTES DE LA REFERENCIA</h6> 
                                    </div> 
                                </div> 

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">R.P.M. </br>[hrs.]:</h6> 
                                        <input type="time" class="form-control" 
                                            name="hora_rpm" value="0" required>                
                                    </div> 
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.C.F.</br></h6>
                                        <input type="number" class="form-control"              
                                            name="frecuencia_fcf"  placeholder="" value="0" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">Nº CONTROLES</br>PRENATALES</h6>
                                        <input type="number" class="form-control"              
                                            name="controles_prenatales"  placeholder="" value="0" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">MADURACIÓN PULMONAR:</h6>
                                    SI <input type="radio" name="maduracion_pulmonar" value="SI" > </br>
                                    NO <input type="radio" name="maduracion_pulmonar" value="NO" checked >  
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">PARTO:</h6>
                                    <select name="parto" id="parto" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="datos_parto">
                        </div>

                        <?php } ?>


                    <?php
                    }
                    while ($row_h = mysqli_fetch_array($result_h));
                    } else {  ?>

                                <div class="form-group row">  
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.U.M. </br>[fecha]</h6>
                                        <input type="date" class="form-control" 
                                            name="fecha_fum" required>                
                                    </div>                             
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">G</br>[Gestaciones]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Gestaciones"           
                                            name="gestaciones" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">P</br>[Partos]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Partos"
                                            name="partos" placeholder="" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">A</br>[Abortos]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Abortos"
                                            name="abortos" value="" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">C</br>[Cesáreas]:</h6>
                                        <input type="number" class="form-control" placeholder="Nº Cesáreas"
                                            name="cesareas" placeholder="" value="0" required>                
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.P.P.</br>[fecha]</h6>
                                        <input type="date" class="form-control" 
                                            name="fecha_fpp" value="">                
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">R.P.M. </br>[hrs.]:</h6> 
                                        <input type="time" class="form-control" 
                                            name="hora_rpm" value="0" required>                
                                    </div> 
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">F.C.F.</br></h6>
                                        <input type="number" class="form-control"              
                                            name="frecuencia_fcf"  placeholder="" value="0" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">Nº CONTROLES</br>PRENATALES</h6>
                                        <input type="number" class="form-control"              
                                            name="controles_prenatales"  placeholder="" value="0" required>               
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">MADURACIÓN PULMONAR:</h6>
                                    SI <input type="radio" name="maduracion_pulmonar" value="SI" > </br>
                                    NO <input type="radio" name="maduracion_pulmonar" value="NO" checked >  
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary">PARTO:</h6>
                                    <select name="parto" id="parto" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-2">
                                    <h6 class="text-primary"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div id="datos_parto">
                            </div>

                        <?php } ?>



        <script language="javascript"> 
            $(document).ready(function(){
            $("#parto").change(function () {
                        $("#parto option:selected").each(function () {
                            parto=$(this).val();
                        $.post("datos_parto.php", {parto:parto}, function(data){
                        $("#datos_parto").html(data);
                        });
                    });
            })
            });
        </script>

