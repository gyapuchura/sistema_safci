<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram	= date("Ymd");
$fecha 	    = date("Y-m-d");
$hora       = date("H:i");
$gestion    = date("Y");
$fecha_r = explode('-',$fecha);
$f_emision = $fecha_r[2].'/'.$fecha_r[1].'/'.$fecha_r[0];

    $num_servicios_sin = 0;
    $num_servicios_leve = 0;
    $num_servicios_moderado = 0;
    $num_servicios_grave = 0;
    $num_servicios_muy_grave = 0;

    $num_estructura_sin = 0;
    $num_estructura_leve = 0;
    $num_estructura_moderado = 0;
    $num_estructura_grave = 0;
    $num_estructura_muy_grave = 0;

    $num_funcional_sin = 0;
    $num_funcional_leve = 0;
    $num_funcional_moderado = 0;
    $num_funcional_grave = 0;
    $num_funcional_muy_grave = 0;

    $num_alimentaria_sin = 0;
    $num_alimentaria_leve = 0;
    $num_alimentaria_moderado = 0;
    $num_alimentaria_grave = 0;
    $num_alimentaria_muy_grave = 0;

            $num_total=0;
            $sql =" SELECT idcarpeta_familiar FROM determinante_salud_cf GROUP BY idcarpeta_familiar";
            $result = mysqli_query($link,$sql);
            if ($row = mysqli_fetch_array($result)){
            mysqli_field_seek($result,0);
            while ($field = mysqli_fetch_field($result)){
            } do {

                $sql_1 =" SELECT iddeterminante_salud, determinante_salud FROM determinante_salud ORDER BY iddeterminante_salud";
                $result_1 = mysqli_query($link,$sql_1);
                if ($row_1 = mysqli_fetch_array($result_1)){
                mysqli_field_seek($result_1,0);
                while ($field_1 = mysqli_fetch_field($result_1)){
                } do {
                  
/************ Evaluamos para cada detrminante de la salud  BEGIN ************/

switch ($row_1[0]) {
    case 1:
       
        $sqla = "SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' ";
        $resulta = mysqli_query($link,$sqla);
        $rowa = mysqli_fetch_array($resulta);  
        
        $sumatoria = $rowa[0];
        
            if ($sumatoria <= 7 ) {

                $num_servicios_sin =  $num_servicios_sin + 1;

            } else {
                if ($sumatoria <= 11 ) {

                    $num_servicios_leve = $num_servicios_leve + 1;

                } else {
                    if ($sumatoria <= 17) {

                        $num_servicios_moderado = $num_servicios_moderado + 1;

                    } else {
                        if ($sumatoria <= 24) {

                            $num_servicios_grave = $num_servicios_grave + 1;

                        } else { 
                            if ($sumatoria <= 35) {

                                $num_servicios_muy_grave = $num_servicios_muy_grave + 1;

                            } else {  } } } } }    
        break;
    case 2:
       
        $sqlb = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' ";
        $resultb = mysqli_query($link,$sqlb);
        $rowb = mysqli_fetch_array($resultb);
       

        $sumatoria = $rowb[0];
        if ($sumatoria <= 16 ) {

            $num_estructura_sin = $num_estructura_sin + 1;

        } else {
            if ($sumatoria <= 31 ) {

                $num_estructura_leve = $num_estructura_leve + 1;                

            } else {
                if ($sumatoria <= 41) {

                    $num_estructura_moderado =  $num_estructura_moderado + 1;

                } else {
                    if ($sumatoria <= 56) {

                        $num_estructura_grave = $num_estructura_grave + 1;                        

                    } else { 
                        if ($sumatoria <= 80) {

                            $num_estructura_muy_grave = $num_estructura_muy_grave + 1;

                        } else {  } } } } }        
        break;
    case 3:
       
        $sqlc = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' ";
        $resultc = mysqli_query($link,$sqlc);
        $rowc = mysqli_fetch_array($resultc);
      

        $valor_cf = $rowc[0];

        $sumatoria = $rowc[0];
        if ($sumatoria <= 3) {

            $num_funcional_sin = $num_funcional_sin + 1;

        } else {
            if ($sumatoria <= 5) {

                $num_funcional_leve =  $num_funcional_leve + 1;

            } else {
                if ($sumatoria <= 9) {

                    $num_funcional_moderado = $num_funcional_moderado + 1;

                } else {
                    if ($sumatoria <= 11) {

                        $num_funcional_grave = $num_funcional_grave + 1;
                        
                    } else { 
                        if ($sumatoria <= 15) {

                            $num_funcional_muy_grave = $num_funcional_muy_grave + 1;

                        } else {  } } } } }       
        break;
    case 4:
       
        $sqld = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' AND idcat_determinante_salud='19' ";
        $resultd = mysqli_query($link,$sqld);
        $rowd = mysqli_fetch_array($resultd);
        $durante = $rowd[0];

        if ($durante == '0' || $durante == '') {
           $grado_alimentario = '1';
        } else {
            if ($durante <= 3) {
                $grado_alimentario = '3';
            } else {
                if ($durante <= 5) {
                    $grado_alimentario = '4';
                } else {
                    if ($durante >= 6) {
                        $grado_alimentario = '5';
                    } else {  } } } }                                                           

        $sqlcon = " SELECT sum(valor_cf)  FROM determinante_salud_cf WHERE idcarpeta_familiar='$row[0]' AND iddeterminante_salud='$row_1[0]' AND idcat_determinante_salud='21' ";
        $resultcon = mysqli_query($link,$sqlcon);
        $rowcon = mysqli_fetch_array($resultcon);
        $consumo = $rowcon[0];

        $alimentaria = $grado_alimentario + $consumo;

        if ($alimentaria <= 7) {

            $num_alimentaria_sin = $num_alimentaria_sin + 1;

        } else {
            if ($alimentaria <= 13) {

                $num_alimentaria_leve = $num_alimentaria_leve + 1;

            } else {
                if ($alimentaria <= 21) {

                    $num_alimentaria_moderado = $num_alimentaria_moderado + 1;
                    
                } else {
                    if ($alimentaria <= 30) {

                        $num_alimentaria_grave = $num_alimentaria_grave + 1;

                    } else { 
                        if ($alimentaria <= 35) {

                            $num_alimentaria_muy_grave = $num_alimentaria_muy_grave + 1;

                        } else {  } } } } }       
        break;
}
/************ Evaluamos para cada detrminante de la salud  END  ************/
                }
                while ($row_1 = mysqli_fetch_array($result_1));
                } else {
                }  
                
                $num_total=$num_total+1;
            }
            while ($row = mysqli_fetch_array($result));
            } else {
            }
            ?>

            <?php
                $num_servicios_sin_p       = ($num_servicios_sin*100)/$num_total;
                $num_servicios_leve_p      = ($num_servicios_leve*100)/$num_total;
                $num_servicios_moderado_p  = ($num_servicios_moderado*100)/$num_total;
                $num_servicios_grave_p     = ($num_servicios_grave*100)/$num_total;
                $num_servicios_muy_grave_p = ($num_servicios_muy_grave*100)/$num_total;
