<?php
session_start();
$_SESSION = array();
session_destroy();
session_start();
require(dirname(__FILE__) . "/db_connect.php");

global $pdo;
// ログイン処理
if (isset($_POST['login']) && !empty($_POST['UserID']) && !empty($_POST['Password'])) {
    try {
        // ユーザ検索
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

        // パスワード比較
        if (isset($name)) {
            if (password_verify($_POST['Password'], $pass_db)) {
                $text = "ログイン認証に成功";
                $_SESSION['user'] = $_POST['UserID'];

                echo ("<form method = \"post\" action = \"./i_general_top.php\">");
                echo ("<input type = \"hidden\" name = \"auth\" value = \"" . $auth . "\">");
                echo ("<button type=\"submit\">");
                echo ("権限確認を表示");
                echo ("</button>");
                echo ("</form>");

                //戻るボタン
                $back_URL = "i_login.html";
                echo ("<form action = " . $back_URL . ">");
                echo ("<input id=\"submit_button\" type=\"submit\" name=\"submit\" value=\"戻る\">");
                echo ("</form>");
                // header("Location:./i_general_top.html");
            } else {
                "<script type='text/javascript'> window.onload = error_id() </script>";

                header("Location:./i_login.html");
            }
        } else {
            header("Location:./i_login.html");
        }
    } catch (PDOException $e) {
        var_dump('Error:' . $e->getMessage());
        die();
    }
    // ログアウト処理
} else if (isset(($_POST['logout']))) {
    session_unset();
} else {
    // "<script type='text/javascript'>window.sessionStorage.setItem(['login_error'],['入力してください']);</script>";
}
// header("Location:./i_login.html");
