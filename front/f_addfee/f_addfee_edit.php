    <?php
    // セッション開始と初期化
    session_start();
    // unset($_SESSION['fee_id']);
    unset($_SESSION['fee_room']);
    unset($_SESSION['fee_name']);
    unset($_SESSION['fee_date']);
    unset($_SESSION['fee_place']);
    unset($_SESSION['fee_fee']);
    unset($_SESSION['fee_content']);
    unset($_SESSION['fee_remark']);
    // 変数宣言

    // DB
    $dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
    $user = 'admin';
    $password = 'software_ex_g3';

    // sql文
    $rf_sql = "";

    // 表示用
    $res_room = "";
    $res_name = "";
    $res_date = "";


    $id = "";
    $date = "";
    $date = date('Y-m-d H:i:s');

    // 予約IDの保存
    if (isset($_POST['fee_id'])) {
        $_SESSION['fee_id'] = $_POST['fee_id'];
    }
    $id = $_SESSION['fee_id'];


    try {
        $pdo = new PDO($dsn, $user, $password);

        function FeeSelectP()
        {

            global $pdo, $rf_sql, $res_room, $res_name, $res_date, $id, $date;

            // データの取得
            $rf_sql = "SELECT * FROM customer WHERE customer.reseravetion_id = '$id'";
            $stmt = $pdo->query($rf_sql);
            $stmt->execute();
            $row = $stmt->fetch();

            // 表示データの格納
            $res_room = $row['room_1'];
            $res_name = $row['customer_name'];
            $res_date = substr($date, 0, 10);

            // セッションに保存
            $_SESSION['fee_room'] = $row['room_1'];
            $_SESSION['fee_name'] = $row['customer_name'];
            $_SESSION['fee_date'] = $date;
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
        <link rel="stylesheet" href="../f_reservation/f_input.css" type="text/css">
        <script src="f_addfee.js"></script>
    </head>

    <body>
        <!--ヘッダー-->
        <header>
            <h1>追加料金編集画面</h1>
        </header>


        <!-- DBからの取得 -->
        <?php FeeSelectP(); ?>

        <!--メイン-->
        <div id="main">
            <form method="POST" action="f_addfee_confimation.php" id="form1">
                <dl>
                    <dt>部屋番号</dt>
                    <dd><?php echo $res_room; ?></dd>
                    <dt>氏名</dt>
                    <dd><?php echo $res_name; ?></dd>
                    <dt>日付</dt>
                    <dd><?php echo $res_date; ?></dd>
                    <dt>場所</dt>
                    <dd><input type="text" id="place" name="place"></dd>
                    <dt>追加料金(円)</dt>
                    <dd><input type="text" id="fee" name="fee"></dd>
                    <dt>内容</dt>
                    <dd><input type="text" id="content" name="content"></dd>
                    <dt>備考</dt>
                    <dd><input type="text" id="remark" name="remark"></dd>
                </dl>
            </form>
            <form method="POST" action="../f_information/f_information.php" id="form2">
            </form>
            <ul>
                <li><input type="submit" name="edit" value="確認" onclick="return check()" form="form1"></li>
                <li><button type="submit" id="backbutton" name="ID" value="<?php echo $_SESSION['fee_id']; ?>" form="form2">戻る</button></li>
            </ul>
            <!-- <li><input type="button" onclick="location.href='../f_information/f_information_details.html'" value="戻る"></li> -->
            <!--<form method="POST" action="../f_information/f_information.php">-->    
            
            <!--</form>-->
               
                

        </div>
    </body>
</html>