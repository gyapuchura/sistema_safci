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
                name="talla" value="" required>                
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="text" class="form-control" placeholder="En kilogramos"               
                name="peso" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="text" class="form-control" 
                name="temperatura" placeholder="En Grados Centígrados" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" placeholder="Latidos por minuto"
                name="frec_cardiaca" required>                
        </div>
    </div>

    <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
    
        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" placeholder="Ciclos por minuto"
                    name="frec_respiratoria"  required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica" required>               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" required>                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control" placeholder="% de O2"
                    name="saturacion" required>                
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
                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="alergia_n" placeholder="Escriba o utilice el botón de dictado por voz" ></textarea>
                    <button type="button" class="btn-mic" onclick="iniciarDictado('alergia_n')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>                     
                    </div>
                    <div class="col-sm-3">             
                    </div>
                </div>

    <?php } else { ?>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" placeholder="Ciclos por minuto"
                    name="frec_respiratoria" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   
                <input type="number" class="form-control" placeholder="% de O2"
                    name="saturacion"  required>             
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
                name="talla"  required>                
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="text" class="form-control" placeholder="En kilogramos"              
                name="peso" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="text" class="form-control" 
                name="temperatura" placeholder="En Grados Centígrados" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" placeholder="Latidos por minuto"
                name="frec_cardiaca" required>                
        </div>
    </div>

    <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
    
        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" placeholder="Ciclos por minuto"
                    name="frec_respiratoria" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica"  required>               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica"  required>                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" class="form-control" placeholder="% de O2"
                    name="saturacion" required>                
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
                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="alergia_m" placeholder="Escriba o utilice el botón de dictado por voz"></textarea>
                    <button type="button" class="btn-mic" onclick="iniciarDictado('alergia_m')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button> 
                    </div>
                    <div class="col-sm-3">             
                    </div>
                </div>

    <?php } else { ?>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" class="form-control" placeholder="Ciclos por minuto"
                    name="frec_respiratoria" required>                
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   
                <input type="number" class="form-control" placeholder="% de O2"
                    name="saturacion" required>             
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>  para menor de 5 anos -->
                <input type="hidden" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica">               
            </div>
            <div class="col-sm-3">
            <!-- <h6 class="text-info"> </br>diastólica [mmHg]</h6>   para menor de 5 anos    --> 
                    <input type="hidden" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica" >          
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
            <textarea class="form-control" rows="3" name="subjetivo" id="subjetivo_d" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('subjetivo_d')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 

            <div class="col-sm-6"> 
            <h6 class="text-info">OBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="objetivo" id="objetivo_d" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('objetivo_d')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
        </div> 

        <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-info">ANÁLISIS:</h6>
            <textarea class="form-control" rows="3" name="analisis" id="analisis_d" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('analisis_d')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div>
                <div class="col-sm-6"> 
            <h6 class="text-info">PLAN:</h6>
            <textarea class="form-control" rows="3" name="plan" id="plan_d" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
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

       <!--     <div id="opcion_patologia_prev"></div> --->
        
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
        
<form name="TELECONSULTA" id="form-teleconsulta" action="guarda_teleconsulta.php" method="post" class="needs-validation" novalidate> <!-- Modificado -->  

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
    <!-- INICIO MODIFICADO: GRUPO VULNERABLE OBLIGATORIO --> <!-- Modificado -->
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info" id="titulo-vulnerable" data-asterisco="true">PACIENTE DE GRUPO VULNERABLE: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        <div class="invalid-feedback" id="alerta-vulnerable" style="display: none; font-size: 14px; margin-bottom:10px;">Debe seleccionar al menos una opción. Si no aplica ninguna, marque "NINGUNA".</div>
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
            <h6 class="text-secundary"><?php echo $row1[1];?> <input type="checkbox" class="chk-vulnerable" name="idgrupo_vulnerable[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>"></h6>
            </div> 
        <?php
        $numero1=$numero1+1;
        }
        while ($row1 = mysqli_fetch_array($result1));
        } else {
        }
        ?>
    </div> 
    <!-- FIN MODIFICADO --> 
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
            <h6 class="text-info">CONSENTIMIENTO INFORMADO:</h6> <!-- Modificado -->
            SI, ACEPTADO -> <input type="radio" name="consentimiento_informado" value="SI" checked data-checked="true" onclick="if(this.dataset.checked === 'true') { this.checked = false; this.dataset.checked = 'false'; } else { this.dataset.checked = 'true'; this.checked = true; }" style="cursor: pointer;" title="Haga clic nuevamente para quitar el marcado" required>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe aceptar el consentimiento para proceder.</div>
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
        <textarea class="form-control" rows="2" name="motivo_teleconsulta" id="tm_motivo" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_motivo')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
        <div class="col-sm-6"> 
            
        </div> 
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">HISTORIA DE LA ENFERMEDAD ACTUAL:</h6>
        <textarea class="form-control" rows="3" name="historia_enfermedad" id="tm_historia" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_historia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
    </div> 
