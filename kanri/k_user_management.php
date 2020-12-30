<?php

# var
# DB
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';
# PHP
$k_res="";
$ku_sql="";
$hash = "";

try {
  #conect
  $pdo = new PDO($dsn, $user, $password);

  // SELECT(user) 
  function KUserManagementP(){
    global $pdo,$ku_sql,$k_res;
    $ku_sql = "SELECT * FROM user";
    $stmt = $pdo->query($ku_sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $k_res .= "<tr><td>";
      //id button('' -> k_user_edit.php or html)
      $k_res .= "<form action='' method='post'>";
      $k_res .= "<button type='submit' name='kue_id' ";
      $k_res .= "value='" . $row['user_id'] . "'>" . $row['user_id'] . "</button>";
      $k_res .= "</form>";
      $k_res .= "</td><td>" ;
      //user name
      $k_res .= $row['user_name'];
      $k_res .= "</td></tr>";
    }
  }
  
  // INSERT(user)
  function KUserInputP(){
    global $pdo,$ku_sql,$hash;
    static $ku_id=0,$ku_name="",$ku_pass="",$ku_auth="";
    if(isset($_POST['ku_input'])){
      if (isset($_POST['ku_id']) and isset($_POST['ku_name']) and isset($_POST['ku_pass'])) {
	if(isset($_POST['ku_auth']) and is_array($_POST['ku_auth'])){
	  $ku_id = $_POST['ku_id'];
	  $ku_name = $_POST['ku_name'];
	  $ku_pass = $_POST['ku_pass'];
	  $hash = password_hash($ku_pass, PASSWORD_DEFAULT);
	  $ku_auth = implode($_POST['ku_auth']);
	
	  // SQL
	  $ku_sql = "INSERT INTO user VALUES($ku_id,'$ku_name','$hash','$ku_auth')";
	  $stmt = $pdo->prepare($ku_sql);
	  $stmt->execute();
	}	
      }
    }
  }

  // EDIT($_POST[ku---] -> $POST[kuu--]) 
  function KUserEditP(){
    global $pdo,$ku_sql,$hash;
    static $kue_id=0,$kuu_id=0,$kuu_name="",$kuu_pass="",$kuu_auth="";
    if(isset($_POST['ku_edit']) and isset($_POST['kue_id'])){
      if (isset($_POST['ku_id']) and isset($_POST['ku_name']) and isset($_POST['ku_pass'])) {
	if(isset($_POST['ku_auth']) and is_array($_POST['ku_auth'])){
	  $kue_id = $_POST['kue_id'];
	  $kuu_id = $_POST['ku_id'];
	  $kuu_name = $_POST['ku_name'];
	  $kuu_pass = $_POST['ku_pass'];
	  $hash = password_hash($kuu_pass, PASSWORD_DEFAULT);
	  $kuu_auth = implode($_POST['ku_auth']);

	  $ku_sql = "UPDATE user SET user_id = $kuu_id, user_name = '$kuu_name', ";
	  $ku_sql .=  "user_pass = '$hash', authority = '$kuu_auth' WHERE user_id = $kue_id";
	  $stmt = $pdo->prepare($ku_sql);
	  $stmt->execute();
	}
      }
    }
  }

  // DELETE
  function KUserDelP(){
    global $pdo,$ku_sql;
    static $kue_id=0;
    if(isset($_POST['ku_del']) and isset($_POST['kue_id'])){
      $kue_id = $_POST['kue_id'];
      $ku_sql = "DELETE FROM user WHERE user_id = '$kue_id'";
      $stmt = $pdo->prepare($ku_sql);
      $stmt->execute();
    }
  }

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
  }
?>
