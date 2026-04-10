<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$fecha 		= date("Y-m-d");
$idpatologia_ap_sano = $_POST['patologia_ap_sano'];

    switch ($idpatologia_ap_sano) {
    case 362: ?>
        <!--------------------------------------------------------->
        <!------------     NUEVA HISTORIA PERINATAL - BEGIN   --------------->
        <!--------------------------------------------------------->
        <div class="form-group row"> 
            <div class="col-sm-6"> 
            <h6 class="text-warning">SE DEBE INICIAR LA HISTORIA CLINICA PERINATAL:</h6>
            
            </div>
            <div class="col-sm-6"> 
            <a class="btn btn-warning btn-icon-split" href="inicia_hc_perinatal.php" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=800,top=50, left=600, scrollbars=YES'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">NUEVA HISTORIA CLINICA PERINATAL</span></a> 
            
            </div> 
        </div>

        <!--------------------------------------------------------->
        <!------------     NUEVA HISTORIA PERINATAL - END   --------------->
        <!--------------------------------------------------------->
    <?php   
    break;
    case 239: 
    ?>
        <!--------------------------------------------------------->
        <!------------     CONTROL DEL NIÑO SANO - BEGIN  --------------->
        <!--------------------------------------------------------->

        <?php  if ($edad_ss <= '2') { ?>
            <!-------------  El niño es menor a 2 años y corresponde el bono juana azurduy ----------->   
            <?php
            $sql_bj = " SELECT idnombre_nino, idnombre_madre, nino_carpetizado, numero_controles, direccion_domicilio, celular_madre, cuenta_madre, ";
            $sql_bj.= " fecha_inscripcion_bono FROM bono_nino_sano  WHERE idnombre_nino='$idnombre_integrante_ss' ";
            $result_bj = mysqli_query($link,$sql_bj);
            if ($row_bj = mysqli_fetch_array($result_bj)){ ?>

            <!-------------  El niño SI tiene registro de beneficiario bono Juana Azurduy BEGIN -----------> 
            <!-------------  Se debe mostrar el registro bono juana azurduy -----------> 
            <div class="form-group row"> 
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                <h6 class="text-info">DATOS DE REGISTRO - BONO JUANA AZURDUY</h6>
                </div>
            </div>
            <hr>

            <?php
                $sql_ma =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row_bj[1]' ";
                $result_ma=mysqli_query($link,$sql_ma);
                $row_ma=mysqli_fetch_array($result_ma);
            ?>
                <div class="form-group row">  
                    <div class="col-sm-2">
                        <h6 class="text-info">Nº DE CEDULA DE IDENTIDAD DE LA MADRE</h6>
                        <input type="number" class="form-control" name="celular_madre" placeholder="" value="<?php echo $row_ma[4];?>" disabled>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">NOMBRE DE LA MADRE</h6></br>
                       <textarea class="form-control" rows="2" name="direccion_domicilio" disabled><?php echo $row_ma[1].' '.$row_ma[2].' '.$row_ma[3];?></textarea> 
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">Nº DE CONTROLES DEL MENOR DE 2 AÑOS</h6> 
                        <input type="number" class="form-control" name="cuenta_madre" placeholder="" value="<?php echo $row_bj[3];?>" disabled>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">FORMULARIO DE CONTROLES</h6> </br> 
                        <input type="date" class="form-control" name="fecha_inscripcion_bono" value="" disabled>
                    </div>
                </div>

                <div class="form-group row">  
                    <div class="col-sm-3">
                        <h6 class="text-info">DIRECCION/DOMICILIO</h6>
                        <textarea class="form-control" rows="2" name="direccion_domicilio" disabled><?php echo $row_bj[4];?></textarea> 
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">CELULAR DE LA MADRE</h6> 
                        <input type="number" class="form-control" name="celular_madre" placeholder="" value="<?php echo $row_bj[5];?>" disabled>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">Nº DE CUENTA BANCARIA</h6> 
                        <input type="number" class="form-control" name="cuenta_madre" placeholder="" value="<?php echo $row_bj[6];?>" disabled>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">FECHA DE INSCRIPCIÓN</h6> 
                        <input type="date" class="form-control" name="fecha_inscripcion_bono" value="<?php echo $row_bj[7];?>" disabled>
                    </div>
                </div>

            <!-------------  El niño SI tiene registro de beneficiario bono Juana Azurduy END -----------> 
            <?php  } else {   ?>

            <!-------------  El niño NO tiene registro de beneficiario bono Juana Azurduy - begin ----------->       
            <hr>

            <div class="form-group row"> 
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                <h6 class="text-info">DATOS DE INSCRIPCIÓN - BONO JUANA AZURDUY</h6>
                </div>
            </div>
            <hr>
            <div class="form-group row">  
                    <div class="col-sm-6">
                        <h6 class="text-info">IDENTIFICACIÓN DE LA MADRE EN CARPETA FAMILIAR</h6> 
                    </div>
                    <div class="col-sm-6">
                        <select name="idnombre_madre" id="idnombre_madre" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql_p = " SELECT integrante_cf.idnombre, nombre.paterno, nombre.materno, nombre.nombre, parentesco.parentesco FROM integrante_cf, nombre, parentesco WHERE integrante_cf.idnombre=nombre.idnombre ";
                        $sql_p.= " AND integrante_cf.idparentesco=parentesco.idparentesco AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.idintegrante_cf  ";
                        $result_p = mysqli_query($link,$sql_p);
                        if ($row_p = mysqli_fetch_array($result_p)){
                        mysqli_field_seek($result_p,0);
                        while ($field_p = mysqli_fetch_field($result_p)){
                        } do {
                        echo "<option value=".$row_p[0].">".$row_p[3]." ".$row_p[1]." ".$row_p[2]." - ".$row_p[4]." </option>";
                        } while ($row_p = mysqli_fetch_array($result_p));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">  
                    <div class="col-sm-3">
                        <h6 class="text-info">DIRECCION/DOMICILIO</h6>
                        <textarea class="form-control" rows="2" name="direccion_domicilio" required></textarea> 
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">CELULAR DE LA MADRE</h6> 
                        <input type="number" class="form-control" name="celular_madre" placeholder="" value="" required>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">Nº DE CUENTA BANCARIA</h6> 
                        <input type="number" class="form-control" name="cuenta_madre" placeholder="" value="" >
                    </div>
                    <div class="col-sm-3">
                        <h6 class="text-info">FECHA DE INSCRIPCIÓN AL BONO </h6> 
                        <input type="date" class="form-control" name="fecha_inscripcion_bono" value="<?php echo $fecha;?>" >
                    </div>
                </div>
            <hr>
            <!-------------  El niño NO tiene registro de beneficiario bono Juana Azurduy - end -----------> 

               <?php } ?>


        <?php } else { ?>
            <!-------------  El niño es mayor a 2 año y no corresponde el bono juana azurduy ----------->
        <?php } ?>
        















        <!--------------------------------------------------------->
        <!------------     CONTROL DEL NIÑO SANO - END  --------------->
        <!--------------------------------------------------------->



    <?php    
    break;
    case 2:  
    ?>


    <?php    
    break;    
    } 
    ?>