<hr>
    <div class="form-group row">    
        <div class="col-sm-3">
        <h6 class="text-info" id="titulo-alergias-tele" data-asterisco="true">ALÉRGIAS: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        SI <input type="radio" name="alergia" value="SI" class="radio-alergia-tele" required> <br>
        NO <input type="radio" name="alergia" value="NO" class="radio-alergia-tele" required>  
        <div class="invalid-feedback" id="alerta-alergias-tele" style="display: none; font-size: 14px; margin-top:5px;">Seleccione SI o NO.</div>
        </div>
        <div class="col-sm-6">
        <h6 class="text-info" id="titulo-desc-alergia-tele">DESCRIPCIÓN DE LA ALÉRGIA</h6>
            <textarea class="form-control" rows="3" name="descripcion_alergia" id="d_alergia_tele" placeholder="Escriba detalles si marcó SI" readonly style="background-color: #eaecf4;"></textarea>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe describir la alergia.</div>
            <button type="button" class="btn-mic mic-alergia-tele" style="display:none;" onclick="iniciarDictado('d_alergia_tele')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div>
        <div class="col-sm-3">             
        </div>
    </div>
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
            <input type="text" class="form-control buscador-cie-tele" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_0" autocomplete="off"> <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[0]" id="idpatologia_tele_0" class="form-control" required style="display: none;"> <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
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
            <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar un diagnóstico CIE-10.</div> </div>  
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 2:</h6>
            <input type="text" class="form-control buscador-cie-tele" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_1" autocomplete="off"> <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[1]" id="idpatologia_tele_1" class="form-control" style="display: none;"> <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
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
            <input type="text" class="form-control buscador-cie-tele" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_2" autocomplete="off"> <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[2]" id="idpatologia_tele_2" class="form-control" style="display: none;"> <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
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
            <input type="text" class="form-control buscador-cie-tele" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_3" autocomplete="off"> <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[3]" id="idpatologia_tele_3" class="form-control" style="display: none;"> <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia ";
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
                <textarea class="form-control" rows="3" name="examen_complementario" id="exam_complementario" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <div class="invalid-feedback" style="margin-top: 5px;">Debe llenar este campo.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('exam_complementario')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
                <div class="col-sm-6">
                <h6 class="text-info">TRATAMIENTO:</h6>
                <textarea class="form-control" rows="3" name="tratamiento_teleconsulta" id="tratamiento" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <div class="invalid-feedback" style="margin-top: 5px;">Debe llenar este campo.</div> <button type="button" class="btn-mic" onclick="iniciarDictado('tratamiento')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
            </div>

            <!-- INICIO MODIFICADO: ESPECIALIDAD INTELIGENTE Y SUBESPECIALIDAD LIBRE -->
            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">ESPECIALIDAD Y CIERRE DE TELECONSULTA:</h6>
                <input type="text" class="form-control buscador-inteligente" placeholder="Buscar especialidad (escriba aquí)..." data-target="idespecialidad_medica" autocomplete="off"> 
                <div class="lista-flotante-especialidad" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

                <select name="idespecialidad_medica" id="idespecialidad_medica" class="form-control" required style="display: none;">
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
                <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar una especialidad médica.</div>
                </div> 
            </div>
            <!-- FIN MODIFICADO -->

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
                }
                ?>
                </select>
                <div class="invalid-feedback" style="margin-top: 5px;">Requerido.</div> </div>
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
                }
                ?>
                </select>
                <div class="invalid-feedback" style="margin-top: 5px;">Requerido.</div> </div> 
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA PRÓXIMO SEGUIMIENTO:</h6>
                    <input type="date" name="fecha_seguimiento" value="<?php echo $fecha;?>" class="form-control" required>
                    <div class="invalid-feedback" style="margin-top: 5px;">Requerido.</div> </div>
                <div class="col-sm-3">
                    <h6 class="text-info">TELEFÓNO CELULAR DEL PACIENTE/FAMILIAR:</h6>
                    <input type="number" name="telefono_paciente" value="" class="form-control" required>
                    <div class="invalid-feedback" style="margin-top: 5px;">Requerido.</div> </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#examplemodaltele">
                    GUARDAR TELECONSULTA
                    </button>  
                </div> 
            </div>

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
                        <button type="button" id="btn-confirmar-tele" class="btn btn-info pull-center">CONFIRMAR</button> </div>
                    </div>
                </div>
            </div>
        </form> 
        
        <!-- INICIO MODIFICADO: MEGA-SCRIPT EXCLUSIVO PARA INYECCIÓN AJAX (TELECONSULTA) V3 -->
        <script>
            (function() {
                setTimeout(function() {
                    var formTele = document.getElementById('form-teleconsulta');
                    if(!formTele) return;

                    // 1. DIBUJO AUTOMÁTICO DE ASTERISCOS
                    var camposOb = formTele.querySelectorAll('input[required], select[required], textarea[required]');
                    camposOb.forEach(function(campo) {
                        var titulo = null;
                        var contenedor = campo.closest('[class*="col-sm-"]');
                        if (contenedor) titulo = contenedor.querySelector('h6');
                        
                        if (titulo && !titulo.hasAttribute('data-asterisco')) {
                            titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                            titulo.setAttribute('data-asterisco', 'true');
                        }
                    });

                    // 2. LÓGICA DE ALERGIAS (Asterisco Dinámico y Color)
                    var radiosAlergia = formTele.querySelectorAll('.radio-alergia-tele');
                    var txtAlergia = formTele.querySelector('#d_alergia_tele');
                    var micAlergia = formTele.querySelector('.mic-alergia-tele');
                    var tituloAlergias = document.getElementById('titulo-alergias-tele');
                    var alertaAlergias = document.getElementById('alerta-alergias-tele');
                    var tituloDescAlergia = document.getElementById('titulo-desc-alergia-tele'); 
                    
                    if(radiosAlergia.length > 0 && txtAlergia) {
                        radiosAlergia.forEach(function(radio) {
                            radio.addEventListener('change', function() {
                                // Quitar error visual general al seleccionar
                                if (Array.from(radiosAlergia).some(r => r.checked)) {
                                    if(alertaAlergias) alertaAlergias.style.setProperty('display', 'none', 'important');
                                    if(tituloAlergias) tituloAlergias.style.color = '';
                                }

                                if(this.value === 'SI' && this.checked) {
                                    // Activar descripción
                                    txtAlergia.readOnly = false;
                                    txtAlergia.style.backgroundColor = '#fff';
                                    txtAlergia.setAttribute('required', 'required'); 
                                    txtAlergia.placeholder = "Escriba o utilice el botón de dictado por voz";
                                    if(micAlergia) micAlergia.style.display = 'inline-block';
                                    
                                    // Magia UX: Poner Asterisco Dinámico
                                    if(tituloDescAlergia && !tituloDescAlergia.hasAttribute('data-asterisco')) {
                                        tituloDescAlergia.innerHTML += ' <span class="asterisco-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                                        tituloDescAlergia.setAttribute('data-asterisco', 'true');
                                    }

                                } else if(this.value === 'NO' && this.checked) {
                                    // Bloquear descripción
                                    txtAlergia.readOnly = true;
                                    txtAlergia.style.backgroundColor = '#eaecf4';
                                    txtAlergia.removeAttribute('required'); 
                                    txtAlergia.value = '';
                                    
                                    // --- INICIO CORRECCIÓN VISUAL (Fantasma eliminado) ---
                                    txtAlergia.classList.remove('is-invalid');
                                    txtAlergia.style.border = ''; 
                                    var feedbackAlergia = txtAlergia.parentNode ? txtAlergia.parentNode.querySelector('.invalid-feedback') : null;
                                    if (feedbackAlergia) feedbackAlergia.style.display = '';
                                    // --- FIN CORRECCIÓN ---
                                    
                                    txtAlergia.placeholder = "Escriba detalles si marcó SI";
                                    if(micAlergia) micAlergia.style.display = 'none';
                                    
                                    // Magia UX: Quitar Asterisco Dinámico
                                    if(tituloDescAlergia && tituloDescAlergia.hasAttribute('data-asterisco')) {
                                        var ast = tituloDescAlergia.querySelector('.asterisco-dinamico');
                                        if(ast) ast.remove();
                                        tituloDescAlergia.removeAttribute('data-asterisco');
                                    }
                                }
                            });
                        });
                    }

                    // 3. CANDADO INTELIGENTE (Para CIE-10 y Especialidad)
                    var buscadores = formTele.querySelectorAll('.buscador-cie-tele, .buscador-inteligente'); 
                    buscadores.forEach(function(input) {
                        var targetId = input.getAttribute('data-target');
                        var selectOriginal = document.getElementById(targetId);
                        var listaFlotante = input.nextElementSibling; 
                        if(!selectOriginal) return;
                        
                        var opciones = Array.from(selectOriginal.options).filter(opt => opt.value !== "");
                        
                        input.addEventListener('input', function() {
                            if (this.readOnly) return; 
                            this.classList.remove('is-invalid');
                            this.style.border = '';
                            var fb = selectOriginal.parentNode.querySelector('.invalid-feedback');
                            if (fb) fb.style.display = '';

                            var term = this.value.toLowerCase().trim();
                            listaFlotante.innerHTML = ''; 
                            if (term === '') {
                                listaFlotante.style.display = 'none';
                                selectOriginal.value = ''; 
                                return;
                            }
                            
                            var coincidencias = opciones.filter(opt => opt.text.toLowerCase().includes(term));
                            if (coincidencias.length > 0) {
                                listaFlotante.style.display = 'block'; 
                                coincidencias.slice(0, 100).forEach(function(opt) { 
                                    var item = document.createElement('div');
                                    item.textContent = opt.text;
                                    item.style.padding = '8px 12px';
                                    item.style.cursor = 'pointer';
                                    item.style.borderBottom = '1px solid #eaecf4';
                                    item.style.fontSize = '0.9rem';
                                    item.style.color = '#5a5c69';
                                    item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                                    item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                                    item.addEventListener('mousedown', function(e) {
                                        e.preventDefault(); 
                                        input.value = opt.text; 
                                        selectOriginal.value = opt.value; 
                                        listaFlotante.style.display = 'none'; 
                                        input.readOnly = true;
                                        input.style.backgroundColor = '#eaecf4';
                                        input.style.color = '#2e59d9';
                                        input.style.cursor = 'not-allowed';
                                        input.title = "Doble clic o presione Borrar para cambiar";
                                    });
                                    listaFlotante.appendChild(item);
                                });
                            } else {
                                listaFlotante.style.display = 'none';
                            }
                        });

                        function desbloquearCIE() {
                            if (input.readOnly) {
                                input.readOnly = false;
                                input.value = '';
                                selectOriginal.value = '';
                                input.style.backgroundColor = '';
                                input.style.color = '';
                                input.style.cursor = 'text';
                                input.removeAttribute('title');
                                input.focus();
                            }
                        }

                        input.addEventListener('keydown', function(e) {
                            if (input.readOnly) {
                                if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); desbloquearCIE(); } 
                                else if (e.key !== 'Tab') { e.preventDefault(); }
                            }
                        });
                        input.addEventListener('dblclick', desbloquearCIE);
                        input.addEventListener('blur', function() {
                            setTimeout(function() {
                                listaFlotante.style.display = 'none';
                                if (!input.readOnly) { input.value = ''; selectOriginal.value = ''; }
                            }, 200);
                        });
                    });

                    // 4. EFECTO MAGIA PARA CHECKBOXES VULNERABLES
                    var chksVul = formTele.querySelectorAll('.chk-vulnerable');
                    var alertaVul = document.getElementById('alerta-vulnerable');
                    var tituloVul = document.getElementById('titulo-vulnerable');
                    
                    if (chksVul) {
                        chksVul.forEach(function(chk) {
                            chk.addEventListener('change', function() {
                                if (Array.from(chksVul).some(c => c.checked)) {
                                    if(alertaVul) alertaVul.style.setProperty('display', 'none', 'important');
                                    if(tituloVul) tituloVul.style.color = '';
                                }
                            });
                        });
                    }

                    // 5. VALIDADOR DE FUERZA BRUTA
                    var btnConfirmar = document.getElementById('btn-confirmar-tele');
                    if (btnConfirmar) {
                        var nuevoBtn = btnConfirmar.cloneNode(true);
                        btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                        
                        nuevoBtn.addEventListener('click', function(e) {
                            e.preventDefault(); 
                            var hayErrores = false;
                            var primerInvalido = null;
                            
                            // Limpieza previa
                            formTele.querySelectorAll('.is-invalid').forEach(function(el) {
                                el.classList.remove('is-invalid');
                                el.style.border = ''; 
                            });
                            formTele.querySelectorAll('.invalid-feedback').forEach(function(el) {
                                el.style.display = ''; 
                            });
                            
                            // A. Validar Grupos Vulnerables Especialmente
                            if(chksVul && chksVul.length > 0) {
                                var alMenosUnoVul = Array.from(chksVul).some(c => c.checked);
                                if(!alMenosUnoVul) {
                                    hayErrores = true;
                                    if(alertaVul) alertaVul.style.setProperty('display', 'block', 'important');
                                    if(tituloVul) {
                                        tituloVul.style.color = '#dc3545';
                                        if(!primerInvalido) primerInvalido = tituloVul;
                                    }
                                }
                            }

                            // B. Validar Radio Buttons de Alergia Manualmente
                            if(radiosAlergia.length > 0) {
                                var alergiaMarcada = Array.from(radiosAlergia).some(r => r.checked);
                                if(!alergiaMarcada) {
                                    hayErrores = true;
                                    if(alertaAlergias) alertaAlergias.style.setProperty('display', 'block', 'important');
                                    if(tituloAlergias) {
                                        tituloAlergias.style.color = '#dc3545';
                                        if(!primerInvalido) primerInvalido = tituloAlergias;
                                    }
                                }
                            }

                            // C. Validar Elementos Regulares
                            var obligatorios = formTele.querySelectorAll('input[required], select[required], textarea[required]');
                            obligatorios.forEach(function(el) {
                                var valor = el.value ? el.value.trim() : '';
                                if (valor === '' || !el.checkValidity()) {
                                    
                                    // Saltamos los radios porque ya se validaron en la parte B
                                    if(el.name === 'alergia') return;

                                    hayErrores = true;
                                    
                                    if (el.style.display === 'none' && el.id && (el.id.includes('idpatologia_tele') || el.id === 'idespecialidad_medica')) {
                                        var inputVisual = formTele.querySelector('input[data-target="' + el.id + '"]');
                                        if (inputVisual) {
                                            inputVisual.classList.add('is-invalid');
                                            inputVisual.style.setProperty('border', '2px solid #dc3545', 'important');
                                            var fback = el.parentNode.querySelector('.invalid-feedback');
                                            if (fback) fback.style.setProperty('display', 'block', 'important');
                                            if (!primerInvalido) primerInvalido = inputVisual;
                                        }
                                    } else if (el.type !== 'hidden' && el.style.display !== 'none') {
                                        el.classList.add('is-invalid');
                                        el.style.setProperty('border', '2px solid #dc3545', 'important');
                                        var fback2 = el.parentNode ? el.parentNode.querySelector('.invalid-feedback') : null;
                                        if (fback2) fback2.style.setProperty('display', 'block', 'important');
                                        if (!primerInvalido) primerInvalido = el;
                                    }
                                }
                            });
                            
                            if (hayErrores) {
                                try {
                                    var btnCancelar = formTele.querySelector('#examplemodaltele [data-dismiss="modal"]');
                                    if (btnCancelar) btnCancelar.click();
                                    $('#examplemodaltele').modal('hide'); 
                                } catch(err) {}
                                
                                setTimeout(function() {
                                    document.body.classList.remove('modal-open');
                                    var backdrops = document.querySelectorAll('.modal-backdrop');
                                    backdrops.forEach(b => b.remove());
                                    
                                    if (primerInvalido) {
                                        primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        setTimeout(() => {
                                            try { primerInvalido.focus({ preventScroll: true }); } catch(err) { primerInvalido.focus(); }
                                        }, 100);
                                    }
                                }, 400);
                            } else {
                                nuevoBtn.innerHTML = "GUARDANDO...";
                                nuevoBtn.disabled = true;
                                formTele.submit(); 
                            }
                        });
                        
                        ['input', 'change'].forEach(function(evt) {
                            formTele.addEventListener(evt, function(e) {
                                if (e.target.hasAttribute('required') && e.target.value.trim() !== '') {
                                    e.target.classList.remove('is-invalid');
                                    e.target.style.border = '';
                                    var fb = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                    if (fb) fb.style.display = '';
                                }
                            });
                        });
                    }
                }, 200); 
            })();
        </script>
        <!-- FIN MEGA-SCRIPT V3 -->

                          
    <!-------- TELECONSULTA - END --------->  


    <?php    
    break; 
    case 4: ?>
 
    <!--------  TELEMETRIA - BEGIN ------>
        
 
