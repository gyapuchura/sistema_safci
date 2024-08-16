<?php include("../cabf.php");?>
<?php 
include("../inc.config.php");
$idestablecimiento_e = $_POST["establecimiento_e"];

$sql2 = " SELECT idarea_influencia, area_influencia FROM area_influencia WHERE latitud != '' AND longitud != '' ";
$sql2.= " AND idestablecimiento_salud='$idestablecimiento_e' ";
$result2 = mysqli_query($link,$sql2);
$row2 = mysqli_num_rows($result2);
?>
        <div class="form-group row">
            <div class="col-sm-6">
            <a class="btn btn-info btn-icon-split" href="mapa_establecimiento.php?idestablecimiento_e=<?php echo $idestablecimiento_e;?>" target="_blank" class="Estilo12" onClick="window.open(this.href, this.target, 'width=1000,height=700,scrollbars=YES,top=50,left=200'); return false;">
            <span class="icon text-white-50">
                <i class="fas fa-book"></i>
            </span>
            <span class="text">GENERAR MAPA DEL ESTABLECIMIENTO DE SALUD</span></a>
            </div>
            <div class="col-sm-4">
            <h6 class="text-info-center">NÚMERO DE AREAS DE INFLUENCIA : <?php echo $row2;?></h6> 
            </div>
            <div class="col-sm-2">
            <a href="detalle_areas_influencia_e.php?idestablecimiento_salud=<?php echo $idestablecimiento_e;?>" target="_blank" class="text-info" onClick="window.open(this.href, this.target, 'width=800,height=700,scrollbars=YES,top=50,left=200'); return false;">VER DETALLE</a>  
            </div>
        </div>
        