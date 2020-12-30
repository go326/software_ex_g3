<?php
    $room_number = $_GET['room_number'];
?>

<!DOCTYPE html>
<html>
    <head>
        <!--文字コードUTF-8-->
        <meta http-equiv="Content-Type" content="test/html" charset="UTF-8">
        <link rel="stylesheet" href="clean_management.css" type="text/css"> 
    </head>
    <body>
        <!--ヘッダー-->
        <header>
            <h1>清掃情報編集画面</h1>
        </header>
        <!--確認用の出力文＿-->
        <?php
            echo ($room_number."号室の掃除状況を変更します。<br>");
        ?>
            <!--メイン-->
        <div class="content">
            <!--i行目-->
            <form method = “get” action = "s_clean_management.php">
                <input type = "radio" value="0" name="room_clean">掃除していない
                <input type = "radio" value="1" name="room_clean">チェックイン状態
                <input type = "radio" value="2" name="room_clean">掃除済み
                <input type = "submit" value=".$room_number." name="room_number">
            </form>
                <button>未清掃</button>
                <!--2行目-->
            <div class="inner">
                <button>清掃済み</button>
            </div>
            <!--3行目-->
            <div class="inner">
                <button onclick="location.href='./clean_management.html'">戻る</button>
                <button onclick="location.href='./clean_management.html'">完了</button>
            </div>
        </div>
        <!--フッター-->
    </body>
</html>