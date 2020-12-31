<!-- PHP -->
<?php
// 変数宣言
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';
$rinfo = "";

try {
  // DB接続
  $pdo = new PDO($dsn, $user, $password);
  // DBの呼び出し
  $sql = "SELECT customer_name,adult,child,dinner_menu FROM customer WHERE is_dinner = 1";
  $stmt = $pdo->query($sql);
  $stmt->execute();
  // 表の作成(基本的にhtml文と同じ)
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $rinfo .= "</tr><td>";
    //$rinfo .= $row['customer_name'] . "</td><td>";
    $rinfo .= "<form action='f_information_details.php' method='post'>";
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

<!DOCTYPE html>
<html>

<head>
  <!--文字コードUTF-8-->
  <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
  <title> </title>
  <link rel="stylesheet" href="restaurant.css" type="text/css">
  <script type="text/javascript" src="restaurant.js"></script>
</head>

<body>
  <header>
    <h1>食事情報閲覧画面</h1>
  </header>

  <!--メイン-->
  <div id="main">
    <!--食事情報閲覧画面-->
    <table border="1">
      <tr valign="top" ;>
        <th>名前</th>
        <th>大人</th>
        <th>子供</th>
        <th>メニュー</th>
      </tr>
    </table>
    <table border="1">
      <!-- 表の表示 -->
      <?php echo $rinfo; ?>
    </table>
  </div>
  <!--フッター-->
  <footer>
    <br><br>
    <center>
      <input type="button" onclick="location.href='../i_gernal_top.html'" value="戻る">
    </center>
  </footer>
</body>

</html>