
<?php
include("../../db_connect.php");

global $pdo;
var_dump($_POST);
if (isset($_POST['search'])) {
    if ($_POST['reservation']  = 'past') {
        $sql = "SELECT * FROM past_customer where ";
        if (isset($_POST['tel']) && isset($_POST['name'])) {
            $sql .= " phone_number =" . $_POST['tel'] . "and customer_name = " . $_POST['tel'];
        } else if (isset($_POST['name'])) {
            $sql .= " customer_name =" . $_POST['name'];
        } else if (isset($_POST['tel'])) {
            $sql .= " phone_number =" . $_POST['tel'];
        }
    } else if ($_POST['reservation']  = 'future') {
        $sql = "SELECT * FROM customer where";
        echo $sql;
        if (isset($_POST['tel']) && isset($_POST['name'])) {
            $sql .= " phone_number =" . $_POST['tel'] . "and customer_name = " . $_POST['tel'];
        } else if (isset($_POST['name'])) {
            $sql .= " customer_name =" . $_POST['name'];
        } else if (isset($_POST['tel'])) {
            $sql .= " phone_number =" . $_POST['tel'];
        }
    }
    echo $sql;
    echo "<br>";
    $smt = $pdo->query($sql);
    $data = $smt->fetch(PDO::FETCH_NUM);
    var_dump($data);
}

foreach ($data as $row) {
    $res .= "<tr>
                <td>" . $row['予約ID'] . "</td>
                <td>" . $row['宿泊日'] . "</td>
                <td>" . $row['予約日'] . "</td>
                <td>" . $row['拍数'] . "</td>
                <td>" . $row['氏名'] . "</td>
                <td>" . $row['住所'] . "</td>
                <td>" . $row['電話番号'] . "</td></th></tr>";
}
echo $res;