<form name="TELEMETRIA" id="form-telemetria" action="guarda_telemetria.php" method="post" class="needs-validation" novalidate> 

<input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-2"></div> 
    <div class="col-sm-8 text-center">
    <h4 class="text-info">ATENCIÓN POR TELEMETRÍA</h4>
    </div> 
    <div class="col-sm-2"></div> 
    </div> 
        <hr>
    <div class="form-group row">  
        <div class="col-sm-4">
        <h6 class="text-info">TIPO DE ATENCIÓN:</h6>
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
            <input type="date" name="fecha_registro" value="<?php echo $fecha;?>" class="form-control" required>
            <div class="invalid-feedback">Requerido.</div>
        </div>
    </div>  
  
    <hr>
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info" id="titulo-vulnerable-telemetria" data-asterisco="true">PACIENTE DE GRUPO VULNERABLE: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        <div class="invalid-feedback" id="alerta-vulnerable-telemetria" style="display: none; font-size: 14px; margin-bottom:10px;">Debe seleccionar al menos una opción. Si no aplica ninguna, marque "NINGUNA".</div>
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
            <h6 class="text-secundary"><?php echo $row1[1];?> <input type="checkbox" class="chk-vulnerable-telemetria" name="idgrupo_vulnerable[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>"></h6>
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
        <div class="invalid-feedback">Campo obligatorio.</div>
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
        <div class="invalid-feedback">Campo obligatorio.</div>
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
        <div class="invalid-feedback">Campo obligatorio.</div>
    </div> 
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-4"> 
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">CONSENTIMIENTO INFORMADO:</h6> 
            SI, ACEPTADO -> <input type="radio" name="consentimiento_informado" value="SI" checked data-checked="true" onclick="if(this.dataset.checked === 'true') { this.checked = false; this.dataset.checked = 'false'; } else { this.dataset.checked = 'true'; this.checked = true; }" style="cursor: pointer;" title="Haga clic nuevamente para quitar el marcado" required>
            <div class="invalid-feedback">Debe aceptar el consentimiento.</div>
        </div> 
        <div class="col-sm-4">
        </div> 
    </div>
