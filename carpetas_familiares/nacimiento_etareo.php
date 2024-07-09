<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	    = date("Ymd");
$fecha 		    = date("Y-m-d");
$gestion        = date("Y");
?>
<?php
        $sql3 = " SELECT integrante_cf.idintegrante_cf, nombre.fecha_nac FROM integrante_cf, nombre WHERE integrante_cf.idnombre=nombre.idnombre ";
        $result3 = mysqli_query($link,$sql3);
        $total3 = mysqli_num_rows($result3);
        if ($row3 = mysqli_fetch_array($result3)){
        mysqli_field_seek($result3,0);
        while ($field3 = mysqli_fetch_field($result3)){
        } do {

            $fecha_nacimiento = $row3[1];
            $dia=date("d");
            $mes=date("m");
            $ano=date("Y");    
            $dianaz=date("d",strtotime($fecha_nacimiento));
            $mesnaz=date("m",strtotime($fecha_nacimiento));
            $anonaz=date("Y",strtotime($fecha_nacimiento));         
            if (($mesnaz == $mes) && ($dianaz > $dia)) {
            $ano=($ano-1); }      
            if ($mesnaz > $mes) {
            $ano=($ano-1);} 

    $edad = ($ano-$anonaz);  

    if ($edad <= 4) {
        $grupo_etareo_cf = '1';
    } else {
        if ($edad <= 9) {
            $grupo_etareo_cf = '2';
        } else {
            if ($edad <= 14) {
                $grupo_etareo_cf = '3';
            } else { 
                if ($edad <= 19) {
                $grupo_etareo_cf = '4';
            } else { 
                if ($edad <= 24) {
                    $grupo_etareo_cf = '5';
                } else { 
                    if ($edad <= 29) {
                        $grupo_etareo_cf = '6';
                    } else { 
                        if ($edad <= 34) {
                            $grupo_etareo_cf = '7';
                        } else { 
                            if ($edad <= 39) {
                                $grupo_etareo_cf = '8';
                            } else { 
                                if ($edad <= 44) {
                                    $grupo_etareo_cf = '9';
                                } else { 
                                    if ($edad <= 49) {
                                        $grupo_etareo_cf = '10';
                                    } else { 
                                        if ($edad <= 54) {
                                            $grupo_etareo_cf = '11';
                                        } else { 
                                            if ($edad <= 59) {
                                                $grupo_etareo_cf = '12';
                                            } else { 
                                                if ($edad <= 64) {
                                                    $grupo_etareo_cf = '13';
                                                } else { 
                                                    if ($edad <= 69) {
                                                        $grupo_etareo_cf = '14';
                                                    } else { 
                                                        if ($edad <= 74) {
                                                            $grupo_etareo_cf = '15';
                                                        } else { 
                                                            if ($edad <= 79) {
                                                                $grupo_etareo_cf = '16';
                                                            } else { 
                                                                if ($edad <= 84) {
                                                                    $grupo_etareo_cf = '17';
                                                                } else { 
                                                                    if ($edad <= 89) {
                                                                        $grupo_etareo_cf = '18';
                                                                    } else { 
                                                                        if ($edad <= 94) {
                                                                            $grupo_etareo_cf = '19';
                                                                        } else { 
                                                                            if ($edad >= 95) {
                                                                                $grupo_etareo_cf = '20';
                                                                            } else { 
            }}}}} }}}}} }}}}} }}}}}

            $sql_a = " UPDATE integrante_cf SET idgrupo_etareo_cf='$grupo_etareo_cf', edad='$edad'  ";
            $sql_a.= " WHERE idintegrante_cf='$row3[0]' ";
            $result_a = mysqli_query($link,$sql_a);  

        } while ($row3 = mysqli_fetch_array($result3));
        } else {
        /*
        Si no se encontraron resultados
        */
        }
        ?>   