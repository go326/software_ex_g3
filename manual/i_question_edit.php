<?php
    $question_number = $_GET['question_number'];
    include '../db_connect.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <!--文字コードUTF-8-->
        <meta http-equiv="Content-Type" content="test/html" charset="UTF-8">
        <link rel="stylesheet" href="./question_select.css" type="text/css">

        <script type="text/javascript">
            function check(){
                const question_name = "よくある質問を入力してください\n";
                const question_result = "解答例を入力してください\n";
                var alert_text;
                if (question_edit.question_name.value == ""){
                    alert_text = question_name;
                    if (question_edit.question_result.value == ""){
                        alert_text = alert_text + question_result;
                    }
                    //条件に一致する場合(メールアドレスが空の場合)
                    alert(alert_text);    //エラーメッセージを出力
                    return false;    //送信ボタン本来の動作をキャンセルします
                }else{
                    //条件に一致しない場合(メールアドレスが入力されている場合)
                    return true;    //送信ボタン本来の動作を実行します
                }
            }
        </script>

    </head>
    <body>
        <!--ヘッダー-->
        <header>
            <h1>よくある質問編集画面</h1>
        </header>
        <!--確認用の出力文＿-->
        <div class="button-area">
            <?php
                echo ("質問No.".$question_number."を変更します。<br>");
            ?>
            <!--メイン-->
        
            <!--i行目-->
            <form id = "question_edit" method = “get” action = "i_question_edit_done.php">

                <table>
                    <tr>
                    <th>質問No.</th>
                    <th>よくある質問</th>
                    <th>解答例</th>
                    </tr>

                    <tr>    
                    <td>
                    <?php
                        //0セル
                        echo ($question_number);

                    ?>
                    <input type = "hidden" name = "question_number" value = "<?php echo ($question_number);?>">
                    </td>

                    <td>
                        <?php
                            //1セル
                            $question_name = ("question_name");
                            $question_text = IQuestionManagemantP($question_name, $question_number);
                            echo ("<input type = \"text\" name = ".$question_name." value = ".$question_text.">");
                        ?>
                    </td>

                    <td>
                        <?php
                            //2セル
                            $question_result = ("question_result");
                            $question_text = IQuestionManagemantP($question_result, $question_number);
                            echo ("<input type = \"text\" name = ".$question_result." value = ".$question_text.">");
                        ?>
                    </td>

                    </tr>
                </table>

            </form>

            <div class="button-position-l">
                <div class="input#submit_button">
                    <!--戻るボタン-->
                    <form  id = "clean_back" action = "i_question_select.php">
                        <input id="submit_button" type="submit" name="submit" value="戻る" onclick="location.href='./s_clean_management.php'"> 
                    </form>
                </div>
            </div>
            <div class="button-position-r">
                <div class="input#submit_button">
                    <!--完了ボタン-->
                    <input id="submit_button" type="submit" name="submit" value="完了" form = "question_edit" onclick = "return check()">
                </div>
            </div>
        </div>
        <!--フッター-->
    </body>
</html>

<?php
//質問テーブルの内容を取得する。　(指定したものを)
function IQuestionManagemantP($question_data, $question_number){
    global $pdo;
    $IQM_sql = ("SELECT ".$question_data." FROM question WHERE question_number = ".$question_number);
    $stmt = $pdo -> query($IQM_sql);
    //fetch
    while ($row = $stmt -> fetch()){
        $question_text = $row[$question_data];
    }
    return $question_text;
}
?>