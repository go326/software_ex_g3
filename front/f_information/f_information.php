<!DOCTYPE html>

<?php
session_save_path("/var/tmp/");
session_start();
unset($_SESSION['fee_id']);

require(dirname(__FILE__) . "/../../db_connect.php");
require(dirname(__FILE__) . "/../f_customer.php");

$dt = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$date = $dt->format("Y-m-d");

global $pdo;

if (isset($_POST['ID'])) {
    $ID = $_POST['ID'];
} else if (isset($_POST['room'])) {

    $ID = bool_stay($date, $_POST['room']);

    if ($ID == 0) {
        $_SESSION['new_res'] = $_POST['room'];
        header("Location:/software_ex_g3/front/f_reservation/f_restore.php");
    }
}

$sql = "SELECT * FROM customer where  reseravetion_id = ?";
$smt = $pdo->prepare($sql);
$smt->bindValue(1, $ID, PDO::PARAM_STR);
$smt->execute();
$data = $smt->fetch(PDO::FETCH_ASSOC);

foreach ($data as $key => $value) {
    if ((strcmp($key, 'room_2') != 0 && strcmp($key, 'room_3') != 0 && strcmp($key, 'child') != 0) && empty($value)) {
        $data[$key] = 'なし';
    }
    if ((strcmp($key, 'is_dinner') == 0 || strcmp($key, 'is_dinner') == 0) && $data[$key] == 1) {
        $data[$key] = "有";
    } else if ((strcmp($key, 'is_dinner') == 0 || strcmp($key, 'is_dinner') == 0) && $data[$key] == 0) {
        $data[$key] = "無";
    }
    if ((strcmp($key, 'is_breakfast') == 0 || strcmp($key, 'is_breakfast') == 0) && $data[$key] == 1) {
        $data[$key] = "有";
    } else if ((strcmp($key, 'is_breakfast') == 0 || strcmp($key, 'is_breakfast') == 0) && $data[$key] == 0) {
        $data[$key] = "無";
    }
}
$dt = new DateTime($data['stay_date']);
$stay_day = $dt->add(DateInterval::createFromDateString($data['stay_count'] . "day"))->format('Y-m-d');


$sql = "SELECT * FROM fee where  fee_id = ?";
$smt = $pdo->prepare($sql);
$smt->bindValue(1, $ID, PDO::PARAM_STR);
$smt->execute();
$fee_data = $smt->fetchAll(PDO::FETCH_ASSOC);
foreach ($fee_data as $key => $value) {
    if (empty($value['fee_remark'])) {
        $fee_data[$key]['fee_remark'] = 'なし';
    }
}
$text = null;
for ($i = 1; $i < 4; $i++) {
    if (bool_stay($date, $data["room_$i"]) == $ID) {
        $sql = "SELECT * FROM room where room_number = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $data["room_$i"], PDO::PARAM_INT);
        $stmt->execute();
        $is_clean = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($is_clean['room_clean'] == 0) {
            $text .= "  " . $data["room_$i"];
        }
    }
    $text .= "が未清掃です．";
}


$_SESSION['is_input'] = 2;
?>

<html>

<head>
    <meta http - equiv=”Content - Type” content=”text html; charset=UTF - 8″>
    <link rel="stylesheet" href="./f_information.css" type="text/css">
    <script type="text/javascript" src="maketable.js"></script>
    <script type="text/javascript" src="f_top.js"></script>
</head>

<body>
    <header>
        <h1>予約詳細画面</h1>
        <form action="../f_reservation/f_restore.php" method="post">
            <?php

            if (strpos(strval($_SESSION['auth']), strval('1')) !== false) {
            ?>
                <input type="hidden" name='id' value=<?php echo $ID; ?>>
                <input type="submit" name='restore' value="編集">
                <input type="submit" name='delete' value="削除">
                <input type="submit" name='checkin' value="チェックイン/チェックアウト">
                <input type="submit" name='isstay' value="外出/帰館">
            <?php
            }
            ?>
            <input type="button" onclick="location.href='../room.php'" value="戻る">
        </form>
        <form action="../f_addfee/f_addfee_edit.php" method="post">
            <input type="hidden" name='fee_id' value=<?php echo $ID; ?>>
            <input type="submit" name='add_fee' value="追加料金登録">
        </form>
        <?php
        echo $text;
        ?>
    </header>

    <div id="info">
        <dl>
            <div id="id">
                <dt> 予約ID </dt>
                <dd>
                    <?php echo $data['reseravetion_id']; ?>
                </dd>
            </div>
            <div id="day">
                <dt> 予約日 </dt>
                <dd>
                    <?php echo $data['reservation_date']; ?>
                </dd>
                <dt> 宿泊日 </dt>
                <dd>
                    <?php echo $data['stay_date'] . "~" . $stay_day; ?>
                </dd>
            </div>
            <div id="customer">
                <dt> 氏名 </dt>
                <dd>
                    <?php echo $data['customer_name']; ?>
                </dd>
                <dt> 住所 </dt>
                <dd>
                    <?php echo $data['customer_address']; ?>
                </dd>
                <dt> 電話番号 </dt>
                <dd>
                    <?php echo $data['phone_number']; ?>
                </dd>
            </div>
            <div id="counter">
                <dt> 人数 </dt>
                <dd>
                    <?php
                    echo "大人" . $data['adult'] . "人";
                    if (!empty($data['child'])) {
                        echo ", 子供" . $data['child'] . "人";
                    }
                    ?>
                </dd>
            </div>
            <div id="plan">
                <dt> プラン </dt>
                <dd>
                    <?php echo $data['customer_plan']; ?>
                </dd>
                <dt> 夕食 </dt>
                <dd>
                    <?php echo $data['is_dinner']; ?>
                </dd>
                <dt> 夕食メニュー </dt>
                <dd>
                    <?php echo $data['dinner_menu']; ?>
                </dd>
                <dt> 朝食 </dt>
                <dd>
                    <?php echo $data['is_breakfast']; ?>
                </dd>
                <dt> 朝食メニュー </dt>
                <dd>
                    <?php echo $data['breakfast_menu']; ?>
                </dd>
            </div>

            <div id="room">
                <dt> 部屋番号</dt>
                <dd>
                    <?php echo $data['room_1'] . " " . $data['room_2'] . " " . $data['room_3']; ?>
                </dd>
            </div>
            <div id="remark">
                <dt> 備考</dt>
                <dd>
                    <?php echo $data['customer_remark']; ?>
                </dd>
            </div>
        </dl>
    </div>

    <?php
    foreach ($fee_data as $value) {
    ?>
        <div id="fee">
            <dl>
                <dt> 場所 </dt>
                <dd>
                    <?php echo $value['fee_place']; ?>
                </dd>
                <dt> 内容 </dt>
                <dd>
                    <?php echo $value['fee_contents']; ?>
                </dd>
                <dt> 料金 </dt>
                <dd>
                    <?php echo $value['fee_add'];  ?>
                </dd>
                <dt> 備考 </dt>
                <dd>
                    <?php echo $value['fee_remark']; ?>
                </dd>
            </dl>
        </div>
    <?php
    }
    ?>
</body>

</html>