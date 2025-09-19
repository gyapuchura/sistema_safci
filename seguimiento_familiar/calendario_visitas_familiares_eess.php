<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$idusuario_ss  =  $_SESSION['idusuario_ss'];
$idnombre_ss   =  $_SESSION['idnombre_ss'];
$perfil_ss     =  $_SESSION['perfil_ss'];

$idestablecimiento_salud_ss  =  $_SESSION['idestablecimiento_salud_ss'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
<link href='../scss/fullcalendar.css' rel='stylesheet'/>
<link href='fullcalendar.print.css' rel='stylesheet' media='print'/>

<script src='../js/jquery-1.10.2.js'></script>
<script src='../js/jquery-ui.custom.min.js'></script>
<script src='../js/fullcalendar.js'></script>
<script>

	$(document).ready(function() {
	    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		/*  className colors

		className: default(transparent), important(red), chill(pink), success(green), info(blue)

		*/

		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events div.external-event').each(function() {

			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		var calendar =  $('#calendar').fullCalendar({
			header: {
				left: 'title',
				center: '',
				right: 'prev,next '
			},
			editable: true,
			firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			selectable: true,
			defaultView: 'month',

			axisFormat: 'h:mm',
			columnFormat: {
                month: 'ddd',  // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
			allDaySlot: false,
			selectHelper: true,
			select: function(start, end, allDay) {
				var title = prompt('Titulo del Evento:');
				if (title) {
					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect');
			},
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped

				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');

				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);

				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;

				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}

			},

			events: [
<?php
$numero = 0;

$sql =" SELECT seguimiento_cf.idcarpeta_familiar, nombre.nombre, nombre.paterno, nombre.materno, visita_cf.numero_visita, ";
$sql.=" visita_cf.fecha_visita, visita_cf.idestado_visita_cf FROM carpeta_familiar, nombre, seguimiento_cf, integrante_cf, visita_cf  ";
$sql.=" WHERE seguimiento_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND visita_cf.idseguimiento_cf=seguimiento_cf.idseguimiento_cf AND integrante_cf.idnombre=nombre.idnombre  ";
$sql.=" AND seguimiento_cf.idintegrante_cf=integrante_cf.idintegrante_cf AND carpeta_familiar.idestablecimiento_salud='$idestablecimiento_salud_ss' ORDER BY visita_cf.fecha_visita ";
$result = mysqli_query($link,$sql);

$total= mysqli_num_rows($result);

if ($row = mysqli_fetch_array($result)){
mysqli_field_seek($result,0);
while ($field = mysqli_fetch_field($result)){
} do {

$fechai = $row[5];
$fechaf = $row[5];
$fechao_ini  = explode('-',$fechai);
$fechao_fini = explode('-',$fechaf);

$horai = $row[2];
$hora_ini  = explode(':',$horai);
?>

                    {
			title: '<?php echo $row[1]." ".$row[2]." ".$row[3];?> - <?php echo $row[4];?> ',
					start: new Date(<?php echo $fechao_ini[0];?>,<?php echo $fechao_ini[1];?>-1,<?php echo $fechao_ini[2];?>),
					end: new Date(<?php echo $fechao_fini[0];?>,<?php echo $fechao_fini[1];?>-1,<?php echo $fechao_fini[2];?>),
					url: 'valida_visita_calendario_eess.php?idcarpeta_familiar=<?php echo $row[0];?>',
					className: '<?php
 if ($row[6]=='1') {
   echo "info";
 }
 else {

 if ($row[6]=='3') {
     echo "success";
 }
 else {
   echo "important";
 }}

?>' 
}

<?php
$numero++;

if ($numero == $total) {

echo "";

}
else {
echo ",";

}


} while ($row = mysqli_fetch_array($result));


} else {

echo "";

/*
Si no se encontraron resultados

fecha.procesos,detalle.procesos,nombreunidad.unidad,nombredireccion.direccion,monto.procesos,evento.procesos,cite.procesos,preventivo.procesos,nombre.profesionales,observaciones.procesos ";
$sql .=" where citedgaa = '$cite' AND idunidad.procesos=idunidad.unidad AND iddireccion.procesos=ididreccion.direccion AND idprofesional.procesos=idprofesional.profesionales";
se muestra el siguiente mensaje
*/
}
?>
			],
		});


	});

</script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Helvetica Nueue",Arial,Verdana,sans-serif;
		background-color: #FFFFFF;
		}
	#wrap {
		width: 1100px;
		margin: 0 auto;
		}
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		text-align: left;

		}

	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
		}

	.external-event { /* try to mimick the look of a real event */
		margin: 10px 0;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
		}

	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #000;
		}

	#external-events p input {
		margin: 0;
		vertical-align: middle;
		}

	#calendar {
/* 		float: right; */
        margin: 0 auto;
		width: 900px;
		background-color: #FFFFFF;
		  border-radius: 6px;
        box-shadow: 0 1px 2px #000000;
		}
</style>
</head>
<body>
		<table width="900" border="0" align="center" cellspacing="0">
		  <tbody>
		    <tr>
		      <td width="152" height="142"><img src="../implementacion_safci/logo_safci_doc.png" width="152" height="106" alt=""/></td>
		      <td width="618" style="color: #365DCE"><h2 class="text-info" style="text-align: center">CALENDARIO VISITAS FAMILIARES - SAFCI</h2>
                <span style="font-family: 'Helvetica Condensed Bold'">
                <?php
					$sql_es =" SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud ";
					$sql_es.=" WHERE idestablecimiento_salud='$idestablecimiento_salud_ss' ";
					$result_es = mysqli_query($link,$sql_es);
					$row_es = mysqli_fetch_array($result_es);?>
                </span>
              <h2 style="text-align: center"><?php echo "ESTABLECIMIENTO : ".$row_es[1];?></H2></td>
		      <td width="124">&nbsp;</td>
	        </tr>
	      </tbody>
</table>
		

<div id='wrap'>

<div id='calendar'></div>

<div style='clear:both'></div>

<div class="container">

</div>


</body>
</html>
