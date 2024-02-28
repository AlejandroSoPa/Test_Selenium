<?php

function escribirEnLog($mensaje) {
    $fechaHoraActual = date('Y-m-d H:i:s');

    $fechaActual = date('Y-m-d');

    $directorioLogs = 'logs/';

    if (!file_exists($directorioLogs)) {
        mkdir($directorioLogs, 0755, true);
    }
    
    $rutaArchivo = $directorioLogs . 'log_' . $fechaActual . '.txt';

    $archivo = fopen($rutaArchivo, 'a');
    
    if ($archivo) {
        $mensajeFormateado = $fechaHoraActual . " " . $mensaje . "\n";
        fwrite($archivo, $mensajeFormateado);
        fclose($archivo);
    } else {
        echo "Error al abrir el archivo de log.";
    }
}


?>
