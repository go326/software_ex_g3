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
        <div class="button-area">
            <?php
                echo ($room_number."号室の掃除状況を変更します。<br>");
            ?>
            <!--メイン-->
        
            <!--i行目-->
            <form  id = "clean_edit" method = “get” action = "s_clean_edit_done.php">
                <input type = "radio" value="0" name="room_clean">掃除していない<br>
                <input type = "radio" value="1" name="room_clean">チェックイン状態<br>
                <input type = "radio" value="2" name="room_clean">掃除済み<br>
            </form>
            <div class="input#submit_button">
                <div class="inline">
                    <!--戻るボタン-->
                    <form  id = "clean_back" action = "s_clean_management.php">
                        <input id="submit_button" type="submit" name="submit" value="戻る" onclick="location.href='./s_clean_management.php'"> 
                    </form>
                    <!--完了ボタン-->
                    <input id="submit_button" type="submit" name="submit" value="完了" form = "clean_edit" value="<?php echo $room_number; ?>" name="room_number"></input>
                </div>
            </div>
        </div>
        <!--フッター-->
    </body>
</html>