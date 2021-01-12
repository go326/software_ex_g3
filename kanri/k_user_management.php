<?php
session_start();
# var
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';
$ku_sql = "";
$k_res = "";

try {
  $pdo = new PDO($dsn, $user, $password);

  // SELECT
  function KUserManagementP()
  {
    global $pdo, $ku_sql, $k_res;
    $ku_sql = "SELECT * FROM user";
    $stmt = $pdo->query($ku_sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $k_res .= "</tr><td>";
      $k_res .= "<form action='k_user_edit.php' method='post'><button type='submit' name='kid' value='" . $row['user_id'] . "'>" . $row['user_id'] . "</button></form>";
      $k_res .= "</td><td>";
      $k_res .= $row['user_name'];
      $k_res .= "</td></tr align ='center'>";
    }
  }

  // INSERT
  function KUserInputP()
  {
    global $pdo, $ku_sql, $hash;
    static $ku_id = "", $ku_name = "", $ku_pass = "", $ku_auth = "";
    if (isset($_POST['ku_input'])) {
      if (isset($_POST['kui_id']) and isset($_POST['kui_name']) and isset($_POST['kui_pass'])) {
        if (isset($_POST['kui_auth']) and is_array($_POST['kui_auth'])) {
          $ku_id = $_POST['kui_id'];
          $ku_name = $_POST['kui_name'];
          $ku_pass = $_POST['kui_pass'];
          $hash = password_hash($ku_pass, PASSWORD_DEFAULT);
          $ku_auth = implode($_POST['kui_auth']);
          $ku_sql = "INSERT INTO user VALUES('$ku_id','$ku_name','$hash','$ku_auth')";
          $stmt = $pdo->prepare($ku_sql);
          $stmt->execute();
          header("Location: k_user_screen.php");
          exit;
        }
        $test_alert = "<script type='text/javascript'>alert('チェックボックスが選択されていません');</script>";
        echo $test_alert;
      }
    }
  }
  // UPDATE
  function KUserEditP()
  {
    global $pdo, $ku_sql;
    static $kid = "", $kuu_id = "", $kuu_name = "", $kuu_pass = "", $kuu_auth = "", $hash = "";
    if(isset($_POST['kid'])){
      $_SESSION['ku_edit'] = $_POST['kid'];
    }
    if (isset($_POST['ku_edit'])) {
      if (isset($_POST['kuu_id']) and isset($_POST['kuu_name']) and isset($_POST['kuu_pass'])) {
        if (isset($_POST['kuu_auth']) and is_array($_POST['kuu_auth'])) {
          
          $kid = $_SESSION['ku_edit'];
          $kuu_id = $_POST['kuu_id'];
          $kuu_name = $_POST['kuu_name'];
          $kuu_pass = $_POST['kuu_pass'];
          $hash = password_hash($kuu_pass, PASSWORD_DEFAULT);
          $kuu_auth = implode($_POST['kuu_auth']);
          $ku_sql = "UPDATE user SET user_id = '$kuu_id', user_name = '$kuu_name', user_pass = '$hash', authority = '$kuu_auth' WHERE user_id = '$kid' ";
          $stmt = $pdo->prepare($ku_sql);
          $stmt->execute();
          $_SESSION = array();
          session_destroy();
          header("Location: k_user_screen.php");
          exit;
        }
        $test_alert = "<script type='text/javascript'>alert('チェックボックスが選択されていません');</script>";
        echo $test_alert;
      }
    }
  }
  // DELETE
  function KUserDelP()
  {
    global $pdo, $ku_sql;
    static $kid = "";
    if(isset($_POST['kid'])){
      $_SESSION['ku_del'] = $_POST['kid'];
    }
    if (isset($_POST['ku_del'])) {
      $kid = $_SESSION['ku_del'];
      $ku_sql = "DELETE FROM user WHERE user_id = '$kid'";
      echo $ku_sql;
      $stmt = $pdo->prepare($ku_sql);
      $stmt->execute();
      $_SESSION = array();
      session_destroy();
      header("Location: k_user_screen.php");
      exit;
    }
  }
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
  }
