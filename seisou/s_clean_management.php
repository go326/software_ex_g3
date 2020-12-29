<?php
    
    include '../db_connect.php';


    //SCleanManagemantP();
    //原因不明だが、POST方式に変更する予定
    //これで選択された部屋番号を受け取ることができる。
    //部屋情報更新
    echo("開始前<br>");
    if(isset($_GET["room_number"])){
        $room_number = $_GET["room_number"];
        echo ($room_number);
        SCleanEditP($room_number);
    }else{
        echo("失敗");
    }
    echo("開始後");

function SCleanManagemantP(){
    global $pdo,$room_number,$room_clean;
    $stmt = $pdo -> query("SELECT * FROM room");
    //fetch
    while ($row = $stmt -> fetch()){
        $room_number = $row["room_number"];
        $room_clean = $row["room_clean"];
        echo($room_number.",".$room_clean."<br>");
    }
    //return [$room_number,$room_clean];
}

//宿泊人数を表示
function SCleanNumberP(){
    echo ("test");
}

//掃除状況を変更する
function SCleanEditP($room_number){
    echo ($room_number."test");

}

//list($room_number,$room_clean) = SCleanManagemantP();
//var_dump($room_number);
//var_dump($room_clean);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>seisou</title>
    </head>

    <body>
        <h1> 清掃情報管理画面php</h1>

        <form method = “get” action = "s_clean_management.php">
            <intput type radio value="0" name="room_clean">掃除していない
            <intput type radio value="1" name="room_clean">チェックイン状態
            <intput type radio value="2" name="room_clean">掃除済み
            <input type="submit" value="201" name="room_number">
            <!--onclick="SCleanManagemantP()">-->
        </form>
    </body>
</html>
