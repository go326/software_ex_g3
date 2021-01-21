<?php
    include '../../db_connect.php';

    

//phpとして別のファイルにするべき？
//質問情報を登録する。
function IQuestionInsertP($question_number,$question_name,$question_result){
    global $pdo;
    try{
        $iqi_sql = "INSERT INTO question (question_number, question_name, question_result) VALUES ('".$question_number."', '".$question_name."', '".$question_result."')";
        $stmt = $pdo -> prepare($iqi_sql);
        $stmt -> execute();
        echo("<div class=\"button-area\">");    //css始まり
        echo ("実行に成功しました。<br>");
        echo ("質問No.".$question_number."を<br>");
        echo ($question_name."<br>");
        echo ($question_result."<br>");
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
        <link rel="stylesheet" href="./question_select.css" type="text/css">
        <title>質問登録完了画面</title>

    </head>

    <body>
        <header>
            <h1> よくある質問登録完了画面</h1>
        </header>
    <br><br><br><br>
    <center>
    <?php
        //清掃情報更新
    if(isset($_GET["question_number"]) && isset($_GET["question_name"]) && isset($_GET["question_result"])){
        $question_number = $_GET["question_number"];
        $question_name = $_GET["question_name"];
        $question_result = $_GET["question_result"];
        IQuestionInsertP($question_number,$question_name,$question_result);
    }
    //戻るボタン
    $back_URL = "i_question_select.php";
    echo ("<form action = ".$back_URL.">");
    echo ("<div class=\"button-position-c\"");  //css中央揃え始まり
    echo ("<div class=\"input#submit_button\">");   //css-submitボタン始まり
    echo ("<input id=\"submit_button\" type=\"submit\" name=\"submit\" value=\"戻る\">");
    echo ("</div>");    //css-submitボタン終わり
    echo ("</div>");    //css中央揃え終わり
    echo ("</form>");
    ?>
    </center>
    </body>
</html>