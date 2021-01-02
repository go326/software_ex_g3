<?php
    //定数宣言
    //DBへ接続
    include '../db_connect.php';

    //よくある質問一覧画面の作成のための定数
    //部屋番号の配列
    $NUM_OF_MANUAL = IManualNumberP(); //全てのマニュアル数
    $LINE_BREAK = 2; //2個の要素tdで改行

    $user_auth = 1;//管理者権限の有無(1,0);
    //html開始
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <link rel="stylesheet" href="./manual_select.css" type="text/css">
        <title>manual</title>

    </head>

    <body>
        <header>
            <h1> マニュアル一覧画面</h1>
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
                <th>マニュアルNo.</th>
                <th>マニュアル名</th>
                <th>マニュアルURL</th>
            </tr>

            <?php
                //マニュアル数だけループする。
                $manual_count = 0; //マニュアルの項目数のカウント
                for ($tr = 0; $tr < $NUM_OF_MANUAL; $tr++){
                    echo ("<tr>");
                    $manual_count++;//次のマニュアルへ(trでも良いよね？)

                    //0セル表示開始
                    echo("<td>");
                    //formがget方式だがpostにする予定最悪このまま
                    $manual_number = ("manual_number");
                    $manual_text = IManualManagemantP($manual_number, $manual_count);
                    if($user_auth == 1){
                        echo ("<form method=\"get\" action = \"i_manual_edit.php\">");
                        //質問番号とそのボタンなりの入力を配置
                        echo("<button type = \"submit\" value = \"".$manual_text."\" name = \"".$manual_number."\">");
                    }
                    echo ($manual_text);
                    if($user_auth == 1){
                        echo ("</button>");
                        echo("</form>");
                    }
                    echo("</td>");
                    //１セル目の処理(manual_nameを取り出す。)
                    echo ("<td>");
                    $manual_name = ("manual_name");
                    $manual_text = IManualManagemantP($manual_name, $manual_count);
                    //セルに取り出した値を出力する。
                    echo ($manual_text);
                    echo ("</td>\n");

                    //2セル目の処理(manual_resultを取り出す。)
                    echo ("<td>");
                    $manual_url = ("manual_url");
                    $manual_text = IManualManagemantP($manual_url, $manual_count);
                    echo ("<a href = ".$manual_text." target=\" blank\">");
                    echo ($manual_text);
                    echo ("</a>");
                    echo ("</td>");

                    echo ("</tr>");
                }
            ?>
        </table>
        
        <!--戻るボタン-->
        <form method="get" action = "i_mq_top.html">
            <input type = "submit" value = "よくある質問、マニュアルTOP画面に戻る">
        </form>
        
    </body>
</html>

<?php

//マニュアルの項目数を取り出す。
function IManualNumberP(){
    global $pdo;
    $num_of_manual = 0;
    $IMN_sql = ("SELECT * FROM manual");
    $stmt = $pdo -> query($IMN_sql);
    $stmt->execute();
    //行数取得
    $num_of_manual = $stmt -> rowCount();
    return $num_of_manual;
}

//質問テーブルの内容を取得する。　(指定したものを)
function IManualManagemantP($manual_data, $manual_count){
    global $pdo;
    $IMM_sql = ("SELECT ".$manual_data." FROM manual WHERE manual_number = ".$manual_count);
    $stmt = $pdo -> query($IMM_sql);
    //fetch
    while ($row = $stmt -> fetch()){
        $manual_text = $row[$manual_data];
    }
    return $manual_text;
}
?>