<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">MOTIVO DE LA CONSULTA E HISTORIA:</h6>
    </div> 
    <div class="col-sm-6"> 
        
    </div> 

    </div> 
<hr>
    <div class="form-group row"> 
        <div class="col-sm-6">
        <h6 class="text-info">MOTIVO DE LA CONSULTA:</h6>
        <textarea class="form-control" rows="2" name="motivo_teleconsulta" id="tm_motivo" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_motivo')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
        <div class="col-sm-6"> 
            
        </div> 
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">HISTORIA DE LA ENFERMEDAD ACTUAL:</h6>
        <textarea class="form-control" rows="3" name="historia_enfermedad" id="tm_historia" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_historia')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
    </div> 
<hr>
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">EXAMEN FÍSICO - SIGNOS VITALES:</h6>
    </div> 
    </div> 
<hr>  
    <div class="form-group row">  
        <div class="col-sm-3">
        <h6 class="text-info">TALLA </br>[Centímetros]:</h6>
            <input type="number" min="20" max="280" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 280) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 20) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En Centímetros" name="talla" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 20 a 280 cm</div> 
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO </br>[kg]:</h6>
            <input type="number" step="any" min="0.2" max="650" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 650) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0.2) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="En kilogramos" name="peso" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0.2 a 650 kg</div>
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="temperatura" placeholder="En Grados Centígrados" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div>
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Latidos por minuto" name="frec_cardiaca" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div>
        </div>
    </div>

    <?php  if ($edad_ss > '5') {  //******* PARA MAYOR DE 5 ANOS */ ?>
    
        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Ciclos por minuto" name="frec_respiratoria" required>               
                <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div>
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL</br>Sistólica [mmHg]:</h6>
                <input type="number" min="0" max="300" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 300) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="presion_arterial" placeholder="Sistólica" required>              
                <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 300</div>
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica [mmHg]</h6>
                    <input type="number" min="0" max="200" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 200) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="presion_arterial_d" placeholder="Diastólica" required>               
                    <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 200</div>
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>
                <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% de O2" name="saturacion" required>               
                <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0% a 100%</div>
            </div>
        </div>

                <!-- INICIO MODIFICADO: ALERGIAS OBLIGATORIAS Y ASTERISCO DINAMICO -->
                <div class="form-group row">    
                    <div class="col-sm-3">
                    <h6 class="text-info" id="titulo-alergias-telemetria" data-asterisco="true">ALÉRGIAS: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
                    SI <input type="radio" name="alergia" value="SI" class="radio-alergia-telemetria" required> <br>
                    NO <input type="radio" name="alergia" value="NO" class="radio-alergia-telemetria" required>  
                    <div class="invalid-feedback" id="alerta-alergias-telemetria" style="display: none; font-size: 14px; margin-top:5px;">Seleccione SI o NO.</div>
                    </div>
                    <div class="col-sm-6">
                    <h6 class="text-info" id="titulo-desc-alergia-telemetria">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                        <textarea class="form-control" rows="3" name="descripcion_alergia" id="d_alergia_telemetria" placeholder="Escriba detalles si marcó SI" readonly style="background-color: #eaecf4;"></textarea>
                        <div class="invalid-feedback" style="margin-top: 5px;">Debe describir la alergia.</div>
                        <button type="button" class="btn-mic mic-alergia-telemetria" style="display:none;" onclick="iniciarDictado('d_alergia_telemetria')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                    </div>
                    <div class="col-sm-3">             
                    </div>
                </div>
                <!-- FIN MODIFICADO -->

    <?php } else { ?>

        <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">FRECUENCIA RESPIRATORIA </br>[cpm]:</h6> 
                <input type="number" min="0" max="80" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 80) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Ciclos por minuto" name="frec_respiratoria" required>               
                <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 80 cpm</div>
            </div> 
            <div class="col-sm-3">
            <h6 class="text-info">SATURACIÓN</br>[% O2]:</h6>   
                <input type="number" min="0" max="100" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 100) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="% de O2" name="saturacion" required>            
                <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0% a 100%</div>
            </div>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="presion_arterial" placeholder="Sistólica" value="0">               
            </div>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="presion_arterial_d" placeholder="Diastólica" value="0">          
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
            <input type="text" class="form-control buscador-cie-telemetria" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_telemetria_0" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[0]" id="idpatologia_telemetria_0" class="form-control" required style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            }
            ?>
            </select>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar un diagnóstico CIE-10.</div>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 2:</h6>
            <input type="text" class="form-control buscador-cie-telemetria" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_telemetria_1" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[1]" id="idpatologia_telemetria_1" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {}
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 3:</h6>
            <input type="text" class="form-control buscador-cie-telemetria" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_telemetria_2" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[2]" id="idpatologia_telemetria_2" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {}
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 4:</h6>
            <input type="text" class="form-control buscador-cie-telemetria" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_telemetria_3" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 200px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[3]" id="idpatologia_telemetria_3" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            $numero=1;
            $sql1 = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            $numero=$numero+1;
            } while ($row1 = mysqli_fetch_array($result1));
            } else {}
            ?>
            </select>
        </div>  
    </div> 
