    <?php
    // セッションの開始
    session_start();

    // 変数宣言
    require("../../i_general_security.php");

    // DB
    $dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
    $user = 'admin';
    $password = 'software_ex_g3';

    // sql文
    $rf_sql = "";


    $id = "";
    $room = "";
    $name = "";
    $date = "";
    $place = "";
    $fee = "";
    $content = "";
    $remark = "";

    // セッションに保存
    if (isset($_POST['place']) and isset($_POST['fee']) and isset($_POST['content']) and isset($_POST['remark'])) {
        $place = IFormSecurityP($_POST['place']);
        $fee = IFormSecurityP($_POST['fee']);
        $content = IFormSecurityP($_POST['content']);
        $remark = IFormSecurityP($_POST['remark']);

        // $_SESSION['fee_place'] = $_POST['place'];
        // $_SESSION['fee_fee'] = $_POST['fee'];
        // $_SESSION['fee_content'] = $_POST['content'];
        // $_SESSION['fee_remark'] = $_POST['remark'];

        $_SESSION['fee_place'] = $place;
        $_SESSION['fee_fee'] = $fee;
        $_SESSION['fee_content'] = $content;
        $_SESSION['fee_remark'] = $remark;
    }


    // セッションの利用
    $id = $_SESSION['fee_id'];
    $room = $_SESSION['fee_room'];
    $name = $_SESSION['fee_name'];
    $date = $_SESSION['fee_date'];
    $place = $_SESSION['fee_place'];
    $fee = $_SESSION['fee_fee'];
    $content = $_SESSION['fee_content'];
    $remark = $_SESSION['fee_remark'];

    try {
        $pdo = new PDO($dsn, $user, $password);

        function FeeInsertP()
        {
            global $pdo, $rf_sql, $id, $date, $place, $fee, $content, $remark;

            // DBに挿入
            if (isset($_POST['input'])) {
                $rf_sql = "INSERT INTO fee VALUES('$id','$date','$id','$place','$fee','$content','$remark')";
                echo $rf_sql;
                $stmt = $pdo->prepare($rf_sql);
                $stmt->execute();
                // 画面遷移
                header("Location:/software_ex_g3/front/f_addfee/f_addfee_done.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <!--文字コードUTF-8-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../f_reservation/f_input.css" type="text/css" ?>
        <script src="f_reservation.js" ?></script>
    </head>

    <body>
        <!--ヘッダー-->
        <header>
            <h1>予約登録確認画面</h1>
        </header>

        <!--メイン-->
        <div id="main" ?>
            <dl>
                <dt>部屋番号</dt>
                <dd><?php echo $room; ?></dd>
                <dt>氏名</dt>
                <dd><?php echo $name; ?></dd>
                <dt>日付</dt>
                <dd><?php echo substr($date, 0, 10); ?></dd>
                <dt>場所</dt>
                <dd><?php echo $place; ?></dd>
                <dt>追加料金(円)</dt>
                <dd><?php echo $fee; ?></dd>
                <dt>内容</dt>
                <dd><?php echo $content; ?></dd>
                <dt>備考</dt>
                <dd><?php echo $remark; ?></dd>
            </dl>

        </div>

        <form action="" method="post">
            <ul>
                <li><input type="button" onclick="location.href='f_addfee_edit.php'" value="キャンセル"></li>
                <li><input type="submit" name="input" value="登録"></li>
            </ul>
        </form>
        <?php FeeInsertP(); ?>

        <!--フッター-->
    </body>

    </html>