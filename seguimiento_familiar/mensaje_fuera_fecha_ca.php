<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora     = date("H:i");
$mes      = date('m');
$gestion    = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss = $_SESSION['idcarpeta_familiar_ss'];

$sql_cf =" SELECT idcarpeta_familiar, codigo, familia, fecha_apertura FROM carpeta_familiar WHERE idcarpeta_familiar='$idcarpeta_familiar_ss' ";
$result_cf=mysqli_query($link,$sql_cf);
$row_cf=mysqli_fetch_array($result_cf);
          
?>
<table width="1200" border="0" align="center">
  <tbody>
    <tr>
      <td width="198" style="text-align: center"><img src="../implementacion_safci/logo_safci_doc.png" width="200" height="140" alt=""/></td>
      <td width="521" style="text-align: center; color: #35B9CB; font-family: 'Helvetica Condensed Bold'; font-size: 24px;">
        <p><strong style="text-align: center">ACTUALIZACIÓN DE SEGUIMIENTO</strong></p>
        <p><strong style="text-align: center">FAMILIA :  <?php echo $row_cf[2];?></strong></p>
        <p><strong style="text-align: center"><?php echo $row_cf[1];?></strong></p>
        </td>
      <td width="167">&nbsp;</td>
    </tr>
        <tr>
      <td width="198" style="text-align: center"></td>
      <td width="521" style="text-align: center; color: #35B9CB; font-family: 'Helvetica Condensed Bold'; font-size: 24px;">
      </td>
      <td width="167">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center; color:#FF0000; font-family: 'Helvetica Condensed Bold'; font-size: 20px;">  
          
      </td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center; color:#FF0000; font-family: 'Helvetica Condensed Bold'; font-size: 20px;">  
           
      </td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center; color:#FF0000; font-family: 'Helvetica Condensed Bold'; font-size: 20px;">
        <p>NO PUEDE ACTUALIZAR </p>
        <p>FUERA DE LA FECHA PLANIFICADA</p>  
        <p>PARA LA VISITA FAMILIAR !!!</p> 
      </td>
    </tr>

    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3">        
      </td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center; font-family: 'Helvetica Condensed Bold'; font-size: 20px;">  
        <a href="actualiza_seguimiento_familiar_ca.php">VOLVER</a>      
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
