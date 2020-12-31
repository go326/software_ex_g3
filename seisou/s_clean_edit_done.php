<?php
    include '../db_connect.php';

    //清掃情報更新
    if(isset($_GET["room_number"]) && isset($_GET["room_clean"])){
        $room_number = $_GET["room_number"];
        $room_clean = $_GET["room_clean"];
        SCleanEditP($room_number,$room_clean);
    }

//phpとして別のファイルにするべき？
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
    $back_URL = "s_clean_management.php";
    echo ("<form action = ".$back_URL.">");
    echo ("<button type = \" submit \">戻る</button>");
    echo ("</form>");
}

?>