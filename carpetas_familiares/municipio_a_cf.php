<?php include("../cabf.php");?>
<?php include("../inc.config.php");
$gestion = date("Y");

$idmunicipio = $_POST["municipio_salud_m"];

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);
?>

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">ANALÍTICA - CARPETAS FAMILIARES - MUNICIPIO DE <?php echo mb_strtoupper($row_mun[1]);?></h6>
                    </div>

                    <div class="card-header py-3">
                    <h6 class="text-info">CUADRO INFORMATIVO PARA SEGUIMIENTO</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-2">
                            <h6 class="text-info">TOTAL DE CARPETAS FAMILIARES:</h6>
                            <?php
                            $sql_f =" SELECT sum(area_influencia.familias) FROM area_influencia, establecimiento_salud  ";   
                            $sql_f.=" WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idmunicipio='$idmunicipio' ";
                            $result_f = mysqli_query($link,$sql_f);
                            $row_f = mysqli_fetch_array($result_f);
                            $meta_cf = $row_f[0];

                            $sql_cf =" SELECT count(idcarpeta_familiar) FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' ";
                            $result_cf = mysqli_query($link,$sql_cf);
                            $row_cf = mysqli_fetch_array($result_cf);  
                            $carpetizacion = $row_cf[0];

                            $porcentaje_mun   = ($carpetizacion*100)/$meta_cf;
                            $p_municipio    = number_format($porcentaje_mun, 2, '.', '');

                            $meta_mun    = number_format($meta_cf, 0, '.', '.');
                            $carpetizacion_mun    = number_format($carpetizacion, 0, '.', '.');
                            ?>
                            <?php echo $carpetizacion_mun;?>
                            <h6 class="text-info">De <?php echo $meta_mun;?> Familias</h6>
                            <h6 class="text-primary"><?php echo $p_municipio;?>%</h6>

                            </div>

                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE ESTABLECIMIENTOS DE SALUD:</h6>
                            <?php
                            $sql_mun =" SELECT idestablecimiento_salud FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' GROUP BY idestablecimiento_salud ";
                            $result_mun = mysqli_query($link,$sql_mun);
                            $establecimientos = mysqli_num_rows($result_mun);  
                            ?>
                            <?php echo $establecimientos;?>
                            </br></br>
                            <a href="carpetizacion_operativos_cf.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=920,height=900,scrollbars=YES,top=50,left=600'); return false;"><h6 class="text-primary">CARPETIZACIÓN OPERATIVOS</h6></a>

                            </div>
                            <div class="col-sm-2">
                            <h6 class="text-info">N° DE INTEGRANTES DE FAMILIA REGISTRADOS:</h6>
                            <?php

                            $sql_h =" SELECT sum(area_influencia.habitantes) FROM area_influencia, establecimiento_salud  ";  
                            $sql_h.=" WHERE area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND establecimiento_salud.idmunicipio='$idmunicipio' "; 
                            $result_h = mysqli_query($link,$sql_h);
                            $row_h = mysqli_fetch_array($result_h);

                            $sql_int =" SELECT count(integrante_cf.idintegrante_cf) FROM integrante_cf, carpeta_familiar WHERE integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar ";
                            $sql_int.=" AND carpeta_familiar.estado='CONSOLIDADO' AND integrante_cf.estado='CONSOLIDADO' AND carpeta_familiar.idmunicipio='$idmunicipio' ";
                            $result_int = mysqli_query($link,$sql_int);
                            $row_int = mysqli_fetch_array($result_int);  
                            $integrantes = $row_int[0];

                            $integrantes_cf   = number_format($integrantes, 0, '.', '.');
                            $integrantes_meta = number_format($row_h[0], 0, '.', '.');

                            $porcentaje_hab   = ($integrantes*100)/$row_h[0];
                            $p_habitantes = number_format($porcentaje_hab, 2, '.', ' ');
                            ?>
                            <?php echo $integrantes_cf;?> 
                            <h6 class="text-info">De <?php echo $integrantes_meta;?> Habitantes</h6>
                            <h6 class="text-primary"><?php echo $p_habitantes;?> %</h6>
                            </div>
                            <div class="col-sm-6">
                            <h6 class="text-info">PERSONAL SAFCI REGISTRADOR:</h6>

                            <?php
                                $numero = 1;
                                $sql =" SELECT idusuario FROM carpeta_familiar WHERE estado='CONSOLIDADO' AND idmunicipio='$idmunicipio' GROUP BY idusuario ";   
                                $result = mysqli_query($link,$sql);
                                if ($row = mysqli_fetch_array($result)){
                                mysqli_field_seek($result,0);
                                while ($field = mysqli_fetch_field($result)){
                                } do {

                                    $sql_p =" SELECT nombre.nombre, nombre.paterno, nombre.materno, establecimiento_salud.establecimiento_salud FROM usuarios, nombre, establecimiento_salud, carpeta_familiar  ";
                                    $sql_p.=" WHERE carpeta_familiar.idusuario=usuarios.idusuario AND carpeta_familiar.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud  ";
                                    $sql_p.=" AND  usuarios.idnombre=nombre.idnombre AND carpeta_familiar.idusuario='$row[0]' ";
                                    $result_p = mysqli_query($link,$sql_p);
                                    $row_p = mysqli_fetch_array($result_p);
                                    echo mb_strtoupper($numero.".- ". $row_p[0]." ".$row_p[1]." ".$row_p[2]); 
                                   ?> 
                                    <h6 class="text-info">Establecimiento: <?php echo $row_p[3];?></h6> 

                                    <?php
                                    $numero = $numero+1;

                                }
                                while ($row = mysqli_fetch_array($result));
                                } else {
                                }
                            ?>
                            </div>
                        </div>   
                    </div>
                </div>
                      
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">I. POBLACIÓN DEL MUNICIPIO:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="piramide_poblacional_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PIRÁMIDE POBLACIONAL - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">II. IDIOMA:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="idioma_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=750,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">IDIOMA - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (a). ESTADO CIVIL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estado_civil_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTADO CIVIL - <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (b). NIVEL DE INSTRUCCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_nivel_instruccion_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=760,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">NIVEL DE INSTRUCCIÓN - <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (c). PROFESIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_profesion_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROFESIÓN - <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (d). OCUPACIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ocupacion_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=860,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info"> OCUPACIÓN - <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (e). AUTO-PERTENENCIA CULTURAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_pertenencia_cultural_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=950,height=700,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AUTO-PERTENENCIA CULTURAL - <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IV (f). SUSTENTO FAMILIAR:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_sustento_familiar_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUSTENTO FAMILIAR - <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">II. UBICACIÓN DE LOS ESTABLECIMIENTOS DE SALUD EN EL MUNICIPIO:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="ubicacion_familias_municipio.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">UBICACIÓN GEOGRÁFICA - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">V. SALUD DE LOS INTEGRANTES DE LA FAMILIA MUNICIPIO :</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="salud_integrantes_grafica_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=1200,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">GRUPOS DE SALUD FAMILIAR  - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                 <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VI. SUBSECTOR SALUD:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_subsector_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=800,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SUBSECTOR SALUD - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                       <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VII. BENEFICIARIOS DE PROGRAMAS SOCIALES:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_programa_social_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=560,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">PROGRAMAS SOCIALES - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">VIII. MEDICINA TRADICIONAL:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_medicina_tradicional_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">MEDICINA TRADICIONAL - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                   <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">IX. DEFUNCIÓN:</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_defuncion_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=850,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">DEFUNCIÓN - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                </div>

                <div class="card-body">
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
                        <h6 class="text-info">SERVICIOS BÁSICOS - <?php echo $row_mun[1];?></h6> 
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_mun_1.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Abastecimiento de agua para consumo</h6></a>  
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_mun_2.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Manejo de la Basura</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_mun_3.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Uso de servicio higienico o baño</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_mun_4.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Eliminación de escretas</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_mun_5.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Iluminación de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_mun_6.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Combustible para cocinar</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_servicios_basicos_mun_7.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Acceso a comunicación</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">ESTRUCTURA DE LA VIVIENDA - <?php echo $row_mun[1];?></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_1.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tipo de vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_2.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Techo de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_3.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Paredes de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_4.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">d) Pisos de la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_5.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">e) Revoque en las paredes interiores</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_6.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">f) Tiene cuarto solo para cocinar</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_7.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">g) Riésgos externos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_estructura_vivienda_mun_8.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">h) Riésgos internos con relación a la vivienda</h6></a>  
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">FUNCIONALIDAD DE LA VIVIENDA - <?php echo $row_mun[1];?></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_mun_1.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Tenencia de la vivienda</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_mun_2.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Índice de hacinamiento</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_funcionalidad_vivienda_mun_3.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">c) Tenencia de animales en la vivienda</h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info">SALUD ALIMENTARIA - <?php echo $row_mun[1];?></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_mun_1.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">a) Grados de la seguridad alimentaria:</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="determinante_salud_alimentaria_mun_2.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">b) Consumo diario de alimentos</h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                        <h6 class="text-info"></h6>
                        </div>
                        <div class="col-sm-8">
                        <a href="riesgo_determinante_salud_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=900,height=600,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">RIESGO EN LAS DETERMINANTES DE LA SALUD - Mun. <?php echo $row_mun[1];?> </h6></a>  
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XII. CARACTERÍSTICAS SOCIOECONÓMICAS</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_socioeconomica_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=580,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">SOCIOECONOMÍA DE LOS HOGARES - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIII. TENENCIA DE ANIMALES DOMÉSTICOS DE COMPAÑÍA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_tenencia_animales_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ANIMALES DOMESTICOS EN CADA HOGAR - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. ESTRUCTURA FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_estructura_familiar_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">ESTRUCTURA FAMILIAR - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XV. ETAPA DEL CICLO VITAL FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ciclo_vital_familiar_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">CICLO VITAL FAMILIAR - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVI. FUNCIONALIDAD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_funcionalidad_cf_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=1000,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">FUNCIONALIDAD FAMILIAR - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XVIII. FORMA DE AYUDA FAMILIAR NECESARIA</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_ayuda_familiar_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=520,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">AYUDA FAMILIAR NECESARIA - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                        <h6 class="text-primary">XIV. EVALUACIÓN DE SALUD FAMILIAR</h6>
                        </div>
                        <div class="col-sm-6">
                        <a href="grafica_evaluacion_salud_familiar_mun.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=620,scrollbars=YES,top=50,left=100'); return false;"><h6 class="text-info">EVALUACIÓN SALUD FAMILIAR - Mun. <?php echo $row_mun[1];?></h6></a>  
                        </div>
                    </div> 

                    </div>
   