
<?php
include("../../db_connect.php");

global $pdo;
var_dump($_POST);
if (isset($_POST['search'])) {
    if ($_POST['reservation']  == 'past') {
        $sql = "SELECT * FROM past_customer where ";
        if (!empty($_POST['tel']) && !empty($_POST['name'])) {
            $sql .= " phone_number =" . $_POST['tel'] . "and customer_name = " . $_POST['name'];
        } else if (!empty($_POST['name'])) {
            $sql .= " customer_name =" . $_POST['name'];
        } else if (!empty($_POST['tel'])) {
            $sql .= " phone_number =" . $_POST['tel'];
        }
    } else if ($_POST['reservation']  == 'future') {
        $sql = "SELECT * FROM customer where";
        echo $sql;
        if (!empty($_POST['tel']) && !empty($_POST['name'])) {
            $sql .= " phone_number =" . $_POST['tel'] . "and customer_name = " . $_POST['name'];
        } else if (!empty($_POST['name'])) {
            $sql .= " customer_name =" . $_POST['name'];
        } else if (!empty($_POST['tel'])) {
            $sql .= " phone_number =" . $_POST['tel'];
        }
    }
    echo $sql;
    echo "<br>";
    $smt = $pdo->query($sql);
    $data = $smt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($data);
}

foreach ($data as $row) {
    $res .= "<tr>
                <td>" . $row['reseravetion_id'] . "</td>
                <td>" . $row['stay_date'] . "</td>
                <td>" . $row['reservation_date'] . "</td>
                <td>" . $row['stay_count'] . "</td>
                <td>" . $row['customer_name'] . "</td>
                <td>" . $row['customer_address'] . "</td>
                <td>" . $row['phone_number'] . "</td></th></tr>";
}
echo $res;
