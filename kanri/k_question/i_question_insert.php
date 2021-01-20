<?php
    $question_number = $_GET['question_number'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <link rel="stylesheet" href="./question_select.css" type="text/css">
        
        <script type="text/javascript">
            function check(){
                const question_name = "よくある質問を入力してください\n";
                const question_result = "解答例を入力してください\n";
                var alert_text;
                if (insert_form.question_name.value == ""){
                    alert_text = question_name;
                    if (insert_form.question_result.value == ""){
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

        <title>question</title>

    </head>

    <body>
        <header>
            <h1> よくある質問登録画面</h1>

        </header>

        <table>
            <tr>
                <th>質問No.</th>
                <th>よくある質問.</th>
                <th>解答例</th>
            </tr>
            
            <tr>
                <form id = "insert_form" method = "get" action = "i_question_insert_done.php">            
                    <?php
                        //3行出力
                        echo ("<td>");
                        echo ($question_number);
                        echo ("<input type = \"hidden\" name = \"question_number\" value = \"$question_number\">");
                        echo ("</td>");

                        echo ("<td>");
                        echo ("<input type = \"text\" name = \"question_name\">");
                        echo ("</td>");

                        echo ("<td>");                        
                        echo ("<input type = \"text\" name = \"question_result\">");
                        echo ("</td>");
                    ?>
                </form>
            </tr>
        </table>
        <p>
        <form method="get" action = "i_question_select.php">
            <input type = "submit" value = "戻る">
        </form>
        
        <input form = "insert_form" type = "submit" value = "完了" onclick = "return check()">
        </p>

    </body>
</html>