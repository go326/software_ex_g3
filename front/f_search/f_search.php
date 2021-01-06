<?php
include("../../db_connect.php");

global $pdo;
var_dump($_POST);
if (isset($_POST['search'])) {
    $sql = "SELECT * FROM ? where ";

    // if ($_POST['reservation']  == 'past') {
    //     $sql = "SELECT * FROM past_customer where ";
    //     if (!empty($_POST['tel']) && !empty($_POST['name'])) {
    //         $sql .= " phone_number =" . $_POST['tel'] . " and customer_name like " . $_POST['name'];
    //     } else if (!empty($_POST['name'])) {
    //         $sql .= " customer_name like " . $_POST['name'];
    //     } else if (!empty($_POST['tel'])) {
    //         $sql .= " phone_number =" . $_POST['tel'];
    //     }
    // } else if ($_POST['reservation']  == 'future') {
    //     $sql = "SELECT * FROM customer where";
    //     if (!empty($_POST['tel']) && !empty($_POST['name'])) {
    //         $sql .= " phone_number =" . $_POST['tel'] . " and customer_name like " . $_POST['name'];
    //     } else if (!empty($_POST['name'])) {
    //         $sql .= " customer_name like " . $_POST['name'];
    //     } else if (!empty($_POST['tel'])) {
    //         $sql .= " phone_number =" . $_POST['tel'];
    //     }
    // }
    echo $sql;
    echo "<br>";
    $smt = $pdo->query($sql);
    $data = $smt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($data);
} else {
    header("Location:./f_search.html");
}

foreach ($data as $row) {
?>
    <form method="post" name="form1" action="../f_information/f_information.php">
    <?php
    $res .= "<tr>";
    $res .= "<td><a href='' value=" . $row['reservation_id'] . ">" . $row['reseravetion_id'] . "</a></td>";
    $res .= "<td>" . $row['stay_date'] . "</td>";
    $res .= "<td>" . $row['reservation_date'] . "</td>";
    $res .= "<td>" . $row['stay_count'] . "</td>";
    $res .= "<td>" . $row['customer_name'] . "</td>";
    $res .= "<td>" . $row['customer_address'] . "</td>";
    $res .= "<td>" . $row['phone_number'] . "</td></th></tr>";
}
echo $res;
    ?>
    </form>