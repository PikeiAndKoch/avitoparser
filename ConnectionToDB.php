<?php

$host = '127.0.0.1';
$db = 'AvitoAds';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

function Write_On_DB($arr)
{
    $md5 = '';
    foreach ($arr as $key=>$value) {
        global $pdo;
        $md5 = md5($value[4]);
        $stmt = $pdo->prepare('SELECT * FROM Ads WHERE hash = :md5');
        $stmt->bindParam('md5', $md5);
        $stmt->execute();
        if ($stmt->fetchAll() == false) {
            $value[] = $md5;
            $stmt = $pdo->prepare('INSERT INTO ADS (ad_name, ad_price, ad_loc, ad_time, ad_src, hash) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute($value);
        }
    }
}

function Read_On_DB()
{

}
