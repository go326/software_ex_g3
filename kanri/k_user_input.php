  <?php require("k_user_management.php"); ?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./k_user.css" type="text/css">
    <title></title>
  </head>

  <body>
  <header>
    <h1>新規ユーザ情報入力</h1>
  </header>
    <div id="main">
    <!-- 入力欄 -->
    <form action="" method="post">  
        <p>ユーザID　　:<input type="number" name="kui_id" minlength="1" maxlength="12" required></p>
        <p>ユーザ名　　:<input type="text" name="kui_name"  minlength="1" maxlength="16" required></p>
        <p>パスワード　:<input type="password" name="kui_pass" minlength="1" required></p>

        <p>ユーザ権限</p>
        <p>
          フロント<input type="checkbox" name="kui_auth[]" value="1"> 
          清掃<input type="checkbox" name="kui_auth[]" value="2"> 
          レストラン<input type="checkbox" name="kui_auth[]" value="3"> 
          アルバイト<input type="checkbox" name="kui_auth[]" value="4"> 
          管理者<input type="checkbox" name="kui_auth[]" value="5"> 
        </p>

        <?php KUserInputP(); ?>
      <input type="button" onclick="location.href='k_user_screen.php'" value="取消">
      <input type="submit" name="ku_input" value=" 登録">
      </form>
    </div>
  </body>

  </html>