<hr>

            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">ESTUDIOS COMPLEMENTARIOS Y CONDUCTA:</h6>
                </div> 
                <div class="col-sm-3"> 
                </div> 
                <div class="col-sm-3"> 
                </div> 
            </div>
            <hr>
            <!-- INICIO MODIFICADO: TELEMETRIA MÚLTIPLE OBLIGATORIA -->
            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info" id="titulo-telemetria-check" data-asterisco="true">TELEMETRÍA REALIZADA (SELECCIÓN MÚLTIPLE): <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
                <div class="invalid-feedback" id="alerta-telemetria-check" style="display: none; font-size: 14px; margin-bottom:10px;">Debe marcar al menos un tipo de telemetría realizada.</div>
                </div> 
            </div> 

            <div class="form-group row">                           
                <?php  
                $numero1=0;                  
                $sql1 ="  SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud ='SI' AND idexamen_complementario !='6' ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do { 
                ?>
                    <div class="col-sm-3"> 
                    <h6 class="text-secundary"> 
                    <input type="checkbox" class="chk-telemetria-check" name="idexamen_complementario[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>" data-nombre="<?php echo strtoupper($row1[1]);?>"> <?php echo $row1[1];?>  
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
                <h6 class="text-info" id="titulo-otros-telemetria">SI MARCÓ OTROS MENCIONE CUAL:</h6>
                <input type="text" name="otros_examenes" id="otros_examenes_telemetria" class="form-control" placeholder="Escriba aquí solo si marcó 'OTROS DISPOSITIVOS'..." readonly style="background-color: #eaecf4;">
                <div class="invalid-feedback" style="margin-top: 5px;">Debe especificar cuál dispositivo.</div>
                </div> 
            </div> 
            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">EXÁMENES COMPLEMENTARIOS O DE GABINETE:</h6>
                <textarea class="form-control" rows="3" name="examen_complementario" id="exam_complementario" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('exam_complementario')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
                <div class="col-sm-6">
                <h6 class="text-info">COMENTARIOS:</h6>
                <textarea class="form-control" rows="3" name="tratamiento_teleconsulta" id="tratamiento" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('tratamiento')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#examplemodaltelemetria">
                    GUARDAR CONSULTA
                    </button>  
                </div> 
            </div>

            <div class="modal fade" id="examplemodaltelemetria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel0">ATENCIÓN POR CONSULTA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCIÓN POR CONSULTA?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="button" id="btn-confirmar-telemetria" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form> 
        
        <!-- INICIO MEGA-SCRIPT EXCLUSIVO PARA TELEMETRÍA (VERSIÓN FINAL UX) -->
        <script>
            (function() {
                setTimeout(function() {
                    var formTelemetria = document.getElementById('form-telemetria');
                    if(!formTelemetria) return;

                    // 1. DIBUJO AUTOMÁTICO DE ASTERISCOS
                    var camposOb = formTelemetria.querySelectorAll('input[required], select[required], textarea[required]');
                    camposOb.forEach(function(campo) {
                        var titulo = null;
                        var contenedor = campo.closest('[class*="col-sm-"]');
                        if (contenedor) titulo = contenedor.querySelector('h6');
                        if (titulo && !titulo.hasAttribute('data-asterisco')) {
                            titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                            titulo.setAttribute('data-asterisco', 'true');
                        }
                    });

                    // 2. LÓGICA DE ALERGIAS (Asterisco Dinámico y Color)
                    var radiosAlergia = formTelemetria.querySelectorAll('.radio-alergia-telemetria');
                    var txtAlergia = formTelemetria.querySelector('#d_alergia_telemetria');
                    var micAlergia = formTelemetria.querySelector('.mic-alergia-telemetria');
                    var tituloAlergias = document.getElementById('titulo-alergias-telemetria');
                    var alertaAlergias = document.getElementById('alerta-alergias-telemetria');
                    var tituloDescAlergia = document.getElementById('titulo-desc-alergia-telemetria'); 
                    
                    if(radiosAlergia.length > 0 && txtAlergia) {
                        radiosAlergia.forEach(function(radio) {
                            radio.addEventListener('change', function() {
                                // Quitar error visual general al seleccionar
                                if (Array.from(radiosAlergia).some(r => r.checked)) {
                                    if(alertaAlergias) alertaAlergias.style.setProperty('display', 'none', 'important');
                                    if(tituloAlergias) tituloAlergias.style.color = '';
                                }

                                if(this.value === 'SI' && this.checked) {
                                    txtAlergia.readOnly = false;
                                    txtAlergia.style.backgroundColor = '#fff';
                                    txtAlergia.setAttribute('required', 'required'); 
                                    txtAlergia.placeholder = "Escriba o utilice el botón de dictado por voz";
                                    if(micAlergia) micAlergia.style.display = 'inline-block';
                                    
                                    if(tituloDescAlergia && !tituloDescAlergia.hasAttribute('data-asterisco')) {
                                        tituloDescAlergia.innerHTML += ' <span class="asterisco-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                                        tituloDescAlergia.setAttribute('data-asterisco', 'true');
                                    }

                                } else if(this.value === 'NO' && this.checked) {
                                    txtAlergia.readOnly = true;
                                    txtAlergia.style.backgroundColor = '#eaecf4';
                                    txtAlergia.removeAttribute('required'); 
                                    txtAlergia.value = '';
                                    txtAlergia.classList.remove('is-invalid');
                                    txtAlergia.placeholder = "Escriba detalles si marcó SI";
                                    if(micAlergia) micAlergia.style.display = 'none';
                                    
                                    if(tituloDescAlergia && tituloDescAlergia.hasAttribute('data-asterisco')) {
                                        var ast = tituloDescAlergia.querySelector('.asterisco-dinamico');
                                        if(ast) ast.remove();
                                        tituloDescAlergia.removeAttribute('data-asterisco');
                                    }
                                }
                            });
                        });
                    }

                    // 3. CANDADO CIE-10 INTELIGENTE
                    var buscadores = formTelemetria.querySelectorAll('.buscador-cie-telemetria');
                    buscadores.forEach(function(input) {
                        var targetId = input.getAttribute('data-target');
                        var selectOriginal = document.getElementById(targetId);
                        var listaFlotante = input.nextElementSibling; 
                        if(!selectOriginal) return;
                        
                        var opciones = Array.from(selectOriginal.options).filter(opt => opt.value !== "");
                        
                        input.addEventListener('input', function() {
                            if (this.readOnly) return; 
                            this.classList.remove('is-invalid');
                            this.style.border = '';
                            var fb = selectOriginal.parentNode.querySelector('.invalid-feedback');
                            if (fb) fb.style.display = '';

                            var term = this.value.toLowerCase().trim();
                            listaFlotante.innerHTML = ''; 
                            if (term === '') {
                                listaFlotante.style.display = 'none';
                                selectOriginal.value = ''; 
                                return;
                            }
                            
                            var coincidencias = opciones.filter(opt => opt.text.toLowerCase().includes(term));
                            if (coincidencias.length > 0) {
                                listaFlotante.style.display = 'block'; 
                                coincidencias.slice(0, 100).forEach(function(opt) { 
                                    var item = document.createElement('div');
                                    item.textContent = opt.text;
                                    item.style.padding = '8px 12px';
                                    item.style.cursor = 'pointer';
                                    item.style.borderBottom = '1px solid #eaecf4';
                                    item.style.fontSize = '0.9rem';
                                    item.style.color = '#5a5c69';
                                    item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                                    item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                                    item.addEventListener('mousedown', function(e) {
                                        e.preventDefault(); 
                                        input.value = opt.text; 
                                        selectOriginal.value = opt.value; 
                                        listaFlotante.style.display = 'none'; 
                                        input.readOnly = true;
                                        input.style.backgroundColor = '#eaecf4';
                                        input.style.color = '#2e59d9';
                                        input.style.cursor = 'not-allowed';
                                        input.title = "Doble clic o presione Borrar para cambiar";
                                    });
                                    listaFlotante.appendChild(item);
                                });
                            } else {
                                listaFlotante.style.display = 'none';
                            }
                        });

                        function desbloquearCIE() {
                            if (input.readOnly) {
                                input.readOnly = false;
                                input.value = '';
                                selectOriginal.value = '';
                                input.style.backgroundColor = '';
                                input.style.color = '';
                                input.style.cursor = 'text';
                                input.removeAttribute('title');
                                input.focus();
                            }
                        }

                        input.addEventListener('keydown', function(e) {
                            if (input.readOnly) {
                                if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); desbloquearCIE(); } 
                                else if (e.key !== 'Tab') { e.preventDefault(); }
                            }
                        });
                        input.addEventListener('dblclick', desbloquearCIE);
                        input.addEventListener('blur', function() {
                            setTimeout(function() {
                                listaFlotante.style.display = 'none';
                                if (!input.readOnly) { input.value = ''; selectOriginal.value = ''; }
                            }, 200);
                        });
                    });

                    // 4. EFECTO MAGIA PARA CHECKBOXES VULNERABLES Y TELEMETRIA
                    var chksVul = formTelemetria.querySelectorAll('.chk-vulnerable-telemetria');
                    var alertaVul = document.getElementById('alerta-vulnerable-telemetria');
                    var tituloVul = document.getElementById('titulo-vulnerable-telemetria');
                    
                    chksVul.forEach(function(chk) {
                        chk.addEventListener('change', function() {
                            if (Array.from(chksVul).some(c => c.checked)) {
                                if(alertaVul) alertaVul.style.setProperty('display', 'none', 'important');
                                if(tituloVul) tituloVul.style.color = '';
                            }
                        });
                    });

                    // >>> LÓGICA DE CONDICIONALIDAD PARA "OTROS DISPOSITIVOS" <<<
                    var chksTele = formTelemetria.querySelectorAll('.chk-telemetria-check');
                    var alertaTele = document.getElementById('alerta-telemetria-check');
                    var tituloTele = document.getElementById('titulo-telemetria-check');
                    
                    var txtOtrosTele = document.getElementById('otros_examenes_telemetria');
                    var tituloOtrosTele = document.getElementById('titulo-otros-telemetria');

                    chksTele.forEach(function(chk) {
                        chk.addEventListener('change', function() {
                            // Limpieza del error general de "Telemetría Múltiple"
                            if (Array.from(chksTele).some(c => c.checked)) {
                                if(alertaTele) alertaTele.style.setProperty('display', 'none', 'important');
                                if(tituloTele) tituloTele.style.color = '';
                            }
                            
                            // Evaluación en tiempo real para la casilla de "OTROS"
                            if(txtOtrosTele) {
                                // Escanea si el médico chequeó específicamente alguna opción que contenga la palabra "OTROS"
                                var otrosMarcado = Array.from(chksTele).some(c => c.checked && c.getAttribute('data-nombre') && c.getAttribute('data-nombre').includes('OTROS'));
                                
                                if (otrosMarcado) {
                                    // Desbloquear casilla
                                    txtOtrosTele.readOnly = false;
                                    txtOtrosTele.style.backgroundColor = '#fff';
                                    txtOtrosTele.setAttribute('required', 'required'); // Hacer obligatorio
                                    txtOtrosTele.placeholder = "Especifique el dispositivo...";
                                    
                                    // Poner Asterisco
                                    if(tituloOtrosTele && !tituloOtrosTele.hasAttribute('data-asterisco')) {
                                        tituloOtrosTele.innerHTML += ' <span class="asterisco-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                                        tituloOtrosTele.setAttribute('data-asterisco', 'true');
                                    }
                                } else {
                                    // Volver a bloquear casilla en gris
                                    txtOtrosTele.readOnly = true;
                                    txtOtrosTele.style.backgroundColor = '#eaecf4';
                                    txtOtrosTele.removeAttribute('required'); // Quitar obligatoriedad
                                    txtOtrosTele.value = '';
                                    
                                    // INICIO DE LA CORRECCIÓN VISUAL (Fantasma eliminado)
                                    txtOtrosTele.classList.remove('is-invalid');
                                    txtOtrosTele.style.border = ''; 
                                    var feedbackOtros = txtOtrosTele.parentNode ? txtOtrosTele.parentNode.querySelector('.invalid-feedback') : null;
                                    if (feedbackOtros) feedbackOtros.style.display = '';
                                    // FIN DE LA CORRECCIÓN
                                    
                                    txtOtrosTele.placeholder = "Escriba aquí solo si marcó 'OTROS DISPOSITIVOS'...";
                                    
                                    // Quitar Asterisco
                                    if(tituloOtrosTele && tituloOtrosTele.hasAttribute('data-asterisco')) {
                                        var ast = tituloOtrosTele.querySelector('.asterisco-dinamico');
                                        if(ast) ast.remove();
                                        tituloOtrosTele.removeAttribute('data-asterisco');
                                    }
                                }
                            }
                        });
                    });

                    // 5. VALIDADOR DE FUERZA BRUTA
                    var btnConfirmar = document.getElementById('btn-confirmar-telemetria');
                    if (btnConfirmar) {
                        var nuevoBtn = btnConfirmar.cloneNode(true);
                        btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                        
                        nuevoBtn.addEventListener('click', function(e) {
                            e.preventDefault(); 
                            var hayErrores = false;
                            var primerInvalido = null;
                            
                            formTelemetria.querySelectorAll('.is-invalid').forEach(function(el) {
                                el.classList.remove('is-invalid');
                                el.style.border = ''; 
                            });
                            formTelemetria.querySelectorAll('.invalid-feedback').forEach(function(el) {
                                el.style.display = ''; 
                            });
                            
                            // A. Validar Grupos Vulnerables
                            if(chksVul.length > 0) {
                                var alMenosUnoVul = Array.from(chksVul).some(c => c.checked);
                                if(!alMenosUnoVul) {
                                    hayErrores = true;
                                    if(alertaVul) alertaVul.style.setProperty('display', 'block', 'important');
                                    if(tituloVul) {
                                        tituloVul.style.color = '#dc3545';
                                        if(!primerInvalido) primerInvalido = tituloVul;
                                    }
                                }
                            }

                            // B. Validar Telemetría Múltiple
                            if(chksTele.length > 0) {
                                var alMenosUnoTele = Array.from(chksTele).some(c => c.checked);
                                if(!alMenosUnoTele) {
                                    hayErrores = true;
                                    if(alertaTele) alertaTele.style.setProperty('display', 'block', 'important');
                                    if(tituloTele) {
                                        tituloTele.style.color = '#dc3545';
                                        if(!primerInvalido) primerInvalido = tituloTele;
                                    }
                                }
                            }

                            // C. Validar Radio Buttons de Alergia Manualmente
                            if(radiosAlergia.length > 0) {
                                var alergiaMarcada = Array.from(radiosAlergia).some(r => r.checked);
                                if(!alergiaMarcada) {
                                    hayErrores = true;
                                    if(alertaAlergias) alertaAlergias.style.setProperty('display', 'block', 'important');
                                    if(tituloAlergias) {
                                        tituloAlergias.style.color = '#dc3545';
                                        if(!primerInvalido) primerInvalido = tituloAlergias;
                                    }
                                }
                            }

                            // D. Validar Elementos Regulares
                            var obligatorios = formTelemetria.querySelectorAll('input[required], select[required], textarea[required]');
                            obligatorios.forEach(function(el) {
                                var valor = el.value ? el.value.trim() : '';
                                if (valor === '' || !el.checkValidity()) {
                                    if(el.name === 'alergia') return; 

                                    hayErrores = true;
                                    
                                    if (el.style.display === 'none' && el.id && el.id.includes('idpatologia_telemetria')) {
                                        var inputVisual = formTelemetria.querySelector('input[data-target="' + el.id + '"]');
                                        if (inputVisual) {
                                            inputVisual.classList.add('is-invalid');
                                            inputVisual.style.setProperty('border', '2px solid #dc3545', 'important');
                                            var fback = el.parentNode.querySelector('.invalid-feedback');
                                            if (fback) fback.style.setProperty('display', 'block', 'important');
                                            if (!primerInvalido) primerInvalido = inputVisual;
                                        }
                                    } else if (el.type !== 'hidden' && el.style.display !== 'none') {
                                        el.classList.add('is-invalid');
                                        el.style.setProperty('border', '2px solid #dc3545', 'important');
                                        var fback2 = el.parentNode ? el.parentNode.querySelector('.invalid-feedback') : null;
                                        if (fback2) fback2.style.setProperty('display', 'block', 'important');
                                        if (!primerInvalido) primerInvalido = el;
                                    }
                                }
                            });
                            
                            if (hayErrores) {
                                try {
                                    var btnCancelar = formTelemetria.querySelector('#examplemodaltelemetria [data-dismiss="modal"]');
                                    if (btnCancelar) btnCancelar.click();
                                    $('#examplemodaltelemetria').modal('hide'); 
                                } catch(err) {}
                                
                                setTimeout(function() {
                                    document.body.classList.remove('modal-open');
                                    var backdrops = document.querySelectorAll('.modal-backdrop');
                                    backdrops.forEach(b => b.remove());
                                    
                                    if (primerInvalido) {
                                        primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        setTimeout(() => {
                                            try { primerInvalido.focus({ preventScroll: true }); } catch(err) { primerInvalido.focus(); }
                                        }, 100);
                                    }
                                }, 400);
                            } else {
                                nuevoBtn.innerHTML = "GUARDANDO...";
                                nuevoBtn.disabled = true;
                                formTelemetria.submit(); 
                            }
                        });
                        
                        ['input', 'change'].forEach(function(evt) {
                            formTelemetria.addEventListener(evt, function(e) {
                                if (e.target.hasAttribute('required') && e.target.value.trim() !== '') {
                                    e.target.classList.remove('is-invalid');
                                    e.target.style.border = '';
                                    var fb = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                    if (fb) fb.style.display = '';
                                }
                            });
                        });
                    }
                }, 200); 
            })();
        </script>
        <!-- FIN MEGA-SCRIPT --> 


    <!-------- TELEMETRIA - END --------->  

    <!-------- EVALUACIÓN CLINICA PREVENTIVA - BEGIN ---------> 
    <?php       
        break;
    case 5: ?>

