<?php	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE_BENEFICIARIOS_BJA.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

$idmunicipio = $_POST['idmunicipio'];

$sql_mun = " SELECT idmunicipio, municipio FROM municipios WHERE idmunicipio='$idmunicipio' ";
$result_mun = mysqli_query($link,$sql_mun);
$row_mun = mysqli_fetch_array($result_mun);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTE CONTROL DE BENEFICIERIOS BJA</title>
</head>
<body>
    <h2 style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">CONTROL DE BENEFICIARIOS BONO JUANA AZURDUY</h2>
    <h2 style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">Municipio - <?php echo $row_mun[1];?></h2>

    <table width="1000" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="30" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO INSCRIPCIÓN</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">RED DE SALUD</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ESTABLECIMIENTO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ÁREA DE INFLUENCIA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NOMBRE DEL NIÑO/NIÑA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE NACIMIENTO DEL NIÑO/NIÑA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">EDAD DEL NIÑO/NIÑA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NOMBRE DEL TITULAR DE PAGO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CÉDULA DEL TITULAR DE PAGO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">PARENTESCO</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NÚMERO DE CONTROLES</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">TELÉFONO DEL TITULAR DE PAGO:</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CUENTA DEL TITULAR DE PAGO:</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE INSCRIPCIÓN:</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE ÚLTIMO CONTROL:</td>

		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
    $numero=1; 
    $sql = " SELECT bono_nino_sano.idbono_nino_sano, bono_nino_sano.codigo, departamento.departamento, municipios.municipio, red_salud.red_salud, establecimiento_salud.establecimiento_salud, ";
    $sql.= " tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, bono_nino_sano.idnombre_nino, bono_nino_sano.idnombre_madre, bono_nino_sano.numero_controles, bono_nino_sano.nino_carpetizado, ";
    $sql.= " bono_nino_sano.direccion_domicilio, bono_nino_sano.celular_madre, bono_nino_sano.cuenta_madre, bono_nino_sano.fecha_inscripcion_bono, bono_nino_sano.lug_nac_nino, bono_nino_sano.lug_nac_madre, bono_nino_sano.idparentesco";
    $sql.= " FROM bono_nino_sano, departamento, municipios, red_salud, establecimiento_salud, area_influencia, tipo_area_influencia WHERE bono_nino_sano.iddepartamento=departamento.iddepartamento ";
    $sql.= " AND bono_nino_sano.idmunicipio=municipios.idmunicipio AND bono_nino_sano.idred_salud=red_salud.idred_salud AND bono_nino_sano.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
    $sql.= " AND bono_nino_sano.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
    $sql.= " AND bono_nino_sano.idmunicipio='$idmunicipio' ";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);           
    while ($field = mysqli_fetch_field($result)){
    } do {
    ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[1];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[3];?></td> 
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[5];?></td> 
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[6];?> <?php echo $row[7];?></td>          
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php
                $sql_n =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row[8]' ";
                $result_n=mysqli_query($link,$sql_n);
                $row_n=mysqli_fetch_array($result_n);
                echo $row_n[1]." ".$row_n[2]." ".$row_n[3];
                ?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                    <?php 
                    $fecha_ni = explode('-',$row_n[5]);
                    $fecha_nino = $fecha_ni[2].'/'.$fecha_ni[1].'/'.$fecha_ni[0];
                    echo $fecha_nino; ?>
              </td> 
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php 
                    $fecha_nacimiento = $row_n[5];
                    $dia = date("d");
                    $mes = date("m");
                    $ano = date("Y");    
                    $dianaz = date("d",strtotime($fecha_nacimiento));
                    $mesnaz = date("m",strtotime($fecha_nacimiento));
                    $anonaz = date("Y",strtotime($fecha_nacimiento));         
                    if (($mesnaz == $mes) && ($dianaz > $dia)) {
                    $ano=($ano-1); }      
                    if ($mesnaz > $mes) {
                    $ano=($ano-1);}       
                    $edad=($ano-$anonaz);  
                    echo $edad ;?> años
                </td> 
                <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php
                $sql_m =" SELECT idnombre, nombre, paterno, materno, ci, fecha_nac, idnacionalidad, idgenero FROM nombre WHERE idnombre='$row[9]' ";
                $result_m=mysqli_query($link,$sql_m);
                $row_m=mysqli_fetch_array($result_m);
                echo $row_m[1]." ".$row_m[2]." ".$row_m[3];
                ?>
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_m[4];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php
                $sql_pa =" SELECT parentesco FROM parentesco WHERE idparentesco='$row[18]' ";
                $result_pa=mysqli_query($link,$sql_pa);
                $row_pa=mysqli_fetch_array($result_pa);
                echo mb_strtoupper($row_pa[0]);?> 
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[10];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[13];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[14];?></td>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_ins = explode('-',$row[15]);
                $f_inscripcion = $fecha_ins[2].'/'.$fecha_ins[1].'/'.$fecha_ins[0];?>
                <?php echo $f_inscripcion;?></td>
		     <!--- <td style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">&nbsp;</td> --->
         	<td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $sql_u =" SELECT diagnostico_psafci.iddiagnostico_psafci, diagnostico_psafci.fecha_registro FROM diagnostico_psafci, atencion_psafci ";
                $sql_u.=" WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND diagnostico_psafci.idpatologia='239' ";
                $sql_u.=" AND atencion_psafci.idnombre='$row[8]' ORDER BY diagnostico_psafci.fecha_registro DESC LIMIT 1 ";
                $result_u=mysqli_query($link,$sql_u);
                $row_u=mysqli_fetch_array($result_u);
                $fecha_uc = explode('-',$row_u[1]);
                $f_ucontrol = $fecha_uc[2].'/'.$fecha_uc[1].'/'.$fecha_uc[0];?>
                <?php echo $f_ucontrol;?>
          </td>
	        </tr>          
            <?php
        $numero=$numero+1;
        }
        while ($row = mysqli_fetch_array($result));
        } else {
        }
        ?>
	      </tbody>
    </table>

</body>
</html>