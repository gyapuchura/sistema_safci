<?php
$parto = $_POST['parto'];

if ($parto == 'SI') { ?>

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">2.2.- PARTO</h6>
                </div>
                <div class="card-body">
                    
                        <div class="form-group row">  
                        <div class="col-sm-2">
                        <h6 class="text-primary">PARTO</br></h6>
                        EUTOCICO <input type="radio" name="tipo_parto" value="EUTOCICO" checked> </br>
                        CESÁREA <input type="radio" name="tipo_parto" value="CESÁREA" >               
                        </div>                             
                        <div class="col-sm-2">
                        <h6 class="text-primary">FECHA DEL PARTO</br>[Fecha]:</h6>
                            <input type="date" class="form-control"              
                                name="fecha_parto" value="1" required>                
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">HORA DEL PARTO</br>[hrs]:</h6>
                            <input type="time" class="form-control" 
                                name="hora_parto" placeholder="" value="0" required>                
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">EDAD GESTACIONAL</br>[Semanas]:</h6>
                            <input type="number" class="form-control" 
                                name="edad_gestacional" value="0" required>                 
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">LÍQUIDO AMNIÓTICO:</br></h6> 
                            <input type="checkbox" name="liq_amniotico" id="liq_amniotico" value="SI">             
                        </div> 
                        <div class="col-sm-2">
                        <h6 class="text-primary">PESO</br>[gramos]</h6>
                            <input type="number" class="form-control"              
                                name="peso_rn"  placeholder="" value="0" required>               
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <div class="col-sm-2">
                        <h6 class="text-primary">TALLA</br>[centímetros]</h6>
                            <input type="number" class="form-control"              
                                name="talla_rn"  placeholder="" value="0" required>               
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">P.C.:</br>[perimetro]</h6>
                            <input type="number" class="form-control"              
                                name="pc_rn"  placeholder="" value="0" required>  
                        </div>
                        <div class="col-sm-2">
                        <h6 class="text-primary">P.T.:</br>[perimetro]</h6>
                            <input type="number" class="form-control"              
                                name="pt_rn"  placeholder="" value="0" required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">APGAR:</br>[Primer Minuto]</h6>
                            <input type="number" class="form-control"              
                                name="apgar_uno"  placeholder="" value="0" required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">APGAR:</br>[5 minutos]</h6>
                            <input type="number" class="form-control"              
                                name="apgar_cinco"  placeholder="" value="0" required>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                        <h6 class="text-primary">INDICE DE CHOQUE:</br>[indice]</h6>
                            <input type="number" class="form-control"              
                                name="indice_choque"  placeholder="" value="0" required>               
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary">CRITERIOS SOFA:</br>[indice]</h6>
                            <input type="number" class="form-control"              
                                name="criterios_sofa"  placeholder="" value="0" required>  
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-3">
                        <h6 class="text-primary"></h6>
                        </div>

                    </div>

                </div>

<?php } else { ?>



<?php } ?>