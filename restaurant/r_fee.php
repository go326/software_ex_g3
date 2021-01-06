<?php
session_start();
# var DB
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';
# var PHP
$rf_sql = "";
$rf_res = "";
$id = "";
$date = "";
$date = date('Y-m-d H:i:s');
$flag = 0;

# session
unset($_SESSION["fee_id"]);
if(!empty($_POST['fid'])){//f_information_details
  $_SESSION['fee_id'] = $_POST['fid'];
  $flag = 1;
}elseif(!empty($_POST['fae'])){//f_addfee_edit
  $_SESSION['fee_id'] = $_POST['fae'];
  $flag = 2;
}else{
  $flag = 0;
}
if($flag!=0){
  $id=$_SESSION['fee_id'];
}

try {
  //conect
  $pdo = new PDO($dsn, $user, $password);

  // SELECT(fee)
  function FeeSelectP(){
    global $pdo,$rf_sql,$rf_res,$id,$date,$flag;
    
    if($flag != 0){
      if($flag == 1){
	$rf_sql = "SELECT * FROM customer,fee WHERE customer.reseravetion_id = '$id' AND fee.fee_id = '$id'";
      }else if($flag == 2){
	$rf_sql = "SELECT * FROM customer WHERE customer.reseravetion_id = '$id'";
      }else{
	$test_alert = "<script type='text/javascript'>alert('error');</script>";
	echo $test_alert;
	exit;
      }
      $stmt = $pdo->query($rf_sql);
      $stmt -> execute(); 
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$rf_res .= "<tr><td>";
	//f_information_details
	if($flag==1){
	  $rf_res .= substr($row['fee_date'], 0, 10);
	  $rf_res .= "</td></tr><tr><td>" ;
	  $rf_res .= $row['fee_place'];
	  $rf_res .= "</td></tr><tr><td>" ;
	  $rf_res .= $row['fee_add'];
	  $rf_res .= "</td></tr><tr><td>" ;
	  $rf_res .= $row['fee_contents'];
	  $rf_res .= "</td></tr><tr><td>" ;
	  $rf_res .= $row['fee_remark'];
	}
	//f_addfee_edit
	else if($flag==2){
	  $id = $row['reseravetion_id'];
	  $rf_res .= $row['room_1'];
	  $rf_res .= "</td></tr><tr><td>" ;
	  $rf_res .= $row['customer_name'];
	  $rf_res .= "</td></tr><tr><td>" ;
	  $rf_res .= substr($date, 0, 10);
	}
	$rf_res .= "</td></tr>";
      }
    }
  }
  // INSERT(fee)
  function FeeInsertP()
  {
    global $pdo,$rf_sql,$id,$date;
    static $rf_place = "", $rf_add = "", $rf_contents = "", $rf_remark = "";
    //f_addfee_edit(insert)
    if (isset($_POST['rf_reg'])) {
      if (!empty($_POST['rf_place']) and !empty($_POST['rf_add']) 
	  and !empty($_POST['rf_contents']) and !empty($_POST['rf_remark'])) {
        $rf_place = $_POST['rf_place'];
        $rf_add = $_POST['rf_add'];
        $rf_contents = $_POST['rf_contents'];
        $rf_remark = $_POST['rf_remark'];

        // SQL
        $rf_sql = "INSERT INTO fee VALUES('$id','$date','$id','$rf_place','$rf_add','$rf_contents','$rf_remark')";
        $stmt = $pdo->prepare($rf_sql);
        $stmt->execute();
      }
    }
  }

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
  }
?>