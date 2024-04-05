<?php
function error($fileName, $status, $mesage, $line) {
    $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . $fileName . " Code: " .  $status . ", error: " . $mesage . ", Line: " . $line . PHP_EOL;
    $errorFile = fopen("./../errors.log", 'a');
    fwrite($errorFile, $errorMessage);
    fclose($errorFile);
}

?>
