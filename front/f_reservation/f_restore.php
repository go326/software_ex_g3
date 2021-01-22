<!DOCTYPE html>
<?php

require(dirname(__FILE__) . "/../../db_connect.php");
require(dirname(__FILE__) . "/../f_customer.php");

global $pdo;

if (isset($_POST['add_fee'])) {
?>
    <form action="../f_addfee/f_addfee_edit.html" type="POST">
        <input type="hidden" value=<?php echo $_POST['id']; ?>>
    </form>
<?php
}

if (isset($_POST['delete'])) {
    delete($_POST['id']);
    header("Location:../room.php");
}

if (isset($_POST['checkin'])) {
    checkin($_POST['id']);
    header("Location:../room.php");
}

if (isset($_POST['isstay'])) {
    stay($_POST['id']);
    header("Location:../room.php");
}

$dt = new DateTime();
$date = $dt->format("Y-m-d");

$sql = "SELECT * FROM customer where  reseravetion_id = ?";

$smt = $pdo->prepare($sql);
$smt->bindValue(1, $_POST['id'], PDO::PARAM_STR);
$smt->execute();
$data = $smt->fetch(PDO::FETCH_NUM);


$dt = new DateTime($data[1]);
$year = $dt->format('Y');
$manth = $dt->format('m');
$day = $dt->format('d');
?>

<html>

<head>
    <!--文字コードUTF-8-->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="f_input.css" type="text/css">
    <script src="f_reservation.js"></script>
</head>

<body>
    <!--ヘッダー-->
    <header>
        <h1>予約編集画面</h1>
    </header>

    <!--メイン-->
    <div id="main">
        <form action="f_reservation_confimation.php" method="post">
            <dl>
                <dt>宿泊日</dt>
                <dd>
                    <!--日付の入力フォームの作成(ドロップダウンリスト)-->

                    <select class="year" name="stay_year" id="year1"></select>年
                    <script>
                        getYear1();
                        LoadData("year1", <?php echo $year; ?>);
                    </script>
                    <select class="month" name="stay_manth" id="month1"></select>月
                    <script>
                        getMonth1();
                        LoadData("month1", <?php echo $manth; ?>);
                    </script>
                    <select class="day" name="stay_day" id="day1"></select>日
                    <script>
                        getDay1();
                        LoadData("day1", <?php echo $day; ?>);
                    </script>
                </dd>
                <dt>泊数</dt>
                <dd>
                    <select name="stay_count" id="stay_count"></select>
                    <script>
                        getStayCount();
                        LoadData("stay_count", <?php echo $data[3]; ?>)
                    </script>
                </dd>
                <!--入力必須項目(最大文字数20)-->
                <dt>氏名</dt>
                <dd>
                    <input type="text" id="name" name="name" maxlength="20" size="25" value='<?php echo $data[4]; ?>' required>
                </dd>
                <!--入力必須項目-->
                <dt>住所</dt>
                <dd>
                    <input type="text" id="address1" name="address" minlength="1" size="40" value='<?php echo $data[5]; ?>' required>
                </dd>
                <!--入力必須項目-->
                <dt>電話番号</dt>
                <dd>
                    <input type="tel" id="tel" name="phone" size="10" maxlength="20" value='<?php echo $data[6]; ?>' required>
                </dd>
                <dt>人数</dt>
                <dd>

                    大人<select name="adult" id="adult"></select>人
                    <script>
                        getAdult();
                        LoadNumber("adult", <?php echo $data[7]; ?>);
                    </script>
                    子供<select name="child" id="child"></select>人
                    <script>
                        getChild();
                        LoadNumber("child", <?php echo $data[8]; ?>);
                    </script>
                </dd>

                <dt>プラン</dt>
                <dd>
                    <input type="text" id="plan" name="plan" manlength="30" size="30" value='<?php echo $data[9]; ?>' required>
                </dd>
                <!--必須選択-->
                <dt>夕食の有無</dt>
                <dd>
                <?php
                if($data[10] == 1){
                    ?>
                    <label><input type="radio" name="is_dinner" value="有" checked required>有</label>
                    <label><input type="radio" name="is_dinner" value="無" required>無</label>
                    <?php
                }else {
                    ?>
                    <label><input type="radio" name="is_dinner" value="有" required>有</label>
                    <label><input type="radio" name="is_dinner" value="無" checked required>無</label>
                    <?php
                }
                    ?>
                </dd>
                <dt>夕食のメニュー</dt>
                <dd>
                    <input type="text" id="dinner_menu" name="dinner_nemu" manlength="30" value='<?php echo $data[11]; ?>'>
                </dd>
                <!--必須選択-->
                <dt>朝食の有無</dt>
                <dd>
                <?php
                if($data[12] == 1){
                    ?>
                    <label><input type="radio" name="is_breakfast" value="有" checked required>有</label>
                    <label><input type="radio" name="is_breakfast" value="無" required>無</label>
                    <?php
                } else {
                    ?>
                    <label><input type="radio" name="is_breakfast" value="有" required>有</label>
                    <label><input type="radio" name="is_breakfast" value="無" checked required>無</label>
                    <?php
                }
                    ?>
                </dd>
                <dt>朝食のメニュー</dt>
                <dd>
                    <input type="text" id="breakfast_menu" name="breakfast_nemu" manlength="30" value='<?php echo $data[13]; ?>'>
                </dd>
                <!--部屋番必須入力(最低一つは)-->
                <dt>部屋番号</dt>
                <dd>
                    <input type="text" id="room-number1" name="room_number1" minlength="3" maxlength="3" size="10" value='<?php echo $data[14]; ?>'>
                    <input type="text" id="room-number2" name="room_number2" minlength="3" maxlength="3" size="10" value='<?php echo $data[15]; ?>'>
                    <input type="text" id="room-number3" name="room_number3" minlength="3" maxlength="3" size="10" value='<?php echo $data[16]; ?>'>
                </dd>
                <dt>備考</dt>
                <dd>
                    <textarea id="remark" name="remark" rows="5" cols="40" value='<?php echo $data[18]; ?>'></textarea>
                </dd>
            </dl>
            <ul>
                <li><input type="button" onclick="location.href='../room.php'" value="戻る"></li>
                <li><input type="submit" name="restore" value="完了" onclick="return check()"></li>
            </ul>
        </form>
        <script src="f_reservation.js"></script>
    </div>
    <!--フッター-->
</body>

</html>
<?php
