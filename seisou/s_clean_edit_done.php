<?php
    include '../db_connect.php';

    

//phpとして別のファイルにするべき？
//掃除状況を変更する,清掃状況管理画面に戻る
function SCleanEditP($room_number,$room_clean){
    global $pdo;
    try{
        $sc_sql = "UPDATE room SET room_clean = ".$room_clean." WHERE room_number = ".$room_number;
        $stmt = $pdo -> prepare($sc_sql);
        $stmt -> execute();
        echo("<div class=\"button-area\">");    //css始まり
        echo ("実行に成功しました。<br>");
        echo ($room_number."号室を");
        if($room_clean == 3){
            echo("掃除していない");
        }else if($room_clean == 2){
            echo("掃除済み");
        }
        echo ("に変更しました。<br>");
        echo ("</div>"); //css終わり
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    $back_URL = "s_clean_management.php";
    echo ("<form action = ".$back_URL.">");
    echo ("<div class=\"button-position-c\"");  //css中央揃え始まり
    echo ("<div class=\"input#submit_button\">");   //css-submitボタン始まり
    echo ("<input id=\"submit_button\" type=\"submit\" name=\"submit\" value=\"戻る\">");
    echo ("</div>");    //css-submitボタン終わり
    echo ("</div>");    //css中央揃え終わり
    echo ("</form>");
}

?>
<!--//htmlの開始-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <link rel="stylesheet" href="./clean_management.css" type="text/css">
        <title>seisou</title>

    </head>

    <body>
        <header>
            <h1> 清掃情報編集完了画面</h1>
        </header>
    <?php
        //清掃情報更新
    if(isset($_GET["room_number"]) && isset($_GET["room_clean"])){
        $room_number = $_POST["room_number"];
        $room_clean = $_POST["room_clean"];
        SCleanEditP($room_number,$room_clean);
    }
    ?>
    </body>
</html>