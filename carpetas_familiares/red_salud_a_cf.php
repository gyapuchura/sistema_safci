<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idred_salud = $_POST["red_salud_cf"];

$sql_red = " SELECT idred_salud, red_salud FROM red_salud WHERE idred_salud='$idred_salud' ";
$result_red = mysqli_query($link,$sql_red);
$row_red = mysqli_fetch_array($result_red);
?>

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES - RED DE SALUD DE <?php echo mb_strtoupper($row_red[1]);?></h6>
                    </div>

                    <div class="card-header py-3">
                    <h6 class="text-info">CUADRO INFORMATIVO PARA SEGUIMIENTO</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-2">
                            <h6 class="text-info">TOTAL DE CARPETAS FAMILIARES:</h6>
                            <?php
                            $sql_cf =" SELECT count(carpeta_familiar.idcarpeta_familiar) FROM carpeta_familiar, ubicacion_cf ";
                            $sql_cf.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                            $sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $total_cf = $row_cf[0];
                            ?>
                            <?php echo $total_cf;?>
                            <h6></h6>
                            </div>

                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE ESTABLECIMIENTOS DE SALUD:</h6>
                            <?php
                            $sql_red =" SELECT ubicacion_cf.idestablecimiento_salud FROM carpeta_familiar, ubicacion_cf ";
                            $sql_red.=" WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO' ";
                            $sql_red.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idred_salud='$idred_salud' GROUP BY ubicacion_cf.idestablecimiento_salud ";
                            $result_red = mysqli_query($link,$sql_red);
                            $establecimientos = mysqli_num_rows($result_red);  
                            ?>
                            <?php echo $establecimientos;?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php
                            $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar, ubicacion_cf  ";
                            $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_int.=" AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
                            $sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' ";
                            $result_int = mysqli_query($link,$sql_int);
                            $row_int = mysqli_fetch_array($result_int);  
                            $integrantes = $row_int[0];
                            ?>
                            <?php echo $integrantes;?> 
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE PERSONAL SAFCI REGISTRADOR:</h6>

                            <?php
                            $sql_per = " SELECT carpeta_familiar.idusuario FROM carpeta_familiar, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_per.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idred_salud='$idred_salud' GROUP BY carpeta_familiar.idusuario ";
                            $result_per = mysqli_query($link,$sql_per);
                            $personal = mysqli_num_rows($result_per);  
                            ?>
                            <?php echo $personal;?>
                            <h6></h6>
                            </div>
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>   
                    </div>
                </div>
                     
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">I. POBLACIÓN EN LA RED DE SALUD:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">II. IDIOMA:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="idioma_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=850,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">IDIOMA - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">V. SALUD DE LOS INTEGRANTES DE LA FAMILIA DE LA RED DE SALUD :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="salud_integrantes_grafica_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">GRUPOS DE SALUD FAMILIAR  - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                 <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VI. SUBSECTOR SALUD:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_subsector_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUBSECTOR SALUD - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                       <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VII. BENEFICIARIOS DE PROGRAMAS SOCIALES:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_programa_social_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROGRAMAS SOCIALES - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VIII. MEDICINA TRADICIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_medicina_tradicional_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">MEDICINA TRADICIONAL - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IX. DEFUNCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_defuncion_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">DEFUNCIÓN - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                </div>

               <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XI. DETERMINANTES DE LA SALUD</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SERVICIOS BÁSICOS - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                     <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_servicios_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo en los Servicios Básicos - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA DE LA VIVIENDA - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                   <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_estructura_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo Estructural de la Vivienda - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                       <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_funcionalidad_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo Funcional de la Vivienda - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SALUD ALIMENTARIA - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_alimentario_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo de la Seguridad Alimentaria - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XII. CARACTERÍSTICAS SOCIOECONÓMICAS</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_socioeconomica_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SOCIOECONOMÍA DE LOS HOGARES - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIII. TENENCIA DE ANIMALES DOMÉSTICOS DE COMPAÑÍA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_tenencia_animales_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANIMALES DOMESTICOS EN CADA HOGAR - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. ESTRUCTURA FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estructura_familiar_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA FAMILIAR - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XV. ETAPA DEL CICLO VITAL FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ciclo_vital_familiar_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">CICLO VITAL FAMILIAR - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVI. FUNCIONALIDAD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_funcionalidad_cf_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=720,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD FAMILIAR - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVIII. FORMA DE AYUDA FAMILIAR NECESARIA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ayuda_familiar_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AYUDA FAMILIAR NECESARIA - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. EVALUACIÓN DE SALUD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_salud_familiar_red.php?idred_salud=<?php echo $idred_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=620,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">EVALUACIÓN SALUD FAMILIAR - Red de Salud: <?php echo $row_red[1];?></h6></a>  
                        </div>
                    </div> 

                    </div>
   