?>

<script type="text/javascript" src="../sala_situacional/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('serv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];

            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([0-9]+[\.0-9x]*)/);
                    if (version) {
                        version = version[0];
                    }
                    brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push(['v' + version, columns[1][i]]);
                    }
                }

            });

            $.each(brands, function (name, y) {
                brandsData.push({
                    name: name,
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart

            $('#d_servicios').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'EVALUACIÓN DE LAS DETERMINANTES DE LA SALUD - NIVEL NACIONAL'
                },
                subtitle: {
                    text: 'Fuente: Sistema Medi-Safci al <?php echo $f_emision;?>'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Porcetaje del Total'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
                },

                series: [{
                    name: 'Carpetas Familiares',
                    colorByPoint: true,
                    data: brandsData
                }],
                drilldown: {
                    series: drilldownSeries
                }
            });
        }
    });
});


		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/modules/data.js"></script>
<script src="../js/modules/drilldown.js"></script>

<div id="d_servicios" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="serv" style="display:none">Evaluacion salud familiar 
SERVICIOS BÁSICOS SIN RIESGO	<?php echo $num_servicios_sin_p;?>%
SERVICIOS BÁSICOS RIESGO LEVE	 <?php echo $num_servicios_leve_p;?>%
SERVICIOS BÁSICOS RIESGO MODERADO 	<?php echo $num_servicios_moderado_p;?>%
SERVICIOS BÁSICOS RIESGO GRAVE	    <?php echo $num_servicios_grave_p;?>%
SERVICIOS BÁSICOS RIESGO MUY GRAVE	  <?php echo $num_servicios_muy_grave_p;?>%
</pre>



<?php               
                echo $num_total;
                echo "</br>";

                echo "</br>";
                echo $num_servicios_sin_p;
                echo "</br>";
                echo $num_servicios_leve_p;
                echo "</br>";
                echo $num_servicios_moderado_p;
                echo "</br>";
                echo $num_servicios_grave_p;
                echo "</br>";
                echo $num_servicios_muy_grave_p;
                echo "</br>";
                echo "</br>";

                echo "</br>";
                echo $num_servicios_sin;
                echo "</br>";
                echo $num_servicios_leve;
                echo "</br>";
                echo $num_servicios_moderado;
                echo "</br>";
                echo $num_servicios_grave;
                echo "</br>";
                echo $num_servicios_muy_grave;
                echo "</br>";
                echo "</br>";

                echo $num_estructura_sin;
                echo "</br>";
                echo $num_estructura_leve;
                echo "</br>";
                echo $num_estructura_moderado;
                echo "</br>";
                echo $num_estructura_grave;
                echo "</br>";
                echo $num_estructura_muy_grave;
                echo "</br>";
                echo "</br>";

                echo $num_funcional_sin;
                echo "</br>";
                echo $num_funcional_leve;
                echo "</br>";
                echo $num_funcional_moderado;
                echo "</br>";
                echo $num_funcional_grave;
                echo "</br>";
                echo $num_funcional_muy_grave;
                echo "</br>";
                echo "</br>";

                echo $num_alimentaria_sin;
                echo "</br>";
                echo $num_alimentaria_leve;
                echo "</br>";
                echo $num_alimentaria_moderado;
                echo "</br>";
                echo $num_alimentaria_grave;
                echo "</br>";
                echo $num_alimentaria_muy_grave;
                echo "</br>";
        ?>
