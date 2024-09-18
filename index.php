<!-- index.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Generador de Códigos de Barras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css?v=2.0">
</head>

<body>
    <div class="container">
        <h1 class="title">BrandDingPeru</h1>
        <h2>Generador de Códigos de Barras</h2>
        <a href="generar_plantilla.php" class="button">Descargar Plantilla de Excel</a>

        <h2>Subir Archivo Excel</h2>
        <form action="procesar.php" method="post" enctype="multipart/form-data" target="_blank">
            <input type="file" name="archivo_excel" />
            <input type="submit" value="Generar Códigos" class="button" />
        </form>
    </div>
</body>

</html>