<?php
// Asegúrate de que no haya espacios en blanco antes de esta línea
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Picqer\Barcode\BarcodeGeneratorPNG;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo_excel'])) {
    $fileTmpPath = $_FILES['archivo_excel']['tmp_name'];
    $fileName = $_FILES['archivo_excel']['name'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('xlsx', 'xls');

    if (in_array($fileExtension, $allowedfileExtensions)) {
        try {
            // Cargar el archivo temporalmente sin moverlo
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            // Inicia el contenido HTML
            echo '<html>
                    <head>
                        <title>Codigos de Barras</title>
                        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
                    </head>
                <body>
                    <div style="width: 100%; text-align: center;">';

            $generator = new BarcodeGeneratorPNG();

            for ($row = 2; $row <= $highestRow; $row++) {
                $codigo = $sheet->getCell('A' . $row)->getValue();
                $descripcion = $sheet->getCell('B' . $row)->getValue();
                $talla = $sheet->getCell('C' . $row)->getValue();
                $color = $sheet->getCell('D' . $row)->getValue();
                $precio = $sheet->getCell('E' . $row)->getValue();

                // Generar el código de barras
                $barcode = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);
                $barcodeBase64 = base64_encode($barcode);
                $barcodeImg = 'data:image/png;base64,' . $barcodeBase64;

                // Crear la estructura visual sin las etiquetas
                echo '
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="img/logo.png" width="50" /><br><br>
                        <img src="' . $barcodeImg . '" width="200" height="50" />
                        <div style="font-size: 14px; font-weight: bold; margin-top: 10px;">
                            ' . htmlspecialchars($descripcion) . '
                        </div>
                        <div style="font-size: 12px; color: #555;">
                            ' . htmlspecialchars($color) . ' - ' . htmlspecialchars($talla) . '
                        </div>
                        <div style="font-size: 14px; color: #000; margin-top: 5px;">
                            S/' . htmlspecialchars($precio) . '
                        </div>
                    </div>
                    <br><hr><br>
                ';
            }

            // Finalizar el contenido HTML
            echo '</div></body></html>';

        } catch (Exception $e) {
            echo 'Error al procesar el archivo: ', $e->getMessage();
        }
    } else {
        echo "Tipo de archivo no permitido. Solo se aceptan archivos .xlsx y .xls.";
    }
} else {
    echo "No se ha subido ningún archivo.";
}
?>
