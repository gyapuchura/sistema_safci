<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idmunicipio = $_POST["municipio_salud_m"];

$sql_est = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_est = mysqli_query($link,$sql_est);
$row_est = mysqli_fetch_array($result_est);
?>

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES - MUNICIPIO DE <?php echo mb_strtoupper($row_est[1]);?></h6>
                    </div>
                     
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">I. POBLACIÓN DEL MUNICIPIO:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">V. SALUD DE LOS INTEGRANTES DE LA FAMILIA MUNICIPIO :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="salud_integrantes_grafica_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">GRUPOS DE SALUD FAMILIAR  - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                 <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VI. SUBSECTOR SALUD:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_subsector_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUBSECTOR SALUD - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                       <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VII. BENEFICIARIOS DE PROGRAMAS SOCIALES:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_programa_social_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROGRAMAS SOCIALES - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VIII. MEDICINA TRADICIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_medicina_tradicional_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">MEDICINA TRADICIONAL - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IX. DEFUNCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_defuncion_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">DEFUNCIÓN - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                </div>

               <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XI. DETERMINANTES DE LA SALUD</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SERVICIOS BÁSICOS - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                     <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_servicios_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo en los Servicios Básicos - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA DE LA VIVIENDA - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                   <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_estructura_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo Estructural de la Vivienda - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                       <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_funcionalidad_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo Funcional de la Vivienda - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SALUD ALIMENTARIA - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_alimentario_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo de la Seguridad Alimentaria - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XII. CARACTERÍSTICAS SOCIOECONÓMICAS</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_socioeconomica_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SOCIOECONOMÍA DE LOS HOGARES - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIII. TENENCIA DE ANIMALES DOMÉSTICOS DE COMPAÑÍA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_tenencia_animales_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANIMALES DOMESTICOS EN CADA HOGAR - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. ESTRUCTURA FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estructura_familiar_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA FAMILIAR - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XV. ETAPA DEL CICLO VITAL FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ciclo_vital_familiar_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">CICLO VITAL FAMILIAR - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVI. FUNCIONALIDAD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_funcionalidad_cf_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=720,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD FAMILIAR - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVIII. FORMA DE AYUDA FAMILIAR NECESARIA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ayuda_familiar_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AYUDA FAMILIAR NECESARIA - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. EVALUACIÓN DE SALUD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_salud_familiar_est.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=620,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">EVALUACIÓN SALUD FAMILIAR - Mun. <?php echo $row_est[1];?></h6></a>  
                        </div>
                    </div> 

                    </div>
   