<?php
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPA PARLANTE</title>
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
    <div class="sala"><h3>SALA SITUACIONAL</h3></div>
    <div class="map" id="map"></div>   
    
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyDwC0dKzZNKNbnzsslPYLNSExYd8uLqRIk", v: "weekly"});
    </script>
    <script>
        async function initMap(){
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
            const center = { lat: -16.509091198231314, lng: -68.11980700825897 };
            const map = new Map (document.getElementById('map'), {
                zoom: 14,
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
            {
            address: '215 Emily St, MountainView, CA',
            description: 'Single family house with modern design',
            price: '$ 3,889,000',
            type: 'home',
            bed: 5,
            bath: 4.5,
            size: 300,
            position: {  
                lat: -16.51220974910444,
                lng: -68.13059582272511,
            },
            }, {
            address: '108 Squirrel Ln &#128063;, Menlo Park, CA',
            description: 'Townhouse with friendly neighbors',
            price: '$ 3,050,000',
            type: 'building',
            bed: 4,
            bath: 3,
            size: 200,
            position: {
                lat: -16.514123004485352, 
                lng: -68.13305809056158,
            },
            },
            {
            address: '100 Chris St, Portola Valley, CA',
            description: 'Spacious warehouse great for small business',
            price: '$ 3,125,000',
            type: 'warehouse',
            bed: 4,
            bath: 4,
            size: 800,
            position: {
                lat: -16.513413250680937, 
                lng: -68.13500537423302,
            },
            }, {
            address: '2117 Su St, MountainView, CA',
            description: 'Single family house near golf club',
            price: '$ 1,700,000',
            type: 'home',
            bed: 4,
            bath: 3,
            size: 200,
            position: {
                lat: -16.509352688682082, 
                lng: -68.13292934452909,
            },
            }, {
            address: '700 Jose Ave, Sunnyvale, CA',
            description: '3 storey townhouse with 2 car garage',
            price: '$ 3,850,000',
            type: 'building',
            bed: 4,
            bath: 4,
            size: 600,
            position: {
                lat: -16.50701763403952, 
                lng: -68.12919570965798,
            },
            }, {
            address: '868 Will Ct, Cupertino, CA',
            description: 'Single family house in great school zone',
            price: '$ 2,500,000',
            type: 'home',
            bed: 3,
            bath: 2,
            size: 100,
            position: {
                lat: -16.504836852720977, 
                lng: -68.13584758792597,
            },
            }, {
            address: '2019 Natasha Dr, San Jose, CA',
            description: 'Single family house',
            price: '$ 2,325,000',
            type: 'home',
            bed: 4,
            bath: 3.5,
            size: 500,
            position: {
                lat: -16.503406987462995, 
                lng: -68.13559009580273,
            },
            }];

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