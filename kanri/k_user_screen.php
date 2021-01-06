<?php require("k_user_management.php"); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>screen</title>
</head>

<body>
  <p><input type="button" onclick="location.href='../i_gernal_top.html'" value="TOPへ戻る"></p>
  <h1>ユーザ情報管理</h1>
  <p><input type="button" onclick="location.href='k_user_input.php'" value="新規入力"></p>
  <!-- 一覧 -->
  <table>
    <tr>
      <th> ユーザID </th>
      <th> ユーザ名 </th>
    </tr>
    <?php KUserManagementP();
    echo $k_res; ?>
  </table>
</body>

</html>