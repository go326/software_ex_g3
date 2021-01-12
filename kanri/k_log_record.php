<?php
session_start();
# var
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';

$sql = "";
$date = "";
$date = date('Y-m-d H:i:s');
$name="";
//$name = $_SESSION['user'];
$name = "admin";

try {
  $pdo = new PDO($dsn, $user, $password);

  // INSERT
  function KLogRecodeP($work,$table,$line,$attribute,$befor,$after)
  {
    global $pdo, $sql,$date,$name;
    if($name != "" and $work != "" and $table != "" and $line != "" and $attribute != "" and $befor != "" and $after != ""){
      $sql = "INSERT INTO log VALUES('$date','$name','$work','$table','$line','$attribute','$befor','$after')";
      //  echo $sql;
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
    }
  }

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
  }
?>