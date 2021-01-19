<!DOCTYPE html>

<?php
include("../../db_connect.php");
require("../f_customer.php");

$dt = new DateTime();
$date = $dt->format("Y-m-d");

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
    } else {
        $data[$key] = "無";
    }
}


$dt = new DateTime($data[1]);
$stay_day = $dt->add(DateInterval::createFromDateString($data[3] . "day"))->format('Y-m-d');

?>

<script>
    var $info = "<?php echo $_POST; ?>"
    var $stay_day = "<?php echo $stay_day; ?>"
</script>



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
            <input type="submit" name='add_fee' value="追加料金登録">
        </form>
    </header>

    <div id=" main">
        <dl>
            <div id="id">
                <dt> 予約ID </dt>
                <dd>
                    <?php echo $data[0]; ?>
                </dd>
            </div>
            <div id="day">
                <dt> 予約日 </dt>
                <dd>
                    <?php echo $data[2]; ?>
                </dd>
                <dt> 宿泊日 </dt>
                <dd>
                    <?php echo $data[1] . "~" . $stay_day; ?>
                </dd>
            </div>
            <div id="customer">
                <dt> 氏名 </dt>
                <dd>
                    <?php echo $data[4]; ?>
                </dd>
                <dt> 住所 </dt>
                <dd>
                    <?php echo $data[5]; ?>
                </dd>
                <dt> 電話番号 </dt>
                <dd>
                    <?php echo $data[6]; ?>
                </dd>
            </div>
            <div id="counter">
                <dt> 人数 </dt>
                <dd>
                    <?php
                    echo "大人" . $data[7] . "人";
                    if (!empty($data[8])) {
                        echo ", 子供" . $data[8] . "人";
                    }
                    ?>
                </dd>
            </div>
            <div id="plan">
                <dt> プラン </dt>
                <dd>
                    <?php echo $data[9]; ?>
                </dd>
                <dt> 夕食 </dt>
                <dd>
                    <?php echo $data[10]; ?>
                </dd>
                <dt> 夕食メニュー </dt>
                <dd>
                    <?php echo $data[11]; ?>
                </dd>
                <dt> 朝食 </dt>
                <dd>
                    <?php echo $data[12]; ?>
                </dd>
                <dt> 朝食メニュー </dt>
                <dd>
                    <?php echo $data[13]; ?>
                </dd>
            </div>

            <div id="room">
                <dt> 部屋番号</dt>
                <dd>
                    <?php echo $data[14] . " " . $data[15] . " " . $data[16]; ?>
                </dd>
            </div>
            <div id="remark">
                <dt> 備考</dt>
                <dd>
                    <?php echo $data[18]; ?>
                </dd>
            </div>
        </dl>
    </div>
</body>

</html>