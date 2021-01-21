<?php
include("../../db_connect.php");

global $pdo;

ini_set('display_errors', "On");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
try {
    if (isset($_POST['search'])) {
        $sql = "SELECT * FROM " . $_POST['reservation'] . " where ";
        // if ($_POST['reservation']  == 'past') {
        if (!empty($_POST['tel']) && !empty($_POST['name'])) {
            $sql .= " phone_number = :phone and customer_name like :name";
            $name = "%" . $_POST['name'] . "%";
            $smt = $pdo->prepare($sql);
            $smt->bindValue(':phone', $_POST['tel'], PDO::PARAM_STR);
            $smt->bindValue(':name', $name, PDO::PARAM_STR);
        } else if (!empty($_POST['name'])) {
            $sql .= " customer_name like :name ";
            $name = "%" . $_POST['name'] . "%";
            $smt = $pdo->prepare($sql);
            $smt->bindValue(':name', $name, PDO::PARAM_STR);
        } else if (!empty($_POST['tel'])) {
            $sql .= " phone_number = :phone";
            $smt = $pdo->prepare($sql);
            $smt->bindValue(':phone', $_POST['tel'], PDO::PARAM_STR);
        }
        $smt->execute();
        $data = $smt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        header("Location:./f_search.html");
    }
} catch (PDOException $e) {
    var_dump($e->getMessage());
}

?>
<form method="post" action="../f_information/f_information.php">
    <?php
    $res = "<h1>検索結果</h1>";
    $res .= "<table>";
    $res .= "<tr>";
    $res .= "<th>予約ID</th>";
    $res .= "<th>宿泊日</th>";
    $res .= "<th>予約日</th>";
    $res .= "<th>宿泊数</th>";
    $res .= "<th>氏名</th>";
    $res .= "<th>住所</th>";
    $res .= "<th>電話番号</th>";
    $res .= "</tr>";
    foreach ($data as $row) {

        $res .= "<tr>";
        $res .= "<td>" . $row['reseravetion_id'] . "</td>";
        $res .= "<td>" . $row['stay_date'] . "</td>";
        $res .= "<td>" . $row['reservation_date'] . "</td>";
        $res .= "<td>" . $row['stay_count'] . "</td>";
        $res .= "<td>" . $row['customer_name'] . "</td>";
        $res .= "<td>" . $row['customer_address'] . "</td>";
        $res .= "<td>" . $row['phone_number'] . "</td>";
        $res .= "<td><button name = 'ID' type= submit value=" . $row['reseravetion_id'] . "> 詳細 </td></tr>";
    }
    $res .= "</table>";
    echo $res;
    ?>
</form>
<html>

<head>
    <link rel="stylesheet" href="f_search.css" type="text/css">
</head>
<body>
    <input type="button" class="button1" id="back_button" onclick="location.href='f_search.html'" value="戻る">
</body>

</html>