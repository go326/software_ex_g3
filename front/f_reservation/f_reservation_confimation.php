<!DOCTYPE html>
<html>

<head>
    <!--文字コードUTF-8-->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="f_input.css" type="text/css" ?>
    <script src="f_reservation.js" ?></script>
</head>

<body>
    <?php
    session_save_path("/var/tmp/");
    session_start();
    $_SESSION['info'] = $_POST;
    if (isset($_POST['reservation'])) {
        $is = 'reservation';
    ?>
        <!--ヘッダー-->
        <header>
            <h1>予約登録確認画面</h1>
        </header>
    <?php
    } else {
        $is = 'restore';
    ?>
        <!--ヘッダー-->
        <header>
            <h1>予約編集確認画面</h1>
        </header>
    <?php
    }
    require(dirname(__FILE__) . "/../../db_connect.php");
    require(dirname(__FILE__) . "/../f_customer.php");
    global $pdo;
    if (isset($_POST['reservation']) || isset($_POST['restore'])) {
        $dt = new DateTime($_POST["stay_year"] . '/' . $_POST["stay_manth"]  . '/' . $_POST["stay_day"]); //宿泊日
        $date = $dt->format('Y-m-d');
        $count = $_POST["stay_count"];
        $is_submit = 0;
        for ($i = 1; $i <= $count; $i++) {
            for ($j = 1; $j < 4; $j++) {
                if (empty($_POST['room_number' . $j])) {
                    continue;
                }
                if (isset($_POST['restore'])) {
                    break 2;
                } else  if (bool_stay($date, $_POST['room_number' . $j]) != 0) {
                    echo "予約が重複しています";
                    $is_submit = 1;
                    break 2;
                }
            }
            $date = $dt->add(DateInterval::createFromDateString("1day"))->format('Y-m-d');
        }
    }
    foreach ($_POST as $name => $value) {
        if (empty($value)) {
            $_POST[$name] = 'なし';
        }
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
    <form action="../ex/f_done.php" method="post">
    
    <?php
    foreach ($_POST as $info) {
    ?>
        <input type="hidden" name="cus_info[]" class="" value=<?php echo $info ?>></input>
    <?php
    }
    ?>

    <input type="button" onclick="location.href='./f_restore.php'" value="キャンセル"> </input>
    <input type="hidden" name="is" value=<?php echo  $is; ?>></input>

            <?php
            if ($is_submit == 0) {
            ?>
                <input type="submit" name="input" value="登録" class=""></input>
            <?php
            }
            ?>
        </form>
        <!--フッター-->
</body>

</html>
