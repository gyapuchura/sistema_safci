<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
$idtipo_atencion = $_POST['tipo_atencion'];

if ($idtipo_atencion == '2') { ?>

<form name="ATENCIONSANO" action="guarda_atencion_psano.php" method="post">  

    <input type="hidden" name="idtipo_atencion" value="<?php echo $idtipo_atencion;?>">   

    <div class="form-group row"> 
    <div class="col-sm-3"> 
    </div> 
    <div class="col-sm-6">
    <h4 class="text-info">ATENCIÓN APARENTEMENTE SANO(A):</h4>
    </div> 
    <div class="col-sm-3"> 
    </div> 
    </div> 
<hr>
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
    <div class="form-group row"> 
    <div class="col-sm-5">
    <h6 class="text-info">DIAGNÓSTICO:</h6>
        <select name="idpatologia_ap_sano"  id="idpatologia_ap_sano" class="form-control" required>
        <option value="">-SELECCIONE-</option>
        <?php
        $numero=1;
        $sql1 = "SELECT idpatologia, patologia, cie FROM patologia WHERE cie LIKE '%Z%' ORDER BY patologia";
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
    <div class="col-sm-7"> 
    <h6 class="text-info">ORIENTACIÓN MÉDICA:</h6>
    <textarea class="form-control" rows="4" name="motivo_consulta" required></textarea>
    </div> 
    </div> 


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
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ATENCIÓN INTEGRAL SAFCI</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCIÓN SAFCI?                          
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
  

<?php } else { ?>

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
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ATENCIÓN INTEGRAL SAFCI</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">                           
                            Esta seguro de GUARDAR ESTA ATENCIÓN SAFCI?                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-info pull-center">CONFIRMAR</button>    
                        </div>
                    </div>
                </div>
            </div>
        </form>    

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

   