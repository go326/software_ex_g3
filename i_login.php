<?php
session_start();
$_SESSION = array();
session_destroy();
session_start();
require(dirname(__FILE__) . "/db_connect.php");

global $pdo;
$text;
if (isset($_POST['login']) && !empty($_POST['UserID']) && !empty($_POST['Password'])) {
    try {

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $re = $pdo->prepare("SELECT * FROM `user` WHERE ? = `user_id`");
        $re->bindValue(1, $_POST['UserID']);
        $re->execute();

        $result = $re->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $name = $row['user_id'];
            $pass_db = $row['user_pass'];
            $auth = $row['authority'];
        }
        echo ($name.",".$pass_db.",".$auth."<br>");
        if (isset($name)) {

            if (password_verify($_POST['Password'], $pass_db)) {
                $text = "ログイン認証に成功";
                $_SESSION['user'] = $_POST['UserID'];
                
                //次の総合TOPに遷移
                //ここは変更するかもしれない
                //よくわからんし、めんどいから権限の情報だけ次にpostで送信する。
                echo ("<form method = \"post\" action = \"./i_general_top.php\">");
                echo ("<input type = \"hidden\" name = \"auth\" value = \"".$auth."\">");
                echo ("<button type=\"submit\">");
                echo ("総合TOPへ");
                echo ("</button>");
                echo ("</form>");
                //header("Location:./i_general_top.html");
            } else {
                $text = "ログイン認証に失敗";
                //header("Location:./i_login.html");
            }
        } else {
            $text = "ユーザーが見つかりません";
            //header("Location:./i_login.html");
        }
    } catch (PDOException $e) {
        var_dump('Error:' . $e->getMessage());
        die();
    }
} else if (isset(($_POST['logout']))) {
    session_unset();
} else {
    $text = "入力してください";
    //header("Location:./i_login.html");
}
echo $text;

//戻るボタン
$back_URL = "i_login.html";
echo ("<form action = ".$back_URL.">");
echo ("<input id=\"submit_button\" type=\"submit\" name=\"submit\" value=\"戻る\">");
echo ("</form>");