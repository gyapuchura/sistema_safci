<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");
?>

data: [
              
    <?php
                    $sql0 = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
                    $sql0.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
                    $sql0.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='1' AND  ";
                    $sql0.= " registro_enfermedad.cifra !='0' AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' ";
                    $result0 = mysqli_query($link,$sql0);
                    $row0 = mysqli_fetch_array($result0);
                    $total = $row0[0];

                    $numero = 0;
                    $sql = " SELECT registro_enfermedad.idsospecha_diag FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
                    $sql.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
                    $sql.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='1' ";
                    $sql.= " AND notificacion_ep.estado='CONSOLIDADO' AND  registro_enfermedad.cifra !='0' ";
                    $sql.= " AND registro_enfermedad.gestion='$gestion' GROUP BY registro_enfermedad.idsospecha_diag ";
                    $result = mysqli_query($link,$sql);
                    $conteo_tipo = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result)){
                    mysqli_field_seek($result,0);
                    while ($field = mysqli_fetch_field($result)){
                    } do {

                    $sql_t    = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag ='$row[0]' ";
                    $result_t = mysqli_query($link,$sql_t);
                    $row_t    = mysqli_fetch_array($result_t);

                    $sql_c = " SELECT SUM(registro_enfermedad.cifra) FROM registro_enfermedad, notificacion_ep, sospecha_diag  ";
                    $sql_c.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND  ";
                    $sql_c.= " registro_enfermedad.idsospecha_diag=sospecha_diag.idsospecha_diag AND sospecha_diag.idcat_registro='1' ";
                    $sql_c.= " AND registro_enfermedad.cifra !='0' AND registro_enfermedad.idsospecha_diag='$row[0]'  ";
                    $sql_c.= " AND registro_enfermedad.gestion='$gestion' AND notificacion_ep.estado='CONSOLIDADO' ";
                    $result_c = mysqli_query($link,$sql_c);
                    $row_c = mysqli_fetch_array($result_c);
                    $conteo = $row_c[0];

                    $p_conteo   = ($conteo*100)/$total;
                    $porcentaje    = number_format($p_conteo, 2, '.', '');

                    ?>

                    ['<?php echo $row_t[0];?>', <?php echo $porcentaje;?>]

                        <?php
                        $numero++;
                        if ($numero == $conteo_tipo) {
                        echo "";
                        }
                        else {
                        echo ",";
                        }
                        
                    } while ($row = mysqli_fetch_array($result));
                    } else {
                    /*
                    Si no se encontraron resultados
                    */
                    }
                    ?>


                    ]