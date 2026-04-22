<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha 		= date("Y-m-d");
$idtipo_atencion = $_POST['tipo_atencion'];
$edad_ss = $_SESSION['edad_ss'];

switch ($idtipo_atencion) {
    case 1: ?>
      
<!--------  ATENCION POR MORBILIDAD ------>

        <form name="ATENCIONMORB" action="guarda_atencion_pmorbilidad.php" method="post">  

    <input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-3">
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ATENCIÓN POR MORBILIDAD:</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>
    <div class="form-group row">  
    <div class="col-sm-4">
                <h6 class="text-info">INCIDENCIA DE LA ATENCIÓN:</h6>
                <?php
                $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
                $result_i = mysqli_query($link,$sql_i);
                if ($row_i = mysqli_fetch_array($result_i)){
                mysqli_field_seek($result_i,0);
                while ($field_i = mysqli_fetch_field($result_i)){
                } do { 
                ?>

                <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>"
                <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > </br>

                <?php }
                while ($row_i = mysqli_fetch_array($result_i));
                } else { } ?>
                </div>

                <div class="col-sm-4">
                <h6 class="text-info">LUGAR DE LA ATENCIÓN:</h6>
                <?php
                $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
                $result_c = mysqli_query($link,$sql_c);
                if ($row_c = mysqli_fetch_array($result_c)){
                mysqli_field_seek($result_c,0);
                while ($field_c = mysqli_fetch_field($result_c)){
                } do { 
                ?>

                <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>"
                <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > </br>

                <?php }
                while ($row_c = mysqli_fetch_array($result_c));
                } else { } ?>
                </div>
            <div class="col-sm-4">
                <h6 class="text-info">FECHA DE LA ATENCIÓN:</h6>
                    <input type="date" name="fecha_registro" value="<?php echo $fecha;?>" class="form-control">
            </div>
    </div>  


<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">SIGNOS VITALES:</h6>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>  

    <div class="form-group row">  
        <div class="col-sm-3">
        <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
            <input type="text" class="form-control" placeholder="En Centrimetros"
                name="talla" value="1" required>                
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="text" class="form-control"              
                name="peso" value="1" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="text" class="form-control" 
                name="temperatura" placeholder="" value="0" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" 
                name="frec_cardiaca" value="0" required>                
        </div>
    </div>

    <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
    
        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" 
                    name="frec_respiratoria" value="0" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0" required>               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0" required>                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0" required>                
            </div>
        </div>

                <div class="form-group row">    
                    <div class="col-sm-3">
                    <h6 class="text-info">ALÉRGIAS:</h6>
                    SI <input type="radio" name="alergia" value="SI" > </br>
                    NO <input type="radio" name="alergia" value="NO" checked >  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="alergia_n" ></textarea>
                    <button type="button" class="btn-mic" onclick="iniciarDictado('alergia_n')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>                     
                    </div>
                    <div class="col-sm-3">             
                    </div>
                </div>

    <?php } else { ?>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" 
                    name="frec_respiratoria" value="0" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   
                <input type="number" class="form-control"
                    name="saturacion" value="0" required>             
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>  para menor de 5 anos -->
                <input type="hidden" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info"> </br>diastólica [mmHg]</h6>   para menor de 5 anos    --> 
                    <input type="hidden" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">          
            </div>
        </div>

    <?php } ?>

<hr>
            <div class="form-group row"> 
            <div class="col-sm-3">
            <h6 class="text-info">NÚMERO DE DIAGNÓSTICOS:</h6>
            </div> 
            <div class="col-sm-3"> 
            <select name="diagnosticos"  id="diagnosticos" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <option value="1">1 DIAGNÓSTICO</option>
            <option value="2">2 DIAGNÓSTICOS</option>
            </select>
            </div> 
            <div class="col-sm-6">
            </div> 
            </div> 
<hr>
            <div id="diagnosticos_ps"></div>
<hr>

            <div class="form-group row">
            <div class="col-sm-6">
            <h4 class="text-info"></h4>  
            </div> 
            <div class="col-sm-6">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal1">
                GUARDAR ATENCIÓN SAFCI
                </button>  
            </div> 
          

    <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">ATENCIÓN INTEGRAL SAFCI</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCIÓN MÉDICA POR MORBILIDAD?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>    


 <?php       
        break;
    case 2: ?>
        
          <!--------  ATENCION PREVENTIVA ------>

        <form name="ATENCIONSANO" action="guarda_atencion_psano.php" method="post">  

