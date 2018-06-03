<?php

require_once 'ConnectionToDB.php';
require_once 'AvitoParser.php';
require_once 'MailNotification.php';

$parse = new AvitoParser;
$mas = $parse->parseAvitoPages2();
Write_On_DB($mas);

echo '<pre>';

print_r($mas);

echo '</pre>';