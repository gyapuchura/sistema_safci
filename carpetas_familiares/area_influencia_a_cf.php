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
                            $sql_f =" SELECT habitantes, familias FROM area_influencia WHERE idarea_influencia='$idarea_influencia' ";   
                            $result_f = mysqli_query($link,$sql_f);
                            $row_f = mysqli_fetch_array($result_f);
                            $meta_cf = $row_f[1];

                            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idarea_influencia='$idarea_influencia' ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $carpetizacion = $row_cf[0];

                            $porcentaje_af   = ($carpetizacion*100)/$meta_cf;
                            $p_area_influencia    = number_format($porcentaje_af, 2, '.', '.');

                            $meta_af   = number_format($meta_cf, 0, '.', '.');
                            $carpetizacion_af    = number_format($carpetizacion, 0, '.', '.');

                            ?>
                            <?php echo $carpetizacion_af;?> 
                            <h6 class="text-info">De <?php echo $meta_af;?> Familias</h6>
                            <h6 class="text-primary"><?php echo $p_area_influencia;?>%</h6>

                            </div>

                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php

                            $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar  ";
                            $sql_int.=" WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_cf.estado='CONSOLIDADO' ";
                            $sql_int.=" AND carpeta_familiar.idarea_influencia='$idarea_influencia' ";
                            $result_int = mysqli_query($link,$sql_int);
                            $row_int = mysqli_fetch_array($result_int);  
                            $integrantes = $row_int[0];

                            $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                            $integrantes_meta = number_format($row_f[0], 0, '.', '.');

                            $porcentaje_hab   = ($integrantes*100)/$integrantes_meta;
                            $p_habitantes = number_format($porcentaje_hab, 2, '.', ' ');

                            ?>
                            <?php echo $integrantes_cf;?>
                            <h6 class="text-info">de <?php echo $integrantes_meta;?> habitantes</h6>
                            <h6 class="text-primary"><?php echo $p_habitantes;?> %</h6>  
                            </div>
                            <div class="col-sm-4">
                            <h6 class="text-info">PERSONAL SAFCI REGISTRADOR:</h6>
                            <?php
                                $numero = 1;
                                $sql =" SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idarea_influencia='$idarea_influencia' GROUP BY idusuario ";   
                                $result = mysqli_query($link,$sql);
                                if ($row = mysqli_fetch_array($result)){
                                mysqli_field_seek($result,0);
                                while ($field = mysqli_fetch_field($result)){
                                } do {

                                    $sql_p =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre  ";
                                    $sql_p.=" WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row[0]' ";
                                    $result_p = mysqli_query($link,$sql_p);
                                    $row_p = mysqli_fetch_array($result_p);
                                    echo mb_strtoupper($numero.".- ". $row_p[0]." ".$row_p[1]." ".$row_p[2]."</br>");
                                    $numero = $numero+1;

                                }
                                while ($row = mysqli_fetch_array($result));
                                } else {
                                }
                            ?>
                            <?php ?>
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
                        <h6 class="text-primary">I. POBLACIÓN NIVEL ÁREA DE INFLUENCIA :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">II. IDIOMA :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="idioma_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=850,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">IDIOMA - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (a). ESTADO CIVIL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estado_civil_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTADO CIVIL - ÁREA DE INFLUENCIA <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (b). NIVEL DE INSTRUCCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_nivel_instruccion_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=760,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">NIVEL DE INSTRUCCIÓN - ÁREA DE INFLUENCIA <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (c). PROFESIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_profesion_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROFESIÓN - ÁREA DE INFLUENCIA <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (d). OCUPACIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ocupacion_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">OCUPACIÓN - ÁREA DE INFLUENCIA <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (e). AUTO-PERTENENCIA CULTURAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_pertenencia_cultural_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AUTO-PERTENENCIA CULTURAL - ÁREA DE INFLUENCIA <?php echo $area_af;?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (f). SUSTENTO FAMILIAR:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_sustento_familiar_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUSTENTO FAMILIAR - ÁREA DE INFLUENCIA <?php echo $area_af;?></h6></a>  
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
                        <a href="grafica_medicina_tradicional_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">MEDICINA TRADICIONAL - ÁREA DE INFLUENCIA  : <?php echo $area_af;?> </h6></a>  
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

         
                <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XI. DETERMINANTES DE LA SALUD</h6>
                        </div>
                        <div class="col-sm-6">
                         
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">SERVICIOS BÁSICOS - <?php echo $area_af;?></h6> 
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af_1.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Abastecimiento de agua para consumo</h6></a>  
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af_2.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Manejo de la Basura</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af_3.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Uso de servicio higienico o baño</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af_4.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Eliminación de escretas</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af_5.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Iluminación de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af_6.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Combustible para cocinar</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_af_7.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Acceso a comunicación</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">ESTRUCTURA DE LA VIVIENDA - <?php echo $area_af;?></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_1.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tipo de vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_2.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Techo de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_3.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Paredes de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_4.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Pisos de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_5.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Revoque en las paredes interiores</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_6.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Tiene cuarto solo para cocinar</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_7.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Riésgos externos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_af_8.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">h) Riésgos internos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA - <?php echo $area_af;?></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_af_1.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tenencia de la vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_af_2.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Índice de hacinamiento</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_af_3.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Tenencia de animales en la vivienda</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">SALUD ALIMENTARIA - <?php echo $area_af;?></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_af_1.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Grados de la seguridad alimentaria:</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_af_2.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Consumo diario de alimentos</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-8">
                        <a href="riesgo_determinante_salud_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">RIESGO DE LAS DETERMINANTES DE LA SALUD - ÁREA DE INFLUENCIA  : <?php echo $area_af;?> </h6></a>  
                        </div>
                    </div>
                    <hr>


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
                        <a href="grafica_evaluacion_funcionalidad_cf_af.php?idarea_influencia=<?php echo $idarea_influencia;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=1000,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD FAMILIAR - ÁREA DE INFLUENCIA  : <?php echo $area_af;?></h6></a>  
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
   