<!DOCTYPE html>

<?php
include("../db_connect.php");

global $pdo;

//insert か select か判定
if (isset($_POST['reservation'])) {
    //insert
    var_dump($_POST);
    foreach ($_POST as $value) {
        $sql = "INSERT into customer values(' . implode(',', array_fill(0, count($value), '?')) . ')";
        echo $sql;
        //$smt = $pdo ->prepare($sql);
        //$smt ->sxecute($parms);
    }
} else {
    //select
    $sql = "SELECT * FROM customer ";
    echo $sql;
    $smt = $pdo->query($sql);
    $data = $smt->fetch();
    var_dump($data);
}
