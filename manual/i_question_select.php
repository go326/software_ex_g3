<?php
    //定数宣言
    //DBへ接続
    include '../db_connect.php';

    //よくある質問一覧画面の作成のための定数
    //部屋番号の配列
    $NUM_OF_QUESTION = IQuestionNumberP(); //全ての質問数
    $LINE_BREAK = 2; //2個の要素tdで改行

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
            ?>
            
        </header>

        <!--よくある質問一覧画面の枠組みの作成-->
        <!--formがget方式だがpostにする予定最悪このまま-->
        <!--<form method="get" action = "s_clean_edit.php">-->
        <table>
            <!--各列のタイトルの作成-->
            <tr>
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
                        //1階の部屋数だけ表を作成したら終了し、次の階へ
                        //if($room_count == $NUM_OF_ROOMS){
                        //    break;
                        //}

                        //1セルの表示開始
                    
                        //質問番号を入れるときはLINE_BREAKを増やして、
                        echo ("<td>");
                        if($td == 0){
                            //１セル目の処理(question_nameを取り出す。)
                            $question_name = ("question_name");
                            $question_text = IQuestionManagemantP($question_name, $question_count);
                        }else{
                            //2セル目の処理(question_resultを取り出す。)
                            $question_result = ("question_result");
                            $question_text = IQuestionManagemantP($question_result, $question_count);
                        }
                        echo ($question_text);
                        echo ("</td>\n");
                    }
                    echo ("</tr>");
                }    
            ?>
        </table>
        <!--</form>-->
        
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
