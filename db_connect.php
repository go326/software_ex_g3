<?php


$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';

$pdo = new PDO($dsn, $user, $password);

ini_set('display_errors', "On");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
