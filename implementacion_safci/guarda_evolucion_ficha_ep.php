<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha 	 = date("Y-m-d");
$hora    = date("h:i");
$gestion = date("Y");

$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$iddepartamento_ss          = $_SESSION['iddepartamento_ss'];
$idred_salud_ss             = $_SESSION['idred_salud_ss'];
$idmunicipio_ss             = $_SESSION['idmunicipio_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idnotificacion_ep_ss       = $_SESSION['idnotificacion_ep_ss'];

$idregistro_enfermedad_ss   = $_SESSION['idregistro_enfermedad_ss'];
$idficha_ep_ss              = $_SESSION['idficha_ep_ss'];

$idsospecha_diag_ss         = $_SESSION['idsospecha_diag_ss'];

$idgrupo_etareo_ss          = $_SESSION['idgrupo_etareo_ss'];
$idgenero_ss                = $_SESSION['idgenero_ss'];

$idseguimiento_ep_ss        = $_SESSION['idseguimiento_ep_ss'];

//-----DATOS ENVIADOS EN EL FORMULARIO DE EVOLUCION DE ENFERMEDAD ----- //

$idsospecha_diag_evol  = $_POST['idsospecha_diag_evol']; 

$_SESSION['idsospecha_diag_evol_ss']  = $idsospecha_diag_evol;

        $sql8 =" UPDATE seguimiento_ep SET idsospecha_diag='$idsospecha_diag_evol' ";
        $sql8.=" WHERE idseguimiento_ep='$idseguimiento_ep_ss' ";            
        $result8 = mysqli_query($link,$sql8); 


//****  leemos la CIFRA de la tabla Registro enfermedad *******//

        $sql_cif = " SELECT idregistro_enfermedad, cifra FROM registro_enfermedad WHERE idregistro_enfermedad='$idregistro_enfermedad_ss'";
        $result_cif = mysqli_query($link,$sql_cif);
        $row_cif=mysqli_fetch_array($result_cif);

//****  descontamos el caso la CIFRA de la tabla Registro enfermedad *******//

        $cifra_evol = $row_cif[1]-1;

//****  guardamos la cifra nueva en la tabla Registro enfermedad origen *******//
        $sql7 =" UPDATE registro_enfermedad SET cifra='$cifra_evol' WHERE idregistro_enfermedad='$idregistro_enfermedad_ss' ";         
        $result7 = mysqli_query($link,$sql7); 

//****  ANALIZAMOS LA EXISTENCIA de un nuevo Registro enfermedad ACTUAL (idsospecha_diag) *******//

$sql_reg = " SELECT idregistro_enfermedad, idnotificacion_ep, idsospecha_diag, cifra FROM registro_enfermedad WHERE idnotificacion_ep ='$idnotificacion_ep_ss' ";
$sql_reg.= " AND idsospecha_diag='$idsospecha_diag_evol' AND idgrupo_etareo='$idgrupo_etareo_ss' AND idgenero='$idgenero_ss'";
$result_reg = mysqli_query($link,$sql_reg);
if ($row_reg=mysqli_fetch_array($result_reg)) {

    //****  SI EL REGISTRO DE LA SOPECHA EXISTE .- actualizamos CIFRA ( + 1 CASO) en el  Registro enfermedad en el grupo etareo correspondiente *******//

    $sql_et = " SELECT idregistro_enfermedad, cifra FROM registro_enfermedad WHERE idregistro_enfermedad='$row_reg[0]' ";
    $result_et = mysqli_query($link,$sql_et);
    $row_et=mysqli_fetch_array($result_et);

    $cifra_mas = $row_et[1]+1;

    $sql6 =" UPDATE registro_enfermedad SET cifra='$cifra_mas' WHERE idregistro_enfermedad='$row_reg[0]'";           
    $result6 = mysqli_query($link,$sql6); 

    //** la ficha formara oarte de otra categoria de enfermedad ******/

    $sql5 =" UPDATE ficha_ep SET idsospecha_diag='$idsospecha_diag_evol', idregistro_enfermedad ='$row_reg[0]' ";
    $sql5.=" WHERE idficha_ep='$idficha_ep_ss' ";            
    $result5 = mysqli_query($link,$sql5); 

    header("Location:mensaje_evolucion_enfermedad.php");

} else {  
    //****  CREAMOS un nuevo Registro enfermedad (idsospecha_diag) *******//

    $sql_n =" SELECT idgrupo_etareo, grupo_etareo FROM grupo_etareo ";
    $result_n = mysqli_query($link,$sql_n);
    if ($row_n = mysqli_fetch_array($result_n)){
    mysqli_field_seek($result_n,0);
    while ($field_n = mysqli_fetch_field($result_n)){
    } do { 
    
        $sql_gen = " SELECT idgenero, genero FROM genero ";
        $result_gen = mysqli_query($link,$sql_gen);
        if ($row_gen = mysqli_fetch_array($result_gen)){
        mysqli_field_seek($result_gen,0);
        while ($field_gen = mysqli_fetch_field($result_gen)){
        } do { 
    
            if ($row_n[0] == $idgrupo_etareo_ss && $row_gen[0]== $idgenero_ss) {

                $sql2 = " INSERT INTO registro_enfermedad (idnotificacion_ep, idsospecha_diag, idgrupo_etareo, idgenero, cifra, fecha_registro, hora_registro, idusuario, gestion) ";
                $sql2.= " VALUES ('$idnotificacion_ep_ss','$idsospecha_diag_evol','$row_n[0]','$row_gen[0]','1','$fecha','$hora','$idusuario_ss','$gestion') ";
                $result2 = mysqli_query($link,$sql2);

            } else {

                $sql0 = " INSERT INTO registro_enfermedad (idnotificacion_ep, idsospecha_diag, idgrupo_etareo, idgenero, cifra, fecha_registro, hora_registro, idusuario, gestion) ";
                $sql0.= " VALUES ('$idnotificacion_ep_ss','$idsospecha_diag_evol','$row_n[0]','$row_gen[0]','0','$fecha','$hora','$idusuario_ss','$gestion') ";
                $result0 = mysqli_query($link,$sql0);
            }
                
            }
            while ($row_gen = mysqli_fetch_array($result_gen));
        } else {
        }      
    }
     while ($row_n = mysqli_fetch_array($result_n));
     } else {
     }

    //** la ficha formara oarte de otra categoria de enfermedad ******/

    $sql_ficha =" UPDATE ficha_ep SET idsospecha_diag='$idsospecha_diag_evol', idregistro_enfermedad ='$row_reg[0]' ";
    $sql_ficha.=" WHERE idficha_ep='$idficha_ep_ss' ";            
    $result_ficha = mysqli_query($link,$sql_ficha); 

    header("Location:mensaje_evolucion_enfermedad.php");
}
?>