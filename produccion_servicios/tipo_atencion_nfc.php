<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
$fecha 		= date("Y-m-d");
$idtipo_atencion = $_POST['tipo_atencion'];

  
    switch ($idtipo_atencion) {
    case 1: ?>
<!--------------------------------------------->    
<!--------  ATENCION POR MORBILIDAD BEGIN ----------->
<!---------------------------------------------> 

   <form name="ATENCIONMORB" id="form-morbilidad-ncf" action="guarda_atencion_pmorbilidad_ncf.php" method="post" class="needs-validation" novalidate>
    
   <style>
    .tooltip {
        position: relative;
        display: inline-block;
        cursor: help;
    }
    .tooltip .tooltip-box {
        visibility: hidden;
        width: 250px;
        background-color: #2a3b4c; /* Gris oscuro elegante */
        color: #ffffff;
        text-align: center;
        border-radius: 6px;
        padding: 10px 12px;
        position: absolute;
        z-index: 9999;
        bottom: 130%; 
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        font-size: 0.85rem;
        font-weight: 500;
        font-family: inherit;
        box-shadow: 0px 5px 15px rgba(0,0,0,0.3);
        line-height: 1.4;
        letter-spacing: 0.3px;
    }
    /* El pequeño triangulito que apunta hacia abajo */
    .tooltip .tooltip-box::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -6px;
        border-width: 6px;
        border-style: solid;
        border-color: #2a3b4c transparent transparent transparent;
    }
    /* Mostrar al pasar el mouse */
    .tooltip:hover .tooltip-box {
        visibility: visible;
        opacity: 1;
    }
</style>

    <input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

        <div class="form-group row"> 
        <div class="col-sm-3">
        </div> 
        <div class="col-sm-6 text-center">
        <h4 class="text-info">ATENCIÓN POR MORBILIDAD</h4>
        </div> 
        <div class="col-sm-3"> 
        </div> 
        </div> 
        <hr>
        <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
                </div>
                <div class="card-body">

                <div class="form-group row">    
                <div class="col-sm-4">
                <h6 class="text-info">NOMBRES:</h6>
                    <input type="text" class="form-control" name="nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required >                
                    <div class="invalid-feedback">Requerido.</div>
                </div>                           
                <div class="col-sm-4">
                <h6 class="text-info">PRIMER APELLIDO:</h6>
                    <input type="text" class="form-control" name="paterno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" autofocus required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                    <input type="text" class="form-control" name="materno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
            </div>

        <div class="form-group row">  
            <div class="col-sm-4">
            <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning" style="font-size:0.85rem; margin-top:-5px;"> SI NO CUENTA ASIGNAR=0</h6>
                <input type="number" class="form-control" name="ci" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required >
                <div class="invalid-feedback">Requerido.</div>
            </div>
            <div class="col-sm-4"><br>
            <h6 class="text-info">COMPLEMENTO:</h6>
                <input type="text" class="form-control" name="complemento" >                
            </div>
            <div class="col-sm-4"><br>
            <h6 class="text-info">GÉNERO:</h6>
                <select name="idgenero" id="idgenero" class="form-control" required>
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
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>      
        </div>   

        <div class="form-group row">  
            <div class="col-sm-4">
                <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                    <input type="date"  class="form-control" name="fecha_nac" required>
                    <div class="invalid-feedback">Requerido.</div>
            </div> 
            <div class="col-sm-4">
            <h6 class="text-info">NACIONALIDAD:</h6>
                <select name="idnacionalidad" id="idnacionalidad" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql1 = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                } while ($row1 = mysqli_fetch_array($result1));
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>  
            <div class="col-sm-4">
            <h6 class="text-info">AUTO PERTENENCIA CULTURAL:</h6>
                <select name="idnacion" id="idnacion" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql1 = "SELECT idnacion, nacion FROM nacion ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                } while ($row1 = mysqli_fetch_array($result1));
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>        
        </div>  
        <hr>
            
                </div>
            </div>

    <div class="card shadow mb-4">
        <div class="card-header py-2">
            <h6 class="m-0 font-weight-bold text-info">2.- INFORMACIÓN DE LA ATENCIÓN</h6>
        </div>
        <div class="card-body">

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
        <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > <br>
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
        <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > <br>
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
            <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="temperatura" placeholder="En grados centígrados" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div>
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Latidos por minuto" name="frec_cardiaca" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div>
        </div>
    </div>
    
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

    <div class="form-group row">    
        <div class="col-sm-3">
        <h6 class="text-info" id="titulo-alergias-morb-ncf" data-asterisco="true">ALÉRGIAS: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        SI <input type="radio" name="alergia" value="SI" class="radio-alergia-morb-ncf" required> <br>
        NO <input type="radio" name="alergia" value="NO" class="radio-alergia-morb-ncf" required>  
        <div class="invalid-feedback" id="alerta-alergias-morb-ncf" style="display: none; font-size: 14px; margin-top:5px;">Seleccione SI o NO.</div>
        </div>
        <div class="col-sm-6">
        <h6 class="text-info" id="titulo-desc-alergia-morb-ncf">DESCRIPCIÓN DE LA ALÉRGIA</h6>
            <textarea class="form-control" rows="3" name="descripcion_alergia" id="d_alergia_morb_ncf" placeholder="Escriba detalles si marcó SI" readonly style="background-color: #eaecf4;"></textarea>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe describir la alergia.</div>
            <button type="button" class="btn-mic mic-alergia-morb-ncf" style="display:none;" onclick="iniciarDictado('d_alergia_morb_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div>
        <div class="col-sm-3">             
        </div>
    </div>
