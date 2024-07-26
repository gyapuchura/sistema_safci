<?php include("../cabf.php"); ?>
<?php include("../inc.config.php");?>
<?php 
date_default_timezone_set('America/La_Paz');
$fecha_ram				= date("Ymd");
$fecha 					= date("Y-m-d");
$gestion                = date("Y");

$idmunicipio = $_GET['idmunicipio'];
$iddepartamento  = $_GET['iddepartamento']; 
$idsospecha_diag = $_GET['idsospecha_diag']; 

$sql1 = " SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud, municipios.municipio ";
$sql1.= " FROM registro_enfermedad, notificacion_ep, municipios, establecimiento_salud WHERE notificacion_ep.idmunicipio=municipios.idmunicipio ";
$sql1.= " AND registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql1.= " AND registro_enfermedad.cifra !='0' AND notificacion_ep.estado='CONSOLIDADO' AND establecimiento_salud.latitud != '' ";
$sql1.= " AND establecimiento_salud.longitud != '' AND establecimiento_salud.idmunicipio='$idmunicipio' LIMIT 1  ";
$result1 = mysqli_query($link,$sql1);
$row1 = mysqli_fetch_array($result1);

$latitud_c  = $row1[1];
$longitud_c = $row1[2];
$zoom_c     = "12";


$sql_d = " SELECT iddepartamento, departamento FROM departamento WHERE iddepartamento='$iddepartamento' ";
$result_d = mysqli_query($link,$sql_d);
$row_d    = mysqli_fetch_array($result_d);

