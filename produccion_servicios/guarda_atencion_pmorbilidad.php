<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');

$fecha_ram	= date("Ymd");
$fecha 		= date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");

$idusuario_ss  = $_SESSION['idusuario_ss'];
$idnombre_ss   = $_SESSION['idnombre_ss'];
$perfil_ss     = $_SESSION['perfil_ss'];

$idcarpeta_familiar_ss      = $_SESSION['idcarpeta_familiar_ss'];
$idestablecimiento_salud_ss = $_SESSION['idestablecimiento_salud_ss'];
$idintegrante_cf_ss         = $_SESSION['idintegrante_cf_ss'];
$idnombre_integrante_ss     = $_SESSION['idnombre_integrante_ss'];
$edad_ss                    = $_SESSION['edad_ss'];

/*********** ENVIO DATOS DEL PÀCIENTE *************/

$idrepeticion    = $_POST['idrepeticion'];
$idtipo_consulta = $_POST['idtipo_consulta'];
$idtipo_atencion = $_POST['idtipo_atencion'];

$diagnosticos    = $_POST['diagnosticos'];
$tratamientos_1  = $_POST['tratamientos_1'];
$tratamientos_2  = $_POST['tratamientos_2'] ;

$motivo_consulta1      = $link->real_escape_string($_POST['motivo_consulta1']);
$idpatologia1          = $_POST['idpatologia1'];
$idtipo_medicamento_11 = $_POST['idtipo_medicamento_11'];
$idmedicamento_11      = $_POST['idmedicamento_11'] ;
$idtipo_medicamento_12 = $_POST['idtipo_medicamento_12'];
$idmedicamento_12      = $_POST['idmedicamento_12'];

$motivo_consulta2      = $link->real_escape_string($_POST['motivo_consulta2']);
$idpatologia2          = $_POST['idpatologia2'];
$idtipo_medicamento_21 = $_POST['idtipo_medicamento_21'];
$idmedicamento_21      = $_POST['idmedicamento_21'];
$idtipo_medicamento_22 = $_POST['idtipo_medicamento_22'];
$idmedicamento_22      = $_POST['idmedicamento_22'];

/*********** PRUEBA DE VARIABLES *************/

/*********** PRUEBA DE VARIABLES *************/
$sql_e    = " SELECT iddepartamento, idred_salud, idmunicipio FROM establecimiento_salud WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
$result_e = mysqli_query($link,$sql_e);
$row_e    = mysqli_fetch_array($result_e);

$sql_int    = " SELECT idgenero FROM nombre WHERE idnombre ='$idnombre_integrante_ss' ";
$result_int = mysqli_query($link,$sql_int);
$row_int    = mysqli_fetch_array($result_int);

$sql_nac    = " SELECT idnacion FROM integrante_cf WHERE idintegrante_cf ='$idintegrante_cf_ss' ";
$result_nac = mysqli_query($link,$sql_nac);
$row_nac    = mysqli_fetch_array($result_nac);

$iddepartamento = $row_e[0];
$idred_salud    = $row_e[1];
$idmunicipio    = $row_e[2];
$idgenero       = $row_int[0];
$idnacion       = $row_nac[0];

$sqlm    = " SELECT MAX(correlativo) FROM atencion_psafci WHERE gestion='$gestion' ";
$resultm = mysqli_query($link,$sqlm);
$rowm    = mysqli_fetch_array($resultm);

$correlativo = $rowm[0]+1;

$codigo = "PSAFCI-ATENCION-".$correlativo."/".$gestion;

