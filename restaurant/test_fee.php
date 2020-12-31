<?php require("r_fee.php") ?>
<html>

<head>
  <meta charset="utf-8">
  <title>fee</title>
</head>

<body>

  <!-- 追加料金入力 -->
  <form action="" method="post">
    <p>
      place<input type="text" name="rf_place">
      add<input type="text" name="rf_add">
      naiyou<input type="text" name="rf_contents">
      bikou<input type="text" name="rf_remark">
    </p>
    <p> <input type="submit" name="rf_reg" value="登録"></p>
  </form>

  <!-- 表の表示 -->
  <table>
    <?php FeeSelectP();
    echo $rf_res; ?>
  </table>
  <!-- 追加料金をDBに入れる -->
  <?php FeeInsertP(); ?>

  <!-- ボタンの作成 -->
  <p>
    <!-- 予約詳細に飛ぶ -->
    <?php echo "<form action='' method='post'><button type='submit' name='fid' value='$id'>fid</button></form>"; ?>
    <!-- 追加料金入力確認画面に飛ぶ -->
    <?php echo "<form action='' method='post'><button type='submit' name='fac' value='$id'>fac</button></form>"; ?>
    <!-- 追加料金入力に飛ぶ -->
    <?php echo "<form action='' method='post'><button type='submit' name='fae' value='$id'>fae</button></form>"; ?>
  </p>

</body>

</html>