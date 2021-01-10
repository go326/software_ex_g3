<?php
session_start();
$_SESSION = array();
session_destroy();
session_start();


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
        }

        if (isset($name)) {

            if (password_verify($_POST['Password'], $pass_db)) {
                $text = "ログイン認証に成功";
                $_SESSION['user'] = $_POST['UserID'];
                header("Location:./i_general_top.html");
            } else {
                $text = "ログイン認証に失敗";
                header("Location:./i_login.html");
            }
        } else {

            $text = "ユーザーが見つかりません";
            header("Location:./i_login.html");
        }
    } catch (PDOException $e) {
        print('Error:' . $e->getMessage());
        die();
    }
} else if (isset(($_POST['logout']))) {
    session_unset();
} else {
    $text = "入力してください";
    header("Location:./i_login.html");
}
