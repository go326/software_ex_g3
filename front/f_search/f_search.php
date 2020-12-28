
<?php
include("../../db_connect.php");

global $pdo;

if (isset($_POST['sarch'])) {
    if ($_POST['reservation']  = 'past') {
        $sql = "SELECT * FROM past_customer where ";
        if (isset($_POST['tel']) && isset($_POST['name'])) {
            $sql .= " phone_number =" . $_POST['tel'] . "and customer_name = " . $_POST['tel'];
        } else if (isset($_POST['name'])) {
            $sql .= " customer_name =" . $_POST['name'];
        } else if (isset($_POST['tel'])) {
            $sql .= " phone_number =" . $_POST['tel'];
        }
        echo $sql;
    } else if ($_POST['reservation']  = 'future') {
        $sql = "SELECT * FROM customer where";
        if (isset($_POST['tel']) && isset($_POST['name'])) {
            $sql .= " phone_number =" . $_POST['tel'] . "and customer_name = " . $_POST['tel'];
        } else if (isset($_POST['name'])) {
            $sql .= " customer_name =" . $_POST['name'];
        } else if (isset($_POST['tel'])) {
            $sql .= " phone_number =" . $_POST['tel'];
        }
    }
    //$smt = $pdo->query($sql);
    //$data = $smt->fetch(PDO::FETCH_NUM);
}
