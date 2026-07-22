<?php   
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=REPORTE_REFERENCIAS_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram      = date("Ymd");
$fecha          = date("Y-m-d");
$gestion        = date("Y");

$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

// =========================================================================
// 1. RECIBIR Y SANITIZAR LOS FILTROS DINÁMICOS DESDE EL POST
// =========================================================================
$inicio_raw   = isset($_POST['inicio']) ? $_POST['inicio'] : '';
$fin_raw      = isset($_POST['finalizacion']) ? $_POST['finalizacion'] : '';

$inicio       = mysqli_real_escape_string($link, $inicio_raw);
$finalizacion = mysqli_real_escape_string($link, $fin_raw);

$iddepartamento    = isset($_POST['iddepartamento']) ? mysqli_real_escape_string($link, $_POST['iddepartamento']) : '';
$idmunicipio       = isset($_POST['idmunicipio']) ? mysqli_real_escape_string($link, $_POST['idmunicipio']) : '';
$idestablecimiento = isset($_POST['idestablecimiento']) ? mysqli_real_escape_string($link, $_POST['idestablecimiento']) : '';
$idusuario_medico  = isset($_POST['idusuario_medico']) ? mysqli_real_escape_string($link, $_POST['idusuario_medico']) : '';

$filtro_extra = "";
if($iddepartamento != '') { $filtro_extra .= " AND referencia_hc.iddepartamento = '$iddepartamento' "; }
if($idmunicipio != '') { $filtro_extra .= " AND referencia_hc.idmunicipio = '$idmunicipio' "; }
if($idestablecimiento != '') { $filtro_extra .= " AND referencia_hc.idestablecimiento_salud = '$idestablecimiento' "; }
if($idusuario_medico != '') { $filtro_extra .= " AND referencia_hc.idusuario = '$idusuario_medico' "; }
// =========================================================================

$fecha_i = explode('-',$inicio);
$f_inicio = isset($fecha_i[2]) ? $fecha_i[2].'/'.$fecha_i[1].'/'.$fecha_i[0] : '';

