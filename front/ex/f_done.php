<!DOCTYPE html>
<?php
require("./db.php");
$title = "";
if (strcmp($_POST['is'], 'reservation') == 0) {
    $title = "予約情報登録完了画面";
    db_insert($_POST['cus_info']);
} elseif (strcmp($_POST['is'], 'restore') == 0) {
    $title = "予約情報編集完了画面";
    db_update($_POST['cus_info']);
}
session_save_path("/var/tmp/");
session_start();
unset($_SESSION['info']);

?>

<html>

<head>
    <!--文字コードUTF-8-->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="../f_base.css" type="text/css">
    <link rel="stylesheet" href="../f_information/f_information.css" type="text/css">
</head>

<body>
    <!--ヘッダー-->
    <header>
        <h1> <?php echo $title; ?> </h1>
    </header>

    <!--メイン-->
    <div id="main">
        <div class="simple-box">
            <h2 class="central-configuration">変更を完了しました</h2>
        </div>
        <input type="button" onclick="location.href='../room.php'" value="フロントTOPへ">
    </div>
    </footer>
</body>

</html>
