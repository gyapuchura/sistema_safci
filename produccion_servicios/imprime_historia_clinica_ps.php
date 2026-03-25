<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");
 
$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss      = $_GET['idcarpeta_familiar'];
$idintegrante_cf_ss         = $_GET['idintegrante_cf'];
$idnombre_integrante_ss     = $_GET['idnombre_integrante'];


$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);

$sql_n =" SELECT nombre.idnombre, nombre.nombre, nombre.paterno, nombre.materno, nombre.ci, nombre.fecha_nac, nacionalidad.nacionalidad, genero.genero  ";
$sql_n.=" FROM nombre, genero, nacionalidad WHERE nombre.idgenero=genero.idgenero AND nombre.idnacionalidad=nacionalidad.idnacionalidad AND nombre.idnombre='$idnombre_integrante_ss'  ";
$result_n=mysqli_query($link,$sql_n);
$row_n=mysqli_fetch_array($result_n);
        
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>HISTORIA CLINICA</title>
</head>
<body>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="197"><img src="../implementacion_safci/mds_logo.jpg" width="193" height="85" alt=""/></td>
      <td width="546"><p style="text-align: center; font-family: Arial; font-size: 24px;"><strong>HISTORIA CLÍNICA</strong></p></td>
      <td width="151"><img src="../implementacion_safci/logo_safci_doc.png" width="126" height="84" alt=""/></br>
      </br><span style="font-family: Arial; font-size: 9px;">Código R.A. - SALUD INE 101/2010</span></td>
    </tr>
    <tr>
      <td colspan="3"><table width="900" border="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="792" colspan="5" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">A. DATOS ADMINISTRATIVOS</td>
            </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5"><table width="900" border="0">
              <tbody>
                <tr>
                  <td width="502">
                  <?php  
                    $sql_pr =" SELECT nombre.paterno, nombre.materno, nombre.nombre, nombre.fecha_nac, genero.genero, profesion.profesion, integrante_datos_cf.ocupacion, ";
                    $sql_pr.=" ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.nombre_edificio, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, ";
                    $sql_pr.=" municipios.municipio, provincias.provincia, establecimiento_salud.establecimiento_salud, red_salud.red_salud, integrante_cf.idparentesco FROM nombre, genero, integrante_cf, integrante_datos_cf, ";
                    $sql_pr.=" carpeta_familiar, ubicacion_cf, profesion, red_salud, municipios, provincias, establecimiento_salud, area_influencia, tipo_area_influencia WHERE nombre.idgenero=genero.idgenero AND ";
                    $sql_pr.=" integrante_cf.idnombre=nombre.idnombre AND integrante_datos_cf.idintegrante_cf=integrante_cf.idintegrante_cf AND integrante_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND  ";
                    $sql_pr.=" ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND integrante_datos_cf.idprofesion=profesion.idprofesion AND ubicacion_cf.idred_salud=red_salud.idred_salud AND ";
                    $sql_pr.=" ubicacion_cf.idmunicipio=municipios.idmunicipio AND ubicacion_cf.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud AND ";
                    $sql_pr.=" area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND ubicacion_cf.idarea_influencia=area_influencia.idarea_influencia AND ";
                    $sql_pr.=" municipios.idprovincia=provincias.idprovincia AND carpeta_familiar.idcarpeta_familiar='$idcarpeta_familiar_ss' AND  integrante_cf.idparentesco='1' ";
                    $result_pr=mysqli_query($link,$sql_pr);
                    if ($row_pr=mysqli_fetch_array($result_pr)) {
                      
                  ?>
                  <table width="502" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td width="149" rowspan="9" style="font-family: Arial; font-size: 9px; text-align: center;">Sello Institucional</td>
                        <td colspan="2" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">RESPONSABLE DE FAMILIA</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Apellido Paterno: <?php echo $row_pr[0];?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Apellido Materno: <?php echo $row_pr[1];?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Nombres: <?php echo $row_pr[2];?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="177" style="font-family: Arial; font-size: 12px;">Fecha de nacimiento: 
                          <?php 
                          $fecha_n = explode('-', $row_pr[3]);
                          $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                          echo $fecha_nac; ?></td>
                        <td width="162" style="font-family: Arial; font-size: 12px;">Sexo: <?php echo $row_pr[4];?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Ocupación: ..... Productivas: <?php echo $row_pr[5];?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Reproductivas: <?php echo $row_pr[6];?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Gestión Comunitaria:</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Establecimiento: </td>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Dirección: <?php echo $row_pr[7];?> <?php echo $row_pr[8];?> <?php echo $row_pr[9];?></td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;"><?php echo $row_pr[14];?></td>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Comunidad: <?php echo $row_pr[10];?> <?php echo $row_pr[11];?></td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Red de Salud: <?php echo $row_pr[15];?></td>
                        <td style="font-family: Arial; font-size: 12px;">Municipio: <?php echo $row_pr[12];?></td>
                        <td style="font-family: Arial; font-size: 12px;">Provincia: <?php echo $row_pr[13];?></td>
                      </tr>
                    </tbody>
                  </table>
                <?php } ?>
                
                </td>
                  <td width="54">&nbsp;</td>
                  <td width="332" valign="top"><table width="333" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td width="110" style="font-family: Arial; font-size: 12px;">No. H.C.</td>
                        <td width="212" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">No Carpeta Familiar</td>
                        <td style="font-family: Arial; font-size: 12px;"><?php echo $row_cf[1];?></td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">No SUMI</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">B. IDENTIFICACION DEL PACIENTE / USUARIO</td>
          </tr>
          <tr>
            <td colspan="5"><table width="900" border="1" cellspacing="0">
              <tbody>
                <tr>
                  <td width="175" style="font-family: Arial; font-size: 12px;">Apellido Paterno: </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[2];?></td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Apellido Materno:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[3];?></td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Nombres:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[1];?></td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Fecha de nacimiento: </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">
                    <?php 
                    $fecha_n = explode('-',$row_n[5]);
                    $fecha_nac = $fecha_n[2].'/'.$fecha_n[1].'/'.$fecha_n[0];
                    echo $fecha_nac; ?></td>
                  <td width="81" style="font-family: Arial; font-size: 12px;">Sexo: </td>
                  <td width="81" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[7];?></td>
                  <td width="77" style="font-family: Arial; font-size: 12px;">Procedencia: </td>
                  <td width="74" style="font-family: Arial; font-size: 12px;"><?php echo $row_n[6];?></td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Fecha de Ingreso: </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                      <?php
                        $sql4 =" SELECT integrante_datos_cf.idintegrante_datos_cf, estado_civil.estado_civil, nivel_instruccion.nivel_instruccion, profesion.profesion, integrante_datos_cf.ocupacion, contribuye_cf.contribuye_cf ";
                        $sql4.=" FROM integrante_datos_cf, estado_civil, nivel_instruccion, profesion, contribuye_cf WHERE integrante_datos_cf.idestado_civil=estado_civil.idestado_civil ";
                        $sql4.=" AND integrante_datos_cf.idnivel_instruccion=nivel_instruccion.idnivel_instruccion AND integrante_datos_cf.idprofesion=profesion.idprofesion ";
                        $sql4.=" AND integrante_datos_cf.idcontribuye_cf=contribuye_cf.idcontribuye_cf AND integrante_datos_cf.idintegrante_cf='$idintegrante_cf_ss'";
                        $result4 = mysqli_query($link,$sql4);
                        $row4 = mysqli_fetch_array($result4);
                      ?>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Idioma Hablado:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">
                    <?php                                     
                        $sql_idh =" SELECT idioma.idioma FROM idioma_cf, idioma WHERE idioma_cf.ididioma=idioma.ididioma  ";
                        $sql_idh.=" AND idioma_cf.idorigen_idioma='2' AND idioma_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                        $result_idh = mysqli_query($link,$sql_idh);
                        if ($row_idh = mysqli_fetch_array($result_idh)) {
                         echo $row_idh[0];
                        } 
                        ?></td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Idioma Materno:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">
                        <?php                                     
                        $sql_idm =" SELECT idioma.idioma FROM idioma_cf, idioma WHERE idioma_cf.ididioma=idioma.ididioma  ";
                        $sql_idm.=" AND idioma_cf.idorigen_idioma='1' AND idioma_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                        $result_idm = mysqli_query($link,$sql_idm);
                        if ($row_idm = mysqli_fetch_array($result_idm)) {
                         echo $row_idm[0];
                        } ?>
                  </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Auto pertenencia cultural:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">
                    <?php                                     
                        $sql_nac =" SELECT nacion.nacion FROM integrante_cf, nacion WHERE integrante_cf.idnacion=nacion.idnacion  ";
                        $sql_nac.=" AND integrante_cf.idnombre='$idnombre_integrante_ss' AND integrante_cf.idcarpeta_familiar='$idcarpeta_familiar_ss' ";
                        $result_nac = mysqli_query($link,$sql_nac);
                        if ($row_nac = mysqli_fetch_array($result_nac)) {
                         echo $row_nac[0];
                        } ?>
                  </td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Ocupación: Productivas:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row4[3];?></td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Reproductivas:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row4[4];?></td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Gestión Comunitaria:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">¿Quién (s) decidieron para que acuda al servicio de salud? </td>
                  <td width="60" style="font-family: Arial; font-size: 12px;">Pareja </td>
                  <td width="73" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td style="font-family: Arial; font-size: 12px;">Hijo/a (s) </td>
                  <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td style="font-family: Arial; font-size: 12px;">Otro familiar</td>
                  <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td width="68" style="font-family: Arial; font-size: 12px;">Usted mismo </td>
                  <td width="49" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td width="57" style="font-family: Arial; font-size: 12px;">Otro</td>
                  <td width="59" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Estado civil:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row4[1];?></td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Escolaridad:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;"><?php echo $row4[2];?></td>
                  <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Grupo Sanguíneo:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Factor Rh: </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Otros: </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr>
            <td colspan="5"><table width="900" border="0">
              <tbody>
                <tr>
                  <td width="300" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">C. ANTECEDENTES PEDIATRICOS</td>
                  <td colspan="3" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">E. ANTECEDENTES GINECO-OBSTETRICOS</td>
                  </tr>
                <tr>
                  <td><table width="300" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td width="80" style="font-family: Arial; font-size: 12px;">Peso RN:</td>
                        <td width="62" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td width="83" style="font-family: Arial; font-size: 12px;">Tipo de Parto</td>
                        <td width="57" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Obs. Perinatales:</td>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="3" style="font-family: Arial; font-size: 12px;">Lactancia: exclusiva/periódica (meses)</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                    <table width="300" border="1" cellspacing="0">
                      <tbody>
                        <tr>
                          <td colspan="6" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">D. VACUNAS</td>
                          </tr>
                        <tr>
                          <td width="178" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td width="22" style="font-family: Arial; font-size: 12px;">1</td>
                          <td width="18" style="font-family: Arial; font-size: 12px;">2</td>
                          <td width="18" style="font-family: Arial; font-size: 12px;">3</td>
                          <td width="18" style="font-family: Arial; font-size: 12px;">4</td>
                          <td width="20" style="font-family: Arial; font-size: 12px;">5</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">BCG</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Polio</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">DPT</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Pentavalente</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Sarampión</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Triple vírica</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Fiebre amarilla</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Hepatitis B</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">D.T.</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="315" valign="top" style="font-family: Arial; font-size: 12px;"><table width="300" border="0">
                    <tbody>
                      <tr>
                        <td>EMBARAZOS</td>
                        <td>G : </td>
                        <td>P: </td>
                        <td>A : </td>
                        <td>C : </td>
                      </tr>
                    </tbody>
                  </table>
                    <table width="300" border="1" cellspacing="0">
                      <tbody>
                        <tr>
                          <td rowspan="2" style="text-align: center">Año </td>
                          <td rowspan="2" style="text-align: center">Duración meses</td>
                          <td colspan="2" style="text-align: center">Tipo de Parto</td>
                          <td colspan="2" style="text-align: center">No. De RN(s)</td>
                          <td rowspan="2" style="text-align: center">Aborto</td>
                        </tr>
                        <tr>
                          <td style="text-align: center">Vaginal</td>
                          <td style="text-align: center">Cesarea</td>
                          <td style="text-align: center">vivo(s) </td>
                          <td style="text-align: center">muerto(s)</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="150" valign="top" style="font-family: Arial; font-size: 12px;"><table width="150" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td colspan="2" style="text-align: center">PAP</td>
                        </tr>
                      <tr>
                        <td style="text-align: center">Fecha</td>
                        <td style="text-align: center">Resultado</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table></td>
                  <td width="150" valign="top" style="font-family: Arial; font-size: 12px;"><table width="150" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td colspan="2" style="text-align: center">Anticoncepción</td>
                        </tr>
                      <tr>
                        <td style="text-align: center">Inicio </td>
                        <td style="text-align: center">Método</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td colspan="5"><table width="900" border="0">
              <tbody>
                <tr>
                  <td width="240" valign="top"><table width="300" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td colspan="3" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">F. ANTECEDENTES PATOLOGICOS</td>
                        </tr>
                      <tr>
                        <td width="166" style="font-family: Arial; font-size: 12px;">Hospitalizaciones por:</td>
                        <td width="46" style="font-family: Arial; font-size: 12px;">Año</td>
                        <td width="74" style="font-family: Arial; font-size: 12px;">Evolución</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                    <table width="300" border="1" cellspacing="0">
                      <tbody>
                        <tr>
                          <td bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">I. FACTORES DE RIESGO SOCIALES</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Procedencia :</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Viajes a:</td>
                        </tr>
                        <tr>
                          <td style="font-family: Arial; font-size: 12px;">Otros:</td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="283" valign="top"><table width="300" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td colspan="4" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">G. MEDICAMENTOS EN ENF. CRONICAS</td>
                        </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Inicio </td>
                        <td style="font-family: Arial; font-size: 12px;">Medicamento </td>
                        <td style="font-family: Arial; font-size: 12px;">Dosificación</td>
                        <td style="font-family: Arial; font-size: 12px;">Final</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                       <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                    <table width="300" border="1" cellspacing="0">
                      <tbody>
                        <tr>
                          <td bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">J. OBSERVACIONES</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="363" valign="top"><table width="300" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;"> H. FACTORES DE RIESGO</td>
                        <td bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">PERSONAL</td>
                        <td bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #ffffff;">FAMILIAR</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Hipertensión Arterial Sistémica</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                        <?php                                     
                        $sql_fr1 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '9' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' AND idintegrante_cf = '$idintegrante_cf_ss' ";
                        $result_fr1 = mysqli_query($link,$sql_fr1);
                        if ($row_fr1 = mysqli_fetch_array($result_fr1)) {
                         echo 'X';
                        } ?>
                          </td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                        <?php                                     
                        $sql_fr1 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '9' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
                        $result_fr1 = mysqli_query($link,$sql_fr1);
                        if ($row_fr1 = mysqli_fetch_array($result_fr1)) {
                         echo 'X';
                        } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Diabetes</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                        <?php                                     
                        $sql_fr2 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '10' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' AND idintegrante_cf = '$idintegrante_cf_ss' ";
                        $result_fr2 = mysqli_query($link,$sql_fr2);
                        if ($row_fr2 = mysqli_fetch_array($result_fr2)) {
                         echo 'X';
                        } ?>
                        </td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                        <?php                                     
                        $sql_fr2 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '10' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
                        $result_fr2 = mysqli_query($link,$sql_fr2);
                        if ($row_fr2 = mysqli_fetch_array($result_fr2)) {
                         echo 'X';
                        } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Sobrepeso</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Abuso de Alcohol</td>
                        <td style="font-family: Arial; font-size: 12px;  text-align: center;">
                          <?php                                     
                          $sql_fr3 =" SELECT idintegrante_factor_riesgo, idcarpeta_familiar FROM integrante_factor_riesgo WHERE idfactor_riesgo_cf = '2' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' AND idintegrante_cf = '$idintegrante_cf_ss' ";
                          $result_fr3 = mysqli_query($link,$sql_fr3);
                          if ($row_fr3 = mysqli_fetch_array($result_fr3)) {
                          echo 'X';
                          } ?>
                        </td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                          <?php                                     
                          $sql_fr3 =" SELECT idintegrante_factor_riesgo, idcarpeta_familiar FROM integrante_factor_riesgo WHERE idfactor_riesgo_cf = '2' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
                          $result_fr3 = mysqli_query($link,$sql_fr3);
                          if ($row_fr3 = mysqli_fetch_array($result_fr3)) {
                          echo 'X';
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Habito de Fumar</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                          <?php                                     
                          $sql_fr3 =" SELECT idintegrante_factor_riesgo, idcarpeta_familiar FROM integrante_factor_riesgo WHERE idfactor_riesgo_cf = '3' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' AND idintegrante_cf = '$idintegrante_cf_ss' ";
                          $result_fr3 = mysqli_query($link,$sql_fr3);
                          if ($row_fr3 = mysqli_fetch_array($result_fr3)) {
                          echo 'X';
                          } ?>
                        </td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                          <?php                                     
                          $sql_fr3 =" SELECT idintegrante_factor_riesgo, idcarpeta_familiar FROM integrante_factor_riesgo WHERE idfactor_riesgo_cf = '3' AND idcarpeta_familiar = '$idcarpeta_familiar_ss'  ";
                          $result_fr3 = mysqli_query($link,$sql_fr3);
                          if ($row_fr3 = mysqli_fetch_array($result_fr3)) {
                          echo 'X';
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Transfusiones</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Cirugías</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Transtornos del SNC</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Tuberculosis</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">                         
                        <?php                                     
                        $sql_fr2 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '1' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' AND idintegrante_cf = '$idintegrante_cf_ss' ";
                        $result_fr2 = mysqli_query($link,$sql_fr2);
                        if ($row_fr2 = mysqli_fetch_array($result_fr2)) {
                         echo 'X';
                        } ?>
                        </td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                        <?php                                     
                        $sql_fr2 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '1' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
                        $result_fr2 = mysqli_query($link,$sql_fr2);
                        if ($row_fr2 = mysqli_fetch_array($result_fr2)) {
                         echo 'X';
                        } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Desnutrición</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                          
                        </td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Drogas</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                          <?php                                     
                          $sql_fr3 =" SELECT idintegrante_factor_riesgo, idcarpeta_familiar FROM integrante_factor_riesgo WHERE idfactor_riesgo_cf = '4' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' AND idintegrante_cf = '$idintegrante_cf_ss' ";
                          $result_fr3 = mysqli_query($link,$sql_fr3);
                          if ($row_fr3 = mysqli_fetch_array($result_fr3)) {
                          echo 'X';
                          } ?>
                        </td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                          <?php                                     
                          $sql_fr3 =" SELECT idintegrante_factor_riesgo, idcarpeta_familiar FROM integrante_factor_riesgo WHERE idfactor_riesgo_cf = '4' AND idcarpeta_familiar = '$idcarpeta_familiar_ss'  ";
                          $result_fr3 = mysqli_query($link,$sql_fr3);
                          if ($row_fr3 = mysqli_fetch_array($result_fr3)) {
                          echo 'X';
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Sífilis</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Otros</td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                        <?php                                     
                        $sql_fr2 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '19' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' AND idintegrante_cf = '$idintegrante_cf_ss' ";
                        $result_fr2 = mysqli_query($link,$sql_fr2);
                        if ($row_fr2 = mysqli_fetch_array($result_fr2)) {
                         echo 'X';
                        } ?>
                        </td>
                        <td style="font-family: Arial; font-size: 12px; text-align: center;">
                        <?php                                     
                        $sql_fr2 =" SELECT idintegrante_morbilidad, idcarpeta_familiar FROM integrante_morbilidad WHERE idmorbilidad_cf = '19' AND idcarpeta_familiar = '$idcarpeta_familiar_ss' ";
                        $result_fr2 = mysqli_query($link,$sql_fr2);
                        if ($row_fr2 = mysqli_fetch_array($result_fr2)) {
                         echo 'X';
                        } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5"><table width="900" border="0">
              <tbody>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;"><strong>INSTRUCTIVO:</strong></td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">SUBJETIVO: Motivo de consulta y/o sintomas que el paciente refiere durante la anamnesis.</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">OBJETIVO: Hallazgos del exámen físico y/o resultados de exámenes de laboratorio y complementarios</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">ANÁLISIS: Lista de problemas detectados: diagnóstico, signos o sintomas a seguir, resultados de laboratorio patológico, antecedentes personales.</td>
                </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">PLAN DE ACCIÓN: Tratamientos, orientaciones, seguimientos, exámenes complementarios necesarios para cada problema.</td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>

           <!---- HISTORIAL DE ATENCIONES - BEGIN ----->  

          <?php
            $numero_at=1;
            $sql_at =" SELECT diagnostico_psafci.iddiagnostico_psafci, diagnostico_psafci.motivo_consulta, patologia.patologia, patologia.cie, diagnostico_psafci.subjetivo, diagnostico_psafci.objetivo, ";
            $sql_at.=" diagnostico_psafci.analisis, diagnostico_psafci.plan, atencion_psafci.idatencion_psafci, diagnostico_psafci.idusuario, atencion_psafci.fecha_registro, atencion_psafci.edad FROM diagnostico_psafci, patologia, atencion_psafci WHERE diagnostico_psafci.idpatologia=patologia.idpatologia ";
            $sql_at.=" AND diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND atencion_psafci.idnombre='$idnombre_integrante_ss' ORDER BY atencion_psafci.fecha_registro  ";
            $result_at = mysqli_query($link,$sql_at);
            if ($row_at = mysqli_fetch_array($result_at)){
            mysqli_field_seek($result_at,0);
            while ($field_at = mysqli_fetch_field($result_at)){
            } do {          
              ?>
          <tr>
            <td colspan="5">
              
              <?php
                      $sql_sg =" SELECT idsigno_vital_psafci, frec_cardiaca, peso, talla, imc, frec_respiratoria, presion_arterial, presion_arterial_d, temperatura, saturacion, alergia,  ";
                      $sql_sg.="  descripcion_alergia, fecha_registro, edad FROM signo_vital_psafci WHERE idnombre ='$idnombre_integrante_ss' AND idatencion_psafci='$row_at[8]' ORDER BY idsigno_vital_psafci DESC LIMIT 1 ";
                      $result_sg = mysqli_query($link,$sql_sg);
                      if ($row_sg = mysqli_fetch_array($result_sg)){
                      mysqli_field_seek($result_sg,0);           
                      while ($field_sg = mysqli_fetch_field($result_sg)){
                      } do {
                  ?>
              <table width="900" border="1" align="center" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="100" valign="top">             
                      <table width="100" border="0" cellspacing="0">
                        <tbody>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">FECHA:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">
                              <?php 
                          $fecha_r = explode('-', $row_sg[12]);
                          $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                          echo $fecha_reg; ?>
                              </td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">EDAD:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_sg[13];?> año(s)</td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">TALLA:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_sg[3];?></td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">PESO:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_sg[2];?></td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">TEMP.</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_sg[8];?></td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">FC</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_sg[1];?></td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">PA</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_sg[6];?>/<?php echo $row_sg[7];?></td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">FR</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_sg[5];?></td>
                            </tr>
                          </tbody>
                        </table>
                      
                      </td>
                    <td width="790" valign="top">
                      <table width="800" border="0" cellspacing="0">
                        <tbody>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Subjetivo</strong></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php echo $row_at[4];?></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Objetivo</strong></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php echo $row_at[5];?></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Análisis</strong></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php echo $row_at[6];?></br></br><?php echo $row_at[2];?> - <?php echo $row_at[3];?></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Plan</strong></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php echo $row_at[7];?>`</br>
          
                            <table width="400" align="left" border="0" cellspacing="0">
                                <tbody>
                                  <?php
                                      $numero_t=1;
                                      $sql_t =" SELECT tratamiento_psafci.idtratamiento_psafci, tipo_medicamento.tipo_medicamento, medicamento.medicamento FROM tratamiento_psafci, tipo_medicamento, medicamento ";
                                      $sql_t.=" WHERE tratamiento_psafci.idtipo_medicamento=tipo_medicamento.idtipo_medicamento AND tratamiento_psafci.idmedicamento=medicamento.idmedicamento AND  ";
                                      $sql_t.=" tratamiento_psafci.idatencion_psafci ='$row_at[8]' ";
                                      $result_t = mysqli_query($link,$sql_t);
                                      if ($row_t = mysqli_fetch_array($result_t)){
                                      mysqli_field_seek($result_t,0);
                                      while ($field_t = mysqli_fetch_field($result_t)){
                                      } do {
                                        ?>
                                                            <tr>
                                                              <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo "Tratamiento ".$numero_t;?></td>
                                                              <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_t[1];?></td>
                                                              <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_t[2];?></td>
                                                              </tr>
                                                            <?php
                                    $numero_t=$numero_t+1;
                                    }
                                    while ($row_t = mysqli_fetch_array($result_t));
                                    } else {
                                    
                                    }
                                    ?>
                                  </tbody>
                                </table>
                              
                              
                              
                              
                              </td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td width="15" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            <td width="183" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            <td width="353" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            <td width="241" style="font-family: Arial; font-size: 12px;"><span style="font-family: Arial; font-size: 12px; text-align: center;">
                              <?php 
                          $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                          $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row_at[9]' ";
                          $result_r = mysqli_query($link,$sql_r);
                          $row_r = mysqli_fetch_array($result_r);                    
                          echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
                              </br>
                              Nombre y firma - Médico</span></td>
                            </tr>
                          </tbody>
                        </table>
                      
                      </td>
                    </tr>
                  </tbody>
                </table>
              
              <?php
                        }
                        while ($row_sg = mysqli_fetch_array($result_sg));
                        } else { ?>
              
              <table width="900" border="1" align="center" cellspacing="0">
                <tbody>
                  <tr>
                    <td width="100" valign="top">
                      <table width="100" border="0" cellspacing="0">
                        <tbody>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">FECHA:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">
                              <?php 
                          $fecha_r = explode('-', $row_at[10]);
                          $fecha_reg = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];
                          echo $fecha_reg; ?>
                              </td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">EDAD:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_at[11];?> año(s)</td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">TALLA:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">PESO:</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">TEMP.</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">FC</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">PA</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td bgcolor="#E4E4E4" style="font-family: Arial; font-size: 12px;">FR</td>
                            </tr>
                          <tr>
                            <td style="font-family: Arial; font-size: 12px; text-align: center;">&nbsp;</td>
                            </tr>
                          </tbody>
                        </table>
                      
                      </td>
                    <td width="790" valign="top">
                      
                      <table width="800" border="0" align="center" cellspacing="0">
                        <tbody>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Subjetivo:</strong></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php echo $row_at[1];?></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Objetivo:</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Análisis:</strong></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><?php echo $row_at[2];?> - <?php echo $row_at[3];?></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;"><strong>Plan</strong></td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">
                              
                              <table width="400" align="left" border="0" cellspacing="0">
                                <tbody>
                                  <?php
            $numero_t=1;
            $sql_t =" SELECT tratamiento_psafci.idtratamiento_psafci, tipo_medicamento.tipo_medicamento, medicamento.medicamento FROM tratamiento_psafci, tipo_medicamento, medicamento ";
            $sql_t.=" WHERE tratamiento_psafci.idtipo_medicamento=tipo_medicamento.idtipo_medicamento AND tratamiento_psafci.idmedicamento=medicamento.idmedicamento AND  ";
            $sql_t.=" tratamiento_psafci.idatencion_psafci ='$row_at[8]' ";
            $result_t = mysqli_query($link,$sql_t);
            if ($row_t = mysqli_fetch_array($result_t)){
            mysqli_field_seek($result_t,0);
            while ($field_t = mysqli_fetch_field($result_t)){
            } do {
              ?>
                                  <tr>
                                    <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo "Tratamiento ".$numero_t;?></td>
                                    <td style="font-family: Arial; font-size: 12px; text-align: center;"><?php echo $row_t[1];?></td>
                                    <td style="text-align: center; font-family: Arial; font-size: 12px;"><?php echo $row_t[2];?></td>
                                    </tr>
                                  <?php
          $numero_t=$numero_t+1;
          }
          while ($row_t = mysqli_fetch_array($result_t));
          } else {
           
          }
          ?>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="4" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="35" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            <td width="90" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            <td width="425" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                            <td width="242" style="font-family: Arial; font-size: 12px;"><span style="font-family: Arial; font-size: 12px; text-align: center;">
                              <?php 
                          $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE  ";
                          $sql_r.=" usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$row_at[9]' ";
                          $result_r = mysqli_query($link,$sql_r);
                          $row_r = mysqli_fetch_array($result_r);                    
                          echo mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]);?>
                              </br>
                              Nombre y firma - Médico</span></td>
                          </tr>
                          </tbody>
                        </table>
                      
                      </td>
                    </tr>
                  </tbody>
                </table>
              
              <?php } ?> 
              
              </td>
          </tr>            
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table>

          <?php
          $numero_at=$numero_at+1;
          }
          while ($row_at = mysqli_fetch_array($result_at));
          } else {
          }
          ?>

  <!---- HISTORIAL DE ATENCIONES - END ----->            
          <tr>
            <td colspan="5">&nbsp;</td>
            </tr>
          </tbody>
      </table></td>
    </tr>  

   

  </tbody>
</table>
</body>
</html>
