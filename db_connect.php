<?php


    $dsn = 'mysql:dbname=admin;host=localhost';
    $user = 'admin';
    $password = 'software_ex_g3';

    $pdo = new PDO($dsn, $user, $password);
    echo ('接続に成功<br>');

?>