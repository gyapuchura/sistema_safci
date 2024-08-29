<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idarea_influencia = $_GET['idarea_influencia'];

$sql1 = " SELECT carpeta_familiar.idcarpeta_familiar, establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,  ";
$sql1.= " ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud ";
$sql1.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf, establecimiento_salud WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND  ";
$sql1.= " ubicacion_cf.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND ubicacion_cf.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql1.= " AND carpeta_familiar.estado='CONSOLIDADO' AND  ubicacion_cf.idarea_influencia='$idarea_influencia' LIMIT 1 ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = $row1[6];
$longitud_c = $row1[7];
$zoom_c     = "16";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARPETAS FAMILIARES POR ÁREA DE INFLUENCIA</title>
    <style>
        :root {
            --building-color: #FF9800;
            --house-color: #0288D1;
            --shop-color: #7B1FA2;
            --users-color: #558B2F;
            }

            /*
            * Optional: Makes the sample page fill the window.
            */
            html,
            body {
            height: 100%;
            margin: 0;
            padding: 0;
            }

            /*
            * Always set the map height explicitly to define the size of the div element
            * that contains the map.
            */
            #map {
            height: 100%;
            width: 100%;
            }

            /*
            * Property styles in unhighlighted state.
            */
            .property {
            align-items: center;
            background-color: #FFFFFF;
            border-radius: 50%;
            color: #263238;
            display: flex;
            font-size: 14px;
            gap: 15px;
            height: 30px;
            justify-content: center;
            padding: 4px;
            position: relative;
            position: relative;
            transition: all 0.3s ease-out;
            width: 30px;
            }

            .property::after {
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
            border-top: 9px solid #FFFFFF;
            content: "";
            height: 0;
            left: 50%;
            position: absolute;
            top: 95%;
            transform: translate(-50%, 0);
            transition: all 0.3s ease-out;
            width: 0;
            z-index: 1;
            }

            .property .icon {
            align-items: center;
            display: flex;
            justify-content: center;
            color: #FFFFFF;
            }

            .property .icon svg {
            height: 20px;
            width: auto;
            }

            .property .details {
            display: none;
            flex-direction: column;
            flex: 1;
            }

            .property .address {
            color: #9E9E9E;
            font-size: 10px;
            margin-bottom: 10px;
            margin-top: 5px;
            }

            .property .features {
            align-items: flex-end;
            display: flex;
            flex-direction: row;
            gap: 10px;
            }

            .property .features > div {
            align-items: center;
            background: #F5F5F5;
            border-radius: 5px;
            border: 1px solid #ccc;
            display: flex;
            font-size: 10px;
            gap: 5px;
            padding: 5px;
            }

            /*
            * Property styles in highlighted state.
            */
            .property.highlight {
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.2);
            height: 80px;
            padding: 8px 15px;
            width: auto;
            }

            .property.highlight::after {
            border-top: 9px solid #FFFFFF;
            }

            .property.highlight .details {
            display: flex;
            }

            .property.highlight .icon svg {
            width: 50px;
            height: 50px;
            }

            .property .users {
            color: #FFA000;
            }

            .property .idcarpeta_familiar {
            color: #03A9F4;
            }

            .property .size {
            color: #388E3C;
            }

            /*
            * House icon colors.
            */
            .property.highlight:has(.fa-house) .icon {
            color: var(--house-color);
            }

            .property:not(.highlight):has(.fa-house) {
            background-color: var(--house-color);
            }

            .property:not(.highlight):has(.fa-house)::after {
            border-top: 9px solid var(--house-color);
            }

            /*
            * Building icon colors.
            */
            .property.highlight:has(.fa-building) .icon {
            color: var(--building-color);
            }

            .property:not(.highlight):has(.fa-building) {
            background-color: var(--building-color);
            }

            .property:not(.highlight):has(.fa-building)::after {
            border-top: 9px solid var(--building-color);
            }

            /*
            * users icon colors.
            */
            .property.highlight:has(.fa-users) .icon {
            color: var(--users-color);
            }

            .property:not(.highlight):has(.fa-users) {
            background-color: var(--users-color);
            }

            .property:not(.highlight):has(.fa-users)::after {
            border-top: 9px solid var(--users-color);
            }

            /*
            * Shop icon colors.
            */
            .property.highlight:has(.fa-shop) .icon {
            color: var(--shop-color);
            }

            .property:not(.highlight):has(.fa-shop) {
            background-color: var(--shop-color);
            }

            .property:not(.highlight):has(.fa-shop)::after {
            border-top: 9px solid var(--shop-color);
            }
    </style>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://use.fontawesome.com/releases/v6.2.0/js/all.js"></script>