<form name="TELEMETRIA" action="guarda_evaluacion_preventiva.php" method="post">  

<input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-2"></div> 
    <div class="col-sm-8">
    <h4 class="text-info">EVALUACIÓN CLÍNICA PREVENTIVA:</h4>
    </div> 
    <div class="col-sm-2"></div> 
    </div> 
        <hr>
    <div class="form-group row">  
        <div class="col-sm-4">
        <h6 class="text-info">TIPO DE ATENCIÓN:</h6>
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
        <h6 class="text-info">TALLA</br>[Centímetros]:</h6>
            <input type="text" class="form-control" placeholder="En Centímetros"
                name="talla" required>                
        </div>                             
        <div class="col-sm-3">
        <h6 class="text-info">PESO</br>[kg]:</h6>
            <input type="text" class="form-control" placeholder="En Kilogramos"            
                name="peso"  required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">PERIMETRO ABDOMINAL</br>[Centímetros]:</h6>
            <input type="text" class="form-control" 
                name="perimetro_abdominal" placeholder="En Centímetros" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">CIRCUNFERENCIA DE CADERA </br>[Centímetros]:</h6>
            <input type="text" class="form-control" placeholder="En Centímetros"
                name="circunferencia_cadera" required>                
        </div>
    </div>

    <div class="form-group row">
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL (Brazo)</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial"  placeholder="Sistólica Brazo" required>               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"></br>diastólica (Brazo) [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_d" placeholder="Diastólica Brazo" required>                
            </div>
            <div class="col-sm-3">
            <h6 class="text-info">PRESIÓN ARTERIAL (Tobillo)</br>Sistólica [mmHg]:</h6>
                <input type="number" class="form-control"              
                    name="presion_arterial_tobillo"  placeholder="Sistólica Tobillo" required>               
            </div>
            <div class="col-sm-3">
            <h6 class="text-info"> </br>diastólica (Tobillo) [mmHg]</h6>
                    <input type="number" class="form-control"              
                    name="presion_arterial_tobillo_d" placeholder="Diastólica Tobillo" required>                
            </div>

        </div>
        <hr>
            <div class="form-group row">
                <div class="col-sm-6">
                <h4 class="text-info"></h4>  
                </div> 
                <div class="col-sm-6">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#examplemodaltele">
                    GUARDAR EVALUACIÓN PREVENTIVA
                    </button>  
                </div> 
            </div>

    <!-- modal de confirmacion de envio de datos-->
            <div class="modal fade" id="examplemodaltele" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel0">ATENCION POR EVALUACIÓN CLÍNICA PREVENTIVA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCION POR EVALUACIÓN CLÍNICA PREVENTIVA?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form> 


    <!-------- EVALUACIÓN CLINICA PREVENTIVA - END ---------> 
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

   