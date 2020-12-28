<!DOCTYPE html>

<?php
include("../../db_connect.php");


$sql = "SELECT * FROM customer ";

$smt = $pdo->query($sql);
$data = $smt->fetch();
var_dump($data);

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
                <?php echo $data; ?>
            </dd>
        </dl>
        <dl id="day">
            <dt> 予約日 </dt?>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 宿泊日 </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
        </dl>
        <dl id="customer">
            <dt> 氏名 </dt?>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 住所 </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 電話番号 </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
        </dl>
        <dl id="counter">
            <dt> 人数 </dt?>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 人数 </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
        </dl>
        <dl id="plan">
            <dt> プラン </dt?>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 夕食 </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 夕食メニュー </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 朝食 </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
            <dt> 朝食メニュー </dt>
            <dd>
                <?php echo $data; ?>
            </dd>
        </dl>

        <dl id="room">
            <dt> 部屋番号</dt?>
            <dd>
                <?php echo $data; ?>
            </dd>
        </dl>
        <dl id="remark">
            <dt> 備考</dt?>
            <dd>
                <?php echo $data; ?>
            </dd>
        </dl>
    </div>
</body>