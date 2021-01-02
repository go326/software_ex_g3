<?php
    $question_number = $_GET['question_number'];
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

        <form method="get" action = "i_question_select.php">
            <input type = "submit" value = "戻る">
        </form>
        
        <input form = "insert_form" type = "submit" value = "完了">


    </body>
</html>