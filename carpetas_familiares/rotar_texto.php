<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
.la {
    color: blue;
    font-size: 55px;
}
.webera {
    color: gray;
    display: block;
    font-size: 20px;
}
.es{
    -webkit-transform: rotate(-90deg); 
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    transform: rotate(-90deg);
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    height:20px;
    width:25px;
}
.inline-block{
    display:-moz-inline-stack;
    display:inline-block;
    zoom:1;
    *display:inline; 
}
</style>

<div class="contenedor">
  <span class="la">la</span> 
  <span class="es inline-block">.es</span>
  <span class="webera">webera</span> 
</div>


<table width="200" border="1" cellspacing="0" class="contenedor">
  <tbody>
    <tr>
      <td><h6 class="es inline-block">SEDENTARISMO</h6></td>
      <td ><h6 class="es inline-block">CONSUME ALCOHOL</h6></td>
      <td><h6 class="es inline-block">HÁBITO DE FUMAR</h6></td>
      <td><h6 class="es inline-block">CONSUME DROGAS ILICITAS</h6></td>
      <td><h6 class="es inline-block">PROMISCUIDAD</h6></td>
      <td><h6 class="es inline-block">CONSUME GASEOSAS</h6></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

<body>
    
</body>
</html>