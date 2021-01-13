<?php
    $manual_number = $_GET['manual_number'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <link rel="stylesheet" href="./manual_select.css" type="text/css">

        <script type="text/javascript">
            function check(){
                const manual_name = "マニュアル名を入力してください\n";
                const manual_pdf = "PDFを指定してください\n";
                var alert_text;
                if (insert_form.manual_name.value == ""){
                    alert_text = manual_name;
                    //条件に一致する場合(メールアドレスが空の場合)
                    if (insert_form.manual_pdf.value != "*.pdf"){
                        alert_text = alert_text_manual_pdf;
                    }
                    alert(alert_text);    //エラーメッセージを出力
                    return false;    //送信ボタン本来の動作をキャンセルします
                }else{
                    //条件に一致しない場合(メールアドレスが入力されている場合)
                    return true;    //送信ボタン本来の動作を実行します
                }
            }
        </script>

        <title>manual</title>

    </head>

    <body>
        <header>
            <h1> マニュアル登録画面</h1>

        </header>

        <table>
            <tr>
                <th>マニュアルNo.</th>
                <th>マニュアル名</th>
                <th>URL</th>
            </tr>
            
            <tr>
                <form id = "insert_form" method = "post" enctype = "multipart/form-data" action = "i_manual_insert_done.php">            
                    <?php
                        //3行出力
                        echo ("<td>");
                        echo ($manual_number);
                        echo ("<input type = \"hidden\" name = \"manual_number\" value = \"$manual_number\">");
                        echo ("</td>\n");

                        echo ("<td>");
                        echo ("<input type = \"text\" name = \"manual_name\">");
                        echo ("</td>\n");

                        echo ("<td>");
                        echo ("<input type=\"file\" name=\"manual_pdf\" accept=\".pdf\" required>");
                        echo ("</td>\n");

                    ?>
                </form>
            </tr>
        </table>

        <form method="get" action = "i_manual_select.php">
            <input type = "submit" value = "戻る">
        </form>
        
        <input form = "insert_form" type = "submit" value = "完了" onclick = "return check()">


    </body>
</html>