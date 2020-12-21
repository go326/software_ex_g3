<!-- 食事情報閲覧画面を表示するためのPHP -->

<?php
#データベースへの接続
$dsn = 'mysql:dbname=admin;host=localhost';
$user = 'admin';
$password = 'software_ex_g3';

// 変数宣言
$res = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    echo ('接続に成功');
    

    #SELECT (costomer)
    $sql = "SELECT customer_name,adult,child,dinner_menu FROM customer WHERE is_dinner = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $res .= "</tr><td>"
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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>infoPHP</title>
</head>

<body>
    <table>
        <?php echo $res; ?>
    </table>
</body>

</html>