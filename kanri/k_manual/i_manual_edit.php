<?php
    $manual_number = $_GET['manual_number'];
    include '../../db_connect.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <!--文字コードUTF-8-->
        <meta http-equiv="Content-Type" content="test/html" charset="UTF-8">
        <link rel="stylesheet" href="./manual_select.css" type="text/css">
        <script type="text/javascript">
            function check(){
                const manual_name = "マニュアル名を入力してください\n";
                //const manual_pdf = "PDFを指定してください\n";
                var alert_text;
                if (manual_edit.manual_name.value == ""){
                    alert_text = manual_name;
                    //if (manual_edit.manual_pdf.value != "*.pdf"){
                    //    alert_text = alert_text + manual_pdf;
                    //}
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
            <h1>マニュアル編集画面</h1>
        <!--確認用の出力文＿-->
            <?php
                echo ("マニュアルNo.".$manual_number."を変更します。<br>");
            ?>
        </header>
            <!--メイン-->
        
            <!--i行目-->
            <form id = "manual_edit" method = "post" enctype = "multipart/form-data" action = "i_manual_edit_done.php">

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
                            echo ("<input type=\"file\" name=\"manual_pdf\" accept=\".pdf\" required>");
                        ?>
                    </td>

                    </tr>
                </table>

            </form>
            <div class="button-position">
                    <!--戻るボタン-->
                    <form  id = "clean_back" action = "i_manual_select.php">
                        <input id="submit_button" type="submit" value="戻る"> 
                    </form>
                    <!--完了ボタン-->
                    <input id="submit_button" type="submit"  value="完了" form = "manual_edit" onclick = "return check()">
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