</head>
<body>
    <div class="sala"><h3 class="text-center">ÁREA DE INFLUENCIA : <?php echo mb_strtoupper($row1[2]." ".$row1[3]);?></h3></div>  
    <div class="map" id="map"></div>   
    
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyCVIUnK94f7R_zUyalAEO6zbfwAEWBMxh4", v: "weekly"});
    </script>
    <script>
        async function initMap(){
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
            const center = { lat: <?php echo $latitud_c;?>, lng: <?php echo $longitud_c;?> };
            const map = new Map (document.getElementById('map'), {
                zoom: <?php echo $zoom_c;?>,
                center,
                mapId: "Mapa SAFCI"
            });
            for (const property of properties){
                const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                map,
                content:buildContent(property),
                position: property.position,
                title: property.description,   
                })
                AdvancedMarkerElement.addListener("click", () => {
                    toggleHighlight(AdvancedMarkerElement, property);
                });
            }
            }
            function toggleHighlight (markerView, property) {
                if (markerView.content.classList.contains("highlight")) {
                    markerView.content.classList.remove("highlight");
                    markerView.zIndex = null;
                }else {
                    markerView.content.classList.add("highlight");
                    markerView.zIndex = 1 ;
                }
            }
            function buildContent(property) {
                const content = document.createElement("div");
                content.classList.add("property");
                content.innerHTML = `
                    <div class="icon">
                        <i aria-hidden="true" class="fa fa-icon fa-${property.type}" title="${property.type}"></i>
                        <span class="fa-sr-only">${property.type}</span>
                        </div>
                    <div class="details">
                    <div class="price">
                    <a href="imprime_carpeta_familiar.php?idcarpeta_familiar=${property.idcarpeta_familiar}" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1280,height=800,scrollbars=YES,top=60,left=400'); return false;">
                    <span>${property.price}</span>
                    </a> 
                    
                    
                    </div>
                    <div class="address">${property.address}</div>
                    <div class="features">
                    <div>
                    <i aria-hidden="true" class="fa fa-users fa-lg users" title="users"></i>
                    <span class="fa-sr-only">Familia:</span>
                    <a href="imprime_carpeta_familiar.php?idcarpeta_familiar=${property.idcarpeta_familiar}" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1280,height=800,scrollbars=YES,top=60,left=400'); return false;">
                    <span> ${property.users}</span>
                    </a> 
                    </div>
                    </div>
                    </div>
                    `;
            return content;
            }

            const properties = [
           <?php
/****** Areas de influencia del Establecimiento de salud *********/

$numero4 = 0;
$sql4 = " SELECT carpeta_familiar.idcarpeta_familiar, carpeta_familiar.familia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,  ";
$sql4.= " ubicacion_cf.avenida_calle, ubicacion_cf.no_puerta, ubicacion_cf.latitud, ubicacion_cf.longitud   ";
$sql4.= " FROM carpeta_familiar, area_influencia, tipo_area_influencia, ubicacion_cf WHERE ubicacion_cf.idcarpeta_familiar=carpeta_familiar.idcarpeta_familiar AND  ";
$sql4.= " ubicacion_cf.idarea_influencia=area_influencia.idarea_influencia AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
$sql4.= " AND carpeta_familiar.estado='CONSOLIDADO' AND  ubicacion_cf.idarea_influencia='$idarea_influencia' ";
$result4 = mysqli_query($link,$sql4);
$total4 = mysqli_num_rows($result4);
 if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do {
	?>
            {
            address: '<?php echo $row4[2]." ".$row4[3]." Dir. ".$row4[4]." Nro. ".$row4[5];?>',
            description: 'Carpeta Familiar>',
            price: '<?php echo "Familia: ".$row4[1];?>',
            type: 'users',
            users: 'Ver Carpeta Familiar',
            idcarpeta_familiar: '<?php echo $row4[0];?>',
            size: 300,
            position: {  
                lat: <?php echo $row4[6];?>,
                lng: <?php echo $row4[7];?>,
            },
            }
            
<?php 
$numero4++;
if ($numero4 == $total4) {
echo ",";
}
else {
echo ",";
}
} while ($row4 = mysqli_fetch_array($result4));
} else {
}
?>

            ];

            initMap();


        </script>
</body>
</html>