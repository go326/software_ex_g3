<?php require("k_user_management.php"); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./k_user.css" type="text/css">
  <title>screen</title>
  
</head>

<body>
<header>
  <p><input type="button" onclick="location.href='k_top.html'" value="TOPへ戻る"></p>
  <h1>ユーザ情報管理</h1> 
  <p><input type="button" onclick="location.href='k_user_input.php'" value="新規入力"></p>
</header> 
  <!-- 一覧 -->
  <table border="1">
    <tr>
      <th> ユーザID </th>
      <th> ユーザ名 </th>
    </tr>
    <?php KUserManagementP();
    echo $k_res; ?>
  </table>
</body>

</html>