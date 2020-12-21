<!-- 食事情報閲覧画面を表示するためのPHP -->

<?php
// 変数宣言
// DB
$dsn = 'mysql:dbname=admin;host=localhost';
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
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rinfo .= "</tr><td>"
            . $row['customer_name'] . "</td><td>"
            . $row['adult'] . "</td><td>"
            . $row['child'] . "</td><td>"
            . $row['dinner_menu'] . "</td><\tr>";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
?>