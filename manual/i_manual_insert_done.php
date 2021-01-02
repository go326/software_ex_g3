<?php
    include '../db_connect.php';

    

//phpとして別のファイルにするべき？
//質問情報を登録する。
function IManualInsertP($manual_number,$manual_name,$manual_url){
    global $pdo;
    try{
        $imi_sql = "INSERT INTO manual (manual_number, manual_name, manual_url) VALUES ('".$manual_number."', '".$manual_name."', '".$manual_url."')";
        $stmt = $pdo -> prepare($imi_sql);
        $stmt -> execute();
        echo("<div class=\"button-area\">");    //css始まり
        echo ("実行に成功しました。<br>");
        echo ("マニュアルNo.".$manual_number."を<br>");
        echo ($manual_name."<br>");
        echo ($manual_result."<br>");
        echo ("と登録しました。<br>");
        echo ("</div>"); //css終わり
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

?>
<!--//htmlの開始-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <link rel="stylesheet" href="./manual_select.css" type="text/css">
        <title>manual</title>

    </head>

    <body>
        <header>
            <h1> よくある質問登録完了画面</h1>
        </header>
    <?php
        //清掃情報更新
    if(isset($_GET["manual_number"]) && isset($_GET["manual_name"]) && isset($_GET["manual_url"])){
        $manual_number = $_GET["manual_number"];
        $manual_name = $_GET["manual_name"];
        $manual_url = $_GET["manual_result"];
        IManualInsertP($manual_number,$manual_name,$manual_url);
    }
    //戻るボタン
    $back_URL = "i_manual_select.php";
    echo ("<form action = ".$back_URL.">");
    echo ("<div class=\"button-position-c\"");  //css中央揃え始まり
    echo ("<div class=\"input#submit_button\">");   //css-submitボタン始まり
    echo ("<input id=\"submit_button\" type=\"submit\" name=\"submit\" value=\"戻る\">");
    echo ("</div>");    //css-submitボタン終わり
    echo ("</div>");    //css中央揃え終わり
    echo ("</form>");
    ?>
    </body>
</html>