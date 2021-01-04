<!DOCTYPE html>
<html>

<head>
    <!--文字コードUTF-8-->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="f_input.css" type="text/css" ?>
    <script src="f_reservation.js" ?></script>
</head>

<body>
    <!--ヘッダー-->
    <header>
        <h1>予約登録確認画面</h1>
    </header>
    <?php
    include("../../db_connect.php");
    global $pdo;
    foreach ($_POST as $name => $value) {
        if (empty($value)) {
            $_POST[$name] = 'なし';
        }
    }

    if (isset($_POST['cus_info'])) {
        var_dump($_POST['cus_info']);
        $sql = 'INSERT INTO customer VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0,?)';
        $stmt = $pdo->prepare($sql);
        $dt = new DateTime(); //予約日
        $today = $dt->format('Y-m-d');
        $dt = new DateTime($_POST['cus_info'][0] . '/' . $_POST['cus_info'][1] . '/' . $_POST['cus_info'][2]); //宿泊日
        $stay_day = $dt->format('Y-m-d');
        $ID = $dt->format('Ymd');
        echo $today;
        echo $stay_day;
        echo $ID;
        $stmt->bindValue(1, $ID, PDO::PARAM_STR); //宿泊日
        $stmt->bindValue(2, $stay_day, PDO::PARAM_STR); //宿泊日
        $stmt->bindValue(3, $today, PDO::PARAM_STR);    //予約日
        $stmt->bindValue(4, $_POST['suc_info'][7], PDO::PARAM_STR);  //泊数
        $stmt->bindValue(5, $_POST['suc_info'][3], PDO::PARAM_STR);  //氏名
        $stmt->bindValue(6, $_POST['suc_info'][4], PDO::PARAM_STR);  //住所
        $stmt->bindValue(7, $_POST['suc_info'][5], PDO::PARAM_STR);  //電話番号
        $stmt->bindValue(8, $_POST['suc_info'][6], PDO::PARAM_STR);  //大人
        $stmt->bindValue(9, $_POST['suc_info'][7], PDO::PARAM_STR);  //子供
        $stmt->bindValue(10, $_POST['suc_info'][8], PDO::PARAM_STR); //プラン
        $stmt->bindValue(11, $_POST['suc_info'][9], PDO::PARAM_INT); //is夕食x
        $stmt->bindValue(12, $_POST['suc_info'][10], PDO::PARAM_STR); //メニュー
        $stmt->bindValue(13, $_POST['suc_info'][11], PDO::PARAM_INT); //is朝食
        $stmt->bindValue(14, $_POST['suc_info'][12], PDO::PARAM_STR); //メニュー
        $stmt->bindValue(15, $_POST['suc_info'][13], PDO::PARAM_INT); //部屋１
        $stmt->bindValue(16, $_POST['suc_info'][14], PDO::PARAM_INT); //部屋２
        $stmt->bindValue(17, $_POST['suc_info'][15], PDO::PARAM_INT); //部屋３
        //$stmt->bindValue(18, $_POST['suc_info'][], PDO::PARAM_STR); //チェックイン
        $stmt->bindValue(19, $_POST['suc_info'][16], PDO::PARAM_STR); //備考
        $stmt->execute(null);
        header("Location:/software_ex_g3/front/f_reservation/f_reservation_done.html");
    }
    ?>

    <!--メイン-->
    <div id="main" ?>
        <dl>
            <dt>宿泊日</dt>
            <dd>
                <?php echo $_POST["stay_year"] . "年" .  $_POST["stay_manth"] . "月" . $_POST["stay_day"] . "日" ?>
            </dd>
            <dt>氏名</dt>
            <dd>
                <?php echo $_POST["name"] ?>
            </dd>
            <dt>住所</dt>
            <dd>
                <?php echo $_POST["address"] ?>
            </dd>
            <dt>電話番号</dt>
            <dd>
                <?php echo $_POST["phone"] ?>
            </dd>
            <dt>人数</dt>
            <dd>

                大人 <?php echo $_POST["adult"] ?> 人
                子供 <?php echo $_POST["child"] ?> 人
            </dd>
            <dt>プラン</dt>
            <dd>
                <?php echo $_POST["plan"] ?>
            </dd>
            <dt>夕食の有無</dt>
            <dd>
                <?php echo $_POST["is_dinner"] ?>
            </dd>
            <dt>食事のメニュー</dt>
            <dd>
                <?php echo $_POST["dinner_nemu"] ?>
            </dd>
            <dt>朝食の有無</dt>
            <dd>
                <?php echo $_POST["is_breakfast"] ?>

            </dd>
            <dt>部屋番号</dt>
            <dd>
                <?php echo $_POST['room_number1'] ?>
                <?php echo $_POST['room_number2'] ?>
                <?php echo $_POST['room_number3'] ?>
            </dd>
            <dt>備考</dt>
            <dd>
                <?php echo $_POST['remark'] ?>
            </dd>
        </dl>

    </div>
    <form action="" method="post">
        <button>キャンセル</button>
        <?php
        foreach ($_POST as $info) {
        ?>
            <input type="hidden" name="cus_info[]" class="" value=<?php echo $info ?>>
        <?php
        }
        ?>
        <input type="submit" name="input" value="登録" class="">
    </form>
    <!--フッター-->
</body>

</html>