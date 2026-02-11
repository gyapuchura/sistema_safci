<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];


?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>REPORTE DIAGNOSTICOS PREVENTIVOS</title>



<h4 align="center" style="font-family: Arial;">TOTAL NACIONAL DE DIAGNÓSTICOS PREVENTIVOS = 
                <?php
                $sql_dgt = " SELECT count(diagnostico_psafci.iddiagnostico_psafci) FROM diagnostico_psafci, patologia ";
                $sql_dgt.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia ";
                $sql_dgt.= " AND patologia.cie LIKE '%Z%' ";
                $result_dgt = mysqli_query($link,$sql_dgt);
                $row_dgt = mysqli_fetch_array($result_dgt);
                $diagnostico_nal = $row_dgt[0];
                echo $diagnostico_nal;
                ?>
</h4>
<table width="1000" border="1" align="center" bordercolor="#009999">
    <tr>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial;"><span class="Estilo8 Estilo1 Estilo2" style="font-size: 12px"> N° </span></td>
        <td width="400" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">DIAGNÓSTICOS PSAFCI</span></td>
        <td width="50" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo8 Estilo1 Estilo2">CIE</span></td>
        <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">MÉDICOS SAFCI-MISALUD</td>
        <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">MÉDICOS TELE-SALUD</td>
            <td width="200" align="center" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><span class="Estilo7">TOTAL/DIAG.</span></td>
        </tr>
            <?php
            $numero = 1;
            $sql = " SELECT diagnostico_psafci.idpatologia, patologia.patologia, patologia.cie FROM diagnostico_psafci, patologia ";
            $sql.= " WHERE diagnostico_psafci.idpatologia=patologia.idpatologia AND cie LIKE '%Z%' ";
            $sql.= " GROUP BY diagnostico_psafci.idpatologia ";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {
           ?>
        <tr>
            <td width="21" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $numero;?></td>
            <td width="315" bgcolor="#FFFFFF" style="font-family: Arial; font-size: 12px;"><?php echo $row[1];?></td>
            <td width="50" bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;"><?php echo $row[2];?></td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                <?php                
                $sql_ps = " SELECT diagnostico_psafci.iddiagnostico_psafci, diagnostico_psafci.idusuario FROM diagnostico_psafci, atencion_psafci, dato_laboral, usuarios, nombre ";
                $sql_ps.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND diagnostico_psafci.idusuario=usuarios.idusuario ";
                $sql_ps.= " AND dato_laboral.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND diagnostico_psafci.idpatologia = '$row[0]' ";
                $sql_ps.= " AND dato_laboral.idcargo_organigrama != '54' GROUP BY diagnostico_psafci.iddiagnostico_psafci ";
                $result_ps = mysqli_query($link,$sql_ps);
                $psafci = mysqli_num_rows($result_ps);
                echo $psafci;?>
            </td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                <?php                
                $sql_tel = " SELECT diagnostico_psafci.iddiagnostico_psafci, diagnostico_psafci.idusuario FROM diagnostico_psafci, atencion_psafci, dato_laboral, usuarios, nombre ";
                $sql_tel.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND diagnostico_psafci.idusuario=usuarios.idusuario ";
                $sql_tel.= " AND dato_laboral.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND diagnostico_psafci.idpatologia = '$row[0]' ";
                $sql_tel.= " AND dato_laboral.idcargo_organigrama = '54' GROUP BY diagnostico_psafci.iddiagnostico_psafci ";
                $result_tel = mysqli_query($link,$sql_tel);
                $telesalud = mysqli_num_rows($result_tel);
                echo $telesalud;?>
            </td>
            <td bgcolor="#FFFFFF" align="center" style="font-family: Arial; font-size: 12px;">
                <?php
                $sql_dgt = " SELECT diagnostico_psafci.iddiagnostico_psafci, diagnostico_psafci.idusuario FROM diagnostico_psafci, atencion_psafci, dato_laboral, usuarios, nombre ";
                $sql_dgt.= " WHERE diagnostico_psafci.idatencion_psafci=atencion_psafci.idatencion_psafci AND diagnostico_psafci.idusuario=usuarios.idusuario ";
                $sql_dgt.= " AND dato_laboral.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre AND diagnostico_psafci.idpatologia = '$row[0]' ";
                $sql_dgt.= " GROUP BY diagnostico_psafci.iddiagnostico_psafci ";
                $result_dgt = mysqli_query($link,$sql_dgt);
                $diagnostico_pat = mysqli_num_rows($result_dgt);
                echo $diagnostico_pat;
                ?>
            </td>
                    </tr> 
                <?php
                $numero++;                    
            } while ($row = mysqli_fetch_array($result));
            } else {
            /*
            Si no se encontraron resultados
            */
            }
            ?>
    </table>
</br>


	</body>
</html>