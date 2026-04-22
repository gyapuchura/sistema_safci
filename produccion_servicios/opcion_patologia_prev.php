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

        <?php
            $sql_hp = " SELECT idhistoria_perinatal, codigo FROM historia_perinatal WHERE idnombre='$idnombre_integrante_ss' ";
            $result_hp = mysqli_query($link,$sql_hp);
            if ($row_hp = mysqli_fetch_array($result_hp)){ 
                
                $sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
                $result_n=mysqli_query($link,$sql_n);
                $row_n=mysqli_fetch_array($result_n);
                ?>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">YA SE CUENTA CON LA HISTORIA CLÍNICA PERINATAL Nº : <?php  echo $row_hp[1];?></h6>
                </div>

               <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-warning">NOMBRE : </h6>
                        </div>
                        <div class="col-sm-8">

                        <input type="text" class="form-control" name="nombre" value="<?php echo mb_strtoupper($row_n[1]." ".$row_n[2]." ".$row_n[3]);?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <h6 class="m-0 font-weight-bold text-warning">GESTACIONES : </h6>
                        </div>
                    </div>
                        
                    <div class="form-group row">
                        <div class="col-sm-12">

                        <table class="table table-bordered">
                        <thead>
                            <tr class="table-warning">
                            <th scope="col">Nº GESTACIÓN</th>
                            <th scope="col">FECHA (F.U.M.)</th>
                            <th scope="col">FECHA PROBABLE DE PARTO</th>
                            <th scope="col">VER ANTECEDENTES</th>
                            <th scope="col">VER CONTROLES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $numero_g=1; 
                            $sql_g =" SELECT idgestacion, fecha_fum, fecha_pp FROM gestacion WHERE idhistoria_perinatal = '$row_hp[0]' ";
                            $result_g = mysqli_query($link,$sql_g);
                            if ($row_g = mysqli_fetch_array($result_g)){
                            mysqli_field_seek($result_g,0);
                            while ($field_g = mysqli_fetch_field($result_g)){
                            } do {
                            ?>

                                <tr>
                                <th scope="row"><?php echo $numero_g;?></th>
                                <td><?php 
                                    $fecha_fu = explode('-', $row_g[1]);
                                    $fecha_fum = $fecha_fu[2].'/'.$fecha_fu[1].'/'.$fecha_fu[0];
                                    echo $fecha_fum; ?>
                                </td>
                                <td>
                                    <?php 
                                    $fecha_fp = explode('-', $row_g[2]);
                                    $fecha_fpp = $fecha_fp[2].'/'.$fecha_fp[1].'/'.$fecha_fp[0];
                                    echo $fecha_fpp; ?>
                                </td>
                                <td>

                                <a class="btn btn-warning btn-icon-split" href="../safci_perinatal/mostrar_antecedentes_hcp.php?idhistoria_perinatal=<?php echo $row_hp[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=900,height=800,top=50, left=700, scrollbars=YES'); return false;">
                                <span class="icon text-white-50">
                                    <i class="fas fa-book"></i>
                                </span>
                                <span class="text">ANTECEDENTES</span></a> 

                                </td>
                                <td>
                                <a class="btn btn-warning btn-icon-split" href="../safci_perinatal/controles_perinatales_hcp.php" target="_blank" onClick="window.open(this.href, this.target, 'width=900,height=800,top=50, left=700, scrollbars=YES'); return false;">
                                <span class="icon text-white-50">
                                    <i class="fas fa-book"></i>
                                </span>
                                <span class="text">CONTROLES</span></a> 
                                </td>
                                </tr>
                            <?php
                            $numero_g=$numero_g+1;
                            }
                            while ($row_g = mysqli_fetch_array($result_g));
                            } else {
                            }
                            ?>

                        </tbody>
                        </table>
                        
                        </div>
                    </div>
                </div>
                                 
                </div>
            </div>

            <?php  } else {   ?>

        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">SE DEBE INICIAR LA HISTORIA CLINICA PERINATAL :</h6>
        </div>

        <div class="card-body">

            <div class="form-group row"> 
                <div class="col-sm-6"> 
                <h6 class="text-warning"></h6>           
                </div>
                <div class="col-sm-6"> 
                <a class="btn btn-warning btn-icon-split" href="../safci_perinatal/inicia_hc_perinatal.php" target="_blank" onClick="window.open(this.href, this.target, 'width=900,height=800,top=50, left=700, scrollbars=YES'); return false;">
                <span class="icon text-white-50">
                    <i class="fas fa-book"></i>
                </span>
                <span class="text">NUEVA HISTORIA CLINICA PERINATAL</span></a> 
                
                </div> 
            </div>

        </div>
        </div>

            <?php  } ?>

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

        <?php  if ($edad_ss < '2') { ?>
            <!-------------  El niño es menor a 2 años y corresponde el bono juana azurduy ----------->   
            <?php
            $sql_bj = " SELECT idnombre_nino, idnombre_madre, nino_carpetizado, numero_controles, direccion_domicilio, celular_madre, cuenta_madre, ";
            $sql_bj.= " fecha_inscripcion_bono, idbono_nino_sano FROM bono_nino_sano  WHERE idnombre_nino='$idnombre_integrante_ss' ";
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
                    <div class="col-sm-3"></br></br>
                            <a class="btn btn-warning btn-icon-split" href="../safci_perinatal/imprime_bja_nino.php?idbono_nino_sano=<?php echo $row_bj[8];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=950,height=800,top=50, left=600, scrollbars=YES'); return false;">
                            <span class="icon text-white-50">
                                <i class="fas fa-user"></i>
                            </span>
                            <span class="text">FORMULARIO DE CONTROLES</span></a>  
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
                    <div class="col-sm-8">
                        <h6 class="text-info">IDENTIFICACIÓN DE LA MADRE EN CARPETA FAMILIAR</h6> 
                        <select name="idnombre_madre" id="idnombre_madre" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql_p = " SELECT integrante_cf.idnombre, nombre.paterno, nombre.materno, nombre.nombre, parentesco.parentesco, integrante_cf.edad FROM integrante_cf, nombre, parentesco WHERE integrante_cf.idnombre=nombre.idnombre ";
                        $sql_p.= " AND integrante_cf.idparentesco=parentesco.idparentesco AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ORDER BY integrante_cf.idintegrante_cf  ";
                        $result_p = mysqli_query($link,$sql_p);
                        if ($row_p = mysqli_fetch_array($result_p)){
                        mysqli_field_seek($result_p,0);
                        while ($field_p = mysqli_fetch_field($result_p)){
                        } do {
                        echo "<option value=".$row_p[0].">".$row_p[3]." ".$row_p[1]." ".$row_p[2]." - ".$row_p[4]." - Edad : ".$row_p[5]." años </option>";
                        } while ($row_p = mysqli_fetch_array($result_p));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">PARENTESCO RESPECTO AL NIÑO/NIÑA</h6> 
                        <select name="idparentesco" id="idparentesco" class="form-control" required>
                        <option value="">-SELECCIONE-</option>
                        <?php
                        $sql_p = " SELECT idparentesco, parentesco FROM parentesco ORDER BY parentesco ";
                        $result_p = mysqli_query($link,$sql_p);
                        if ($row_p = mysqli_fetch_array($result_p)){
                        mysqli_field_seek($result_p,0);
                        while ($field_p = mysqli_fetch_field($result_p)){
                        } do {
                        echo "<option value=".$row_p[0].">".$row_p[1]."</option>";
                        } while ($row_p = mysqli_fetch_array($result_p));
                        } else {
                        echo "No se encontraron resultados!";
                        }
                        ?>
                        </select>
                    </div>

                </div>
                <div class="form-group row">  
                    <div class="col-sm-4">
                        <h6 class="text-info">LUGAR DE NACIMIENTO DEL NIÑO/NIÑA</h6> 
                        <textarea class="form-control" rows="2" name="lug_nac_nino" required></textarea> 
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">LUGAR DE NACIMIENTO DEL TITULAR DE PAGO</h6> 
                        <textarea class="form-control" rows="2" name="lug_nac_madre" required></textarea> 
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">DIRECCION/DOMICILIO</h6>
                        <textarea class="form-control" rows="2" name="direccion_domicilio" required></textarea> 
                    </div>
                </div>
                <div class="form-group row">  
                    <div class="col-sm-4">
                        <h6 class="text-info">CELULAR DE LA MADRE</h6> 
                        <input type="number" class="form-control" name="celular_madre" placeholder="" value="" required>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-info">Nº DE CUENTA BANCARIA</h6> 
                        <input type="number" class="form-control" name="cuenta_madre" placeholder="" value="" >
                    </div>
                    <div class="col-sm-4">
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