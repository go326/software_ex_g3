<?php
    //定数宣言
    //DBへ接続
    include '../db_connect.php';

    //よくある質問一覧画面の作成のための定数
    //部屋番号の配列
    $NUM_OF_MANUAL = IManualNumberP(); //全てのマニュアル数
    $LINE_BREAK = 2; //2個の要素tdで改行

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
            ?>
            
        </header>

        <!--よくある質問一覧画面の作成-->
        <table>
            <!--各列のタイトルの作成-->
            <tr>
                <th>マニュアル名</th>
                <th>マニュアルURL</th>
            </tr>

            <?php
                //マニュアル数だけループする。
                $manual_count = 0; //マニュアルの項目数のカウント
                for ($tr = 0; $tr < $NUM_OF_MANUAL; $tr++){
                    echo ("<tr>");
                    $manual_count++;//次のマニュアルへ(trでも良いよね？)
                    for ($td = 0; $td < $LINE_BREAK ; $td++){
                        //1階の部屋数だけ表を作成したら終了し、次の階へ
                        //if($room_count == $NUM_OF_ROOMS){
                        //    break;
                        //}

                        //formがget方式だがpostにする予定最悪このまま
                        //<form method="get" action = "s_clean_edit.php">
                        //質問番号とそのボタンなりの入力を配置
                        //</form>
                        //1セルの表示開始
                        //質問番号を入れるときはLINE_BREAKを増やして、
                        echo ("<td>");
                        if($td == 0){
                            //１セル目の処理(manual_nameを取り出す。)
                            $manual_name = ("manual_name");
                            $manual_text = IManualManagemantP($manual_name, $manual_count);
                        }else{
                            //2セル目の処理(manual_resultを取り出す。)
                            $manual_result = ("manual_result");
                            $manual_text = IManualManagemantP($manual_result, $manual_count);
                        }
                        //セルに取り出した値を出力する。
                        echo ($manual_text);
                        echo ("</td>\n");
                    }
                    echo ("</tr>");
                }    
            ?>
        </table>
        
        <!--戻るボタン-->
        <form method="get" action = "">
            <input type = "submit" value = "よくある質問、マニュアルTOP画面に戻る">
        </form>
        
    </body>
</html>

<?php

//マニュアルの項目数を取り出す。
function IManualNumberP(){
    global $pdo;
    $num_of_manual = 0;
    $stmt = $pdo -> query("SELECT * FROM manual");
    $stmt->execute();
    //行数取得
    $num_of_question = $stmt -> rowCount();
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