<input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ATENCIÓN PREVENTIVA:</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
        <hr>
    <div class="form-group row">  
        <div class="col-sm-4">
        <h6 class="text-info">INCIDENCIA DE LA ATENCIÓN:</h6>
        <?php
        $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
        $result_i = mysqli_query($link,$sql_i);
        if ($row_i = mysqli_fetch_array($result_i)){
        mysqli_field_seek($result_i,0);
        while ($field_i = mysqli_fetch_field($result_i)){
        } do { 
        ?>

        <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>"
        <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > </br>

        <?php }
        while ($row_i = mysqli_fetch_array($result_i));
        } else { } ?>
        </div>

        <div class="col-sm-4">
        <h6 class="text-info">LUGAR DE LA ATENCIÓN:</h6>
        <?php
        $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
        $result_c = mysqli_query($link,$sql_c);
        if ($row_c = mysqli_fetch_array($result_c)){
        mysqli_field_seek($result_c,0);
        while ($field_c = mysqli_fetch_field($result_c)){
        } do { 
        ?>

        <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>"
        <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > </br>

        <?php }
        while ($row_c = mysqli_fetch_array($result_c));
        } else { } ?>
        </div>
        <div class="col-sm-4">
        <h6 class="text-info">FECHA DE LA ATENCIÓN:</h6>
            <input type="date" name="fecha_registro" value="<?php echo $fecha;?>" class="form-control">
        </div>
    </div>  
    </br>


<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">SIGNOS VITALES:</h6>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>  

    <div class="form-group row">  
        <div class="col-sm-3">
        <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
            <input type="text" class="form-control" placeholder="En Centrimetros"
                name="talla" value="1" required>                
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="text" class="form-control"              
                name="peso" value="1" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="text" class="form-control" 
                name="temperatura" placeholder="" value="0" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" 
                name="frec_cardiaca" value="0" required>                
        </div>
    </div>

    <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
    
        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" 
                    name="frec_respiratoria" value="0" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0" required>               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0" required>                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0" required>                
            </div>
        </div>

                <div class="form-group row">    
                    <div class="col-sm-3">
                    <h6 class="text-info">ALÉRGIAS:</h6>
                    SI <input type="radio" name="alergia" value="SI" > </br>
                    NO <input type="radio" name="alergia" value="NO" checked >  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="alergia_m" ></textarea>
                    <button type="button" class="btn-mic" onclick="iniciarDictado('alergia_m')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button> 
                    </div>
                    <div class="col-sm-3">             
                    </div>
                </div>

    <?php } else { ?>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" 
                    name="frec_respiratoria" value="0" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   
                <input type="number" class="form-control"
                    name="saturacion" value="0" required>             
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>  para menor de 5 anos -->
                <input type="hidden" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info"> </br>diastólica [mmHg]</h6>   para menor de 5 anos    --> 
                    <input type="hidden" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">          
            </div>
        </div>

    <?php } ?>
<hr>
        <div class="form-group row"> 
            <div class="col-sm-12"> 
            <h6 class="text-info">SUBJETIVO:</h6>
            <h6 class="text-secundary">Motivo de consulta y/o sintomas que el paciente refiere durante la anamnesis</h6>
            </div> 
        </div> 
        <div class="form-group row"> 
            <div class="col-sm-12"> 
            <h6 class="text-info">OBJETIVO:</h6>
            <h6 class="text-secundary">Hallazgos del exámen físico y/o resultados de exámenes de laboratorio y complementarios</h6>
            </div> 
        </div> 
        <div class="form-group row"> 
            <div class="col-sm-12"> 
            <h6 class="text-info">ANÁLISIS:</h6>
            <h6 class="text-secundary">Lista de problemas detectados: diagnóstico, signos o sintomas a seguir, resultados de laboratorio patológico, antecedentes personales</h6>
            </div> 
        </div> 
        <div class="form-group row"> 
            <div class="col-sm-12"> 
            <h6 class="text-info">PLAN:</h6>
            <h6 class="text-secundary">Tratamientos, orientaciones, seguimientos, exámenes complementarios necesarios para cada problema.</h6>
            </div> 
        </div> 
