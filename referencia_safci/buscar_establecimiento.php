<?php include("../cabf.php");?>
<?php include("../inc.config.php");

      $b = $_POST['b'];

      if ($b == '' || $b == ' ') {
            echo "No se han escrito el nombre del Establecimiento";
      } else {
            echo "<option value=''> - SELECCIONE DE LA LISTA DE ESTABLECIMIENTOS COINCIDENTES - </option>";
            $numero=1;
            $sql =" SELECT establecimiento_salud.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, nivel_establecimiento.nivel_establecimiento, tipo_establecimiento.tipo_establecimiento,";
            $sql.=" subsector_salud.subsector_salud, municipios.municipio, departamento.departamento FROM establecimiento_salud, subsector_salud, nivel_establecimiento, tipo_establecimiento, departamento, municipios ";
            $sql.=" WHERE establecimiento_salud.idsubsector_salud=subsector_salud.idsubsector_salud AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento AND establecimiento_salud.iddepartamento=departamento.iddepartamento ";
            $sql.=" AND establecimiento_salud.idmunicipio=municipios.idmunicipio  AND establecimiento_salud.idtipo_establecimiento=tipo_establecimiento.idtipo_establecimiento AND establecimiento_salud.establecimiento_salud LIKE '%$b%' ";
            $result = mysqli_query($link,$sql);

            $contar = mysqli_num_rows($result);

            if($contar == 0){
                  echo "No se han encontrado resultados para '<b>".$b."</b>'.";
            }else{
                  while($row = mysqli_fetch_array($result)){
                        $idestablecimiento_salud = $row[0];
                        $establecimiento_salud   = $row[1];
                        $nivel_establecimiento   = $row[2];
                        $tipo_establecimiento    = $row[3];
                        $subsector_salud         = $row[4];
                        $municipio               = $row[5];
                        $departamento            = $row[6];
	                  
                        echo "<option value=".$idestablecimiento_salud." >".$numero.".- ".$establecimiento_salud." - ".$nivel_establecimiento." - ".$tipo_establecimiento." - ".$subsector_salud." - Mun. ".$municipio." - ".$departamento." </option> ";                        
                        
                        $numero = $numero+1;
                  }
            }      
      }
?>

