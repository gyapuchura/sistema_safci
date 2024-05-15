<?php include("../inc.config.php"); ?>
<?php
$subsector = $_POST['subsector'];
if ($subsector == 'SI') { ?>

<form name="SUBSECTOR" action="guarda_subsector_cf.php" method="post"> 
<hr>      
        <div class="form-group row">  

        <div class="col-sm-4">   
        <h6 class="text-info">ASISTE/CORRESPONDE</h6>          
        <select name="idsubsector_elige"  id="idsubsector_elige" class="form-control" required>
            <option value="">Seleccione</option>
            <?php
            $sql1 = " SELECT idsubsector_elige, subsector_elige FROM subsector_elige ";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]."</option>";
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
        </select>
        </div>
        <div class="col-sm-4">  
        <h6 class="text-info">SUBSECTOR SALUD</h6>           
        <select name="idsubsector_salud"  id="idsubsector_salud" class="form-control" required>
            <option value="">Seleccione</option>
            <?php
            $sql1 = " SELECT idsubsector_salud, subsector_salud FROM subsector_salud WHERE indice='SI' ";
            $result1 = mysqli_query($link,$sql1);
            if ($row1 = mysqli_fetch_array($result1)){
            mysqli_field_seek($result1,0);
            while ($field1 = mysqli_fetch_field($result1)){
            } do {
            echo "<option value=".$row1[0].">".$row1[1]."</option>";
            } while ($row1 = mysqli_fetch_array($result1));
            } else {
            echo "No se encontraron resultados!";
            }
            ?>
        </select>
        </div>
        <div class="col-sm-4">    
        </br>
            <button type="submit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">ADICIONAR SUBSECTOR</span>    
            </button>
        </form> 
        </div>
        </div>       
   
<?php } else {  ?>
    
    <form name="SUBSECTOR" action="guarda_subsector_cf.php" method="post"> 
        <input type="hidden" name="idsubsector_elige" value="1">
        <input type="hidden" name="idsubsector_salud" value="9">
    <hr>      
        <div class="form-group row">  
        <div class="col-sm-4">               
        </div>       
        <div class="col-sm-8">    
        </br>
            <button type="submit" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file"></i>
            </span>
            <span class="text">NO CORRESPONDE A NINGUN SUBSECTOR</span>    
            </button>
        </form> 
        </div>
        </div>  
<?php } ?>