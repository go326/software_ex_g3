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
    foreach ($_POST as $name => $value) {
        if (empty($value)) {
            $_POST[$name] = 'なし';
        }
    }

    if (isset($_POST['cus_info'])) {
        echo 'aa';
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
        <input type="hidden" name="cus_info" class="" value={$_POST}>
        <input type="submit" name="input" value="登録" class="">
    </form>
    <!--フッター-->
</body>

</html>