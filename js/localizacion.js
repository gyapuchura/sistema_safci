class Localizacion {
    constructor(callback){
        //obtener ubicacion
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position)=>{
                this.latitude = position.coords.latitude;
                this.longitude = position.coords.longitude;

                callback();
            });
        }else{
            alert("Tu navegador no soporta geolocalizacion!! :(")
        }
    }

}
