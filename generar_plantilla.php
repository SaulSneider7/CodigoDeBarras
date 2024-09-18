<?php
// generar_plantilla.php

$file = 'template/plantilla.xlsx';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} else {
    echo "El archivo no existe.";
}
?>
