<!DOCTYPE html>

<?php
include("../../db_connect.php");


$sql = "SELECT * FROM customer ";

$smt = $pdo->query($sql);
$data = $smt->fetch(PDO::FETCH_NUM);

$stay_day = $data[2]->DateTime::add(DateInterval::createFromDateString($data[3] . "day"))->format('Y-m-d');


?>

<html>

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="./f_information.css" type="text/css">
    <!-- <script type="text/javascript" src="maketable.js"></script>
    <script type="text/javascript" src="f_top.js"></script> -->
</head>

<body>
    <header>
        <h1>予約確認画面</h1>
    </header>

    <div id="main">
        <dl id="id">
            <dt> 予約ID </dt?>
            <dd>
                <?php echo $data[0]; ?>
            </dd>
        </dl>
        <dl id="day">
            <dt> 予約日 </dt?>
            <dd>
                <?php echo $data[2]; ?>
            </dd>
            <dt> 宿泊日 </dt>
            <dd>
                <?php echo $data[1] . "~" . $stay_day; ?>
            </dd>
        </dl>
        <dl id="customer">
            <dt> 氏名 </dt?>
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
        </dl>
        <dl id="counter">
            <dt> 人数 </dt?>
            <dd>
                <?php echo $data[7]; ?>
            </dd>
            <dt> 人数 </dt>
            <dd>
                <?php echo $data[8]; ?>
            </dd>
        </dl>
        <dl id="plan">
            <dt> プラン </dt?>
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
        </dl>

        <dl id="room">
            <dt> 部屋番号</dt?>
            <dd>
                <?php echo $data[14] . " " . $data[15] . " " . $data[16]; ?>
            </dd>
        </dl>
        <dl id="remark">
            <dt> 備考</dt?>
            <dd>
                <?php echo $data[18]; ?>
            </dd>
        </dl>
    </div>
</body>