<hr>
            <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">EVOLUCIÓN CLÍNICA (S.O.A.P.):</h6>
        </div> 
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-6">
        <h6 class="text-info">SUBJETIVO: 
            <span class="tooltip">
                <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                <span class="tooltip-box">Lo que el paciente expresa, siente o refiere (Síntomas y motivo de consulta).</span>
            </span>
        </h6>
        <textarea class="form-control" rows="3" name="subjetivo" id="soap_subjetivo" placeholder="Ej. Paciente refiere dolor de cabeza..." required></textarea>
        <div class="invalid-feedback">Debe llenar la información Subjetiva.</div>
        <button type="button" class="btn-mic" onclick="iniciarDictado('soap_subjetivo')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 

        <div class="col-sm-6">
        <h6 class="text-info">OBJETIVO:
            <span class="tooltip">
                <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                <span class="tooltip-box">Lo que el médico encuentra en el examen físico o signos vitales (Signos).</span>
            </span>
        </h6>
        <textarea class="form-control" rows="3" name="objetivo" id="soap_objetivo" placeholder="Ej. Al examen físico se evidencia..." required></textarea>
        <div class="invalid-feedback">Debe llenar la información Objetiva.</div>
        <button type="button" class="btn-mic" onclick="iniciarDictado('soap_objetivo')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-6">
        <h6 class="text-info">ANÁLISIS:
            <span class="tooltip">
                <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                <span class="tooltip-box">Razonamiento médico, análisis de resultados y justificación clínica.</span>
            </span>
        </h6>
        <textarea class="form-control" rows="3" name="analisis" id="soap_analisis" placeholder="Ej. Cuadro clínico compatible con..." required></textarea>
        <div class="invalid-feedback">Debe llenar el Análisis.</div>
        <button type="button" class="btn-mic" onclick="iniciarDictado('soap_analisis')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 

        <div class="col-sm-6">
        <h6 class="text-info">PLAN:
            <span class="tooltip">
                <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                <span class="tooltip-box">Conducta a seguir, exámenes solicitados, derivación o recomendaciones.</span>
            </span>
        </h6>
        <textarea class="form-control" rows="3" name="plan" id="soap_plan" placeholder="Ej. Se solicitan laboratorios y se receta..." required></textarea>
        <div class="invalid-feedback">Debe llenar el Plan clínico.</div>
        <button type="button" class="btn-mic" onclick="iniciarDictado('soap_plan')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
    </div> 
    <hr>

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">IMPRESIÓN DIAGNÓSTICA (CIE-10):</h6>
        </div> 
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 1:</h6>
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_0" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[0]" id="idpatologia_ncf_0" class="form-control" required style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            $sql_p = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie NOT LIKE '%Z%' ORDER BY patologia";
            $res_p = mysqli_query($link,$sql_p);
            while ($r_p = mysqli_fetch_array($res_p)){
                echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>";
            }
            ?>
            </select>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar un diagnóstico principal.</div>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 2:</h6>
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_1" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[1]" id="idpatologia_ncf_1" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_p, 0);
            while ($r_p = mysqli_fetch_array($res_p)){ echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>"; }
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 3:</h6>
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_2" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[2]" id="idpatologia_ncf_2" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_p, 0);
            while ($r_p = mysqli_fetch_array($res_p)){ echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>"; }
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 4:</h6>
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_3" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[3]" id="idpatologia_ncf_3" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_p, 0);
            while ($r_p = mysqli_fetch_array($res_p)){ echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>"; }
            ?>
            </select>
        </div>  
    </div> 
<hr>
            <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">TRATAMIENTO:</h6>
        </div> 
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">TRATAMIENTO 1:</h6>
            <input type="text" class="form-control buscador-tratamiento-ncf" placeholder="Buscar Medicamento (Ej. AZITROMICINA)..." data-target="idmedicamento_ncf_0" autocomplete="off"> 
            <div class="lista-flotante-tratamiento" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idmedicamento[0]" id="idmedicamento_ncf_0" class="form-control" required style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            // CONSULTA: Unimos la tabla medicamento con tipo_medicamento usando su ID compartido
            $sql_m = "SELECT m.idmedicamento, m.medicamento, t.tipo_medicamento 
                      FROM medicamento m 
                      INNER JOIN tipo_medicamento t ON m.idtipo_medicamento = t.idtipo_medicamento 
                      ORDER BY m.medicamento";
            $res_m = mysqli_query($link, $sql_m);
            while ($r_m = mysqli_fetch_array($res_m)){
                // $r_m[0] = idmedicamento (Se va al backend)
                // $r_m[1] = nombre del medicamento (Lo ve el médico)
                // $r_m[2] = tipo de medicamento (Lo ve el médico)
                echo "<option value=".$r_m[0].">".$r_m[1]." - ".$r_m[2]."</option>";
            }
            ?>
            </select>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe recetar al menos un tratamiento principal.</div>
        </div>  
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">TRATAMIENTO 2:</h6>
            <input type="text" class="form-control buscador-tratamiento-ncf" placeholder="Buscar Medicamento (Ej. PARACETAMOL)..." data-target="idmedicamento_ncf_1" autocomplete="off"> 
            <div class="lista-flotante-tratamiento" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idmedicamento[1]" id="idmedicamento_ncf_1" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_m, 0);
            while ($r_m = mysqli_fetch_array($res_m)){ echo "<option value=".$r_m[0].">".$r_m[1]." - ".$r_m[2]."</option>"; }
            ?>
            </select>
        </div>  
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">TRATAMIENTO 3:</h6>
            <input type="text" class="form-control buscador-tratamiento-ncf" placeholder="Buscar Medicamento..." data-target="idmedicamento_ncf_2" autocomplete="off"> 
            <div class="lista-flotante-tratamiento" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idmedicamento[2]" id="idmedicamento_ncf_2" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_m, 0);
            while ($r_m = mysqli_fetch_array($res_m)){ echo "<option value=".$r_m[0].">".$r_m[1]." - ".$r_m[2]."</option>"; }
            ?>
            </select>
        </div>  
    </div> 

    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">TRATAMIENTO 4:</h6>
            <input type="text" class="form-control buscador-tratamiento-ncf" placeholder="Buscar Medicamento..." data-target="idmedicamento_ncf_3" autocomplete="off"> 
            <div class="lista-flotante-tratamiento" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idmedicamento[3]" id="idmedicamento_ncf_3" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_m, 0);
            while ($r_m = mysqli_fetch_array($res_m)){ echo "<option value=".$r_m[0].">".$r_m[1]." - ".$r_m[2]."</option>"; }
            ?>
            </select>
        </div>  
    </div> 
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
            </div>

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
                            Esta seguro de GUARDAR ESTA ATENCIÓN SAFCI POR MORBILIDAD?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="button" id="btn-confirmar-morbilidad-ncf" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>    
            </div>
        </div>

<script>
    // 1. DESPERTAR LOS GLOBOS FLOTANTES DE AYUDA (TOOLTIPS) DE BOOTSTRAP
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof $ !== 'undefined' && $.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip({
                boundary: 'window',
                trigger: 'hover'
            });
        }
    });

    (function() {
        setTimeout(function() {
            var formMorbNcf = document.getElementById('form-morbilidad-ncf') || document.querySelector('form[action*="guarda_atencion_pmorbilidad_ncf.php"]');
            if(!formMorbNcf) return;

            // 2. DIBUJO AUTOMÁTICO DE ASTERISCOS
            var camposOb = formMorbNcf.querySelectorAll('input[required], select[required], textarea[required]');
            camposOb.forEach(function(campo) {
                var titulo = null;
                var contenedor = campo.closest('[class*="col-sm-"]');
                if (contenedor) titulo = contenedor.querySelector('h6');
                if (titulo && !titulo.hasAttribute('data-asterisco')) {
                    titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                    titulo.setAttribute('data-asterisco', 'true');
                }
            });

            // 3. LÓGICA DE ALERGIAS
            var radiosAlergia = formMorbNcf.querySelectorAll('.radio-alergia-morb-ncf');
            var txtAlergia = formMorbNcf.querySelector('#d_alergia_morb_ncf');
            var micAlergia = formMorbNcf.querySelector('.mic-alergia-morb-ncf');
            var tituloAlergias = document.getElementById('titulo-alergias-morb-ncf');
            var alertaAlergias = document.getElementById('alerta-alergias-morb-ncf');
            var tituloDescAlergia = document.getElementById('titulo-desc-alergia-morb-ncf'); 
            
            if(radiosAlergia.length > 0 && txtAlergia) {
                radiosAlergia.forEach(function(radio) {
                    radio.addEventListener('change', function() {
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
                            txtAlergia.style.border = ''; 
                            var fbAlergia = txtAlergia.parentNode ? txtAlergia.parentNode.querySelector('.invalid-feedback') : null;
                            if (fbAlergia) fbAlergia.style.display = '';
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

            // 4. BUSCADORES INTELIGENTES (CON IGNORANCIA DE ACENTOS Y FORZADO DE MAYÚSCULAS)
            var buscadores = formMorbNcf.querySelectorAll('.buscador-cie-ncf, .buscador-tratamiento-ncf');
            
            // Función: Quitar acentos para comparar limpiamente
            function quitarAcentos(cadena) {
                return cadena.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            }

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

                    // Convertimos lo que escribe el médico a minúsculas y le quitamos los acentos
                    var term = quitarAcentos(this.value.toLowerCase().trim());
                    listaFlotante.innerHTML = ''; 
                    if (term === '') {
                        listaFlotante.style.display = 'none';
                        selectOriginal.value = ''; 
                        return;
                    }
                    
                    // Filtramos ignorando también los acentos y mayúsculas de la base de datos
                    var coincidencias = opciones.filter(opt => quitarAcentos(opt.text.toLowerCase()).includes(term));
                    if (coincidencias.length > 0) {
                        listaFlotante.style.display = 'block'; 
                        coincidencias.slice(0, 100).forEach(function(opt) { 
                            var item = document.createElement('div');
                            
                            // MAGIA VISUAL: Forzamos a que se dibuje en MAYÚSCULAS absolutas
                            item.textContent = opt.text.toUpperCase();
                            
                            item.style.padding = '8px 12px';
                            item.style.cursor = 'pointer';
                            item.style.borderBottom = '1px solid #eaecf4';
                            item.style.fontSize = '0.9rem';
                            item.style.color = '#5a5c69';
                            item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                            item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                            item.addEventListener('mousedown', function(e) {
                                e.preventDefault(); 
                                // Plasmamos en la cajita el texto también en MAYÚSCULAS absolutas
                                input.value = opt.text.toUpperCase(); 
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

                function desbloquear() {
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
                        if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); desbloquear(); } 
                        else if (e.key !== 'Tab') { e.preventDefault(); }
                    }
                });
                input.addEventListener('dblclick', desbloquear);
                input.addEventListener('blur', function() {
                    setTimeout(function() { listaFlotante.style.display = 'none'; if (!input.readOnly) { input.value = ''; selectOriginal.value = ''; } }, 200);
                });
            });

            // 5. VALIDADOR DE FUERZA BRUTA (INMUNE Y LIMPIADOR EN TIEMPO REAL)
            var btnConfirmar = formMorbNcf.querySelector('#btn-confirmar-morbilidad-ncf') || formMorbNcf.querySelector('.modal-footer .btn-info');
            if (btnConfirmar) {
                var nuevoBtn = btnConfirmar.cloneNode(true);
                btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                
                nuevoBtn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    var hayErrores = false;
                    var primerInvalido = null;
                    
                    formMorbNcf.querySelectorAll('.is-invalid').forEach(function(el) {
                        el.classList.remove('is-invalid');
                        el.style.border = ''; 
                    });
                    formMorbNcf.querySelectorAll('.invalid-feedback').forEach(function(el) {
                        el.style.display = ''; 
                    });
                    
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

                    var obligatorios = formMorbNcf.querySelectorAll('input[required], select[required], textarea[required]');
                    obligatorios.forEach(function(el) {
                        var valor = el.value ? el.value.trim() : '';
                        if (valor === '' || !el.checkValidity()) {
                            if(el.name === 'alergia') return; 

                            hayErrores = true;
                            
                            if (el.style.display === 'none' && el.id && (el.id.includes('idpatologia_ncf') || el.id.includes('idmedicamento_ncf'))) {
                                var inputVisual = formMorbNcf.querySelector('input[data-target="' + el.id + '"]');
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
                            var modalActivo = formMorbNcf.querySelector('.modal');
                            var btnCancelar = modalActivo ? modalActivo.querySelector('[data-dismiss="modal"]') : null;
                            if (btnCancelar) btnCancelar.click();
                            if (modalActivo) $(modalActivo).modal('hide'); 
                        } catch(err) {}
                        
                        setTimeout(function() {
                            document.body.classList.remove('modal-open');
                            var backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(b => b.remove());
                            
                            if (primerInvalido) {
                                primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                setTimeout(() => { try { primerInvalido.focus({ preventScroll: true }); } catch(err) { primerInvalido.focus(); } }, 100);
                            }
                        }, 400);
                    } else {
                        nuevoBtn.innerHTML = "GUARDANDO...";
                        nuevoBtn.disabled = true;
                        formMorbNcf.submit(); 
                    }
                });
                
                ['input', 'change'].forEach(function(evt) {
                    formMorbNcf.addEventListener(evt, function(e) {
                        if (e.target && e.target.hasAttribute && e.target.hasAttribute('required')) {
                            var val = e.target.value || '';
                            if (val.trim() !== '') {
                                e.target.classList.remove('is-invalid');
                                e.target.style.border = '';
                                var fb = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                if (fb) fb.style.display = '';
                            }
                        }
                    });
                });
            }
        }, 200); 
    })();
</script>

<!--------------------------------------------->    
<!--------  ATENCION POR MORBILIDAD END ----------->
<!---------------------------------------------> 
    
   <?php 
    break;
    case 2: ?>
<!--------------------------------------------->    
<!--------  ATENCION PREVENTIVA BEGIN ----------->
<!---------------------------------------------> 

<style>
    .tooltip-senior { position: relative; display: inline-block; cursor: help; }
    .tooltip-senior .tooltip-box {
        visibility: hidden; width: 280px; background-color: #2a3b4c; color: #ffffff;
        text-align: center; border-radius: 6px; padding: 10px 12px; position: absolute;
        z-index: 9999; bottom: 130%; left: 50%; transform: translateX(-50%);
        opacity: 0; transition: opacity 0.3s ease-in-out; font-size: 0.85rem;
        font-weight: 500; font-family: inherit; box-shadow: 0px 5px 15px rgba(0,0,0,0.3);
        line-height: 1.4; letter-spacing: 0.3px;
    }
    .tooltip-senior .tooltip-box::after {
        content: ""; position: absolute; top: 100%; left: 50%; margin-left: -6px;
        border-width: 6px; border-style: solid; border-color: #2a3b4c transparent transparent transparent;
    }
    .tooltip-senior:hover .tooltip-box { visibility: visible; opacity: 1; }
</style>

<form name="ATENCIONSANO" id="form-preventiva-ncf" action="guarda_atencion_psano_ncf.php" method="post" class="needs-validation" novalidate>  

    <input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
        <div class="col-sm-3"> </div> 
        <div class="col-sm-6 text-center">
            <h4 class="text-info">ATENCIÓN PREVENTIVA</h4>
        </div> 
        <div class="col-sm-3"> </div> 
    </div> 
    <hr>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
        </div>
        <div class="card-body">

            <div class="form-group row">    
                <div class="col-sm-4">
                <h6 class="text-info">NOMBRES:</h6>
                    <input type="text" class="form-control" name="nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required >                
                    <div class="invalid-feedback">Requerido.</div>
                </div>                           
                <div class="col-sm-4">
                <h6 class="text-info">PRIMER APELLIDO:</h6>
                    <input type="text" class="form-control" name="paterno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" autofocus required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                    <input type="text" class="form-control" name="materno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
            </div>

            <div class="form-group row">  
                <div class="col-sm-4">
                <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning" style="font-size:0.85rem; margin-top:-5px;"> SI NO CUENTA ASIGNAR=0</h6>
                    <input type="number" class="form-control" name="ci" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required >
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4"><br>
                <h6 class="text-info">COMPLEMENTO:</h6>
                    <input type="text" class="form-control" name="complemento" >                
                </div>
                <div class="col-sm-4"><br>
                <h6 class="text-info">GÉNERO:</h6>
                    <select name="idgenero" id="idgenero" class="form-control" required>
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
                    } else { }
                    ?>
                    </select>
                    <div class="invalid-feedback">Requerido.</div>
                </div>      
            </div>   

            <div class="form-group row">  
                <div class="col-sm-4">
                    <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                        <input type="date"  class="form-control" name="fecha_nac" required>
                        <div class="invalid-feedback">Requerido.</div>
                </div> 
                <div class="col-sm-4">
                <h6 class="text-info">NACIONALIDAD:</h6>
                    <select name="idnacionalidad" id="idnacionalidad" class="form-control" required>
                    <option value="">-SELECCIONE-</option>
                    <?php
                    $sql1 = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
                    $result1 = mysqli_query($link,$sql1);
                    if ($row1 = mysqli_fetch_array($result1)){
                    mysqli_field_seek($result1,0);
                    while ($field1 = mysqli_fetch_field($result1)){
                    } do {
                    echo "<option value=".$row1[0].">".$row1[1]."</option>";
                    } while ($row1 = mysqli_fetch_array($result1));
                    } else { }
                    ?>
                    </select>
                    <div class="invalid-feedback">Requerido.</div>
                </div>  
                <div class="col-sm-4">
                <h6 class="text-info">AUTO PERTENENCIA CULTURAL:</h6>
                    <select name="idnacion" id="idnacion" class="form-control" required>
                    <option value="">-SELECCIONE-</option>
                    <?php
                    $sql1 = "SELECT idnacion, nacion FROM nacion ";
                    $result1 = mysqli_query($link,$sql1);
                    if ($row1 = mysqli_fetch_array($result1)){
                    mysqli_field_seek($result1,0);
                    while ($field1 = mysqli_fetch_field($result1)){
                    } do {
                    echo "<option value=".$row1[0].">".$row1[1]."</option>";
                    } while ($row1 = mysqli_fetch_array($result1));
                    } else { }
                    ?>
                    </select>
                    <div class="invalid-feedback">Requerido.</div>
                </div>        
            </div> 
        
        <hr>
            
                </div>
            </div>

   <!-------- DATOS PERSONALES DEL INTEGRANTE FAMILIAR (End) --------->    
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">2.- INFORMACIÓN DE LA ATENCIÓN</h6>
        </div>
        <div class="card-body">

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
                <?php echo " - ".$row_i[1]." -> ";?> <input type="radio" name="idrepeticion" value="<?php echo $row_i[0];?>" <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > <br>
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
                <?php echo " - ".$row_c[1]." -> ";?> <input type="radio" name="idtipo_consulta" value="<?php echo $row_c[0];?>" <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > <br>
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
            <br>
            <hr>

            <div class="form-group row"> 
                <div class="col-sm-12">
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
                    <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="temperatura" placeholder="En grados centígrados°C" required>               
                    <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div>
                </div>
                <div class="col-sm-3">
                <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
                    <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="latidos por minuto" name="frec_cardiaca" required>               
                    <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div>
                </div>
            </div>
            
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

            <div class="form-group row">    
                <div class="col-sm-3">
                <h6 class="text-info" id="titulo-alergias-prev-ncf" data-asterisco="true">ALÉRGIAS: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
                SI <input type="radio" name="alergia" value="SI" class="radio-alergia-prev-ncf" required> <br>
                NO <input type="radio" name="alergia" value="NO" class="radio-alergia-prev-ncf" required>  
                <div class="invalid-feedback" id="alerta-alergias-prev-ncf" style="display: none; font-size: 14px; margin-top:5px;">Seleccione SI o NO.</div>
                </div>
                <div class="col-sm-6">
                <h6 class="text-info" id="titulo-desc-alergia-prev-ncf">DESCRIPCIÓN DE LA ALÉRGIA</h6>
                    <textarea class="form-control" rows="3" name="descripcion_alergia" id="d_alergia_prev_ncf" placeholder="Escriba detalles si marcó SI" readonly style="background-color: #eaecf4;"></textarea>
                    <div class="invalid-feedback" style="margin-top: 5px;">Debe describir la alergia.</div>
                    <button type="button" class="btn-mic mic-alergia-prev-ncf" style="display:none;" onclick="iniciarDictado('d_alergia_prev_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div>
                <div class="col-sm-3"> </div>
            </div>




            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">EVOLUCIÓN CLÍNICA (S.O.A.P.):</h6>
                </div> 
            </div> 

            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">SUBJETIVO: 
                    <span class="tooltip-senior">
                        <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                        <span class="tooltip-box">Motivo de consulta y/o sintomas que el paciente refiere durante la anamnesis.</span>
                    </span>
                </h6>
                <textarea class="form-control" rows="3" name="subjetivo" id="soap_subjetivo_p" placeholder="Ej. Paciente acude para control..." required></textarea>
                <div class="invalid-feedback">Debe llenar la información Subjetiva.</div>
                <button type="button" class="btn-mic" onclick="iniciarDictado('soap_subjetivo_p')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 

                <div class="col-sm-6">
                <h6 class="text-info">OBJETIVO:
                    <span class="tooltip-senior">
                        <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                        <span class="tooltip-box">Hallazgos del exámen físico y/o resultados de exámenes de laboratorio y complementarios.</span>
                    </span>
                </h6>
                <textarea class="form-control" rows="3" name="objetivo" id="soap_objetivo_p" placeholder="Ej. Paciente en buen estado general..." required></textarea>
                <div class="invalid-feedback">Debe llenar la información Objetiva.</div>
                <button type="button" class="btn-mic" onclick="iniciarDictado('soap_objetivo_p')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
            </div> 

            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">ANÁLISIS:
                    <span class="tooltip-senior">
                        <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                        <span class="tooltip-box">Lista de problemas detectados: diagnóstico, signos o sintomas a seguir.</span>
                    </span>
                </h6>
                <textarea class="form-control" rows="3" name="analisis" id="soap_analisis_p" placeholder="Ej. Paciente sano, sin alteraciones..." required></textarea>
                <div class="invalid-feedback">Debe llenar el Análisis.</div>
                <button type="button" class="btn-mic" onclick="iniciarDictado('soap_analisis_p')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 

                <div class="col-sm-6">
                <h6 class="text-info">PLAN:
                    <span class="tooltip-senior">
                        <svg width="18" height="18" fill="currentColor" class="bi bi-info-circle text-info ml-1" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                        <span class="tooltip-box">Orientaciones, seguimientos, vacunas o recomendaciones de prevención.</span>
                    </span>
                </h6>
                <textarea class="form-control" rows="3" name="plan" id="soap_plan_p" placeholder="Ej. Se indican recomendaciones nutricionales..." required></textarea>
                <div class="invalid-feedback">Debe llenar el Plan clínico.</div>
                <button type="button" class="btn-mic" onclick="iniciarDictado('soap_plan_p')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
            </div> 

            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">DIAGNÓSTICO (PREVENTIVO):</h6>
                <input type="text" class="form-control buscador-cie-prev-ncf" placeholder="Buscar diagnóstico preventivo (escriba aquí)..." data-target="idpatologia_ap_sano_ncf" autocomplete="off"> 
                    <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 100%; max-height: 350px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

                    <select name="idpatologia_ap_sano" id="idpatologia_ap_sano_ncf" class="form-control" required style="display: none;">
                    <option value="">-SELECCIONE-</option>
                    <?php
                    // Mantenemos estrictamente tu consulta SQL para sano (CIE %Z%)
                    $sql_p = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie LIKE '%Z%' AND idpatologia != '938' AND idpatologia != '939' AND idpatologia !='456' AND idpatologia !='455' ORDER BY patologia";
                    $res_p = mysqli_query($link,$sql_p);
                    if ($res_p) {
                        while ($r_p = mysqli_fetch_array($res_p)){
                            echo "<option value='".$r_p[0]."'>".$r_p[1]." - ".$r_p[2]."</option>";
                        }
                    }
                    ?>
                    </select>
                    <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar un diagnóstico preventivo.</div>
                </div> 
            </div> 
         
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
            </div>

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
                            ¿Está seguro de GUARDAR ESTA ATENCIÓN A UN PACIENTE APARENTEMENTE SANO?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="button" id="btn-confirmar-preventiva-ncf" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>     
    </div>
</div>

<script>
    (function() {
        setTimeout(function() {
            var formPrevNcf = document.getElementById('form-preventiva-ncf') || document.querySelector('form[action*="guarda_atencion_psano_ncf.php"]');
            if(!formPrevNcf) return;

            // 1. DIBUJO AUTOMÁTICO DE ASTERISCOS
            var camposOb = formPrevNcf.querySelectorAll('input[required], select[required], textarea[required]');
            camposOb.forEach(function(campo) {
                var titulo = null;
                var contenedor = campo.closest('[class*="col-sm-"]');
                if (contenedor) titulo = contenedor.querySelector('h6');
                if (titulo && !titulo.hasAttribute('data-asterisco')) {
                    titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                    titulo.setAttribute('data-asterisco', 'true');
                }
            });

            // 2. LÓGICA DE ALERGIAS (Anti-fantasmas)
            var radiosAlergia = formPrevNcf.querySelectorAll('.radio-alergia-prev-ncf');
            var txtAlergia = formPrevNcf.querySelector('#d_alergia_prev_ncf');
            var micAlergia = formPrevNcf.querySelector('.mic-alergia-prev-ncf');
            var tituloAlergias = document.getElementById('titulo-alergias-prev-ncf');
            var alertaAlergias = document.getElementById('alerta-alergias-prev-ncf');
            var tituloDescAlergia = document.getElementById('titulo-desc-alergia-prev-ncf'); 
            
            if(radiosAlergia.length > 0 && txtAlergia) {
                radiosAlergia.forEach(function(radio) {
                    radio.addEventListener('change', function() {
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
                            txtAlergia.style.border = ''; 
                            var fbAlergia = txtAlergia.parentNode ? txtAlergia.parentNode.querySelector('.invalid-feedback') : null;
                            if (fbAlergia) fbAlergia.style.display = '';
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

            // 3. BUSCADOR INTELIGENTE (DESPLIEGUE AUTOMÁTICO, SIN ACENTOS Y MAYÚSCULAS)
            var buscadores = formPrevNcf.querySelectorAll('.buscador-cie-prev-ncf');
            
            function quitarAcentos(cadena) {
                return cadena.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            }

            buscadores.forEach(function(input) {
                var targetId = input.getAttribute('data-target');
                var selectOriginal = document.getElementById(targetId);
                var listaFlotante = input.nextElementSibling; 
                if(!selectOriginal) return;
                
                var opciones = Array.from(selectOriginal.options).filter(opt => opt.value !== "");
                
                // Función Maestra: Construye la lista dependiendo si hay texto o no
                function mostrarOpciones(filtro) {
                    if (input.readOnly) return; 
                    
                    input.classList.remove('is-invalid');
                    input.style.border = '';
                    var fb = selectOriginal.parentNode.querySelector('.invalid-feedback');
                    if (fb) fb.style.display = '';

                    var term = quitarAcentos(filtro.toLowerCase().trim());
                    listaFlotante.innerHTML = ''; 
                    
                    // MAGIA UX: Si está vacío muestra TODO. Si tiene texto, filtra.
                    var coincidencias = (term === '') 
                        ? opciones 
                        : opciones.filter(opt => quitarAcentos(opt.text.toLowerCase()).includes(term));
                    
                    if (coincidencias.length > 0) {
                        listaFlotante.style.display = 'block'; 
                        coincidencias.slice(0, 100).forEach(function(opt) { 
                            var item = document.createElement('div');
                            item.textContent = opt.text.toUpperCase();
                            item.style.padding = '8px 12px';
                            item.style.cursor = 'pointer';
                            item.style.borderBottom = '1px solid #eaecf4';
                            item.style.fontSize = '0.9rem';
                            item.style.color = '#5a5c69';
                            item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#eaecf4'; this.style.color = '#2e59d9'; });
                            item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'transparent'; this.style.color = '#5a5c69'; });
                            item.addEventListener('mousedown', function(e) {
                                e.preventDefault(); 
                                input.value = opt.text.toUpperCase(); 
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
                }

                // Disparadores de la Magia
                input.addEventListener('focus', function() { mostrarOpciones(this.value); });
                input.addEventListener('click', function() { mostrarOpciones(this.value); });
                input.addEventListener('input', function() { mostrarOpciones(this.value); });

                function desbloquear() {
                    if (input.readOnly) {
                        input.readOnly = false;
                        input.value = '';
                        selectOriginal.value = '';
                        input.style.backgroundColor = '';
                        input.style.color = '';
                        input.style.cursor = 'text';
                        input.removeAttribute('title');
                        input.focus(); // Al recuperar el foco, ¡volverá a desplegar la lista automáticamente!
                    }
                }

                input.addEventListener('keydown', function(e) {
                    if (input.readOnly) {
                        if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); desbloquear(); } 
                        else if (e.key !== 'Tab') { e.preventDefault(); }
                    }
                });
                
                input.addEventListener('dblclick', desbloquear);
                
                input.addEventListener('blur', function() {
                    setTimeout(function() { 
                        listaFlotante.style.display = 'none'; 
                        if (!input.readOnly && input.value.trim() === '') {
                            input.value = ''; selectOriginal.value = ''; 
                        }
                    }, 200);
                });
            });

            // 4. VALIDADOR DE FUERZA BRUTA (INMUNE Y LIMPIADOR EN TIEMPO REAL)
            var btnConfirmar = formPrevNcf.querySelector('#btn-confirmar-preventiva-ncf') || formPrevNcf.querySelector('.modal-footer .btn-info');
            if (btnConfirmar) {
                var nuevoBtn = btnConfirmar.cloneNode(true);
                btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                
                nuevoBtn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    var hayErrores = false;
                    var primerInvalido = null;
                    
                    formPrevNcf.querySelectorAll('.is-invalid').forEach(function(el) {
                        el.classList.remove('is-invalid');
                        el.style.border = ''; 
                    });
                    formPrevNcf.querySelectorAll('.invalid-feedback').forEach(function(el) {
                        el.style.display = ''; 
                    });
                    
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

                    var obligatorios = formPrevNcf.querySelectorAll('input[required], select[required], textarea[required]');
                    obligatorios.forEach(function(el) {
                        var valor = el.value ? el.value.trim() : '';
                        if (valor === '' || !el.checkValidity()) {
                            if(el.name === 'alergia') return; 

                            hayErrores = true;
                            
                            // Ajuste para el diagnóstico único de Preventiva
                            if (el.style.display === 'none' && el.id === 'idpatologia_ap_sano_ncf') {
                                var inputVisual = formPrevNcf.querySelector('input[data-target="' + el.id + '"]');
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
                            var modalActivo = formPrevNcf.querySelector('.modal');
                            var btnCancelar = modalActivo ? modalActivo.querySelector('[data-dismiss="modal"]') : null;
                            if (btnCancelar) btnCancelar.click();
                            if (modalActivo) $(modalActivo).modal('hide'); 
                        } catch(err) {}
                        
                        setTimeout(function() {
                            document.body.classList.remove('modal-open');
                            var backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(b => b.remove());
                            
                            if (primerInvalido) {
                                primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                setTimeout(() => { try { primerInvalido.focus({ preventScroll: true }); } catch(err) { primerInvalido.focus(); } }, 100);
                            }
                        }, 400);
                    } else {
                        nuevoBtn.innerHTML = "GUARDANDO...";
                        nuevoBtn.disabled = true;
                        formPrevNcf.submit(); 
                    }
                });
                
                ['input', 'change'].forEach(function(evt) {
                    formPrevNcf.addEventListener(evt, function(e) {
                        if (e.target && e.target.hasAttribute && e.target.hasAttribute('required')) {
                            var val = e.target.value || '';
                            if (val.trim() !== '') {
                                e.target.classList.remove('is-invalid');
                                e.target.style.border = '';
                                var fb = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                if (fb) fb.style.display = '';
                            }
                        }
                    });
                });
            }
        }, 200); 
    })();
</script>

<hr>
            </div>
        </div>

<!--------------------------------------------->    
<!--------  ATENCION PREVENTIVA END ----------->
<!---------------------------------------------> 
    <?php break;
    case 3: ?>
<!--------------------------------------------->    
<!--------  ATENCION TELECONSULTA BEGIN ----------->
<!---------------------------------------------> 

<form name="TELECONSULTA" id="form-teleconsulta-ncf" action="guarda_teleconsulta_ncf.php" method="post" class="needs-validation" novalidate>  

    <input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6 text-center">
    <h4 class="text-info">TELECONSULTA</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
        <hr>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
                </div>
                <div class="card-body">

                <div class="form-group row">    
                <div class="col-sm-4">
                <h6 class="text-info">NOMBRES:</h6>
                    <input type="text" class="form-control" name="nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required >                
                    <div class="invalid-feedback">Requerido.</div>
                </div>                           
                <div class="col-sm-4">
                <h6 class="text-info">PRIMER APELLIDO:</h6>
                    <input type="text" class="form-control" name="paterno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required autofocus>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                    <input type="text" class="form-control" name="materno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
            </div>

        <div class="form-group row">  
            <div class="col-sm-4">
            <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning" style="font-size:0.85rem; margin-top:-5px;"> SI NO CUENTA ASIGNAR=0</h6>
                <input type="number" class="form-control" name="ci" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required >
                <div class="invalid-feedback">Requerido.</div>
            </div>
            <div class="col-sm-4">
            <h6 class="text-info">COMPLEMENTO:</h6>
                <input type="text" class="form-control" name="complemento" >                
            </div>
            <div class="col-sm-4">
            <h6 class="text-info">GÉNERO:</h6>
                <select name="idgenero" id="idgenero" class="form-control" required>
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
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>      
        </div>   

        <div class="form-group row">  
            <div class="col-sm-4">
                <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                    <input type="date"  class="form-control" placeholder="ingresar fecha" name="fecha_nac" required>
                    <div class="invalid-feedback">Requerido.</div>
            </div> 
            <div class="col-sm-4">
            <h6 class="text-info">NACIONALIDAD:</h6>
                <select name="idnacionalidad" id="idnacionalidad" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql1 = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                } while ($row1 = mysqli_fetch_array($result1));
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>  
            <div class="col-sm-4">
            <h6 class="text-info">AUTO PERTENENCIA CULTURAL:</h6>
                <select name="idnacion" id="idnacion" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql1 = "SELECT idnacion, nacion FROM nacion ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                } while ($row1 = mysqli_fetch_array($result1));
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>        
        </div> 
        <hr>          
        </div>
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
            <input type="date" name="fecha_registro" value="<?php echo $fecha;?>" class="form-control" required>
            <div class="invalid-feedback">Requerido.</div>
        </div>
    </div>  
  
    <hr>
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info" id="titulo-vulnerable-ncf" data-asterisco="true">PACIENTE DE GRUPO VULNERABLE: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        <div class="invalid-feedback" id="alerta-vulnerable-ncf" style="display: none; font-size: 14px; margin-bottom:10px;">Debe seleccionar al menos una opción. Si no aplica ninguna, marque "OTROS DISPOSITIVOS".</div>
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
            <h6 class="text-secundary"><?php echo $row1[1];?> <input type="checkbox" class="chk-vulnerable-ncf" name="idgrupo_vulnerable[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>"></h6>
            </div> 
        <?php
        $numero1=$numero1+1;
        }
        while ($row1 = mysqli_fetch_array($result1));
        } else { }
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
            } else { }
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
            } else { }
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
            } else { }
            ?>
        </select>
        <div class="invalid-feedback">Campo obligatorio.</div>
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
                } else { }
                ?>
            </select>
            <div class="invalid-feedback">Campo obligatorio.</div>
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">CONSENTIMIENTO INFORMADO:</h6>
            SI, ACEPTADO -> <input type="radio" name="consentimiento_informado" value="SI" checked data-checked="true" onclick="if(this.dataset.checked === 'true') { this.checked = false; this.dataset.checked = 'false'; } else { this.dataset.checked = 'true'; this.checked = true; }" style="cursor: pointer;" title="Haga clic nuevamente para quitar el marcado" required>
            <div class="invalid-feedback" style="margin-top:5px;">Debe aceptar el consentimiento.</div>
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
        <h6 class="text-info" id="titulo-alergias-ncf" data-asterisco="true">ALÉRGIAS: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        SI <input type="radio" name="alergia" value="SI" class="radio-alergia-ncf" required> <br>
        NO <input type="radio" name="alergia" value="NO" class="radio-alergia-ncf" required>  
        <div class="invalid-feedback" id="alerta-alergias-ncf" style="display: none; font-size: 14px; margin-top:5px;">Seleccione SI o NO.</div>
        </div>
        <div class="col-sm-6">
        <h6 class="text-info" id="titulo-desc-alergia-ncf">DESCRIPCIÓN DE LA ALÉRGIA</h6>
            <textarea class="form-control" rows="3" name="descripcion_alergia" id="d_alergia_ncf" placeholder="Escriba detalles si marcó SI" readonly style="background-color: #eaecf4;"></textarea>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe describir la alergia.</div>
            <button type="button" class="btn-mic mic-alergia-ncf" style="display:none;" onclick="iniciarDictado('d_alergia_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
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
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_0" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[0]" id="idpatologia_ncf_0" class="form-control" required style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            $sql_p = "SELECT idpatologia, patologia, cie FROM patologia ORDER BY patologia";
            $res_p = mysqli_query($link,$sql_p);
            while ($r_p = mysqli_fetch_array($res_p)){
                echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>";
            }
            ?>
            </select>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar un diagnóstico CIE-10.</div>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 2:</h6>
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_1" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[1]" id="idpatologia_ncf_1" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_p, 0);
            while ($r_p = mysqli_fetch_array($res_p)){
                echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>";
            }
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 3:</h6>
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_2" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[2]" id="idpatologia_ncf_2" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_p, 0);
            while ($r_p = mysqli_fetch_array($res_p)){
                echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>";
            }
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 4:</h6>
            <input type="text" class="form-control buscador-cie-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_ncf_3" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[3]" id="idpatologia_ncf_3" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($res_p, 0);
            while ($r_p = mysqli_fetch_array($res_p)){
                echo "<option value=".$r_p[0].">".$r_p[1]." - ".$r_p[2]."</option>";
            }
            ?>
            </select>
        </div>  
    </div>  
