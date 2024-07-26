<?php include("../cabf.php");?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");
$idcarpeta_familiar_ss = '2';       
?>
    <table width="300" border="1" cellspacing="0">
    <tbody>
    <tr>
        <td colspan="2" bgcolor="#503B92" style="color: #FBF9F9; font-family: arial; font-size: 14px; text-align: left;"></td>
    </tr>
    <?php
        $sql5 =" SELECT item_determinante_salud.item_determinante_salud, determinante_salud_cf.valor_cf FROM determinante_salud_cf, item_determinante_salud ";
        $sql5.=" WHERE determinante_salud_cf.iditem_determinante_salud=item_determinante_salud.iditem_determinante_salud ";
        $sql5.=" AND determinante_salud_cf.iddeterminante_salud='1' AND determinante_salud_cf.idcat_determinante_salud='1' ";
        $sql5.="  AND determinante_salud_cf.idcarpeta_familiar='2' ";
        $result5 = mysqli_query($link,$sql5);
        if ($row5 = mysqli_fetch_array($result5)){
        mysqli_field_seek($result5,0);
        while ($field5 = mysqli_fetch_field($result5)){
        } do { 
        ?>
        <tr>
            <td width="246"><?php echo $row5[0];?></td>
            <td width="38"><?php echo $row5[1];?></td>
        </tr>                           
        <?php
        }
        while ($row5 = mysqli_fetch_array($result5));
        } else {
        }
    ?>
    </tbody>
    </table>