$sql_sos = " SELECT idsospecha_diag, sospecha_diag FROM sospecha_diag WHERE idsospecha_diag='$idsospecha_diag' ";
$result_sos = mysqli_query($link,$sql_sos);
$row_sos = mysqli_fetch_array($result_sos);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPA SAFCI MUNICIPIO</title>
    <style>
        :root {
            --building-color: #FF9800;
            --house-color: #E84C8C;
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

            .property .enfermedad {
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

            .property .user {
            color: #E84C8C;
            }

            .property .users {
            color: #E84C8C;
            }

            .property .mapa {
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
    <script src="../js/all.js"></script>
</head>
<body>
    <div class="sala"><h4 class="text-primary">MUNICIPIO : <a href="../sala_situacional/detalle_establecimientos_e.php?idmunicipio=<?php echo $idmunicipio;?>" target="_blank" class="text-info" onClick="window.open(this.href, this.target, 'width=700,height=400,scrollbars=YES,top=70,left=400'); return false;"><?php echo mb_strtoupper($row1[3]);?></a> - <?php echo $row_d[1];?> </h4></div>  
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
                    <div class="enfermedad">Enfermedad: ${property.enfermedad}</div>
                    <div class="features">

                    <div>
                    <i aria-hidden="true" class="fa fa-user fa-lg user" title="sospecha"></i>                   
                    <span class="fa-sr-only">sospecha</span>
                    <a href="marco_ep_establecimiento.php?idsospecha_diag_estab=<?php echo $idsospecha_diag;?>&idestablecimiento_salud=${property.description}" target="_blank" class="Estilo12" style="font-size: 12px; font-family: Arial;" onClick="window.open(this.href, this.target, 'width=1000,height=400,scrollbars=YES,top=60,left=400'); return false;">
                    <span>Sospechas: ${property.user}</span>
                    </div>
                    </a> 
 
                    <div>
                    <i aria-hidden="true" class="fa fa-users fa-lg users" title="grupos"></i>
                    <span class="fa-sr-only">grupos</span>
                    <a href="piramide_sospechas_estab.php?idsospecha_diag_estab=<?php echo $idsospecha_diag;?>&idestablecimiento_salud=${property.description}" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=700,height=400,scrollbars=YES,top=50,left=300'); return false;">
                    <span>${property.users}</span>
                    </a>
                    </div>
                    <div>
                    <i aria-hidden="true" class="fa fa-map fa-lg map" title="map"></i>
                    <span class="fa-sr-only">mapa</span>
                    <a href="detalle_notificaciones_estab.php?idestablecimiento_salud=${property.description};?>&idmunicipio=<?php echo $idmunicipio;?>&idsospecha_diag=<?php echo $idsospecha_diag?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=800,height=500,scrollbars=YES,top=50,left=300'); return false;">
                    <span>${property.mapa}</sup></span>
                    </a>
                    </div>
                    </div>
                    </div>
                    `;
            return content;
            }

            const properties = [
           
                <?php 
$numero2 = 0;
$sql2 = " SELECT notificacion_ep.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, ";
$sql2.= " tipo_establecimiento.tipo_establecimiento, establecimiento_salud.latitud, establecimiento_salud.longitud ";
$sql2.= " FROM  registro_enfermedad, notificacion_ep, establecimiento_salud, nivel_establecimiento, tipo_establecimiento ";
$sql2.= " WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql2.= " AND notificacion_ep.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud ";
$sql2.= " AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento ";
$sql2.= " AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.latitud !='' ";
$sql2.= " AND establecimiento_salud.longitud !='' AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.cifra != '0' ";
$sql2.= " AND notificacion_ep.idmunicipio = '$idmunicipio' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' GROUP BY notificacion_ep.idestablecimiento_salud ";
$result2 = mysqli_query($link,$sql2);
$total2 = mysqli_num_rows($result2);
 if ($row2 = mysqli_fetch_array($result2)){
mysqli_field_seek($result2,0);
while ($field2 = mysqli_fetch_field($result2)){
} do {

$sql_c =" SELECT SUM(registro_enfermedad.cifra) FROM notificacion_ep, registro_enfermedad ";
$sql_c.=" WHERE registro_enfermedad.idnotificacion_ep=notificacion_ep.idnotificacion_ep ";
$sql_c.=" AND notificacion_ep.estado='CONSOLIDADO' AND registro_enfermedad.idsospecha_diag='$idsospecha_diag' ";
$sql_c.=" AND notificacion_ep.gestion='$gestion' AND notificacion_ep.idestablecimiento_salud='$row2[0]' ";
$result_c = mysqli_query($link,$sql_c);
$row_c = mysqli_fetch_array($result_c);

	?>
            {
            enfermedad: '<?php echo $row_sos[1];?>',
            description: '<?php echo $row2[0];?>',
            price: '<?php echo "Establecimiento: ".$row2[1]." - ".$row2[2];?>',
            type: 'home',
            user: <?php echo $row_c[0];?>,
            users: 'Grupos',
            mapa: 'Notificaciones F-302A',
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
echo "";
/*
Si no se encontraron resultados
*/
}
?>

            ];

            initMap();

            // map = new google.maps.Map(document.getElementById('map'),{
              //  zoom: 10,
             //   center: { lat: -16.509091198231314, lng: -68.11980700825897 },
                
           // });
            
           // const contentString = 
           // '<div class="contenido">'+
           // '<div class="centro"><h3>CENTRO DE SALUD LAS PALMAS</h3></div>'+
           // '<div class="POBLACION"><H4>POBLACION: 5000 HHABITANTES</H4></div>'+
           // '<div class="AREA"><H3>AREA DE INFLUENCIA: BARRIO LOS PINOS</H3></div>'+
           // '<div class="MEDICOS"><H3>LISTA DE PERSONAL DEPENDIENTE</H3></div>'+
           // '</div>';

            //const infowindow = new google.maps.InfoWindow({
               // content: contentString,
               // maxWidth:200,
              //  arialLabel: "Salud Familair Comunitaria Intercultural",
            //});
            //const marker = new google.maps.Marker({
               // position:{ lat: -16.509091198231314, lng: -68.11980700825897 },
               // map,
             //   title: "esta es una prueba de mapas de safci"
           // });
           // marker.addListener("click", () => {
                //infowindow.open({
                 //   anchor:marker, 
               //     map,
             //   });
           // });
        //window.initMap = initMap


        </script>
</body>
</html>