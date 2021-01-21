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
                <p>ユーザID　　:<input oninput="maxLengthCheck(this)" type="number" name="id" min="0" maxlength="10" required></p>
                <p>ユーザ名　　:<input oninput="maxLengthCheck(this)" type="text" name="name" minlength="1" maxlength="16" required></p>
                <p>パスワード　:<input oninput="maxLengthCheck(this)" type="password" name="pass" minlength="1" maxlength="16" required></p>
                <script>
                    function maxLengthCheck(object) {
                        if (object.value.length > object.maxLength)
                            object.value = object.value.slice(0, object.maxLength)
                    }
                </script>
                <p>ユーザ権限</p>
                <p>
                    フロント<input type="checkbox" name="auth[]" value="1">
                    清掃<input type="checkbox" name="auth[]" value="2">
                    レストラン<input type="checkbox" name="auth[]" value="3">
                    アルバイト<input type="checkbox" name="auth[]" value="4">
                    管理者<input type="checkbox" name="auth[]" value="5">
                </p>

                <input type="button" onclick="location.href='k_user_screen.php'" value="取消">
                <input type="submit" name="input" value=" 登録">
            </form>
            <?php KUserInputP(); ?>
        </div>
    </body>

    </html>