<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>seisou</title>
    </head>

    <body>
        <h1> 清掃情報管理画面php</h1>
    </body>
</html>

<?php
    
    include '../db_connect.php';

    //SCleanManagemantP();
    //原因不明だが、POST方式に変更する予定
    //これで選択された部屋番号の清掃情報を受け取ることができる。


    //清掃情報更新
    if(isset($_GET["room_number"]) && isset($_GET["room_clean"])){
        $room_number = $_GET["room_number"];
        $room_clean = $_GET["room_clean"];
        SCleanEditP($room_number,$room_clean);
    }

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

//掃除状況を変更する,清掃状況管理画面に戻る
function SCleanEditP($room_number,$room_clean){
    global $pdo;
    try{
        $sc_sql = "UPDATE room SET room_clean = ".$room_clean." WHERE room_number = ".$room_number;
        $stmt = $pdo -> prepare($sc_sql);
        $stmt -> execute();
        echo ("実行に成功しました。<br>");
        echo ($room_number."号室を");
        if($room_clean == 0){
            echo("掃除していない");
        }else if($room_clean == 1){
            echo("チェックイン状態");
        }else if($room_clean == 2){
            echo("掃除済み");
        }
        echo ("に変更しました。<br>");
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    $back_URL = "clean_management.html";
    echo ("<form action = ".$back_URL.">");
    echo ("<button type = \" submit \">戻る</button>");
    echo ("</form>");
}

//list($room_number,$room_clean) = SCleanManagemantP();
//var_dump($room_number);
//var_dump($room_clean);

?>