if ($diagnosticos == '' && $tratamientos_1 == '') {
    
    header("Location:mensaje_ps_vacio.php");

} else {
   
$sql0 = " INSERT INTO atencion_psafci (iddepartamento, idred_salud, idmunicipio, idestablecimiento_salud, idnombre, edad, idgenero, ";
$sql0.= " idrepeticion, idtipo_consulta, idtipo_atencion, idnacion, codigo, correlativo,  gestion, fecha_registro, hora_registro, idusuario)  ";
$sql0.= " VALUES ('$iddepartamento','$idred_salud','$idmunicipio','$idestablecimiento_salud_ss','$idnombre_integrante_ss','$edad_ss','$idgenero', ";
$sql0.= " '$idrepeticion','$idtipo_consulta','$idtipo_atencion','$idnacion','$codigo','$correlativo','$gestion', '$fecha','$hora','$idusuario_ss')";
$result0 = mysqli_query($link,$sql0);   
$idatencion_psafci = mysqli_insert_id($link);


if ($diagnosticos == '1' && $tratamientos_1 == '1') {
    
    $sql_dg1 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
    $sql_dg1.= " VALUES ('$idatencion_psafci','$motivo_consulta1','$idpatologia1','$fecha','$hora','$idusuario_ss') ";
    $result_dg1 = mysqli_query($link,$sql_dg1);   
    $iddiagnostico_psafci_1 = mysqli_insert_id($link);

        $sql_tr11 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
        $sql_tr11.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_11','$idmedicamento_11','$fecha','$hora','$idusuario_ss') ";
        $result_tr11 = mysqli_query($link,$sql_tr11);

        $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
        header("Location:mostrar_atencion_psafci.php");
    
} else {
    if ($diagnosticos == '1' && $tratamientos_1 == '2') {

        $sql_dg1 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
        $sql_dg1.= " VALUES ('$idatencion_psafci','$motivo_consulta1','$idpatologia1','$fecha','$hora','$idusuario_ss') ";
        $result_dg1 = mysqli_query($link,$sql_dg1);   
        $iddiagnostico_psafci_1 = mysqli_insert_id($link);
    
            $sql_tr11 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
            $sql_tr11.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_11','$idmedicamento_11','$fecha','$hora','$idusuario_ss') ";
            $result_tr11 = mysqli_query($link,$sql_tr11);
    
            $sql_tr12 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
            $sql_tr12.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_12','$idmedicamento_12','$fecha','$hora','$idusuario_ss') ";
            $result_tr12 = mysqli_query($link,$sql_tr12);

            $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
            header("Location:mostrar_atencion_psafci.php");

    } else {
            if ($diagnosticos == '2' && $tratamientos_1 == '1' && $tratamientos_2 == '1') {

            $sql_dg1 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg1.= " VALUES ('$idatencion_psafci','$motivo_consulta1','$idpatologia1','$fecha','$hora','$idusuario_ss') ";
            $result_dg1 = mysqli_query($link,$sql_dg1);   
            $iddiagnostico_psafci_1 = mysqli_insert_id($link);
    
                $sql_tr11 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                $sql_tr11.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_11','$idmedicamento_11','$fecha','$hora','$idusuario_ss') ";
                $result_tr11 = mysqli_query($link,$sql_tr11);
    
            $sql_dg2 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
            $sql_dg2.= " VALUES ('$idatencion_psafci','$motivo_consulta2','$idpatologia2','$fecha','$hora','$idusuario_ss') ";
            $result_dg2 = mysqli_query($link,$sql_dg2);   
            $iddiagnostico_psafci_2 = mysqli_insert_id($link);
    
                $sql_tr21 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                $sql_tr21.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento_21','$idmedicamento_21','$fecha','$hora','$idusuario_ss') ";
                $result_tr21 = mysqli_query($link,$sql_tr21);

                $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
                header("Location:mostrar_atencion_psafci.php");

            } else {
                if ($diagnosticos == '2' && $tratamientos_1 == '2' && $tratamientos_2 == '1') {
                    
                    $sql_dg1 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
                    $sql_dg1.= " VALUES ('$idatencion_psafci','$motivo_consulta1','$idpatologia1','$fecha','$hora','$idusuario_ss') ";
                    $result_dg1 = mysqli_query($link,$sql_dg1);   
                    $iddiagnostico_psafci_1 = mysqli_insert_id($link);
            
                        $sql_tr11 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                        $sql_tr11.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_11','$idmedicamento_11','$fecha','$hora','$idusuario_ss') ";
                        $result_tr11 = mysqli_query($link,$sql_tr11);
        
                        $sql_tr12 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                        $sql_tr12.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_12','$idmedicamento_12','$fecha','$hora','$idusuario_ss') ";
                        $result_tr12 = mysqli_query($link,$sql_tr12);
            
                    $sql_dg2 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
                    $sql_dg2.= " VALUES ('$idatencion_psafci','$motivo_consulta2','$idpatologia2','$fecha','$hora','$idusuario_ss') ";
                    $result_dg2 = mysqli_query($link,$sql_dg2);   
                    $iddiagnostico_psafci_2 = mysqli_insert_id($link);
            
                        $sql_tr21 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                        $sql_tr21.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento_21','$idmedicamento_21','$fecha','$hora','$idusuario_ss') ";
                        $result_tr21 = mysqli_query($link,$sql_tr21);

                        $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
                        header("Location:mostrar_atencion_psafci.php");

                } else {
                    if ($diagnosticos == '2' && $tratamientos_1 == '1' && $tratamientos_2 == '2') {
                        
                        $sql_dg1 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
                        $sql_dg1.= " VALUES ('$idatencion_psafci','$motivo_consulta1','$idpatologia1','$fecha','$hora','$idusuario_ss') ";
                        $result_dg1 = mysqli_query($link,$sql_dg1);   
                        $iddiagnostico_psafci_1 = mysqli_insert_id($link);
                
                            $sql_tr11 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                            $sql_tr11.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_11','$idmedicamento_11','$fecha','$hora','$idusuario_ss') ";
                            $result_tr11 = mysqli_query($link,$sql_tr11);
                
                        $sql_dg2 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
                        $sql_dg2.= " VALUES ('$idatencion_psafci','$motivo_consulta2','$idpatologia2','$fecha','$hora','$idusuario_ss') ";
                        $result_dg2 = mysqli_query($link,$sql_dg2);   
                        $iddiagnostico_psafci_2 = mysqli_insert_id($link);
                
                            $sql_tr21 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                            $sql_tr21.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento_21','$idmedicamento_21','$fecha','$hora','$idusuario_ss') ";
                            $result_tr21 = mysqli_query($link,$sql_tr21);
        
                            $sql_tr22 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                            $sql_tr22.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento_22','$idmedicamento_22','$fecha','$hora','$idusuario_ss') ";
                            $result_tr22 = mysqli_query($link,$sql_tr22);

                            $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
                            header("Location:mostrar_atencion_psafci.php");

                    } else {
                        if ($diagnosticos == '2' && $tratamientos_1 == '2' && $tratamientos_2 == '2') {

                            $sql_dg1 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
                            $sql_dg1.= " VALUES ('$idatencion_psafci','$motivo_consulta1','$idpatologia1','$fecha','$hora','$idusuario_ss') ";
                            $result_dg1 = mysqli_query($link,$sql_dg1);   
                            $iddiagnostico_psafci_1 = mysqli_insert_id($link);
                    
                                $sql_tr11 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                                $sql_tr11.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_11','$idmedicamento_11','$fecha','$hora','$idusuario_ss') ";
                                $result_tr11 = mysqli_query($link,$sql_tr11);
        
                                $sql_tr12 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                                $sql_tr12.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_1','$idtipo_medicamento_12','$idmedicamento_12','$fecha','$hora','$idusuario_ss') ";
                                $result_tr12 = mysqli_query($link,$sql_tr12);
                    
                            $sql_dg2 = " INSERT INTO diagnostico_psafci (idatencion_psafci, motivo_consulta, idpatologia, fecha_registro, hora_registro, idusuario) ";
                            $sql_dg2.= " VALUES ('$idatencion_psafci','$motivo_consulta2','$idpatologia2','$fecha','$hora','$idusuario_ss') ";
                            $result_dg2 = mysqli_query($link,$sql_dg2);   
                            $iddiagnostico_psafci_2 = mysqli_insert_id($link);
                    
                                $sql_tr21 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                                $sql_tr21.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento_21','$idmedicamento_21','$fecha','$hora','$idusuario_ss') ";
                                $result_tr21 = mysqli_query($link,$sql_tr21);
            
                                $sql_tr22 = " INSERT INTO tratamiento_psafci (idatencion_psafci, iddiagnostico_psafci, idtipo_medicamento, idmedicamento, fecha_registro, hora_registro, idusuario) ";
                                $sql_tr22.= " VALUES ('$idatencion_psafci','$iddiagnostico_psafci_2','$idtipo_medicamento_22','$idmedicamento_22','$fecha','$hora','$idusuario_ss') ";
                                $result_tr22 = mysqli_query($link,$sql_tr22);

                                $_SESSION['idatencion_psafci_ss'] = $idatencion_psafci;
                                header("Location:mostrar_atencion_psafci.php");

                        } else {
                        
                            header("Location:mensaje_error_ps.php");
                        }                
                    }                
                }            
            }       
        }   
    }

}
?>