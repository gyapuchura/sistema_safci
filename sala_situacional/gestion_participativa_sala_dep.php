<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$gestion    = date("Y");

$iddepartamento = $_GET['iddepartamento'];

$sql_dep = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento'  ";
$result_dep = mysqli_query($link,$sql_dep);
$row_dep = mysqli_fetch_array($result_dep);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REPORTE GESTION PARTICIPATIVA DEPARTAMENTAL</title>
</head>
<body>
     
<h4 style="font-family: Arial; font-size: 16px; color: #2D56CF; text-align: center;">DECLARACIONES GESTIÓN PARTICIPATIVA DEPARTAMENTO <?php echo $row_dep[1];?></h4>

<table width="1200" border="1" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="37" style="font-family: Arial; font-size: 12px; color: #2D56CF; text-align: center;">N°</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">CÓDIGO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">DEPARTAMENTO</td>
              <td width="100" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">MUNICIPIO</td>
              <td width="250" style="color: #2D56CF; font-family: Arial; font-size: 12px; text-align: center;">RESPONSABLE MUNICIPAL</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">FECHA DE REGISTRO:</td>

              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">Nº ÁREAS DE INFLUENCIA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">Nº DE A.L.S. AUTORIDADES LOCALES DE SALUD</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">Nº ESTABLECIMIENTOS DE SALUD EN EL MUNICIPIO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">Nº DE COMITÉS LOCALES DE SALUD EN EL MUNICIPIO</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">¿CUENTA CON COSOMUSA?</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">AUTORIDAD COSOMUSA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">VIGENCIA AUTORIDAD COSOMUSA</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CELULAR AUTORIDAD COSOMUSA</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">¿CUENTA CON PLAN MUNICIPAL DE SALUD?</td>
              <td width="100" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">¿CUENTA CON LEY MUNICIPAL DE APROBACIÓN DE PLAN MUNICIPAL DE SALUD?</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NÚMERO DE PROYECTOS EN SALUD PLANIFICADOS</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NÚMERO DE PROYECTOS EN SALUD EJECUTADOS</td>

            <?php
            $numero=0;
            $sqlm =" SELECT idmedicina_tradicional, medicina_tradicional FROM medicina_tradicional WHERE idmedicina_tradicional != '5' ORDER BY idmedicina_tradicional ";
            $resultm = mysqli_query($link,$sqlm);
            if ($rowm = mysqli_fetch_array($resultm)){
            mysqli_field_seek($resultm,0);
            while ($fieldm = mysqli_fetch_field($resultm)){
            } do {
            ?>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $rowm[1]."</br></br> CON REGISTRO RUMETRAB"?></td>
            <?php
            $numero=$numero+1;  
            }
            while ($rowm = mysqli_fetch_array($resultm));
            } else {
            }
            ?>

                        <?php
            $numero=0;
            $sqlm =" SELECT idmedicina_tradicional, medicina_tradicional FROM medicina_tradicional WHERE idmedicina_tradicional != '5' ORDER BY idmedicina_tradicional ";
            $resultm = mysqli_query($link,$sqlm);
            if ($rowm = mysqli_fetch_array($resultm)){
            mysqli_field_seek($resultm,0);
            while ($fieldm = mysqli_fetch_field($resultm)){
            } do {
            ?>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;"><?php echo $rowm[1]."</br></br> SIN REGISTRO RUMETRAB"?></td>
            <?php
            $numero=$numero+1;  
            }
            while ($rowm = mysqli_fetch_array($resultm));
            } else {
            }
            ?>

              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">CONVENIO SAFCI</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">ASIGNACIÓN PRESUPUESTARIA [Bs]</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NÚMERO DE SALAS DE PARTO INTERCULTURAL IMPLEMENTADAS:</td>
              <td width="200" style="font-size: 12px; color: #2D56CF; font-family: Arial; text-align: center;">NÚMERO DE REFERENCIAS Y CONTRAREFERENCIAS CON MEDICINA TRADICIONAL:</td>


		     <!--- <td width="106" style="color: #2D56CF; font-size: 12px; font-family: Arial; text-align: center;">F302A</td>  --->
	        </tr>
            <?php
                $numero=1; 
                $sql =" SELECT gestion_participativa.idgestion_participativa, gestion_participativa.codigo, departamento.departamento, municipios.municipio,  ";
                $sql.=" nombre.nombre, nombre.paterno, nombre.materno, gestion_participativa.fecha_registro, gestion_participativa.hora_registro, gestion_participativa.idusuario,  ";
                $sql.=" gestion_participativa.numero_areas_influencia, gestion_participativa.numero_als ,gestion_participativa.numero_eess ,gestion_participativa.numero_cls ,gestion_participativa.cosomusa ,gestion_participativa.autoridad_cosomusa , ";
                $sql.=" gestion_participativa.autoridad_vigencia, gestion_participativa.autoridad_celular ,gestion_participativa.plan_municipal ,gestion_participativa.ley_municipal ,gestion_participativa.proyectos_planificados ,gestion_participativa.proyectos_ejecutados ,";
                $sql.=" vigencia_convenio.vigencia_convenio, gestion_participativa.asignacion_presupuestaria ,gestion_participativa.salas_parto_intercultural ,gestion_participativa.referencias_medicina_tradicional ";
                $sql.=" FROM gestion_participativa, departamento, municipios, nombre, usuarios, vigencia_convenio WHERE gestion_participativa.iddepartamento=departamento.iddepartamento ";
                $sql.=" AND gestion_participativa.idmunicipio=municipios.idmunicipio AND gestion_participativa.idvigencia_convenio=vigencia_convenio.idvigencia_convenio ";
                $sql.=" AND gestion_participativa.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND gestion_participativa.iddepartamento='$iddepartamento' ORDER BY gestion_participativa.idgestion_participativa ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);           
            while ($field = mysqli_fetch_field($result)){
            } do {
            ?>
		    <tr>
		      <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $numero;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <a href="../gestion_participativa/formulario_gestion_participativa.php?idgestion_participativa=<?php echo $row[0];?>" target="_blank" onClick="window.open(this.href, this.target, 'width=950,height=900,top=50, left=200, scrollbars=YES'); return false;">
                <?php echo $row[1];?></a>  
              </td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[2];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[3];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo mb_strtoupper($row[4]." ".$row[5]." ".$row[6]);?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
              <?php 
                $fecha_r = explode('-',$row[7]);
                $f_registro = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];?>
                <?php echo $f_registro;?> - <?php echo $row[8];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[10];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[11];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[12];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[13];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[14];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[15];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;">
                <?php 
                $fecha_v = explode('-',$row[16]);
                $f_vigencia = $fecha_v[2].'/'.$fecha_v[1].'/'.$fecha_v[0];?>
                <?php echo $f_vigencia;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[17];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[18];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[19];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[20];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[21];?></td>

                  <?php          
                  $sql_m =" SELECT medicina_tradicional_gp.idmedicina_tradicional_gp, medicina_tradicional.idmedicina_tradicional, medicina_tradicional_gp.numero_med_trad ";
                  $sql_m.=" FROM medicina_tradicional_gp, medicina_tradicional WHERE medicina_tradicional_gp.idmedicina_tradicional=medicina_tradicional.idmedicina_tradicional ";
                  $sql_m.=" AND medicina_tradicional_gp.rumetrab='CON RUMETRAB' AND medicina_tradicional_gp.idgestion_participativa='$row[0]' ORDER BY medicina_tradicional.idmedicina_tradicional ";
                  $result_m = mysqli_query($link,$sql_m);
                  if ($row_m = mysqli_fetch_array($result_m)){
                  mysqli_field_seek($result_m,0);
                  while ($field_m = mysqli_fetch_field($result_m)){
                  } do {
                  ?>

              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_m[2];?></td>

                  <?php 
                  }
                  while ($row_m = mysqli_fetch_array($result_m));
                  } else {
                  }
                  ?>

                       <?php          
                  $sql_m =" SELECT medicina_tradicional_gp.idmedicina_tradicional_gp, medicina_tradicional.idmedicina_tradicional, medicina_tradicional_gp.numero_med_trad ";
                  $sql_m.=" FROM medicina_tradicional_gp, medicina_tradicional WHERE medicina_tradicional_gp.idmedicina_tradicional=medicina_tradicional.idmedicina_tradicional ";
                  $sql_m.=" AND medicina_tradicional_gp.rumetrab='SIN RUMETRAB' AND medicina_tradicional_gp.idgestion_participativa='$row[0]' ORDER BY medicina_tradicional.idmedicina_tradicional ";
                  $result_m = mysqli_query($link,$sql_m);
                  if ($row_m = mysqli_fetch_array($result_m)){
                  mysqli_field_seek($result_m,0);
                  while ($field_m = mysqli_fetch_field($result_m)){
                  } do {
                  ?>

              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row_m[2];?></td>

                  <?php 
                  }
                  while ($row_m = mysqli_fetch_array($result_m));
                  } else {
                  }
                  ?>

              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[22];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php 
              $presupuesto_gp  = number_format($row[23], 0, '', '.');
              echo $presupuesto_gp;?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[24];?></td>
              <td style="font-size: 12px; font-family: Arial; text-align: center;"><?php echo $row[25];?></td>
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