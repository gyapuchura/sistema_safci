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

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);

$sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$idnombre_integrante_ss' ";
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
            <td colspan="5" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">A. DATOS ADMINISTRATIVOS</td>
            </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5"><table width="900" border="0">
              <tbody>
                <tr>
                  <td width="502"><table width="502" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td width="149" rowspan="9" style="font-family: Arial; font-size: 9px; text-align: center;">Sello Institucional</td>
                        <td colspan="2" bgcolor="#000000" style="text-align: center; font-family: Arial; font-size: 12px; color: #FFFFFF;">RESPONSABLE DE FAMILIA</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Apellido Paterno: </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Apellido Materno:</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Nombres:</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="177" style="font-family: Arial; font-size: 12px;">Fecha de nacimiento: </td>
                        <td width="162" style="font-family: Arial; font-size: 12px;">Sexo:</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Ocupación: ..... Productivas: </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Reproductivas: </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Gestión Comunitaria:</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Establecimiento:</td>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Dirección: </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                        <td colspan="2" style="font-family: Arial; font-size: 12px;">Comunidad: </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">Red de Salud:</td>
                        <td style="font-family: Arial; font-size: 12px;">Municipio:</td>
                        <td style="font-family: Arial; font-size: 12px;">Provincia:</td>
                      </tr>
                    </tbody>
                  </table></td>
                  <td width="54">&nbsp;</td>
                  <td width="332" valign="top"><table width="333" border="1" cellspacing="0">
                    <tbody>
                      <tr>
                        <td width="110" style="font-family: Arial; font-size: 12px;">No. H.C.</td>
                        <td width="212" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial; font-size: 12px;">No Carpeta Familiar</td>
                        <td style="font-family: Arial; font-size: 12px;">&nbsp;</td>
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
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Apellido Materno:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Nombres:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Fecha de nacimiento: </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td width="81" style="font-family: Arial; font-size: 12px;">Sexo: </td>
                  <td width="81" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td width="77" style="font-family: Arial; font-size: 12px;">Procedencia: </td>
                  <td width="74" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Fecha de Ingreso: </td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Idioma Hablado:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Idioma Materno:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Auto pertenencia cultural:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  </tr>
                <tr>
                  <td style="font-family: Arial; font-size: 12px;">Ocupación: Productivas:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Reproductivas:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
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
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">Escolaridad:</td>
                  <td colspan="2" style="font-family: Arial; font-size: 12px;">&nbsp;</td>
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
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
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
