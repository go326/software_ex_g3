<?php
    //定数宣言
    //DBへ接続
    include '../../db_connect.php';

    //よくある質問一覧画面の作成のための定数
    //部屋番号の配列
    $NUM_OF_QUESTION = IQuestionNumberP(); //全ての質問数
    $LINE_BREAK = 3; //3個の要素tdで改行

    $user_auth = 1;//管理者権限の有無(1,0);
    //たぶん権限確認するメソッドが必要

    //html開始
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <link rel="stylesheet" href="./question_select.css" type="text/css">
        <title>question</title>

    </head>

    <body>
        <header>
            <h1> よくある質問一覧画面</h1>
            <!--日付取得-->
            <?php
                $date = date("Y-m-d");
                echo ($date."<br>");
                $next_date = date("Y-m-d", strtotime("+1 day"));
                if($user_auth == 1){
                    echo ("<ul>");
                    echo ("<li><input type=\"button\" onclick=\"location.href='./i_question_insert.php?question_number=".($NUM_OF_QUESTION + 1)."'\" value=\"新規入力\"></li>");
                    echo ("</ul>");
                }
            ?>
        </header>

        <!--よくある質問一覧画面の作成-->
        <table>
            <!--各列のタイトルの作成-->
            <tr>
                <th>質問No.</th>
                <th>よくある質問</th>
                <th>解答例</th>
            </tr>

            <?php
                //質問数だけループする。
                $question_count = 0; //質問の項目数のカウント
                for ($tr = 0; $tr < $NUM_OF_QUESTION; $tr++){
                    echo ("<tr>");
                    $question_count++;//次の質問へ(trでも良いよね？)
                    for ($td = 0; $td < $LINE_BREAK ; $td++){
                        echo ("<td>");
                        if($td == 0){
                            //0セル表示開始
                            //formがget方式だがpostにする予定最悪このまま
                            $question_number = ("question_number");
                            $question_text = IQuestionManagemantP($question_number, $question_count);
                        }else if($td == 1){
                            //１セル目の処理(question_nameを取り出す。)
                            $question_name = ("question_name");
                            $question_text = IQuestionManagemantP($question_name, $question_count);
                        }else if($td == 2){
                            //2セル目の処理(question_resultを取り出す。)
                            $question_result = ("question_result");
                            $question_text = IQuestionManagemantP($question_result, $question_count);
                        }
                        //セルに取り出した値を出力する。
                        if($user_auth == 1 && $td == 0){
                            echo ("<form method=\"get\" action = \"i_question_edit.php\">");
                            //質問番号とそのボタンなりの入力を配置
                            echo("<button type = \"submit\" value = \"".$question_text."\" name = \"".$question_number."\">");
                        }

                        echo ($question_text);

                        if($user_auth == 1 && $td == 0){
                            echo ("</button>");
                            echo("</form>");
                        }
                        echo ("</td>\n");
                    }
                    echo ("</tr>");
                }    
            ?>
        </table>
        
        <!--戻るボタン-->
        <form method="get" action = "../k_top.html">
            <input type = "submit" value = "よくある質問、マニュアルTOP画面に戻る">
        </form>
        
    </body>
</html>

<?php

//質問の項目数を取り出す。
function IQuestionNumberP(){
    global $pdo;
    $num_of_question = 0;
    $stmt = $pdo -> query("SELECT * FROM question");
    $stmt->execute();
    //行数取得
    $num_of_question = $stmt -> rowCount();
    return $num_of_question;
}

//質問テーブルの内容を取得する。　(指定したものを)
function IQuestionManagemantP($question_data, $question_count){
    global $pdo;
    $IQM_sql = ("SELECT ".$question_data." FROM question WHERE question_number = ".$question_count);
    $stmt = $pdo -> query($IQM_sql);
    //fetch
    while ($row = $stmt -> fetch()){
        $question_text = $row[$question_data];
    }
    return $question_text;
}
?>
