<?php

/**
 * Logger von mmai
 *
 * @param mixed $mixedInput
 */
function devlog($mixedInput) {

    if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
        $rel_root = 'www.stama-neu.de/';
    } else {
        return false; // Produktionssystem nicht loggen
    }
    if (is_array($mixedInput) || is_object($mixedInput)) {
        // Das ist sehr viel unnötige Info, weg damit:
        if (is_array($mixedInput)) {
            unset($mixedInput['GLOBALS']['UTF8_LOOKUP_TABLE']);
            unset($mixedInput['GLOBALS']['HTTP_ENV_VARS']);
            unset($mixedInput['GLOBALS']['HTTP_SERVER_VARS']);
            unset($mixedInput['GLOBALS']['HTTP_SESSION_VARS']);
            unset($mixedInput['GLOBALS']['_SESSION']);
        }
        $mixedInput = print_r($mixedInput, true);
    }
    $mixedInput .= "\n";
    error_log(date("Y-m-d - H:i:s") . ' - ' . $mixedInput, 3, $_SERVER['DOCUMENT_ROOT'] . '/'.$rel_root.'/templates/mi/logfile.txt');
}
?>