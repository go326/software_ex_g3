<?php
session_start();
require("k_log_record.php");

// 変数
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';

$sql = "";
$res = "";

$eid = "";
$flag = 0;

$id = "";
$name = "";
$pass = "";
$auth = "";

// ログ
$auth_edit1 = "";
$auth_edit2 = "";


// ID(+ユーザ情報)保持
if (isset($_POST['eid'])) {
    $_SESSION['eid'] = $_POST['eid'];
    $eid = $_SESSION['eid'];
    try {
        $pdo = new PDO($dsn, $user, $password);
        $sql = "SELECT * FROM user WHERE user_id = '$eid'";
        $stmt = $pdo->query($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['user_auth'] = $row['authority'];
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

try {
    $pdo = new PDO($dsn, $user, $password);

    // 表の作成
    function KUserManagementP()
    {
        unset($_SESSION['eid']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_auth']);

        global $pdo, $sql, $res, $alert;
        static $auth = "";
        $sql = "SELECT * FROM user";
        $stmt = $pdo->query($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $auth = "";
            if (strpos($row['authority'], '1') !== false) $auth .= "フロント ";
            if (strpos($row['authority'], '2') !== false) $auth .= "清掃 ";
            if (strpos($row['authority'], '3') !== false) $auth .= "レストラン ";
            if (strpos($row['authority'], '4') !== false) $auth .= "アルバイト ";
            if (strpos($row['authority'], '5') !== false) $auth .= "管理者 ";
            // 表の作成
            $res .= "</tr>";
            $res .= "<td>";
            $res .= "<form action='k_user_edit.php' method='post'>";
            $res .= "<button type='submit' name='eid' value='{$row['user_id']}'> {$row['user_id']} </button>";
            $res .= "</form>";
            $res .= "</td>";
            $res .= "<td>{$row['user_name']}</td>";
            $res .= "<td>{$auth}</td>";
            $res .= "</tr align ='center'>";
        }
        if ($res == "") {
            $alert = "<script type='text/javascript'>alert('ユーザ情報がありません');</script>";
            echo $alert;
        }
    }

    // ユーザの登録
    function KUserInputP()
    {
        global $pdo, $sql, $id, $name, $pass, $auth, $flag, $auth_edit2;
        if (isset($_POST['input'])) {
            InputConf();
            if ($flag == 0) {
                $sql = "SELECT * FROM user";
                $stmt = $pdo->query($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($id == $row['user_id']) {
                        $alert = "<script type='text/javascript'>alert('ユーザIDが既に登録されています');</script>";
                        echo $alert;
                        $flag = 1;
                    }
                }
            }
            if ($flag == 0) {
                $sql = "INSERT INTO user VALUES('$id','$name','$pass','$auth')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                UserLog();
                KLogRecodeP("$_SESSION[user]", "ユーザ登録", "ユーザ情報", "$id", "全", "-", "{$id},{$name},{$auth_edit2}");

                header("Location: k_user_screen.php");
                exit;
            }
        }
    }

    function KUserEditP()
    {
        global $pdo, $sql, $eid, $name, $pass, $auth, $flag, $auth_edit1, $auth_edit2;
        $eid = $_SESSION['eid'];
        if (isset($_POST['edit'])) {
            InputConf();
            if ($flag == 0) {
                $sql = "UPDATE user SET user_id = '$eid', user_name = '$name', user_pass = '$pass', authority = '$auth' WHERE user_id = '$eid' ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                UserLog();
                KLogRecodeP("$_SESSION[user]", "ユーザ編集", "ユーザ情報", "$eid", "氏名,権利", "{$_SESSION['user_name']},{$auth_edit1}", "{$name},{$auth_edit2}");
                header("Location: k_user_screen.php");
                exit;
            }
        }
    }

    function KUserDelP()
    {
        global $pdo, $sql, $eid, $auth_edit1;
        if (isset($_POST['del'])) {
            UserLog();
            KLogRecodeP("$_SESSION[user]", "ユーザ削除", "ユーザ情報", "$eid", "全", "{$eid},{$_SESSION['user_name']},{$auth_edit1}", "-");
            $eid = $_SESSION['eid'];
            $sql = "DELETE FROM user WHERE user_id = '$eid'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            header("Location: k_user_screen.php");
            exit;
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

// 入力確認
function InputConf()
{
    global $id, $name, $pass, $auth, $flag;
    // ID
    if (!empty($_POST['id'])) {
        if ($_POST['id'] != 0) {
            $id = $_POST['id'];
        } else {
            $alert = "<script type='text/javascript'>alert('IDは0以外の数値を指定してください');</script>";
            echo $alert;
            $flag = 1;
        }
    }
    // 名前
    if (!empty($_POST['name'])) $name = $_POST['name'];
    // パスワード
    if (!empty($_POST['pass'])) $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    // 権限
    if (isset($_POST['auth']) and is_array($_POST['auth'])) $auth = implode("", $_POST["auth"]);
    else {
        $alert = "<script type='text/javascript'>alert('チェックボックスが選択されていません');</script>";
        echo $alert;
        $flag = 1;
    }
}

// ログの保存
function UserLog()
{
    global $eid, $name, $auth, $auth_edit1, $auth_edit2;
    // 名前：変更前
    if (empty($_SESSION['user_name'])) $_SESSION['user_name'] = "-";
    // 名前：変更後
    if ($name == "") $name = "-";
    // 権限：変更前
    if (empty($_SESSION['user_auth'])) $auth_edit1 = "-";
    if (strpos($_SESSION['user_auth'], '1') !== false) $auth_edit1 .= "フロント ";
    if (strpos($_SESSION['user_auth'], '2') !== false) $auth_edit1 .= "清掃 ";
    if (strpos($_SESSION['user_auth'], '3') !== false) $auth_edit1 .= "レストラン ";
    if (strpos($_SESSION['user_auth'], '4') !== false) $auth_edit1 .= "アルバイト ";
    if (strpos($_SESSION['user_auth'], '5') !== false) $auth_edit1 .= "管理者";
    // 権限：変更後
    if ($auth == "") $auth_edit2 = "-";
    if (strpos($auth, '1') !== false) $auth_edit2 .= "フロント ";
    if (strpos($auth, '2') !== false) $auth_edit2 .= "清掃 ";
    if (strpos($auth, '3') !== false) $auth_edit2 .= "レストラン ";
    if (strpos($auth, '4') !== false) $auth_edit2 .= "アルバイト ";
    if (strpos($auth, '5') !== false) $auth_edit2 .= "管理者";
}
