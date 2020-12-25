<!DOCTYPE html>

<?php
include("../db_connect.php");

global $pdo;

$sql = "SELECT * FROM customer ";

$smt = $pdo->query($sql);

$data = $smt->fetch();

var_dump($data);
