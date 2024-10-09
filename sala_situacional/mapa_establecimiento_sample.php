<?php include("../cabf.php");?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idestablecimiento_e = $_GET['idestablecimiento_e'];

$sql1 = " SELECT idestablecimiento_salud, establecimiento_salud, latitud, longitud FROM establecimiento_salud ";
$sql1.= " WHERE latitud != '' AND longitud != '' AND idestablecimiento_salud='$idestablecimiento_e' ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = $row1[2];
$longitud_c = $row1[3];
$zoom_c     = "12";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPA SAFCI DEPARTAMENTO</title>
    <style>
        :root {
            --building-color: #FF9800;
            --house-color: #0288D1;
            --shop-color: #7B1FA2;
            --warehouse-color: #558B2F;
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

            .property .bed {
            color: #FFA000;
            }

            .property .bath {
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
            * Warehouse icon colors.
            */
            .property.highlight:has(.fa-warehouse) .icon {
            color: var(--warehouse-color);
            }

            .property:not(.highlight):has(.fa-warehouse) {
            background-color: var(--warehouse-color);
            }

            .property:not(.highlight):has(.fa-warehouse)::after {
            border-top: 9px solid var(--warehouse-color);
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
    <div class="sala"><h3 class="text-center">ESTABLECIMIENTO : <?php echo mb_strtoupper($row1[1]);?></h3></div>  
    <div class="map" id="map"></div>   
    
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk", v: "weekly"});
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
                    <div class="price">${property.price}</div>
                    <div class="address">${property.address}</div>
                    <div class="features">
                    <div>
                    <i aria-hidden="true" class="fa fa-bed fa-lg bed" title="bedroom"></i>
                    <span class="fa-sr-only">bedroom</span>
                    <span>${property.bed}</span>
                    </div>
                    <div>
                    <i aria-hidden="true" class="fa fa-bath fa-lg bath" title="bathroom"></i>
                    <span class="fa-sr-only">bathroom</span>
                    <span>${property.bath}</span>
                    </div>
                    <div>
                    <i aria-hidden="true" class="fa fa-ruler fa-lg size" title="size"></i>
                    <span class="fa-sr-only">size</span>
                    <span>${property.size} ft<sup>2</sup></span>
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
$sql4 = " SELECT area_influencia.idarea_influencia, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, ";
$sql4.= " area_influencia.habitantes, area_influencia.familias, area_influencia.distancia, area_influencia.latitud, area_influencia.longitud ";
$sql4.= " FROM area_influencia, tipo_area_influencia WHERE area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia ";
$sql4.= " AND area_influencia.idestablecimiento_salud='$idestablecimiento_e' ";
$result4 = mysqli_query($link,$sql4);
$total4 = mysqli_num_rows($result4);
 if ($row4 = mysqli_fetch_array($result4)){
mysqli_field_seek($result4,0);
while ($field4 = mysqli_fetch_field($result4)){
} do {
	?>
            {
            address: '<?php echo $row4[3];?>',
            description: '<?php echo $row4[4];?>',
            price: '<?php echo $row4[1]." - ".$row4[2];?>',
            type: 'warehouse',
            bed: 5,
            bath: 4.5,
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

<?php 
$numero2 = 0;
$sql2 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, ";
$sql2.= " nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud ";
$sql2.= " FROM establecimiento_salud, nivel_establecimiento, tipo_establecimiento WHERE establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !=''  ";
$sql2.= " AND establecimiento_salud.longitud !='' AND establecimiento_salud.idestablecimiento_salud = '$idestablecimiento_e' ORDER BY idestablecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {
	?>
            {
            address: '<?php echo $row2[3];?>',
            description: '<?php echo $row2[3];?>',
            price: '<?php echo $row2[1]." - ".$row2[2];?>',
            type: 'home',
            bed: 5,
            bath: 4.5,
            size: 300,
            position: {  
                lat: <?php echo $row2[4];?>,
                lng: <?php echo $row2[5];?>,
            },
            }
            
<?php 
$numero2++;
if ($numero2 == $total2) {
echo "";
}
else {
echo ",";
}
} while ($row2 = mysqli_fetch_array($result2));
} else {

}
?>
            ];

            initMap();


        </script>
</body>
</html>