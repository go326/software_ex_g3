<?php

// var
// DB
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';
// HTML
$rinfo = "";
// PHP

try {
    // DB接続
    $pdo = new PDO($dsn, $user, $password);
    // echo ('接続に成功');

    // SELECT (costomer)
    $sql = "SELECT customer_name,adult,child,dinner_menu FROM customer WHERE is_dinner = 1";
    $stmt = $pdo->query($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $rinfo .= "</tr><td>";
      $rinfo .= $row['customer_name'] . "</td><td>";
      //id button('' -> f_information_details.php or html)
      $rinfo .= "<form action='' method='post'>";
      $rinfo .= "<button type='submit' name='rf_d' ";
      $rinfo .= "value='" . $row['customer_id'] . "'>" . $row['costomer_name'] . "</button>";
      $rinfo .= "</form>";
      $rinfo .= $row['adult'] . "</td><td>";
      $rinfo .= $row['child'] . "</td><td>";
      $rinfo .= $row['dinner_menu'];
      $rinfo .= "</td></tr>";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
?>