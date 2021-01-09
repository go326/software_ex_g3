<?php
    $manual_number = $_GET['manual_number'];
    include '../db_connect.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <!--文字コードUTF-8-->
        <meta http-equiv="Content-Type" content="test/html" charset="UTF-8">
        <link rel="stylesheet" href="./manual_select.css" type="text/css">
    </head>
    <body>
        <!--ヘッダー-->
        <header>
            <h1>マニュアル編集画面</h1>
        </header>
        <!--確認用の出力文＿-->
        <div class="button-area">
            <?php
                echo ("マニュアルNo.".$manual_number."を変更します。<br>");
            ?>
            <!--メイン-->
        
            <!--i行目-->
            <form id = "manual_edit" method = “post” enctype = "multipart/form-data" action = "i_manual_edit_done.php">

                <table>
                    <tr>
                    <th>マニュアルNo.</th>
                    <th>マニュアル名</th>
                    <th>URL</th>
                    </tr>

                    <tr>    
                    <td>
                    <?php
                        //0セル
                        echo ($manual_number);

                    ?>
                    <input type = "hidden" name = "manual_number" value = "<?php echo ($manual_number);?>">
                    </td>

                    <td>
                        <?php
                            //1セル
                            $manual_name = ("manual_name");
                            $manual_text = IManualManagemantP($manual_name, $manual_number);
                            echo ("<input type = \"text\" name = ".$manual_name." value = ".$manual_text.">");
                        ?>
                    </td>

                    <td>
                        <?php
                            //2セル
                            $manual_url = ("manual_url");
                            $manual_text = IManualManagemantP($manual_url, $manual_number);  
                            echo ($manual_text);                          
                            echo ("<input type=\"file\" name=\"manual_pdf\" accept=\".pdf\" value = \"./".$manual_text."\"required multiple>");
                        ?>
                    </td>

                    </tr>
                </table>

            </form>

            <div class="button-position-l">
                <div class="input#submit_button">
                    <!--戻るボタン-->
                    <form  id = "clean_back" action = "i_manual_select.php">
                        <input id="submit_button" type="submit" name="submit" value="戻る"> 
                    </form>
                </div>
            </div>
            <div class="button-position-r">
                <div class="input#submit_button">
                    <!--完了ボタン-->
                    <input id="submit_button" type="submit" name="submit" value="完了" form = "manual_edit">
                </div>
            </div>
        </div>
        <!--フッター-->
    </body>
</html>

<?php
//質問テーブルの内容を取得する。　(指定したものを)
function IManualManagemantP($manual_data, $manual_number){
    global $pdo;
    $IMM_sql = ("SELECT ".$manual_data." FROM manual WHERE manual_number = ".$manual_number);
    $stmt = $pdo -> query($IMM_sql);
    //fetch
    while ($row = $stmt -> fetch()){
        $manual_text = $row[$manual_data];
    }
    return $manual_text;
}
?>