<hr>

        <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-info">SUBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="subjetivo" id="subjetivo_d" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('subjetivo_d')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 

            <div class="col-sm-6"> 
            <h6 class="text-info">OBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="objetivo" id="objetivo_d" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('objetivo_d')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
        </div> 

        <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-info">ANÁLISIS:</h6>
            <textarea class="form-control" rows="3" name="analisis" id="analisis_d" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('analisis_d')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div>
                <div class="col-sm-6"> 
            <h6 class="text-info">PLAN:</h6>
            <textarea class="form-control" rows="3" name="plan" id="plan_d" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('plan_d')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>            
            </div> 
        </div>
        <hr>

    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNÓSTICO:</h6>
        <select name="idpatologia_ap_sano"  id="idpatologia_ap_sano" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = " SELECT idpatologia, patologia, cie FROM patologia WHERE cie LIKE '%Z%' AND idpatologia != '938' AND idpatologia != '939' AND idpatologia !='456' AND idpatologia !='455' ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
            </select>
        </div> 
    </div> 

    <!---  <div id="opcion_patologia_prev"></div>   --->
        
   <hr>     
            <div class="form-group row">
            <div class="col-sm-6">
            <h4 class="text-info"></h4>  
            </div> 
            <div class="col-sm-6">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal0">
                GUARDAR ATENCIÓN SAFCI
                </button>  
            </div> 
          

    <!-- modal de confirmacion de envio de datos-->
    <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel0">ATENCIÓN INTEGRAL SAFCI</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCIÓN PREVENTIVA?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>     

        </div>
<hr>
    <?php   
    break;
    case 3: ?>
   <!--------  TELECONSULTA - BEGIN ------>
        
<form name="TELECONSULTA" action="guarda_teleconsulta.php" method="post">  

<input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-4"></div> 
    <div class="col-sm-4">
    <h4 class="text-info">TELECONSULTA:</h4>
    </div> 
    <div class="col-sm-4"></div> 
    </div> 
        <hr>
    <div class="form-group row">  
        <div class="col-sm-4">
        <h6 class="text-info">TIPO DE TELECONSULTA:</h6>
        <?php
        $sql_i =" SELECT idrepeticion, repeticion FROM repeticion ";
        $result_i = mysqli_query($link,$sql_i);
        if ($row_i = mysqli_fetch_array($result_i)){
        mysqli_field_seek($result_i,0);
        while ($field_i = mysqli_fetch_field($result_i)){
        } do { 
        ?>

        <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>"
        <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > </br>

        <?php }
        while ($row_i = mysqli_fetch_array($result_i));
        } else { } ?>
        </div>

        <div class="col-sm-4">
        <h6 class="text-info">LUGAR DE LA ATENCIÓN:</h6>
        <?php
        $sql_c =" SELECT idtipo_consulta, tipo_consulta FROM tipo_consulta ";
        $result_c = mysqli_query($link,$sql_c);
        if ($row_c = mysqli_fetch_array($result_c)){
        mysqli_field_seek($result_c,0);
        while ($field_c = mysqli_fetch_field($result_c)){
        } do { 
        ?>

        <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>"
        <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > </br>

        <?php }
        while ($row_c = mysqli_fetch_array($result_c));
        } else { } ?>
        </div>
        <div class="col-sm-4">
        <h6 class="text-info">FECHA DE LA ATENCIÓN:</h6>
            <input type="date" name="fecha_registro" value="<?php echo $fecha;?>" class="form-control">
        </div>
    </div>  
  
    <hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">PACIENTE DE GRUPO VULNERABLE:</h6>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
    <div class="form-group row"> 
        <?php  
        $numero1=0;                  
        $sql1 ="  SELECT idgrupo_vulnerable, grupo_vulnerable FROM grupo_vulnerable ";
        $result1 = mysqli_query($link,$sql1);
        if ($row1 = mysqli_fetch_array($result1)){
        mysqli_field_seek($result1,0);
        while ($field1 = mysqli_fetch_field($result1)){
        } do { 
        ?>
            <div class="col-sm-3">
            <h6 class="text-secundary"><?php echo $row1[1];?> <input type="checkbox" name="idgrupo_vulnerable[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>"></h6>
            
            </div> 
        <?php
        $numero1=$numero1+1;
        }
        while ($row1 = mysqli_fetch_array($result1));
        } else {
        }
        ?>
    </div> 
    <hr>
    <div class="form-group row"> 
    <div class="col-sm-4">
        <h6 class="text-info">CAPTADO POR:</h6>
        <select name="idcaptacion_ts"  id="idcaptacion_ts" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = " SELECT idcaptacion_ts, captacion_ts FROM captacion_ts ";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
        </select>
    </div> 
    <div class="col-sm-4">
        <h6 class="text-info">DE:</h6> 
        <select name="idde_ts"  id="idde_ts" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = " SELECT idde_ts, de_ts FROM de_ts ";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
        </select>
    </div> 
    <div class="col-sm-4"> 
        <h6 class="text-info">EN:</h6>
        <select name="iden_ts"  id="iden_ts" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = " SELECT iden_ts, en_ts FROM en_ts ";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
        </select>
    </div> 

    </div> 
    <div class="form-group row"> 
        <div class="col-sm-4"> 
            <h6 class="text-info">VÍA DE COMUNICACIÓN:</h6>
                <select name="idvia_comunicacion"  id="idvia_comunicacion" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $numero=1;
                $sql1 = " SELECT idvia_comunicacion, via_comunicacion FROM via_comunicacion ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                $numero=$numero+1;
                } while ($row1 = mysqli_fetch_array($result1));
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
            </select>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">CONSENTIMIENTO INFORMADO: <input type="radio" name="consentimiento_informado" value="SI" required></h6>
            
        </div> 
        <div class="col-sm-4">
        </div> 
    </div>
