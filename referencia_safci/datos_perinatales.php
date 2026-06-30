<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php

$datos_perinatales = $_POST['datos_perinatales'];

if ($datos_perinatales =='SI') { ?>
    
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">2.1.- ANTECEDENTES GINECO OBTETRICOS</h6>
            </div>
            <div class="card-body">
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
                            name="hora_rpm"  required>                
                    </div> 
                    <div class="col-sm-2">
                    <h6 class="text-primary">F.C.F.</br></h6>
                        <input type="number" class="form-control"              
                            name="frecuencia_fcf"  placeholder=""  required>               
                    </div>
                    <div class="col-sm-2">
                    <h6 class="text-primary">Nº CONTROLES</br>PRENATALES</h6>
                        <input type="number" class="form-control"              
                            name="controles_prenatales"  placeholder=""  required>               
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

<?php } else { ?>
    
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

