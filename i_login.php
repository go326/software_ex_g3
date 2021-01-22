<?php
session_start();
$_SESSION = array();
session_destroy();
session_save_path("/var/tmp/");
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
                $_SESSION['user'] = $_POST['UserID'];
                $_SESSION['auth'] = $row['authority'];
                // echo ("<form method = \"post\" action = \"./i_general_top.php\">");
                // echo ("<input type = \"hidden\" name = \"auth\" value = \"" . $auth . "\">");
                // echo ("<button type=\"submit\">");
                // echo ("権限確認を表示");
                // echo ("</button>");
                // echo ("</form>");
                header("Location:./i_general_top.html");
                exit;
            } else {
                $alert = "<script type='text/javascript'>alert('ログイン認証に失敗しました'); </script>";
            }
        } else {
            $alert = "<script type='text/javascript'>alert('ユーザ認証に失敗しました'); </script>";
        }
    } catch (PDOException $e) {
        var_dump('Error:' . $e->getMessage());
        die();
    }
}
// ログアウト処理
if (isset(($_POST['logout']))) {
    session_unset();
}
//  else {
//     $alert = "<script type='text/javascript'>alert('入力してください'); </script>";
// }
echo $alert;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <!--文字コードUTF-8-->
    <meta charset="UTF-8">
    <link rel="stylesheet" href="i_general_top.css">
    <script src="i_login.js"></script>
    <title>ログイン画面</title>
</head>

<body>
    <script>
        function maxLengthCheck(object) {
            if (object.value.length > object.maxLength)
                object.value = object.value.slice(0, object.maxLength)
        }
    </script>
    <!--ヘッダー-->
    <header>
        <fieldset class="back2">
            <center>
                <h2>ログイン</h2>
                <form action="./i_login.php" method="post">
                    <p>ユーザーID：<input oninput="maxLengthCheck(this)" type="number" name="UserID" maxlength="12" required>
                    </p>
                    <p>パスワード：<input oninput="maxLengthCheck(this)" type="password" name="Password" maxlength="127" required></p>
                    <p><input type="submit" name="login" value="ログイン" id="button2"></p>
                </form>
            </center>
        </fieldset>
</body>

</html>
