<?php include("../cabf.php"); ?>
<?php include("../inc.config.php"); ?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");
$hora    = date("H:i");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idusuario_origen  = $_POST['medico_operativo_cf1'];
$idusuario_destino = $_POST['medico_operativo_cf2'];
$idmotivo_cambio_cf = $_POST['idmotivo_cambio_cf'];


    $sql =" SELECT idcarpeta_familiar FROM carpeta_familiar WHERE idusuario = '$idusuario_origen' AND carpeta_familiar.estado='CONSOLIDADO'";
    $result = mysqli_query($link,$sql);
    if ($row = mysqli_fetch_array($result)){
    mysqli_field_seek($result,0);
    while ($field = mysqli_fetch_field($result)){
    } do { 
                  
          $sql1 = " UPDATE carpeta_familiar SET idusuario ='$idusuario_destino' ";
          $sql1.= " WHERE idcarpeta_familiar = '$row[0]' ";
          $result1 = mysqli_query($link,$sql1);   

          $sql_s = " UPDATE seguimiento_cf SET idusuario ='$idusuario_destino' ";
          $sql_s.= " WHERE idcarpeta_familiar = '$row[0]' ";
          $result_s = mysqli_query($link,$sql_s); 

          $sql2 = " INSERT INTO reasignacion_cf (idcarpeta_familiar, idusuario_origen, idusuario_destino, idmotivo_cambio_cf, transferido, fecha_registro, hora_registro, idusuario) ";
          $sql2.= " VALUES ('$row[0]','$idusuario_origen','$idusuario_destino','$idmotivo_cambio_cf','NO','$fecha','$hora','$idusuario_ss') ";
          $result2 = mysqli_query($link,$sql2);   

      $sql_seg =" SELECT idseguimiento_cf FROM seguimiento_cf WHERE idcarpeta_familiar = '$row[0]'";
      $result_seg = mysqli_query($link,$sql_seg);
      if ($row_seg = mysqli_fetch_array($result_seg)){
      mysqli_field_seek($result_seg,0);
      while ($field_seg = mysqli_fetch_field($result_seg)){
      } do { 

          $sql_v = " UPDATE visita_cf SET idusuario ='$idusuario_destino' ";
          $sql_v.= " WHERE idseguimiento_cf = '$row_seg[0]' ";
          $result_v = mysqli_query($link,$sql_v); 

      }
      while ($row_seg = mysqli_fetch_array($result_seg));
      } else {
      }

    }
    while ($row = mysqli_fetch_array($result));
    } else {
    }


    /***** el otro usuario destino ahora cambia sus carpetas al usuario origen teniendo cuidado de no mezclar *******/

    $sql3 =" SELECT idcarpeta_familiar FROM carpeta_familiar WHERE idusuario = '$idusuario_destino' AND carpeta_familiar.estado='CONSOLIDADO'";
    $result3 = mysqli_query($link,$sql3);
    if ($row3 = mysqli_fetch_array($result3)){
    mysqli_field_seek($result3,0);
    while ($field3 = mysqli_fetch_field($result3)){
    } do { 

        $sql4 =" SELECT idcarpeta_familiar FROM reasignacion_cf WHERE idusuario_origen ='$idusuario_origen' AND idcarpeta_familiar ='$row3[0]' AND transferido = 'NO' ";
        $result4 = mysqli_query($link,$sql4);
        if ($row4 = mysqli_fetch_array($result4)){
        mysqli_field_seek($result4,0);
        while ($field4 = mysqli_fetch_field($result4)){
        } do { 
          /*** no devuelve las carpetas que antes eran del usuario origen ****/
        }
        while ($row4 = mysqli_fetch_array($result4));
        } else {

              $sql5 = " UPDATE carpeta_familiar SET idusuario ='$idusuario_origen' ";
              $sql5.= " WHERE idcarpeta_familiar = '$row3[0]' ";
              $result5 = mysqli_query($link,$sql5);  

              $sql21 = " INSERT INTO reasignacion_cf (idcarpeta_familiar, idusuario_origen, idusuario_destino, idmotivo_cambio_cf, transferido, fecha_registro, hora_registro, idusuario) ";
              $sql21.= " VALUES ('$row3[0]','$idusuario_destino','$idusuario_origen','$idmotivo_cambio_cf','SI','$fecha','$hora','$idusuario_ss') ";
              $result21 = mysqli_query($link,$sql21); 

              $sql_s = " UPDATE seguimiento_cf SET idusuario ='$idusuario_origen' ";
              $sql_s.= " WHERE idcarpeta_familiar = '$row3[0]' ";
              $result_s = mysqli_query($link,$sql_s); 

                  $sql_sgm =" SELECT idseguimiento_cf FROM seguimiento_cf WHERE idcarpeta_familiar = '$row3[0]'";
                  $result_sgm = mysqli_query($link,$sql_sgm);
                  if ($row_sgm = mysqli_fetch_array($result_sgm)){
                  mysqli_field_seek($result_sgm,0);
                  while ($field_sgm = mysqli_fetch_field($result_sgm)){
                  } do { 

                      $sql_vi = " UPDATE visita_cf SET idusuario ='$idusuario_origen' ";
                      $sql_vi.= " WHERE idseguimiento_cf = '$row_sgm[0]' ";
                      $result_vi = mysqli_query($link,$sql_vi); 

                  }
                  while ($row_sgm = mysqli_fetch_array($result_sgm));
                  } else {
                  }
        }
         }
    while ($row3 = mysqli_fetch_array($result3));
    } else {
    }

              $sql_tr = " UPDATE reasignacion_cf SET transferido ='SI' ";
              $sql_tr.= " WHERE idusuario_origen = '$idusuario_origen' AND idusuario_destino='$idusuario_destino' ";
              $result_tr = mysqli_query($link,$sql_tr);

    header("Location:mensaje_intercambio_cf.php");

?>