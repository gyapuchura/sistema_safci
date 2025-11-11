<?php include("../cabf.php");?>
<?php 
include("../inc.config.php");
$idmunicipio_salud = $_POST["municipio_salud"];

$sql2 = " SELECT idestablecimiento_salud, establecimiento_salud FROM establecimiento_salud WHERE latitud != '' AND longitud != '' ";
$sql2.= " AND idmunicipio='$idmunicipio_salud' ";
$result2 = mysqli_query($link,$sql2);
$row2 = mysqli_num_rows($result2);

?>
        <div class="form-group row">
            <div class="col-sm-4">
            <a class="btn btn-warning btn-icon-split" href="mapa_municipio.php?idmunicipio_salud=<?php echo $idmunicipio_salud;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1200,height=900,scrollbars=YES,top=50,left=200'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GENERAR MAPA DEL MUNICIPIO</span></a>
            </div>
            <div class="col-sm-4">
            <h6 class="text-info-center">NÚMERO DE ESTABLECIMIENTOS : <?php echo $row2;?></h6> 
            </div>
            <div class="col-sm-4">
            <a href="detalle_establecimientos_e.php?idmunicipio=<?php echo $idmunicipio_salud;?>" target="_blank" class="text-info" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;">VER DETALLE</a>  
            </div>
        </div>
        