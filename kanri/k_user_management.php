<?php
session_start();
require("k_log_record.php");

// 変数
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';

$sql = "";
$res = "";
$alert = "";

$eid = "";
$flag = 0;

$id = "";
$name = "";
$pass = "";
$auth = "";

// ID(+ユーザ情報)保持
if (isset($_POST['eid'])) {
    $_SESSION['eid'] = $_POST['eid'];
    $eid = $_SESSION['eid'];
    try {
        $pdo = new PDO($dsn, $user, $password);
        $sql = "SELECT user_name FROM user WHERE user_id = '$eid'";
        $stmt = $pdo->query($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        $_SESSION['user_name'] = $row['user_name'];
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// 入力確認
if (isset($_POST['id']) and !empty($_POST['name']) and !empty($_POST['pass'])) {
    if (isset($_POST['auth']) and is_array($_POST['auth'])) {
        if ($_POST['id'] != 0) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $auth = implode("", $_POST["auth"]);
        } else {
            $alert = "<script type='text/javascript'>alert('IDは0以外で指定してください');</script>";
            echo $alert;
            $flag = 1;
        }
    } else {
        $alert = "<script type='text/javascript'>alert('チェックボックスが選択されていません');</script>";
        echo $alert;
        $flag = 1;
    }
}

try {
    $pdo = new PDO($dsn, $user, $password);

    // 表の作成
    function KUserManagementP()
    {
        unset($_SESSION['eid']);
        unset($_SESSION['user_name']);
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
        global $pdo, $sql, $id, $name, $pass, $auth, $flag, $alert;
        if (isset($_POST['input']) and $flag == 0) {
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
            if ($flag == 0) {
                $sql = "INSERT INTO user VALUES('$id','$name','$pass','$auth')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                header("Location: k_user_screen.php");
                exit;
            }
        }
    }
    // UPDATE
    function KUserEditP()
    {
        global $pdo, $sql, $eid, $id, $name, $pass, $auth, $flag, $alert;
        $eid = $_SESSION['eid'];
        if (isset($_POST['edit']) and $flag == 0) {
            $sql = "SELECT * FROM user";
            $stmt = $pdo->query($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($id == $row['user_id'] and $id != $eid) {
                    $alert = "<script type='text/javascript'>alert('ユーザIDが既に登録されています');</script>";
                    echo $alert;
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 0) {
                $sql = "UPDATE user SET user_id = '$id', user_name = '$name', user_pass = '$pass', authority = '$auth' WHERE user_id = '$eid' ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                KLogRecodeP("ユーザ編集", "ユーザ情報テーブル", "{$id}", "氏名,権利", "{$_SESSION['user_name']},{$_SESSION['user_auth']}", "{$name},{$auth}");
                header("Location: k_user_screen.php");
                exit;
            }
        }
    }
    // DELETE
    function KUserDelP()
    {
        global $pdo, $sql, $eid, $alert;
        if (isset($_POST['del'])) {
            $eid = $_SESSION['eid'];
            $sql = "DELETE FROM user WHERE user_id = '$eid'";
            echo $sql;
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
