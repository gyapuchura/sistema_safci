<?php
$fecha_nacimiento = '2000-03-12';

    $dia=date("d");
    $mes=date("m");
    $ano=date("Y");
    
    $dianaz=date("d",strtotime($fecha_nacimiento));
    $mesnaz=date("m",strtotime($fecha_nacimiento));
    $anonaz=date("Y",strtotime($fecha_nacimiento));      
    //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual    
    if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); }    
    //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual    
    if ($mesnaz > $mes) {
    $ano=($ano-1);}    
     //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad    
    $edad=($ano-$anonaz);
      
    echo $edad;
    
    
?>