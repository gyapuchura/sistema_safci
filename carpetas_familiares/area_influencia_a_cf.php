<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idarea_influencia = $_POST["area_influencia_af"];

$sql_area = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia FROM area_influencia, tipo_area_influencia ";
$sql_area.= " WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idarea_influencia='$idarea_influencia' ";
$result_area = mysqli_query($link,$sql_area);
$row_area = mysqli_fetch_array($result_area);
$area_af = $row_area[1]." ".$row_area[2];

?>
<!--- funcion mostrar cuadro informativo --->
            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES EN EL ÁREA DE INFLUENCIA : <?php echo mb_strtoupper($area_af);?></h6>
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
                            $sql_cf.=" AND ubicacion_cf.ubicacion_actual='SI' AND ubicacion_cf.idarea_influencia='$idarea_influencia' ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $total_cf = $row_cf[0];
                            ?>
                            <?php echo $total_cf;?>
                            <h6></h6>
                            </div>

                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php
                            $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar, ubicacion_cf  ";
                            $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_int.=" AND ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND carpeta_familiar.estado='CONSOLIDADO'  ";
                            $sql_int.=" AND integrante_cf.estado='CONSOLIDADO' AND ubicacion_cf.idarea_influencia='$idarea_influencia' ";
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
                            $sql_per.= " AND carpeta_familiar.estado='CONSOLIDADO' AND ubicacion_cf.idarea_influencia='$idarea_influencia' GROUP BY carpeta_familiar.idusuario ";
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
                            <div class="col-sm-2">
                            </div>
                        </div>   
                    </div>
                </div>    
                     
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">I. POBLACIÓN NIVEL ÁREA DE INFLUENCIA :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">II. UBICACIÓN GEOGRÁFICA DE LAS FAMILIAS:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="ubicacion_familias_area_influencia.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">UBICACIÓN GEOGRÁFICA DE LAS FAMILIAS - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">V. SALUD DE LOS INTEGRANTES DE LA FAMILIA :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="salud_integrantes_grafica_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">GRUPOS DE SALUD FAMILIAR  - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                 <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VI. SUBSECTOR SALUD - ÁREA DE INFLUENCIA :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_subsector_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUBSECTOR SALUD - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                       <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VII. BENEFICIARIOS DE PROGRAMAS SOCIALES:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_programa_social_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROGRAMAS SOCIALES - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VIII. MEDICINA TRADICIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_medicina_tradicional_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">MEDICINA TRADICIONAL - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IX. DEFUNCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_defuncion_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">DEFUNCIÓN - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                </div>

               <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XI. DETERMINANTES DE LA SALUD</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SERVICIOS BÁSICOS - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                     <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_servicios_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo en los Servicios Básicos - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA DE LA VIVIENDA - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                   <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_estructura_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo Estructural de la Vivienda - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                       <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_funcionalidad_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo Funcional de la Vivienda - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SALUD ALIMENTARIA - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-7">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-5">
                        <a href="calcula_riesgo_alimentario_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">-> Riésgo de la Seguridad Alimentaria - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XII. CARACTERÍSTICAS SOCIOECONÓMICAS</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_socioeconomica_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SOCIOECONOMÍA DE LOS HOGARES - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIII. TENENCIA DE ANIMALES DOMÉSTICOS DE COMPAÑÍA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_tenencia_animales_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANIMALES DOMESTICOS EN CADA HOGAR - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. ESTRUCTURA FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estructura_familiar_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA FAMILIAR - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XV. ETAPA DEL CICLO VITAL FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ciclo_vital_familiar_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">CICLO VITAL FAMILIAR - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVI. FUNCIONALIDAD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_funcionalidad_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=720,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD FAMILIAR - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVIII. FORMA DE AYUDA FAMILIAR NECESARIA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ayuda_familiar_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AYUDA FAMILIAR NECESARIA - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. EVALUACIÓN DE SALUD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_salud_familiar_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=620,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">EVALUACIÓN SALUD FAMILIAR - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div> 

                    </div>
   