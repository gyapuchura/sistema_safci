<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php

$parto = $_POST['parto'];

if ($parto == 'SI') { ?>
            <div class="card shadow mb-4">
            
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">2.2.- PARTO</h6>
                </div>
                <div class="card-body">
                    
                        <div class="form-group row">  
                        <div class="col-sm-2">
                        <h6 class="text-primary">PARTO</br></h6>
                        EUTOCICO <input type="radio" name="idtipo_parto" value="1" checked></br>
                        CESÁREA <input type="radio" name="idtipo_parto" value="2" >               
                        </div>                             
                        <div class="col-sm-2">
                        <h6 class="text-primary">FECHA DEL PARTO</br>[Fecha]:</h6>
                            <input type="date" class="form-control"              
                                name="fecha_parto"  required>                
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">HORA DEL PARTO</br>[hrs]:</h6>
                            <input type="time" class="form-control" 
                                name="hora_parto" required>                
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">EDAD GESTACIONAL</br>[Semanas]:</h6>
                            <input type="number" class="form-control" 
                                name="edad_gestacional" required>                 
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">LÍQUIDO AMNIÓTICO:</br></h6> 
                            <input type="checkbox" name="liq_amniotico" id="liq_amniotico" value="SI">             
                        </div> 
                        <div class="col-sm-2">
                        <h6 class="text-primary">PESO</br>[gramos]</h6>
                            <input type="number" class="form-control"              
                                name="peso_rn" required>               
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <div class="col-sm-2">
                        <h6 class="text-primary">TALLA</br>[centímetros]</h6>
                            <input type="number" class="form-control"              
                                name="talla_rn" required>               
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">P.C.:</br>[perimetro]</h6>
                            <input type="number" class="form-control"              
                                name="pc_rn" required>  
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">P.T.:</br>[perimetro]</h6>
                            <input type="number" class="form-control"              
                                name="pt_rn"  required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">APGAR:</br>[Primer Minuto]</h6>
                            <input type="number" class="form-control"              
                                name="apgar_uno" required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">APGAR:</br>[5 minutos]</h6>
                            <input type="number" class="form-control"              
                                name="apgar_cinco" required>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">INDICE DE CHOQUE:</br>[indice]</h6>
                            <input type="number" class="form-control"              
                                name="indice_choque" required>               
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">CRITERIOS SOFA:</br>[indice]</h6>
                            <input type="number" class="form-control"              
                                name="criterio_sofa" required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">GÉNERO DEL RECIEN NACIDO</h6>
                            <select name="idgenero_rn" id="idgenero_rn" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT idgenero, genero FROM genero ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                            </select> 
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">PESO - EDAD GESTACIONAL</h6>
                            <select name="idpeso_eg" id="idpeso_eg" class="form-control" required>
                            <option value="">-SELECCIONE-</option>
                            <?php
                            $sql1 = "SELECT idpeso_eg, peso_eg FROM peso_eg ";
                            $result1 = mysqli_query($link,$sql1);
                            if ($row1 = mysqli_fetch_array($result1)){
                            mysqli_field_seek($result1,0);
                            while ($field1 = mysqli_fetch_field($result1)){
                            } do {
                            echo "<option value=".$row1[0].">".$row1[1]."</option>";
                            } while ($row1 = mysqli_fetch_array($result1));
                            } else {
                            echo "No se encontraron resultados!";
                            }
                            ?>
                            </select> 
                        </div>
                    </div>
                </div>
            </div>

<?php } else { ?>

        <input type="hidden" name="tipo_parto" value="" >
        <input type="hidden" name="fecha_parto" value="0000-00-00" >
        <input type="hidden" name="hora_parto" value="" >
        <input type="hidden" name="edad_gestacional" value="" >
        <input type="hidden" name="liq_amniotico" value="" >
        <input type="hidden" name="peso_rn" value="" >
        <input type="hidden" name="talla_rn" value="" >
        <input type="hidden" name="pc_rn" value="" >
        <input type="hidden" name="pt_rn" value="" >
        <input type="hidden" name="apgar_uno" value="" >
        <input type="hidden" name="apgar_cinco" value="" >
        <input type="hidden" name="indice_choque" value="" >
        <input type="hidden" name="criterios_sofa" value="" >

<?php } ?>