<?php include("../inc.config.php"); ?>
<?php
    $diagnosticos = $_POST['diagnosticos'];

    ?>      
       <input type="hidden" name="diagnosticos" value="<?php echo $diagnosticos;?>">
    
<!-------- 1 diagnostico - 1 o 2 tratamientos -----> 
    <div class="form-group row"> 
    <div class="col-sm-6">
    <h6 class="text-info">DIAGNÓSTICO 1 :</h6>
    </div> 
    <div class="col-sm-6"> 
    <h6 class="text-info">
    </div> 
    </div> 

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
            <div class="col-sm-12"> 
            <h6 class="text-info">MOTIVO DE CONSULTA 1:</h6>
            <textarea class="form-control" rows="3" name="motivo_consulta1" id="motivo_consulta1" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('motivo_consulta1')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
        </div> 
        <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-info">SUBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="subjetivo1" id="subjetivo1" placeholder="Historia Enfermedad Actual" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('subjetivo1')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
            <div class="col-sm-6"> 
            <h6 class="text-info">OBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="objetivo1" required></textarea>
            <textarea class="form-control" rows="3" name="objetivo1" id="objetivo1" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('objetivo1')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
            </div> 
                <div class="form-group row"> 
                <div class="col-sm-6"> 
            <h6 class="text-info">ANÁLISIS:</h6>
            <textarea class="form-control" rows="3" name="analisis1" id="analisis1" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('analisis1')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div>
                <div class="col-sm-6"> 
            <h6 class="text-info">PLAN:</h6>
            <textarea class="form-control" rows="3" name="plan1" id="plan1" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('plan1')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
        </div>

        <div class="form-group row"> 
        <div class="col-sm-12">
        <h6 class="text-info">C.I.E. :</h6>
        <select name="idpatologia1"  id="idpatologia1" class="form-control" required>
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
            <div class="form-group row"> 
            <div class="col-sm-3">
            <h6 class="text-info">NÚMERO DE TRATAMIENTOS:</h6>
            </div> 
            <div class="col-sm-3"> 
            <select name="tratamientos_1"  id="tratamientos_1" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <option value="1">1 TRATAMIENTO</option>
            <option value="2">2 TRATAMIENTOS</option>
            </select>
            </div> 
            <div class="col-sm-6">
            </div> 
            </div> 

            <div id="tratamientos_ps_1"></div>

 <?php  if ($diagnosticos == '2') {    ?>

<!-------- 2 diagnosticos - 1 o 2 tratamientos -----> 
    <hr>
    </br>
    </br>
    <div class="form-group row"> 
    <div class="col-sm-12">
    <h6 class="text-info">DIAGNÓSTICO 2 :</h6>
    </div> 
    </div> 
   
     <hr>
            <div class="form-group row"> 
            <div class="col-sm-12"> 
            <h6 class="text-info">MOTIVO DE CONSULTA 2:</h6>
            <textarea class="form-control" rows="3" name="motivo_consulta2" id="motivo_consulta2" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('motivo_consulta2')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
            </div> 
            <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-info">SUBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="subjetivo2" placeholder="Historia Enfermedad Actual" id="subjetivo2" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('subjetivo2')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 

                <div class="col-sm-6"> 
            <h6 class="text-info">OBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="objetivo2" id="objetivo2" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('objetivo2')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
            </div> 
                <div class="form-group row"> 
                <div class="col-sm-6"> 
            <h6 class="text-info">ANÁLISIS:</h6>
            <textarea class="form-control" rows="3" name="analisis2" id="analisis2" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('analisis2')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div>
                <div class="col-sm-6"> 
            <h6 class="text-info">PLAN:</h6>
            <textarea class="form-control" rows="3" name="plan2" id="plan2" required></textarea>
            <button type="button" class="btn-mic" onclick="iniciarDictado('plan2')"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg></button>
            </div> 
        </div>
     <div class="form-group row"> 
    <div class="col-sm-12">
    <h6 class="text-info">C.I.E. :</h6>
    <select name="idpatologia2"  id="idpatologia2" class="form-control" required>
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
<div class="form-group row"> 
            <div class="col-sm-3">
            <h6 class="text-info">NÚMERO DE TRATAMIENTOS:</h6>
            </div> 
            <div class="col-sm-3"> 
            <select name="tratamientos_2"  id="tratamientos_2" class="form-control" required>
            <option value="">-SELECCIONE-</option>
            <option value="1">1 TRATAMIENTO</option>
            <option value="2">2 TRATAMIENTOS</option>
            </select>
            </div> 
            <div class="col-sm-6">
            </div> 
            </div> 

            <div id="tratamientos_ps_2"></div>

<?php  } else { }  ?>


    <script language="javascript">
        $(document).ready(function(){
        $("#tratamientos_1").change(function () {
                    $("#tratamientos_1 option:selected").each(function () {
                        tratamientos=$(this).val();
                    $.post("tratamientos_ps_1.php", {tratamientos:tratamientos}, function(data){
                    $("#tratamientos_ps_1").html(data);
                    });
                });
        })
        });
    </script>

    <script language="javascript">
        $(document).ready(function(){
        $("#tratamientos_2").change(function () {
                    $("#tratamientos_2 option:selected").each(function () {
                        tratamientos=$(this).val();
                    $.post("tratamientos_ps_2.php", {tratamientos:tratamientos}, function(data){
                    $("#tratamientos_ps_2").html(data);
                    });
                });
        })
        });
    </script>