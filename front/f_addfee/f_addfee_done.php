<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <!--文字コードUTF-8-->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="../f_base.css" type="text/css">
    <link rel="stylesheet" href="f_addfee.css" type="text/css">
</head>

<body>
    <!--ヘッダー-->
    <header>
        <h1>追加料金編集完了画面</h1>
    </header>
    <!--メイン-->
    <div id="main">
        <div class="simple-box">
            <h2 class="central-configuration">変更を完了しました</h2>
        </div>
        <!-- <input type="button" onclick="location.href='../f_information/f_information.php'" value="予約情報詳細へ"> -->
        <form method="POST" action="../f_information/f_information.php">    
        <button type="submit" name="ID" value="<?php echo $_SESSION['fee_id']; ?>">予約情報詳細へ</button>
        </form>
    </div>
    </footer>
</body>

</html>