$fecha_f = explode('-',$finalizacion);
$f_finalizacion = isset($fecha_f[2]) ? $fecha_f[2].'/'.$fecha_f[1].'/'.$fecha_f[0] : '';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>REPORTE REFERENCIAS MEDI-APS</title>
        <style type="text/css">
            table { border-collapse: collapse; }
            .c-cabecera { font-family: Arial; font-size: 12px; color: #ffffff; text-align: center; background-color: #36b9cc; font-weight: bold; padding: 5px; }
            .c-dato { font-family: Arial; font-size: 11px; text-align: center; background-color: #FFFFFF; }
            .c-izq { font-family: Arial; font-size: 11px; text-align: left; background-color: #FFFFFF; }
        </style>
</head>
<body>
<h4 align="center" style="font-family: Arial; color: #36b9cc;">REPORTE DE REFERENCIAS Y CONTRARREFERENCIAS MEDI-APS</h4>
<h4 align="center" style="font-family: Arial;"> DEL <?php echo $f_inicio;?> AL <?php echo $f_finalizacion;?></h4>

<table width="100%" border="1" align="center" bordercolor="#36b9cc">
    <thead>
        <tr>
            <td class="c-cabecera">N°</td>
            <td class="c-cabecera">FECHA DE REGISTRO</td>
            <td class="c-cabecera">TIPO ATENCIÓN</td>
            <td class="c-cabecera">CÓDIGO REFERENCIA</td>
            <td class="c-cabecera">CÓDIGO DE EESS</td>
            <td class="c-cabecera">DEPARTAMENTO</td>
            <td class="c-cabecera">RED DE SALUD</td>
            <td class="c-cabecera">MUNICIPIO</td>
            <td class="c-cabecera">NIVEL</td>
            <td class="c-cabecera">ESTABLECIMIENTO ORIGEN</td>
            <td class="c-cabecera">ESTABLECIMIENTO RECEPTOR</td>
            <td class="c-cabecera">TIPO</td>
            <td class="c-cabecera">PROCEDENCIA</td>
            <td class="c-cabecera">DIAGNÓSTICO 1</td>
            <td class="c-cabecera">DIAGNÓSTICO 2</td>
            <td class="c-cabecera">DIAGNÓSTICO 3</td>
            <td class="c-cabecera">DIAGNÓSTICO 4</td>
            <td class="c-cabecera">CAPTACIÓN</td>
            <td class="c-cabecera">MÉDICO OPERATIVO</td>
            <td class="c-cabecera">CARGO ORGANIZACIONAL</td>
            <td class="c-cabecera">EDAD</td>
            <td class="c-cabecera">ESPECIALIDAD MÉDICA</td>
            <td class="c-cabecera">CARNET DE IDENTIDAD</td>
            <td class="c-cabecera">FECHA DE NACIMIENTO</td>
            <td class="c-cabecera">PERSONA REFERIDA</td>
            <td class="c-cabecera">GENERO</td>
            <td class="c-cabecera">TELÉFONO PACIENTE</td>
            <td class="c-cabecera">NACIÓN</td>
            <td class="c-cabecera">NUEVO / SEGUIMIENTO</td>
            <td class="c-cabecera">TIEMPO</td>
            <td class="c-cabecera">CONSULTA/VISITA</td>
            <td class="c-cabecera">CONTEXTO ATENCIÓN</td>
            <td class="c-cabecera">MEDIO COMUNICACIÓN</td>
            <td class="c-cabecera">ESTADO/ETAPA</td>
        </tr> 
    </thead>
    <tbody>
    <?php
    $numero = 1; 
    
    // CONSULTA BASE: Extracción de toda la carga operativa
    $sql =" SELECT referencia_hc.idreferencia_hc, referencia_hc.codigo, nombre.nombre, nombre.paterno, nombre.materno, ";
    $sql.=" departamento.departamento, municipios.municipio, establecimiento_salud.establecimiento_salud, estado_referencia.estado_referencia,  ";
    $sql.=" especialidad_medica.especialidad_medica, referencia_hc.fecha_registro, referencia_hc.hora_registro, referencia_hc.idusuario, red_salud.red_salud, referencia_hc.idestablecimiento_receptor, referencia_hc.idestado_referencia, establecimiento_salud.codigo_establecimiento, ";
    $sql.=" ne.nivel_establecimiento, nombre.ci, nombre.fecha_nac, g.genero, atc.telefono_paciente, nac.nacion, a.idrepeticion, tc.tipo_consulta, de.de_ts, vc.via_comunicacion, ta.tipo_atencion, t_ref.tiempo_ts, te_est.tipo_establecimiento, cap.captacion_ts, en.en_ts ";
    
    $sql.=" FROM referencia_hc ";
    $sql.=" INNER JOIN nombre ON referencia_hc.idnombre = nombre.idnombre ";
    $sql.=" INNER JOIN estado_referencia ON referencia_hc.idestado_referencia = estado_referencia.idestado_referencia ";
    $sql.=" LEFT JOIN especialidad_medica ON referencia_hc.idespecialidad_medica = especialidad_medica.idespecialidad_medica ";
    $sql.=" INNER JOIN departamento ON referencia_hc.iddepartamento = departamento.iddepartamento ";
    $sql.=" LEFT JOIN red_salud ON referencia_hc.idred_salud = red_salud.idred_salud ";
    $sql.=" INNER JOIN municipios ON referencia_hc.idmunicipio = municipios.idmunicipio ";
    $sql.=" INNER JOIN establecimiento_salud ON referencia_hc.idestablecimiento_salud = establecimiento_salud.idestablecimiento_salud ";
    
    $sql.=" LEFT JOIN nivel_establecimiento ne ON establecimiento_salud.idnivel_establecimiento = ne.idnivel_establecimiento ";
    $sql.=" LEFT JOIN tipo_establecimiento te_est ON establecimiento_salud.idtipo_establecimiento = te_est.idtipo_establecimiento ";
    $sql.=" LEFT JOIN genero g ON nombre.idgenero = g.idgenero ";
    $sql.=" LEFT JOIN atencion_psafci a ON referencia_hc.idatencion_psafci = a.idatencion_psafci ";
    $sql.=" LEFT JOIN atencion_teleconsulta atc ON referencia_hc.idatencion_psafci = atc.idatencion_psafci ";
    $sql.=" LEFT JOIN nacion nac ON a.idnacion = nac.idnacion ";
    $sql.=" LEFT JOIN tipo_consulta tc ON a.idtipo_consulta = tc.idtipo_consulta ";
    $sql.=" LEFT JOIN de_ts de ON atc.idde_ts = de.idde_ts ";
    $sql.=" LEFT JOIN en_ts en ON atc.iden_ts = en.iden_ts ";
    $sql.=" LEFT JOIN via_comunicacion vc ON atc.idvia_comunicacion = vc.idvia_comunicacion ";
    $sql.=" LEFT JOIN tipo_atencion ta ON a.idtipo_atencion = ta.idtipo_atencion ";
    $sql.=" LEFT JOIN captacion_ts cap ON atc.idcaptacion_ts = cap.idcaptacion_ts ";
    $sql.=" LEFT JOIN tiempo_ts t_ref ON referencia_hc.idtiempo_ts = t_ref.idtiempo_ts ";
    
    $sql.=" WHERE referencia_hc.fecha_registro BETWEEN '$inicio' AND '$finalizacion' $filtro_extra ";
    $sql.=" ORDER BY referencia_hc.idreferencia_hc ASC "; 
    
    $result = mysqli_query($link,$sql);
    if ($result && $row = mysqli_fetch_array($result)){
        mysqli_field_seek($result,0);           
        while ($field = mysqli_fetch_field($result)){
        } do {
            // CÁLCULO DE EDAD Y GÉNERO
            $edad_calculada = "";
            if (!empty($row[19]) && $row[19] != '0000-00-00') {
                $fecha_nac_dt = new DateTime($row[19]);
                $fecha_ate_dt = new DateTime($row[10]);
                $edad_calculada = $fecha_nac_dt->diff($fecha_ate_dt)->y;
            }
            $genero_final = "S/D";
            if (!empty($row[20])) {
                $g_upper = strtoupper($row[20]);
                if ($g_upper == 'MASCULINO' || $g_upper == 'M') { $genero_final = 'M'; }
                else if ($g_upper == 'FEMENINO' || $g_upper == 'F') { $genero_final = 'F'; }
                else { $genero_final = $g_upper; }
            }

            // OBTENER ESTABLECIMIENTO RECEPTOR PARA FILA 1
            $eess_receptor_inicial = "-";
            $sql_er =" SELECT establecimiento_salud FROM establecimiento_salud WHERE idestablecimiento_salud='{$row[14]}' ";
            $res_er = mysqli_query($link,$sql_er);
            if($res_er && $row_er = mysqli_fetch_array($res_er)) { $eess_receptor_inicial = $row_er[0]; }

            // OBTENER MEDICO ORIGEN PARA FILA 1
            $medico_origen = "-";
            $sql_r =" SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='{$row[12]}' ";
            $res_r = mysqli_query($link,$sql_r);
            if($res_r && $row_r = mysqli_fetch_array($res_r)) { $medico_origen = mb_strtoupper($row_r[0]." ".$row_r[1]." ".$row_r[2]); }

            // OBTENER CARGO ORIGEN PARA FILA 1
            $cargo_origen = "-";
            $sql_c =" SELECT cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama AND usuarios.idusuario='{$row[12]}' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1 ";
            $res_c = mysqli_query($link,$sql_c);
            if($res_c && $row_c = mysqli_fetch_array($res_c)) { $cargo_origen = $row_c[0]; }

            // EXTRACCIÓN DE DIAGNÓSTICOS PARA FILA 1 (PRESUNTIVOS)
            $diag_origen = array("", "", "");
            $d_idx = 0;
            $sql_dg = " SELECT p.patologia, p.cie FROM diagnostico_presuntivo dp INNER JOIN patologia p ON dp.idpatologia=p.idpatologia WHERE dp.idreferencia_hc='{$row[0]}' LIMIT 3";
            $res_dg = mysqli_query($link,$sql_dg);
            if ($res_dg && $row_dg = mysqli_fetch_array($res_dg)){
                do {
                    $diag_origen[$d_idx] = $row_dg[1]." - ".$row_dg[0];
                    $d_idx++;
                } while ($row_dg = mysqli_fetch_array($res_dg));
            }

            // =========================================================================
            // FILA 1: LA REFERENCIA INICIAL (IDA)
            // =========================================================================
            ?>
            <tr>
                <td class="c-dato"><?php echo $numero;?></td>
                <td class="c-dato"><?php $f_l = explode('-',$row[10]); echo isset($f_l[2]) ? $f_l[2].'/'.$f_l[1].'/'.$f_l[0] : ''; ?></td>
                <td class="c-dato"><b>REFERENCIA</b></td> 
                <td class="c-dato"><b><?php echo $row[1];?></b></td>
                <td class="c-dato"><?php echo !empty($row[16]) ? $row[16] : "S/D"; ?></td>
                <td class="c-izq"><?php echo $row[5];?></td>
                <td class="c-izq"><?php echo !empty($row[13]) ? $row[13] : "S/D"; ?></td>
                <td class="c-izq"><?php echo $row[6];?></td>
                <td class="c-dato"><?php echo !empty($row[17]) ? $row[17] : "S/D"; ?></td>
                <td class="c-izq"><?php echo $row[7];?></td> 
                <td class="c-izq"><?php echo $eess_receptor_inicial; ?></td> 
                <td class="c-dato"><?php echo !empty($row[29]) ? mb_strtoupper($row[29]) : "S/D"; ?></td>
                <td class="c-dato"><?php echo !empty($row[25]) ? mb_strtoupper($row[25]) : "S/D"; ?></td>
                
                <td class="c-izq"><?php echo $diag_origen[0]; ?></td>
                <td class="c-izq"><?php echo $diag_origen[1]; ?></td>
                <td class="c-izq"><?php echo $diag_origen[2]; ?></td>
                <td class="c-izq"></td> 
                
                <td class="c-dato"><?php echo !empty($row[30]) ? mb_strtoupper($row[30]) : "S/D"; ?></td>
                <td class="c-izq"><?php echo $medico_origen; ?></td>
                <td class="c-dato"><?php echo $cargo_origen; ?></td>
                <td class="c-dato"><?php echo $edad_calculada; ?></td>
                <td class="c-izq"><?php echo !empty($row[9]) ? mb_strtoupper($row[9]) : "S/D"; ?></td>
                <td class="c-dato"><?php echo !empty($row[18]) ? $row[18] : "S/D"; ?></td>
                <td class="c-dato"><?php if(!empty($row[19]) && $row[19] != '0000-00-00'){ $fn = explode('-', $row[19]); echo $fn[2].'/'.$fn[1].'/'.$fn[0]; } ?></td>
                <td class="c-izq"><?php echo mb_strtoupper($row[2]." ".$row[3]." ".$row[4]);?></td>
                <td class="c-dato"><?php echo $genero_final; ?></td>
                <td class="c-dato"><?php echo !empty($row[21]) ? $row[21] : "S/D"; ?></td>
                <td class="c-dato"><?php echo !empty($row[22]) ? mb_strtoupper($row[22]) : "S/D"; ?></td>
                <td class="c-dato"><?php if($row[23] == '1'){echo "NUEVO";} else if($row[23] == '2'){echo "SEGUIMIENTO";} else {echo "S/D";} ?></td>
                <td class="c-dato"><?php echo !empty($row[28]) ? mb_strtoupper($row[28]) : "S/D"; ?></td>
                <td class="c-dato"><?php echo !empty($row[24]) ? mb_strtoupper($row[24]) : "S/D"; ?></td>
                <td class="c-izq"><?php echo !empty($row[31]) ? mb_strtoupper($row[31]) : "S/D"; ?></td>
                <td class="c-izq"><?php echo !empty($row[26]) ? mb_strtoupper($row[26]) : "S/D"; ?></td> <!-- Medio com. origen -->
                <td class="c-dato"><?php echo mb_strtoupper($row[8]);?></td>
            </tr>
            <?php
            $numero++;

            // =========================================================================
            // FILA 2: CLONACIÓN DE CONTRAREFERENCIA (VUELTA) - SOLO SI ESTÁ EN ESTADO 2
            // =========================================================================
            if ($row[15] == '2') {
                // Buscamos el viaje de retorno en deriva_referencia_hc incluyendo idvia_comunicacion
                $sql_der = "SELECT idusuario_o, idestablecimiento_salud_o, fecha_deriva, idvia_comunicacion FROM deriva_referencia_hc WHERE idreferencia_hc='{$row[0]}' ORDER BY idderiva_referencia_hc DESC LIMIT 1";
                $res_der = mysqli_query($link, $sql_der);
                
                if ($res_der && $row_der = mysqli_fetch_array($res_der)) {
                    $id_usuario_especialista = $row_der[0];
                    $id_eess_especialista = $row_der[1];
                    $fecha_retorno = explode('-', $row_der[2]);
                    $f_reg_contra = isset($fecha_retorno[2]) ? $fecha_retorno[2].'/'.$fecha_retorno[1].'/'.$fecha_retorno[0] : '';
                    $id_via_comunicacion_contra = $row_der[3];

                    // OBTENER DATOS DEL EESS DEL ESPECIALISTA 
                    $eess_contra_nombre = "-"; $codigo_eess_contra = "S/D"; $dpto_contra = "S/D"; $mun_contra = "S/D"; $nivel_contra = "S/D"; $tipo_eess_contra = "S/D"; $red_contra = "S/D";
                    $sql_eess_c = "SELECT es.establecimiento_salud, es.codigo_establecimiento, d.departamento, m.municipio, ne.nivel_establecimiento, te.tipo_establecimiento, rs.red_salud FROM establecimiento_salud es LEFT JOIN departamento d ON es.iddepartamento = d.iddepartamento LEFT JOIN municipios m ON es.idmunicipio = m.idmunicipio LEFT JOIN nivel_establecimiento ne ON es.idnivel_establecimiento = ne.idnivel_establecimiento LEFT JOIN tipo_establecimiento te ON es.idtipo_establecimiento = te.idtipo_establecimiento LEFT JOIN red_salud rs ON es.idred_salud = rs.idred_salud WHERE es.idestablecimiento_salud='$id_eess_especialista'";
                    $res_eess_c = mysqli_query($link, $sql_eess_c);
                    if($res_eess_c && $row_eess_c = mysqli_fetch_array($res_eess_c)) {
                        $eess_contra_nombre = $row_eess_c[0];
                        $codigo_eess_contra = !empty($row_eess_c[1]) ? $row_eess_c[1] : "S/D";
                        $dpto_contra = !empty($row_eess_c[2]) ? $row_eess_c[2] : "S/D";
                        $mun_contra = !empty($row_eess_c[3]) ? $row_eess_c[3] : "S/D";
                        $nivel_contra = !empty($row_eess_c[4]) ? $row_eess_c[4] : "S/D";
                        $tipo_eess_contra = !empty($row_eess_c[5]) ? $row_eess_c[5] : "S/D";
                        $red_contra = !empty($row_eess_c[6]) ? $row_eess_c[6] : "S/D";
                    }

                    // OBTENER NOMBRE DEL ESPECIALISTA 
                    $medico_contra_nombre = "-";
                    $sql_med_c = "SELECT nombre.nombre, nombre.paterno, nombre.materno FROM usuarios, nombre WHERE usuarios.idnombre=nombre.idnombre AND usuarios.idusuario='$id_usuario_especialista'";
                    $res_med_c = mysqli_query($link, $sql_med_c);
                    if($res_med_c && $row_med_c = mysqli_fetch_array($res_med_c)) { $medico_contra_nombre = mb_strtoupper($row_med_c[0]." ".$row_med_c[1]." ".$row_med_c[2]); }

                    // OBTENER CARGO DEL ESPECIALISTA 
                    $cargo_contra = "-";
                    $sql_car_c = "SELECT cargo_organigrama.cargo_organigrama FROM usuarios, dato_laboral, cargo_organigrama WHERE dato_laboral.idusuario=usuarios.idusuario AND dato_laboral.idcargo_organigrama=cargo_organigrama.idcargo_organigrama AND usuarios.idusuario='$id_usuario_especialista' ORDER BY dato_laboral.idcargo_organigrama DESC LIMIT 1";
                    $res_car_c = mysqli_query($link, $sql_car_c);
                    if($res_car_c && $row_car_c = mysqli_fetch_array($res_car_c)) { $cargo_contra = $row_car_c[0]; }

                    // OBTENER MEDIO DE COMUNICACIÓN DE LA CONTRAREFERENCIA
                    $medio_comunicacion_contra = "S/D";
                    if (!empty($id_via_comunicacion_contra)) {
                        $sql_vc_c = "SELECT via_comunicacion FROM via_comunicacion WHERE idvia_comunicacion='$id_via_comunicacion_contra'";
                        $res_vc_c = mysqli_query($link, $sql_vc_c);
                        if ($res_vc_c && $row_vc_c = mysqli_fetch_array($res_vc_c)) {
                            $medio_comunicacion_contra = mb_strtoupper($row_vc_c[0]);
                        }
                    }

                    // EXTRACCIÓN DE DIAGNÓSTICOS DE EGRESO (CONTRAREFERENCIA)
                    $diag_contra = array("", "", "");
                    $d_idx2 = 0;
                    $sql_dg2 = " SELECT p.patologia, p.cie FROM diagnostico_egreso de INNER JOIN patologia p ON de.idpatologia=p.idpatologia WHERE de.idreferencia_hc='{$row[0]}' LIMIT 3";
                    $res_dg2 = mysqli_query($link,$sql_dg2);
                    if ($res_dg2 && $row_dg2 = mysqli_fetch_array($res_dg2)){
                        do {
                            $diag_contra[$d_idx2] = $row_dg2[1]." - ".$row_dg2[0];
                            $d_idx2++;
                        } while ($row_dg2 = mysqli_fetch_array($res_dg2));
                    }
                    ?>
                    <tr>
                        <td class="c-dato"><?php echo $numero;?></td>
                        <td class="c-dato"><?php echo $f_reg_contra; ?></td>
                        <td class="c-dato" style="color: #e74a3b;"><b>CONTRAREFERENCIA</b></td> 
                        <td class="c-dato"><b><?php echo $row[1];?></b></td>
                        <td class="c-dato"><?php echo $codigo_eess_contra; ?></td>
                        <td class="c-izq"><?php echo $dpto_contra;?></td>
                        <td class="c-izq"><?php echo $red_contra;?></td>
                        <td class="c-izq"><?php echo $mun_contra;?></td>
                        <td class="c-dato"><?php echo $nivel_contra;?></td>
                        <td class="c-izq"><?php echo $eess_contra_nombre;?></td> <!-- El origen ahora es el Especialista -->
                        <td class="c-izq"><?php echo $row[7];?></td> <!-- El receptor ahora es el Rural -->
                        <td class="c-dato"><?php echo mb_strtoupper($tipo_eess_contra);?></td>
                        <td class="c-dato"><?php echo !empty($row[25]) ? mb_strtoupper($row[25]) : "S/D"; ?></td>
                        
                        <td class="c-izq"><?php echo $diag_contra[0]; ?></td>
                        <td class="c-izq"><?php echo $diag_contra[1]; ?></td>
                        <td class="c-izq"><?php echo $diag_contra[2]; ?></td>
                        <td class="c-izq"></td> 
                        
                        <td class="c-dato"><?php echo !empty($row[30]) ? mb_strtoupper($row[30]) : "S/D"; ?></td>
                        <td class="c-izq"><?php echo $medico_contra_nombre; ?></td>
                        <td class="c-dato"><?php echo $cargo_contra; ?></td>
                        <td class="c-dato"><?php echo $edad_calculada; ?></td>
                        <td class="c-izq"><?php echo !empty($row[9]) ? mb_strtoupper($row[9]) : "S/D"; ?></td> <!-- Especialidad copiada de la Referencia -->
                        <td class="c-dato"><?php echo !empty($row[18]) ? $row[18] : "S/D"; ?></td>
                        <td class="c-dato"><?php if(!empty($row[19]) && $row[19] != '0000-00-00'){ $fn = explode('-', $row[19]); echo $fn[2].'/'.$fn[1].'/'.$fn[0]; } ?></td>
                        <td class="c-izq"><?php echo mb_strtoupper($row[2]." ".$row[3]." ".$row[4]);?></td>
                        <td class="c-dato"><?php echo $genero_final; ?></td>
                        <td class="c-dato"><?php echo !empty($row[21]) ? $row[21] : "S/D"; ?></td>
                        <td class="c-dato"><?php echo !empty($row[22]) ? mb_strtoupper($row[22]) : "S/D"; ?></td>
                        <td class="c-dato"><?php if($row[23] == '1'){echo "NUEVO";} else if($row[23] == '2'){echo "SEGUIMIENTO";} else {echo "S/D";} ?></td>
                        <td class="c-dato"><?php echo !empty($row[28]) ? mb_strtoupper($row[28]) : "S/D"; ?></td>
                        <td class="c-dato"><?php echo !empty($row[24]) ? mb_strtoupper($row[24]) : "S/D"; ?></td>
                        <td class="c-izq"><?php echo !empty($row[31]) ? mb_strtoupper($row[31]) : "S/D"; ?></td>
                        <td class="c-izq"><?php echo $medio_comunicacion_contra; ?></td> <!-- Medio com. especialista -->
                        <td class="c-dato"><?php echo mb_strtoupper($row[8]);?></td>
                    </tr>
                    <?php
                    $numero++;
                }
            }

        } while ($row = mysqli_fetch_array($result));
    } 
    ?>
    </tbody>
</table>
</body>
</html>