<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">MOTIVO DE LA TELECONSULTA E HISTORIA:</h6>
    </div> 
    <div class="col-sm-6"> 
        
    </div> 

    </div> 
<hr>
    <div class="form-group row"> 
        <div class="col-sm-6">
        <h6 class="text-info">MOTIVO DE LA TELECONSULTA:</h6>
        <textarea class="form-control" rows="2" name="motivo_teleconsulta" id="tm_motivo" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_motivo')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
        <div class="col-sm-6"> 
            
        </div> 
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">HISTORIA DE LA ENFERMEDAD ACTUAL:</h6>
        <textarea class="form-control" rows="3" name="historia_enfermedad" id="tm_historia" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_historia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
    </div> 
<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">EXAMEN FÍSICO - SIGNOS VITALES:</h6>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>  

    <div class="form-group row">  
        <div class="col-sm-3">
        <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
            <input type="text" class="form-control" placeholder="En Centrimetros"
                name="talla" value="1" required>                
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="text" class="form-control"              
                name="peso" value="1" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="text" class="form-control" 
                name="temperatura" placeholder="" value="0" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" 
                name="frec_cardiaca" value="0" required>                
        </div>
    </div>

    <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
    
        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" 
                    name="frec_respiratoria" value="0" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0" required>               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0" required>                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control"
                    name="saturacion" value="0" required>                
            </div>
        </div>

                <div class="form-group row">    
                    <div class="col-sm-3">
                    <h6 class="text-info">ALÉRGIAS:</h6>
                    SI <input type="radio" name="alergia" value="SI" > </br>
                    NO <input type="radio" name="alergia" value="NO" checked >  
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                        <textarea class="form-control" rows="3" name="descripcion_alergia" id="d_alergia" ></textarea>
                        <button type="button" class="btn-mic" onclick="iniciarDictado('d_alergia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                    </div>
                    <div class="col-sm-3">             
                    </div>
                </div>

    <?php } else { ?>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" 
                    name="frec_respiratoria" value="0" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   
                <input type="number" class="form-control"
                    name="saturacion" value="0" required>             
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>  para menor de 5 anos -->
                <input type="hidden" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info"> </br>diastólica [mmHg]</h6>   para menor de 5 anos    --> 
                    <input type="hidden" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" value="0">          
            </div>
        </div>

    <?php } ?>
<hr>

    <div class="form-group row"> 
        <div class="col-sm-6">
        <h6 class="text-info">IMPRESIÓN DIAGNÓSTICA:</h6>
        </div> 
        <div class="col-sm-3"> 
        </div> 
        <div class="col-sm-3"> 
        </div> 
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 1:</h6>
            <select name="idpatologia[0]"  id="idpatologia[0]" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 2:</h6>
        <select name="idpatologia[1]"  id="idpatologia[1]" class="form-control" >
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 3:</h6>
            <select name="idpatologia[2]"  id="idpatologia[2]" class="form-control" >
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 4:</h6>
            <select name="idpatologia[3]"  id="idpatologia[3]" class="form-control" >
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
            </select>
        </div>  
    </div> 
