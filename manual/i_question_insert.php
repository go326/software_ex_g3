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
            <form id = "insert_form" method = "get" action = "i_question_insert_done.php">            
            <?php
                //3行出力
                for ($tr = 0; $tr < 3; $tr++){
                    echo ("<tr>");
                    //1列目
                    echo("<th>");
                    if($tr == 0){
                        echo ("質問No.");
                        echo ("</th>");
                        echo ("<td>");
                        echo ($question_number);
                        echo ("<input type = \"hidden\" name = \"question_number\" value = \"$question_number\">");
                        echo ("</td>");
                    }else if($tr == 1){
                        echo ("よくある質問");
                        echo ("</th>");
                        echo ("<td>");
                        echo ("<input type = \"text\" name = \"question_name\">");
                        echo ("</td>");
                    }else if($tr = 2){
                        echo("解答例");
                        echo ("</th>");
                        echo ("<td>");                        
                        echo ("<input type = \"text\" name = \"question_result\">");
                        echo ("</td>");
                    }
                    echo ("</tr>\n");
                }
            ?>
            </form>
        </table>

        <form method="get" action = "i_question_select.php">
            <input type = "submit" value = "戻る">
        </form>
        
        <input form = "insert_form" type = "submit" value = "完了">


    </body>
</html>