<?php
    include '../../db_connect.php';

//phpとして別のファイルにするべき？
//よくある質問の内容を変更する,よくある質問一覧画面に戻る
function IManualEditP($manual_number,$manual_name,$manual_url){
    global $pdo;
    try{
        $ime_sql = "UPDATE manual SET manual_name = \"".$manual_name."\" ,manual_url = \"".$manual_url."\" WHERE manual_number = ".$manual_number;
        $stmt = $pdo -> prepare($ime_sql);
        $stmt -> execute();
        echo("<div class=\"button-area\">");    //css始まり
        echo ("実行に成功しました。<br>");
        echo ("マニュアルNo.".$manual_number."を<br>");
        echo ($manual_name."<br>");
        echo ($manual_url."<br>");
        echo ("に変更しました。<br>");
        echo ("</div>"); //css終わり
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function IManualUploadP(){
    // ファイル名を取得して、ユニークなファイル名に変更
    $manual_file_name = $_FILES['manual_pdf']['name'];

    // 仮にファイルがアップロードされている場所のパスを取得
    $tmp_path = $_FILES['manual_pdf']['tmp_name'];

    // 保存先のパスを設定
    $upload_path = '../../../upload/';

    //正しいものかどうかを判断する
    if (is_uploaded_file($tmp_path)) {
        // 仮のアップロード場所から保存先にファイルを移動
        if (move_uploaded_file($tmp_path, $upload_path . $manual_file_name)) {
            // ファイルが読出可能になるようにアクセス権限を変更
            chmod($upload_path . $manual_file_name, 0644);

            echo $manual_file_name . "をアップロードしました。";
            return $manual_file_name;
        } else {
            echo "Error:アップロードに失敗しました。";
        }
    } else {
        echo "Error:ファイルが見つかりません。";
    }
    return 0;
}

?>
<!--//htmlの開始-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <link rel="stylesheet" href="./manual_select.css" type="text/css">
        <title>manual</title>

    </head>

    <body>
        <header>
            <h1> マニュアル編集完了画面</h1>
        </header>
    <?php
        //清掃情報更新
        $manual_number = $_POST["manual_number"];
        $manual_name = $_POST["manual_name"];
        //ファイル名がmanual_file_nameになる
        $manual_file_name = IManualUploadP();
        echo ("start".$manual_number."<br>".$manual_name."<br>".$manual_file_name."<br>");

        if(preg_match($manual_file_name, ".pdf")){
            IManualEditP($manual_number, $manual_name, $manual_file_name);
            echo ("test1<br>");
        }

        if(strpos($manual_file_name, '.pdf') !== false){
            IManualEditP($manual_number, $manual_name, $manual_file_name);
            echo ("test2<br>");

        }

        echo ("end".$manual_number."<br>".$manual_name."<br>".$manual_file_name."<br>");
        
        $back_URL = "i_manual_select.php";
        echo ("<form action = ".$back_URL.">");
        echo ("<div class=\"button-position-c\"");  //css中央揃え始まり
        echo ("<div class=\"input#submit_button\">");   //css-submitボタン始まり
        echo ("<input id=\"submit_button\" type=\"submit\" name=\"submit\" value=\"戻る\">");
        echo ("</div>");    //css-submitボタン終わり
        echo ("</div>");    //css中央揃え終わり
        echo ("</form>");
    ?>
    </body>
</html>