<hr>

  <!--      <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">ESTUDIOS COMPLEMENTARIOS Y CONDUCTA:</h6>
                </div> 
                <div class="col-sm-3"> 
                </div> 
                <div class="col-sm-3"> 
                </div> 
            </div>
            <hr>
            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">TELEMETRÍA REALIZADA (SELECCIÓN MÚLTIPLE):</h6>
                </div> 
                <div class="col-sm-3"> 
                </div> 
                <div class="col-sm-3"> 
                </div> 
            </div> 


            <div class="form-group row">                           
                <?php  
                $numero1=0;                  
                $sql1 ="  SELECT idtipo_examen_ref, tipo_examen_ref FROM tipo_examen_ref ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do { 
                ?>
                    <div class="col-sm-3"> 
                    <h6 class="text-secundary"> 
                    <input type="checkbox" name="idtipo_examen_ref[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>">  <?php echo $row1[1];?>  
                    </h6>
                    </div> 
                <?php
                $numero1=$numero1+1;
                }
                while ($row1 = mysqli_fetch_array($result1));
                } else {
                }
                ?>
            </div> 

            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">SI MARCÓ OTROS MENCIONE CUAL:</h6>
                <input type="text" name="otros_descripcion" class="form-control" placeholder="Ejemplo...TERMÓMETRO DIGITAL, ETC.">
                </div> 
            </div> --->
            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">EXÁMENES COMPLEMENTARIOS O DE GABINETE:</h6>
                <textarea class="form-control" rows="3" name="examen_complementario" id="exam_complementario" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('exam_complementario')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
                <div class="col-sm-6">
                <h6 class="text-info">TRATAMIENTO:</h6>
                <textarea class="form-control" rows="3" name="tratamiento_teleconsulta" id="tratamiento" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('tratamiento')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
            </div>

            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">ESPECIALIDAD Y CIERRE DE TELECONSULTA:</h6>
                <select name="idespecialidad_medica"  id="idespecialidad_medica" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $numero=1;
                $sql1 = "SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica ORDER BY especialidad_medica";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                $numero=$numero+1;
                } while ($row1 = mysqli_fetch_array($result1));
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
                </div> 
            </div>

            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">SUBESPECIALIDAD:</h6>
                <input type="text" name="subespecialidad" class="form-control" placeholder="Llenado libre">
                </div> 
            </div>

            <div class="form-group row"> 
                <div class="col-sm-2">
                <h6 class="text-info">TIEMPO:</h6></br>
                <select name="idtiempo_ts"  id="idtiempo_ts" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $numero=1;
                $sql1 = "SELECT idtiempo_ts, tiempo_ts FROM tiempo_ts ORDER BY tiempo_ts";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                $numero=$numero+1;
                } while ($row1 = mysqli_fetch_array($result1));
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">ESTADO DEL PACIENTE:</h6></br>
                <select name="idestado_paciente"  id="idestado_paciente" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $numero=1;
                $sql1 = "SELECT idestado_paciente, estado_paciente FROM estado_paciente ORDER BY estado_paciente";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                $numero=$numero+1;
                } while ($row1 = mysqli_fetch_array($result1));
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
                </div> 
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA CONSULTA DE SEGUIMIENTO:</h6>
                    <input type="date" name="fecha_seguimiento" value="<?php echo $fecha;?>" class="form-control" required>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-info">TELEFÓNO CELULAR DEL PACIENTE/FAMILIAR:</h6>
                    <input type="number" name="telefono_paciente" value="" class="form-control" required>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-6">
                <h4 class="text-info"></h4>  
                </div> 
                <div class="col-sm-6">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#examplemodaltele">
                    GUARDAR TELECONSULTA
                    </button>  
                </div> 
          </div>

    <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="examplemodaltele" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel0">ATENCIÓN POR TELECONSULTA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCIÓN POR TELECONSULTA?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form> 

                          
    <!-------- TELECONSULTA - END --------->  


    <?php    
    break; 
    case 4: ?>
 
    <!--------  TELEINTERCONSULTA - BEGIN ------>
        
 


    <!-------- TELEINTERCONSULTA - END --------->  


     <?php 
     break; 
    } 
    ?>


    <script language="javascript"> 
        $(document).ready(function(){
        $("#diagnosticos").change(function () {
                    $("#diagnosticos option:selected").each(function () {
                        diagnosticos=$(this).val();
                    $.post("diagnosticos_ps.php", {diagnosticos:diagnosticos}, function(data){
                    $("#diagnosticos_ps").html(data);
                    });
                });
        })
        });
    </script>

        <script language="javascript"> 
        $(document).ready(function(){
        $("#idpatologia_ap_sano").change(function () {
                    $("#idpatologia_ap_sano option:selected").each(function () {
                        patologia_ap_sano=$(this).val();
                    $.post("opcion_patologia_prev.php", {patologia_ap_sano:patologia_ap_sano}, function(data){
                    $("#opcion_patologia_prev").html(data);
                    });
                });
        })
        });
    </script>

   