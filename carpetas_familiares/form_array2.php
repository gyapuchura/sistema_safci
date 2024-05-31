<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ENVIO DE VARIAS VARIABLES EN UN ARRAY</h1>

    <form action="guarda_determinante_salud2.php" method="POST">
    NO<input type="radio" name="campo[0]" value="1" checked>
    SI<input type="radio" name="campo[0]" value="5" ></br></br>
    NO<input type="radio" name="campo[1]" value="1" checked>
    SI<input type="radio" name="campo[1]" value="5" ></br></br>
    NO<input type="radio" name="campo[2]" value="1" checked>
    SI<input type="radio" name="campo[2]" value="5" ></br></br>
    NO<input type="radio" name="campo[3]" value="1" checked>
    SI<input type="radio" name="campo[3]" value="5" ></br></br>
    NO<input type="radio" name="campo[4]" value="1" checked>
    SI<input type="radio" name="campo[4]" value="5" ></br></br>

    <input type="submit" value="enviar">
</form>
</body>
</html>