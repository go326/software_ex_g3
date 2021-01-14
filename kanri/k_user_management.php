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

// 編集時のIDを記憶
if (isset($_POST['eid'])) {
    $_SESSION['eid'] = $_POST['eid'];
}

// 入力情報の確認
if (isset($_POST['id']) and isset($_POST['name']) and isset($_POST['pass'])) {
    if (isset($_POST['auth']) and is_array($_POST['auth'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $auth = implode("", $_POST["auth"]);
    } else {
        $test_alert = "<script type='text/javascript'>alert('チェックボックスが選択されていません');</script>";
        echo $test_alert;
        $flag = 1;
    }
}

if ($flag == 0) {
    try {
        $pdo = new PDO($dsn, $user, $password);

        function KUserManagementP()
        {
            unset($_SESSION['eid']);
            global $pdo, $sql, $res;
            static $auth1 = "", $auth2 = "", $auth3 = "", $auth4 = "", $auth5 = "";
            $sql = "SELECT * FROM user";
            $stmt = $pdo->query($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $auth1 = "";
                $auth2 = "";
                $auth3 = "";
                $auth4 = "";
                $auth5 = "";
                if (strpos($row['authority'], '1') !== false) {
                    $auth1 .= "フロント ";
                }
                if (strpos($row['authority'], '2') !== false) {
                    $auth2 .= "清掃 ";
                }
                if (strpos($row['authority'], '3') !== false) {
                    $auth3 .= "レストラン ";
                }
                if (strpos($row['authority'], '4') !== false) {
                    $auth4 .= "アルバイト ";
                }
                if (strpos($row['authority'], '5') !== false) {
                    $auth5 .= "管理者 ";
                }
                $res .= "</tr><td>";
                $res .= "<form action='k_user_edit.php' method='post'>";
                $res .= "<button type='submit' name='eid' value='{$row['user_id']}'> {$row['user_id']} </button>";
                $res .= "</form>";
                $res .= "</td><td>";
                $res .= $row['user_name'];
                $res .= "</td><td>";
                $res .= $auth1 . $auth2 . $auth3 . $auth4 . $auth5;
                $res .= "</td></tr align ='center'>";
            }
        }

        // INSERT
        function KUserInputP()
        {
            global $pdo, $sql, $id, $name, $pass, $auth, $flag;
            if (isset($_POST['input'])) {
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
            global $pdo, $sql, $eid, $id, $name, $pass, $auth;
            if (isset($_POST['edit'])) {
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
                    $eid = $_SESSION['eid'];
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
}