<hr>

            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">EXÁMENES COMPLEMENTARIOS O DE GABINETE:</h6>
                <textarea class="form-control" rows="3" name="examen_complementario" id="exam_complementario" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('exam_complementario')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
                <div class="col-sm-6">
                <h6 class="text-info">TRATAMIENTO:</h6>
                <textarea class="form-control" rows="3" name="tratamiento_teleconsulta" id="tratamiento" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('tratamiento')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
            </div>

            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info">ESPECIALIDAD Y CIERRE DE TELECONSULTA:</h6>
                <input type="text" class="form-control buscador-inteligente-ncf" placeholder="Buscar especialidad (escriba aquí)..." data-target="idespecialidad_medica_ncf" autocomplete="off"> 
                <div class="lista-flotante-especialidad" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

                <select name="idespecialidad_medica" id="idespecialidad_medica_ncf" class="form-control" required style="display: none;">
                <option value="">-SELECCIONE-</option>
                <?php
                $sql_e = "SELECT idespecialidad_medica, especialidad_medica FROM especialidad_medica ORDER BY especialidad_medica";
                $res_e = mysqli_query($link,$sql_e);
                while ($r_e = mysqli_fetch_array($res_e)){
                    echo "<option value=".$r_e[0].">".$r_e[1]."</option>";
                }
                ?>
                </select>
                <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar una especialidad médica.</div>
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
                $sql1 = "SELECT idtiempo_ts, tiempo_ts FROM tiempo_ts ORDER BY tiempo_ts";
                $result1 = mysqli_query($link,$sql1);
                while ($row1 = mysqli_fetch_array($result1)){
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">ESTADO DEL PACIENTE:</h6></br>
                <select name="idestado_paciente"  id="idestado_paciente" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql1 = "SELECT idestado_paciente, estado_paciente FROM estado_paciente ORDER BY estado_paciente";
                $result1 = mysqli_query($link,$sql1);
                while ($row1 = mysqli_fetch_array($result1)){
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
                </div> 
                <div class="col-sm-3">
                    <h6 class="text-info">FECHA PROXIMO SEGUIMIENTO:</h6>
                    <input type="date" name="fecha_seguimiento" value="<?php echo $fecha;?>" class="form-control" required>
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-info">TELEFÓNO CELULAR DEL PACIENTE/FAMILIAR:</h6>
                    <input type="number" name="telefono_paciente" value="" class="form-control" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required>
                    <div class="invalid-feedback">Requerido.</div>
                </div>
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
                        <button type="button" id="btn-confirmar-tele-ncf" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form> 

<script>
    (function() {
        setTimeout(function() {
            // RASTREADOR BLINDADO: Busca el formulario por ID, y si falla, lo busca por su action
            var formTeleNcf = document.getElementById('form-teleconsulta-ncf') || document.querySelector('form[action*="guarda_teleconsulta_ncf.php"]');
            if(!formTeleNcf) return;

            // 1. DIBUJO AUTOMÁTICO DE ASTERISCOS
            var camposOb = formTeleNcf.querySelectorAll('input[required], select[required], textarea[required]');
            camposOb.forEach(function(campo) {
                var titulo = null;
                var contenedor = campo.closest('[class*="col-sm-"]');
                if (contenedor) titulo = contenedor.querySelector('h6');
                
                if (titulo && !titulo.hasAttribute('data-asterisco')) {
                    titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                    titulo.setAttribute('data-asterisco', 'true');
                }
            });

            // 2. LÓGICA DE ALERGIAS
            var radiosAlergia = formTeleNcf.querySelectorAll('.radio-alergia-ncf');
            var txtAlergia = formTeleNcf.querySelector('#d_alergia_ncf');
            var micAlergia = formTeleNcf.querySelector('.mic-alergia-ncf');
            var tituloAlergias = document.getElementById('titulo-alergias-ncf');
            var alertaAlergias = document.getElementById('alerta-alergias-ncf');
            var tituloDescAlergia = document.getElementById('titulo-desc-alergia-ncf'); 
            
            if(radiosAlergia.length > 0 && txtAlergia) {
                radiosAlergia.forEach(function(radio) {
                    radio.addEventListener('change', function() {
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
                            txtAlergia.style.border = ''; 
                            var fbAlergia = txtAlergia.parentNode ? txtAlergia.parentNode.querySelector('.invalid-feedback') : null;
                            if (fbAlergia) fbAlergia.style.display = '';

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

            // 3. BUSCADORES INTELIGENTES
            var buscadores = formTeleNcf.querySelectorAll('.buscador-cie-ncf, .buscador-inteligente-ncf'); 
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

                function desbloquear() {
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
                        if (e.key === 'Backspace' || e.key === 'Delete') { e.preventDefault(); desbloquear(); } 
                        else if (e.key !== 'Tab') { e.preventDefault(); }
                    }
                });
                input.addEventListener('dblclick', desbloquear);
                input.addEventListener('blur', function() {
                    setTimeout(function() { listaFlotante.style.display = 'none'; if (!input.readOnly) { input.value = ''; selectOriginal.value = ''; } }, 200);
                });
            });

            // 4. EFECTO MAGIA PARA CHECKBOXES VULNERABLES
            var chksVul = formTeleNcf.querySelectorAll('.chk-vulnerable-ncf');
            var alertaVul = document.getElementById('alerta-vulnerable-ncf');
            var tituloVul = document.getElementById('titulo-vulnerable-ncf');
            
            if(chksVul) {
                chksVul.forEach(function(chk) {
                    chk.addEventListener('change', function() {
                        if (Array.from(chksVul).some(c => c.checked)) {
                            if(alertaVul) alertaVul.style.setProperty('display', 'none', 'important');
                            if(tituloVul) tituloVul.style.color = '';
                        }
                    });
                });
            }

            // 5. VALIDADOR DE FUERZA BRUTA (INMUNE A IDs DUPLICADOS)
            var btnConfirmar = formTeleNcf.querySelector('#btn-confirmar-tele-ncf') || formTeleNcf.querySelector('.modal-footer .btn-info');
            if (btnConfirmar) {
                var nuevoBtn = btnConfirmar.cloneNode(true);
                btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                
                nuevoBtn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    var hayErrores = false;
                    var primerInvalido = null;
                    
                    formTeleNcf.querySelectorAll('.is-invalid').forEach(function(el) {
                        el.classList.remove('is-invalid');
                        el.style.border = ''; 
                    });
                    formTeleNcf.querySelectorAll('.invalid-feedback').forEach(function(el) {
                        el.style.display = ''; 
                    });
                    
                    // A. Validar Grupos Vulnerables
                    if(chksVul.length > 0) {
                        var alMenosUno = Array.from(chksVul).some(c => c.checked);
                        if(!alMenosUno) {
                            hayErrores = true;
                            if(alertaVul) alertaVul.style.setProperty('display', 'block', 'important');
                            if(tituloVul) {
                                tituloVul.style.color = '#dc3545';
                                if(!primerInvalido) primerInvalido = tituloVul;
                            }
                        }
                    }

                    // B. Validar Alergias
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
                    var obligatorios = formTeleNcf.querySelectorAll('input[required], select[required], textarea[required]');
                    obligatorios.forEach(function(el) {
                        var valor = el.value ? el.value.trim() : '';
                        if (valor === '' || !el.checkValidity()) {
                            if(el.name === 'alergia') return;

                            hayErrores = true;
                            
                            if (el.style.display === 'none' && el.id && (el.id.includes('idpatologia_ncf') || el.id === 'idespecialidad_medica_ncf')) {
                                var inputVisual = formTeleNcf.querySelector('input[data-target="' + el.id + '"]');
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
                            // CIERRE DE MODAL BLINDADO (Aísla exactamente el modal de este formulario)
                            var modalActivo = formTeleNcf.querySelector('.modal');
                            var btnCancelar = modalActivo ? modalActivo.querySelector('[data-dismiss="modal"]') : null;
                            if (btnCancelar) btnCancelar.click();
                            if (modalActivo) $(modalActivo).modal('hide'); 
                        } catch(err) {}
                        
                        setTimeout(function() {
                            document.body.classList.remove('modal-open');
                            var backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(b => b.remove());
                            
                            if (primerInvalido) {
                                primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                setTimeout(() => { try { primerInvalido.focus({ preventScroll: true }); } catch(err) { primerInvalido.focus(); } }, 100);
                            }
                        }, 400);
                    } else {
                        nuevoBtn.innerHTML = "GUARDANDO...";
                        nuevoBtn.disabled = true;
                        formTeleNcf.submit(); 
                    }
                });

                // =========================================================================
                // INICIO DEL PARCHE: LIMPIADOR DE ERRORES EN TIEMPO REAL
                // =========================================================================
                ['input', 'change'].forEach(function(evt) {
                    formTeleNcf.addEventListener(evt, function(e) {
                        // Verifica si el campo modificado era obligatorio y ya tiene texto
                        if (e.target && e.target.hasAttribute && e.target.hasAttribute('required')) {
                            var val = e.target.value || '';
                            if (val.trim() !== '') {
                                e.target.classList.remove('is-invalid');
                                e.target.style.border = '';
                                var fb = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                if (fb) fb.style.display = '';
                            }
                        }
                    });
                });
                // =========================================================================
            }
        }, 200); 
    })();
</script> 


<!--------------------------------------------->    
<!--------  ATENCION TELECONSULTA END ----------->
<!---------------------------------------------> 
   
    <?php break;
    case 4: ?>
<!--------------------------------------------->    
<!--------  ATENCION TELEMETRIA BEGIN ----------->
<!---------------------------------------------> 

<form name="TELEMETRIA" id="form-telemetria-ncf" action="guarda_telemetria_ncf.php" method="post" class="needs-validation" novalidate>  

    <input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-2"> 
    </div> 
    <div class="col-sm-8 text-center">
    <h4 class="text-info">ATENCIÓN POR TELEMETRÍA</h4>
    </div> 
    <div class="col-sm-2"> 
    </div> 
    </div> 
        <hr>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
                </div>
                <div class="card-body">

                <div class="form-group row">    
                <div class="col-sm-4">
                <h6 class="text-info">NOMBRES:</h6>
                    <input type="text" class="form-control" name="nombre" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required >                
                    <div class="invalid-feedback">Requerido.</div>
                </div>                           
                <div class="col-sm-4">
                <h6 class="text-info">PRIMER APELLIDO:</h6>
                    <input type="text" class="form-control" name="paterno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required autofocus>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                    <input type="text" class="form-control" name="materno" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');" required>                
                    <div class="invalid-feedback">Requerido.</div>
                </div>
            </div>

        <div class="form-group row">  
            <div class="col-sm-4">
            <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning" style="font-size:0.85rem; margin-top:-5px;"> SI NO CUENTA ASIGNAR=0</h6>
                <input type="number" class="form-control" name="ci" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required >
                <div class="invalid-feedback">Requerido.</div>
            </div>
            <div class="col-sm-4"><br>
            <h6 class="text-info">COMPLEMENTO:</h6>
                <input type="text" class="form-control" name="complemento" >                
            </div>
            <div class="col-sm-4"><br>
            <h6 class="text-info">GÉNERO:</h6>
                <select name="idgenero" id="idgenero" class="form-control" required>
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
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>      
        </div>   

        <div class="form-group row">  
            <div class="col-sm-4">
                <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                    <input type="date"  class="form-control" placeholder="ingresar fecha" name="fecha_nac" required>
                    <div class="invalid-feedback">Requerido.</div>
            </div> 
            <div class="col-sm-4">
            <h6 class="text-info">NACIONALIDAD:</h6>
                <select name="idnacionalidad" id="idnacionalidad" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql1 = "SELECT idnacionalidad, nacionalidad FROM nacionalidad ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                } while ($row1 = mysqli_fetch_array($result1));
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>  
            <div class="col-sm-4">
            <h6 class="text-info">AUTO PERTENENCIA CULTURAL:</h6>
                <select name="idnacion" id="idnacion" class="form-control" required>
                <option value="">-SELECCIONE-</option>
                <?php
                $sql1 = "SELECT idnacion, nacion FROM nacion ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do {
                echo "<option value=".$row1[0].">".$row1[1]."</option>";
                } while ($row1 = mysqli_fetch_array($result1));
                } else { }
                ?>
                </select>
                <div class="invalid-feedback">Requerido.</div>
            </div>        
        </div> 
        <hr>          
        </div>
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
        <?php if ($row_i[0] == '1') { echo "checked";} else { } ?> > <br>
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
        <?php if ($row_c[0] == '1') { echo "checked";} else { } ?> > <br>
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
        <h6 class="text-info" id="titulo-vulnerable-tele-ncf" data-asterisco="true">PACIENTE DE GRUPO VULNERABLE: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        <div class="invalid-feedback" id="alerta-vulnerable-tele-ncf" style="display: none; font-size: 14px; margin-bottom:10px;">Debe seleccionar al menos una opción. Si no aplica ninguna, marque "NINGUNA".</div>
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
            <h6 class="text-secundary"><?php echo $row1[1];?> <input type="checkbox" class="chk-vulnerable-tele-ncf" name="idgrupo_vulnerable[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>"></h6>
            </div> 
        <?php
        $numero1=$numero1+1;
        }
        while ($row1 = mysqli_fetch_array($result1));
        } else { }
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
            } else { }
            ?>
        </select>
        <div class="invalid-feedback">Requerido.</div>
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
            } else { }
            ?>
        </select>
        <div class="invalid-feedback">Requerido.</div>
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
            } else { }
            ?>
        </select>
        <div class="invalid-feedback">Requerido.</div>
    </div> 

    </div> 
    <div class="form-group row"> 
        <div class="col-sm-4"> 
        </div>
        <div class="col-sm-4">
            <h6 class="text-info">CONSENTIMIENTO INFORMADO:</h6> 
            SI, ACEPTADO -> <input type="radio" name="consentimiento_informado" value="SI" checked data-checked="true" onclick="if(this.dataset.checked === 'true') { this.checked = false; this.dataset.checked = 'false'; } else { this.dataset.checked = 'true'; this.checked = true; }" style="cursor: pointer;" title="Haga clic nuevamente para quitar el marcado" required>
            <div class="invalid-feedback" style="margin-top:5px;">Debe aceptar el consentimiento.</div>
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
        <textarea class="form-control" rows="2" name="motivo_teleconsulta" id="tm_motivo_t_ncf" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_motivo_t_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
        </div> 
        <div class="col-sm-6"> 
        </div> 
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">HISTORIA DE LA ENFERMEDAD ACTUAL:</h6>
        <textarea class="form-control" rows="3" name="historia_enfermedad" id="tm_historia_t_ncf" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
        <button type="button" class="btn-mic" onclick="iniciarDictado('tm_historia_t_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
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
            <input type="number" step="any" min="10" max="47" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" oninput="if(this.value > 47) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 10) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" name="temperatura" placeholder="En grados centígrados" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 10°C a 47°C</div>
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="number" min="0" max="350" onkeydown="if(['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" oninput="if(this.value > 350) { this.value = ''; this.classList.add('is-invalid'); } else { this.classList.remove('is-invalid'); }" onblur="if(this.value !== '' && this.value < 0) { this.value = ''; this.classList.add('is-invalid'); }" class="form-control" placeholder="Latidos por minuto" name="frec_cardiaca" required>               
            <div class="invalid-feedback" style="margin-top: 5px;">Permitido: 0 a 350 lpm</div>
        </div>
    </div>
   
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

    <div class="form-group row">    
        <div class="col-sm-3">
        <h6 class="text-info" id="titulo-alergias-tele-ncf" data-asterisco="true">ALÉRGIAS: <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
        SI <input type="radio" name="alergia" value="SI" class="radio-alergia-tele-ncf" required> <br>
        NO <input type="radio" name="alergia" value="NO" class="radio-alergia-tele-ncf" required>  
        <div class="invalid-feedback" id="alerta-alergias-tele-ncf" style="display: none; font-size: 14px; margin-top:5px;">Seleccione SI o NO.</div>
        </div>
        <div class="col-sm-6">
        <h6 class="text-info" id="titulo-desc-alergia-tele-ncf">DESCRIPCIÓN DE LA ALÉRGIA</h6>
            <textarea class="form-control" rows="3" name="descripcion_alergia" id="d_alergia_tele_ncf" placeholder="Escriba detalles si marcó SI" readonly style="background-color: #eaecf4;"></textarea>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe describir la alergia.</div>
            <button type="button" class="btn-mic mic-alergia-tele-ncf" style="display:none;" onclick="iniciarDictado('d_alergia_tele_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
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
            <input type="text" class="form-control buscador-cie-tele-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_ncf_0" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[0]" id="idpatologia_tele_ncf_0" class="form-control" required style="display: none;">
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
            } else { }
            ?>
            </select>
            <div class="invalid-feedback" style="margin-top: 5px;">Debe seleccionar un diagnóstico CIE-10.</div>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 2:</h6>
            <input type="text" class="form-control buscador-cie-tele-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_ncf_1" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[1]" id="idpatologia_tele_ncf_1" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($result1, 0);
            while ($row1 = mysqli_fetch_array($result1)){
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            } 
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 3:</h6>
            <input type="text" class="form-control buscador-cie-tele-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_ncf_2" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[2]" id="idpatologia_tele_ncf_2" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($result1, 0);
            while ($row1 = mysqli_fetch_array($result1)){
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            } 
            ?>
            </select>
        </div>  
    </div> 
    <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">DIAGNOSTICO 4:</h6>
            <input type="text" class="form-control buscador-cie-tele-ncf" placeholder="Buscar enfermedad (escriba aquí)..." data-target="idpatologia_tele_ncf_3" autocomplete="off"> 
            <div class="lista-flotante-cie" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000; width: 95%; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 4px;"></div> 

            <select name="idpatologia[3]" id="idpatologia_tele_ncf_3" class="form-control" style="display: none;">
            <option value="">-SELECCIONE-</option>
            <?php
            mysqli_data_seek($result1, 0);
            while ($row1 = mysqli_fetch_array($result1)){
            echo "<option value=".$row1[0].">".$row1[1]." - ".$row1[2]."</option>";
            } 
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
            
            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info" id="titulo-telemetria-check-ncf" data-asterisco="true">TELEMETRÍA REALIZADA (SELECCIÓN MÚLTIPLE): <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span></h6>
                <div class="invalid-feedback" id="alerta-telemetria-check-ncf" style="display: none; font-size: 14px; margin-bottom:10px;">Debe marcar al menos un tipo de telemetría.</div>
                </div> 
            </div> 

            <div class="form-group row">                           
                <?php  
                $numero1=0;                  
                $sql1 ="  SELECT idexamen_complementario, examen_complementario FROM examen_complementario WHERE telesalud ='SI' ";
                $result1 = mysqli_query($link,$sql1);
                if ($row1 = mysqli_fetch_array($result1)){
                mysqli_field_seek($result1,0);
                while ($field1 = mysqli_fetch_field($result1)){
                } do { 
                ?>
                    <div class="col-sm-3"> 
                    <h6 class="text-secundary"> 
                    <input type="checkbox" class="chk-telemetria-check-ncf" name="idexamen_complementario[<?php echo $numero1;?>]" value="<?php echo $row1[0];?>" data-nombre="<?php echo strtoupper($row1[1]);?>"> <?php echo $row1[1];?>  
                    </h6>
                    </div> 
                <?php
                $numero1=$numero1+1;
                }
                while ($row1 = mysqli_fetch_array($result1));
                } else { }
                ?>
            </div> 

            <div class="form-group row"> 
                <div class="col-sm-12">
                <h6 class="text-info" id="titulo-otros-telemetria-ncf">SI MARCÓ OTROS MENCIONE CUAL:</h6>
                <input type="text" name="otros_examenes" id="otros_examenes_telemetria_ncf" class="form-control" placeholder="Escriba aquí solo si marcó 'OTROS DISPOSITIVOS'..." readonly style="background-color: #eaecf4;">
                <div class="invalid-feedback" style="margin-top: 5px;">Debe especificar cuál dispositivo.</div>
                </div> 
            </div> 

            <div class="form-group row"> 
                <div class="col-sm-6">
                <h6 class="text-info">EXÁMENES COMPLEMENTARIOS O DE GABINETE:</h6>
                <textarea class="form-control" rows="3" name="examen_complementario" id="exam_complementario_t_ncf" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('exam_complementario_t_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
                <div class="col-sm-6">
                <h6 class="text-info">COMENTARIOS / TRATAMIENTO:</h6>
                <textarea class="form-control" rows="3" name="tratamiento_teleconsulta" id="tratamiento_t_ncf" placeholder="Escriba o utilice el botón de dictado por voz" required></textarea>
                <button type="button" class="btn-mic" onclick="iniciarDictado('tratamiento_t_ncf')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
                </div> 
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#examplemodaltele2">
                    GUARDAR ATENCIÓN POR TELEMETRÍA
                    </button>  
                </div> 
            </div>

    <div class="modal fade" id="examplemodaltele2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel0">ATENCIÓN POR TELEMETRÍA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCIÓN POR TELEMETRÍA?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="button" id="btn-confirmar-telemetria-ncf" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form> 

<script>
    (function() {
        setTimeout(function() {
            var formTelemetriaNcf = document.getElementById('form-telemetria-ncf') || document.querySelector('form[action*="guarda_telemetria_ncf.php"]');
            if(!formTelemetriaNcf) return;

            // 1. DIBUJO AUTOMÁTICO DE ASTERISCOS
            var camposOb = formTelemetriaNcf.querySelectorAll('input[required], select[required], textarea[required]');
            camposOb.forEach(function(campo) {
                var titulo = null;
                var contenedor = campo.closest('[class*="col-sm-"]');
                if (contenedor) titulo = contenedor.querySelector('h6');
                if (titulo && !titulo.hasAttribute('data-asterisco')) {
                    titulo.innerHTML += ' <span style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                    titulo.setAttribute('data-asterisco', 'true');
                }
            });

            // 2. LÓGICA DE ALERGIAS (Anti-fantasmas)
            var radiosAlergia = formTelemetriaNcf.querySelectorAll('.radio-alergia-tele-ncf');
            var txtAlergia = formTelemetriaNcf.querySelector('#d_alergia_tele_ncf');
            var micAlergia = formTelemetriaNcf.querySelector('.mic-alergia-tele-ncf');
            var tituloAlergias = document.getElementById('titulo-alergias-tele-ncf');
            var alertaAlergias = document.getElementById('alerta-alergias-tele-ncf');
            var tituloDescAlergia = document.getElementById('titulo-desc-alergia-tele-ncf'); 
            
            if(radiosAlergia.length > 0 && txtAlergia) {
                radiosAlergia.forEach(function(radio) {
                    radio.addEventListener('change', function() {
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
                            txtAlergia.style.border = ''; 
                            var fbAlergia = txtAlergia.parentNode ? txtAlergia.parentNode.querySelector('.invalid-feedback') : null;
                            if (fbAlergia) fbAlergia.style.display = '';

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

            // 3. BUSCADORES CIE-10
            var buscadores = formTelemetriaNcf.querySelectorAll('.buscador-cie-tele-ncf');
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
                    setTimeout(function() { listaFlotante.style.display = 'none'; if (!input.readOnly) { input.value = ''; selectOriginal.value = ''; } }, 200);
                });
            });

            // 4. CHECKBOXES (Vulnerables y Telemetría Múltiple con 'Otros')
            var chksVul = formTelemetriaNcf.querySelectorAll('.chk-vulnerable-tele-ncf');
            var alertaVul = document.getElementById('alerta-vulnerable-tele-ncf');
            var tituloVul = document.getElementById('titulo-vulnerable-tele-ncf');
            
            chksVul.forEach(function(chk) {
                chk.addEventListener('change', function() {
                    if (Array.from(chksVul).some(c => c.checked)) {
                        if(alertaVul) alertaVul.style.setProperty('display', 'none', 'important');
                        if(tituloVul) tituloVul.style.color = '';
                    }
                });
            });

            var chksTele = formTelemetriaNcf.querySelectorAll('.chk-telemetria-check-ncf');
            var alertaTele = document.getElementById('alerta-telemetria-check-ncf');
            var tituloTele = document.getElementById('titulo-telemetria-check-ncf');
            var txtOtrosTele = document.getElementById('otros_examenes_telemetria_ncf');
            var tituloOtrosTele = document.getElementById('titulo-otros-telemetria-ncf');

            chksTele.forEach(function(chk) {
                chk.addEventListener('change', function() {
                    if (Array.from(chksTele).some(c => c.checked)) {
                        if(alertaTele) alertaTele.style.setProperty('display', 'none', 'important');
                        if(tituloTele) tituloTele.style.color = '';
                    }
                    
                    if(txtOtrosTele) {
                        var otrosMarcado = Array.from(chksTele).some(c => c.checked && c.getAttribute('data-nombre') && c.getAttribute('data-nombre').includes('OTROS'));
                        
                        if (otrosMarcado) {
                            txtOtrosTele.readOnly = false;
                            txtOtrosTele.style.backgroundColor = '#fff';
                            txtOtrosTele.setAttribute('required', 'required'); 
                            txtOtrosTele.placeholder = "Especifique el dispositivo...";
                            
                            if(tituloOtrosTele && !tituloOtrosTele.hasAttribute('data-asterisco')) {
                                tituloOtrosTele.innerHTML += ' <span class="asterisco-dinamico" style="color: #e74a3b; font-size: 1.1em; font-weight: bold;" title="Campo obligatorio">*</span>';
                                tituloOtrosTele.setAttribute('data-asterisco', 'true');
                            }
                        } else {
                            txtOtrosTele.readOnly = true;
                            txtOtrosTele.style.backgroundColor = '#eaecf4';
                            txtOtrosTele.removeAttribute('required'); 
                            txtOtrosTele.value = '';
                            
                            txtOtrosTele.classList.remove('is-invalid');
                            txtOtrosTele.style.border = ''; 
                            var feedbackOtros = txtOtrosTele.parentNode ? txtOtrosTele.parentNode.querySelector('.invalid-feedback') : null;
                            if (feedbackOtros) feedbackOtros.style.display = '';
                            
                            txtOtrosTele.placeholder = "Escriba aquí solo si marcó 'OTROS DISPOSITIVOS'...";
                            
                            if(tituloOtrosTele && tituloOtrosTele.hasAttribute('data-asterisco')) {
                                var ast = tituloOtrosTele.querySelector('.asterisco-dinamico');
                                if(ast) ast.remove();
                                tituloOtrosTele.removeAttribute('data-asterisco');
                            }
                        }
                    }
                });
            });

            // 5. VALIDADOR DE FUERZA BRUTA (INMUNE Y LIMPIADOR)
            var btnConfirmar = formTelemetriaNcf.querySelector('#btn-confirmar-telemetria-ncf') || formTelemetriaNcf.querySelector('.modal-footer .btn-info');
            if (btnConfirmar) {
                var nuevoBtn = btnConfirmar.cloneNode(true);
                btnConfirmar.parentNode.replaceChild(nuevoBtn, btnConfirmar);
                
                nuevoBtn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    var hayErrores = false;
                    var primerInvalido = null;
                    
                    formTelemetriaNcf.querySelectorAll('.is-invalid').forEach(function(el) {
                        el.classList.remove('is-invalid');
                        el.style.border = ''; 
                    });
                    formTelemetriaNcf.querySelectorAll('.invalid-feedback').forEach(function(el) {
                        el.style.display = ''; 
                    });
                    
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

                    var obligatorios = formTelemetriaNcf.querySelectorAll('input[required], select[required], textarea[required]');
                    obligatorios.forEach(function(el) {
                        var valor = el.value ? el.value.trim() : '';
                        if (valor === '' || !el.checkValidity()) {
                            if(el.name === 'alergia') return; 

                            hayErrores = true;
                            
                            if (el.style.display === 'none' && el.id && el.id.includes('idpatologia_tele_ncf')) {
                                var inputVisual = formTelemetriaNcf.querySelector('input[data-target="' + el.id + '"]');
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
                            var modalActivo = formTelemetriaNcf.querySelector('.modal');
                            var btnCancelar = modalActivo ? modalActivo.querySelector('[data-dismiss="modal"]') : null;
                            if (btnCancelar) btnCancelar.click();
                            if (modalActivo) $(modalActivo).modal('hide'); 
                        } catch(err) {}
                        
                        setTimeout(function() {
                            document.body.classList.remove('modal-open');
                            var backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(b => b.remove());
                            
                            if (primerInvalido) {
                                primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                setTimeout(() => { try { primerInvalido.focus({ preventScroll: true }); } catch(err) { primerInvalido.focus(); } }, 100);
                            }
                        }, 400);
                    } else {
                        nuevoBtn.innerHTML = "GUARDANDO...";
                        nuevoBtn.disabled = true;
                        formTelemetriaNcf.submit(); 
                    }
                });
                
                ['input', 'change'].forEach(function(evt) {
                    formTelemetriaNcf.addEventListener(evt, function(e) {
                        if (e.target && e.target.hasAttribute && e.target.hasAttribute('required')) {
                            var val = e.target.value || '';
                            if (val.trim() !== '') {
                                e.target.classList.remove('is-invalid');
                                e.target.style.border = '';
                                var fb = e.target.parentNode ? e.target.parentNode.querySelector('.invalid-feedback') : null;
                                if (fb) fb.style.display = '';
                            }
                        }
                    });
                });
            }
        }, 200); 
    })();
</script> 

<!--------------------------------------------->    
<!--------  ATENCION TELEMETRIA END ----------->
<!---------------------------------------------> 

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

   