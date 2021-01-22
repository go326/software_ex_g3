<!DOCTYPE html>

<?php
session_start();
unset($_SESSION['fee_id']);

require(dirname(__FILE__) . "/../../db_connect.php");
require(dirname(__FILE__) . "/../f_customer.php");

$dt = new DateTime();
$date = $dt->format("Y-m-d");

global $pdo;

if (empty($_POST['ID'])) {
    header("Location:/software_ex_g3/front/room.php");
}

$sql = "SELECT * FROM customer where  reseravetion_id = ?";
$smt = $pdo->prepare($sql);
$smt->bindValue(1, $_POST['ID'], PDO::PARAM_STR);
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
            <input type="hidden" name='id' value=<?php echo $_POST['ID']; ?>>
            <input type="submit" name='restore' value="編集">
            <input type="submit" name='delete' value="削除">
            <input type="submit" name='checkin' value="チェックイン/チェックアウト">
            <input type="submit" name='isstay' value="外出/帰館">
        </form>
        <form action="../f_addfee/f_addfee_edit.php" method="post">
            <input type="hidden" name='fee_id' value=<?php echo $_POST['ID']; ?>>
            <input type="submit" name='add_fee' value="追加料金登録">
        </form>
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

    <div id="fee">
        <div id="day">
            <dt> 内容 </dt>
            <dd>
                <?php echo $data['reservation_date']; ?>
            </dd>
            <dt> 料金 </dt>
            <dd>
                <?php echo $data['stay_date'] . "~" . $stay_day; ?>
            </dd>
            <dt> 備考 </dt>
            <dd>
                <?php echo $data['stay_date'] . "~" . $stay_day; ?>
            </dd>
        </div>

    </div>
</body>

</html>