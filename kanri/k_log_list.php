<?php
session_start();
# var
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';

$sql = "";
$res="";


try {
  $pdo = new PDO($dsn, $user, $password);
  // SELECT
  function KLogListP()
  {
    global $pdo, $sql, $res;
    $sql = "SELECT * FROM log";
    $stmt = $pdo->query($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $res .= "<tr><td>";
      $res .= substr($row['log_date'], 0, 10);
      $res .= "</td><td>";
      $res .= $row['log_name'];
      $res .= "</td><td>";
      $res .= $row['log_work'];
      $res .= "</td><td>";
      $res .= $row['log_table'];
      $res .= "</td><td>";
      $res .= $row['log_line'];
      $res .= "</td><td>";
      $res .= $row['log_attribute'];
      $res .= "</td><td>";
      $res .= $row['log_befor'];
      $res .= "</td><td>";
      $res .= $row['log_after'];
      $res .= "</td></tr>";
    }
  }

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
  }
?>
<?php require_once("k_log_record.php"); ?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<title>log</title>
</head>

<body>
<?php KLogRecodeP("work","table","line","attribute","befor","after"); ?>

  <!-- Management -->
  <table>
    <?php KLogListP(); echo $res; ?>
  </table>

</body>

</html>