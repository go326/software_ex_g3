<?php
session_start();

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

// IDを保持
if (isset($_POST['eid'])) $_SESSION['eid'] = $_POST['eid'];

// 入力情報の確認
if (isset($_POST['id']) and isset($_POST['name']) and isset($_POST['pass'])) {
    if (isset($_POST['auth']) and is_array($_POST['auth'])) {
        if ($_POST['id'] != 0) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $auth = implode("", $_POST["auth"]);
        } else {
            $test_alert = "<script type='text/javascript'>alert('IDは0以外で指定してください');</script>";
            echo $test_alert;
            $flag = 1;
        }
    } else {
        $test_alert = "<script type='text/javascript'>alert('チェックボックスが選択されていません');</script>";
        echo $test_alert;
        $flag = 1;
    }
}


try {
    $pdo = new PDO($dsn, $user, $password);
    function KUserManagementP()
    {
        unset($_SESSION['eid']);
        global $pdo, $sql, $res;
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
    }

    // INSERT
    function KUserInputP()
    {
        global $pdo, $sql, $id, $name, $pass, $auth, $flag;
        if (isset($_POST['input']) and $flag == 0) {
            $sql = "SELECT * FROM user";
            $stmt = $pdo->query($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($id == $row['user_id']) {
                    $test_alert = "<script type='text/javascript'>alert('ユーザIDが既に登録されています');</script>";
                    echo $test_alert;
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
        global $pdo, $sql, $eid, $id, $name, $pass, $auth, $flag;
        $eid = $_SESSION['eid'];
        if (isset($_POST['edit']) and $flag == 0) {
            $sql = "SELECT * FROM user";
            $stmt = $pdo->query($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($id == $row['user_id'] and $id != $eid) {
                    $test_alert = "<script type='text/javascript'>alert('ユーザIDが既に登録されています');</script>";
                    echo $test_alert;
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 0) {
                $sql = "UPDATE user SET user_id = '$id', user_name = '$name', user_pass = '$pass', authority = '$auth' WHERE user_id = '$eid' ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                header("Location: k_user_screen.php");
                exit;
            }
        }
    }
    // DELETE
    function KUserDelP()
    {
        global $pdo, $sql, $eid;
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
