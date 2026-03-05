<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
$idtipo_atencion = $_POST['tipo_atencion'];

if ($idtipo_atencion == '2') { ?>

<form name="ATENCIONSANO" action="guarda_atencion_psano_ncf.php" method="post">  

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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
                </div>
                <div class="card-body">

                <div class="form-group row">    
                <div class="col-sm-4">
                <h6 class="text-info">NOMBRES:</h6>
                    <input type="text" class="form-control" 
                    name="nombre" required >                
                </div>                           
                <div class="col-sm-4">
                <h6 class="text-info">PRIMER APELLIDO:</h6>
                    <input type="text" class="form-control" 
                    name="paterno" autofocus>                
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                    <input type="text" class="form-control" 
                    name="materno" required>                
                </div>
            </div>

        <div class="form-group row">  
            <div class="col-sm-4">
            <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning"> SI NO CUENTA ASIGNAR=0</h6>
                <input type="number" class="form-control" 
                name="ci" required >
            </div>
            <div class="col-sm-4"></br>
            <h6 class="text-info">COMPLEMENTO:</h6>
                <input type="text" class="form-control" 
                name="complemento" >                
            </div>
            <div class="col-sm-4"></br>
            <h6 class="text-info">GÉNERO</h6>
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
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
            </div>      
        </div>   

        <div class="form-group row">  
            <div class="col-sm-4">
                <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                    <input type="date"  class="form-control" 
                        placeholder="ingresar fecha" name="fecha_nac" required>
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
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
            </div>  
            <div class="col-sm-4">
            <h6 class="text-info">AUTO PERTENENCIA CULTURAL</h6>

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
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
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
    <div class="col-sm-6">
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

                <div class="col-sm-6">
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
            <input type="number" class="form-control"              
                name="peso" value="1" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="number" class="form-control" 
                name="temperatura" placeholder="" value="0" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" 
                name="frec_cardiaca" value="0" required>                
        </div>
    </div>
    
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
            <h6 class="text-info"></br>diastólica [mmHg]</h6>
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
                <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                </div>
                <div class="col-sm-3">             
                </div>
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

        <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-info">SUBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="subjetivo" required></textarea>
            </div> 

                <div class="col-sm-6"> 
            <h6 class="text-info">OBJETIVO:</h6>
            <textarea class="form-control" rows="3" name="objetivo" required></textarea>
            </div> 
            </div> 
                <div class="form-group row"> 
                <div class="col-sm-6"> 
            <h6 class="text-info">ANÁLISIS:</h6>
            <textarea class="form-control" rows="3" name="analisis" required></textarea>
            </div>
                <div class="col-sm-6"> 
            <h6 class="text-info">PLAN:</h6>
            <textarea class="form-control" rows="3" name="plan" required></textarea>
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
                            Esta seguro de GUARDAR ESTA ATENCIÓN A UN PACIENTE APARENTEMENTE SANO?                          
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
            </div>
        </div>

<?php } else { ?>

    <form name="ATENCIONMORB" action="guarda_atencion_pmorbilidad_ncf.php" method="post">  

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

        <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold text-info">1.- INFORMACIÓN DE FILIACIÓN</h6>
                </div>
                <div class="card-body">

                <div class="form-group row">    
                <div class="col-sm-4">
                <h6 class="text-info">NOMBRES:</h6>
                    <input type="text" class="form-control" 
                    name="nombre" required >                
                </div>                           
                <div class="col-sm-4">
                <h6 class="text-info">PRIMER APELLIDO:</h6>
                    <input type="text" class="form-control" 
                    name="paterno" autofocus>                
                </div>
                <div class="col-sm-4">
                <h6 class="text-info">SEGUNDO APELLIDO:</h6>
                    <input type="text" class="form-control" 
                    name="materno" required>                
                </div>
            </div>

        <div class="form-group row">  
            <div class="col-sm-4">
            <h6 class="text-info">CÉDULA DE IDENTIDAD:</h6><h6 class="text-warning"> SI NO CUENTA ASIGNAR=0</h6>
                <input type="number" class="form-control" 
                name="ci" required >
            </div>
            <div class="col-sm-4"></br>
            <h6 class="text-info">COMPLEMENTO:</h6>
                <input type="text" class="form-control" 
                name="complemento" >                
            </div>
            <div class="col-sm-4"></br>
            <h6 class="text-info">GÉNERO</h6>
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
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
            </div>      
        </div>   

        <div class="form-group row">  
            <div class="col-sm-4">
                <h6 class="text-info">FECHA DE NACIMIENTO:</h6>
                    <input type="date"  class="form-control" 
                        placeholder="ingresar fecha" name="fecha_nac" required>
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
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
            </div>  
            <div class="col-sm-4">
            <h6 class="text-info">AUTO PERTENENCIA CULTURAL</h6>

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
                } else {
                echo "No se encontraron resultados!";
                }
                ?>
                </select>
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
    <div class="col-sm-6">
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

                <div class="col-sm-6">
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
            <input type="number" class="form-control"              
                name="peso" value="1" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">TEMPERATURA</br>[°C]:</h6>
            <input type="number" class="form-control" 
                name="temperatura" placeholder="" value="0" required>                
        </div>
        <div class="col-sm-3">
        <h6 class="text-info">FRECUENCIA CARDIACA </br>[lpm]:</h6>
            <input type="text" class="form-control" 
                name="frec_cardiaca" value="0" required>                
        </div>
    </div>
    
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
                <textarea class="form-control" rows="2" name="descripcion_alergia"></textarea> 
                </div>
                <div class="col-sm-3">             
                </div>
            </div>
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
                            Esta seguro de GUARDAR ESTA ATENCIÓN SAFCI POR MORBILIDAD?                          
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
        </div>

<?php } ?>

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

   