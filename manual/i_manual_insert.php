<?php
    $manual_number = $_GET['manual_number'];
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
                        echo ("<input type=\"file\" name=\"manual_pdf\" accept=\".pdf\" required multiple>");
                        echo ("</td>\n");

                    ?>
                </form>\n
            </tr>
        </table>

        <form method="get" action = "i_manual_select.php">
            <input type = "submit" value = "戻る">
        </form>
        
        <input form = "insert_form" type = "submit" value = "完了">


    </body>
</html>