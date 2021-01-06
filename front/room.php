<?php

include("../db_connect.php");
global $pdo;

$sql = "SELECT room_number FROM  room";
echo $sql;
$smt = $pdo->prepare($sql);
$data = $smt->execute();
$data = $smt->fetchAll(PDO::FETCH_NUM);

$room = array();
foreach ($data as $value) {
    array_push($room, $value[0]);
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="./clean_management.css" type="text/css">
    <title>seisou</title>

</head>

<body>
    <header>
        <h1> 清掃情報管理画面</h1>

        <!--戻るボタン-->
        <div class="button-position-c">
            <div class="input#submit_button">
                <form action="../i_general_top.html">
                    <input id="submit_button" type="submit" name="submit" value="総合TOP画面へ戻る">
                </form>
            </div>
        </div>

        <!--日付取得-->
        <?php
        // $date = date("Y-m-d");
        // echo ($date . "<br>");
        // $next_date = date("Y-m-d", strtotime("+1 day"));

        $dt = new DateTime(); //予約日
        $date = $dt->format('Y-m-d');
        ?>

        <span class="sample0"><button class="bg_color0"></button></span>掃除していない、予約なしの状態<br>
        <span class="sample1"><button class="bg_color0"></button></span>お客様がチェックインしている状態<br>
        <span class="sample2"><button class="bg_color0"></button></span>掃除済み状態<br>
    </header>

    <!--清掃情報確認画面の枠組みの作成-->
    <!--formがget方式だがpostにする予定最悪このまま-->
    <form method="get" action="./f_information/f_information.php">
        <?php
        //３階分テーブルを作成する
        foreach ($room as $num => $value) {


            if ($value % 100 == 1) {
                echo ("<table>");
                //ホテルの１階分だけループする。
                $room_count = 0; //1階の部屋数のカウント
                echo ("<tr>");
                //表の１行に表示する部屋数分だけループする
            }
            //1セルの表示開始
            echo ("<td>");
            //1部屋のリンク現在はボタンで作成
            //チェックインの情報をとるかな？
            //$SCMroom_clean = SCleanManagemantP($value);
            //bg_color0,1,2あるがこれを文字列結合で判断している。
            echo ("<button class = room_button bg_color" . $SCMroom_clean . " type = submit value = " . $value . " name = room >");

            //1セルの表示名
            //1行目
            echo ($value);
            //改行
            echo ("<br>");

            echo cus_name($value) . "<br>";
            //今日の宿泊者数
            $number_people = SCleanNumberP($value);
            echo ("本日" . $number_people . "人");
            echo ("<br>");
            echo ("</button>");
            echo ("</td>\n");
            //１セル終了

            if ($value[$num + 1] % 100 == 35) {
                echo ("</tr>");
                echo ("</table>\n");
            }
        }
        ?>
    </form>
</body>

</html>

<?php
//清掃情報確認画面の枠組みに反映
//清掃情報確認画面の枠組みの清掃状況を取り出し
//ここで参照する色を決めている
function SCleanManagemantP($room_number)
{
    global $pdo;
    $room_clean = 0; //清掃状況、初期値は0で宿泊予定者がいないことを示す。
    $stmt = $pdo->query("SELECT room_clean FROM room WHERE room_number = " . $room_number);
    //fetch
    while ($row = $stmt->fetch()) {
        //$room_number = $row["room_number"];
        $room_clean = $row["room_clean"];
        //echo($room_number.",".$room_clean."<br>");
    }
    return $room_clean;
}

function cus_name($room)
{
    global $date, $pdo;
    $sql = "SELECT customer_name FROM customer where stay_date = ? and ( room_1 = ? or room_2 =? or room_3 = ?)";
    $smt = $pdo->prepare($sql);
    $smt->bindValue(1, $date, PDO::PARAM_STR);
    $smt->bindValue(2, $room, PDO::PARAM_INT);
    $smt->bindValue(3, $room, PDO::PARAM_INT);
    $smt->bindValue(4, $room, PDO::PARAM_INT);
    $smt->execute();
    $data = $smt->fetch(PDO::FETCH_ASSOC);
    return $data['customer_name'] . " 様";
}

//宿泊人数を表示
function SCleanNumberP($room)
{
    global $pdo, $date;
    $number_people = 0; //その部屋の人数初期値は0
    try {
        $people_sql = "SELECT adult, child FROM customer WHERE stay_date = ? and ( room_1 = ? or room_2 =? or room_3 = ?) ";
        $stmt = $pdo->prepare($people_sql);
        $stmt->bindValue(1, $date, PDO::PARAM_STR);
        $stmt->bindValue(2, $room, PDO::PARAM_INT);
        $stmt->bindValue(3, $room, PDO::PARAM_INT);
        $stmt->bindValue(4, $room, PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adult = $row["adult"];
            $child = $row["child"];
        }
        if (isset($adult)) {
            if (isset($child)) {
                //大人も子供もいる状態
                $number_people = $adult + $child;
            } else {
                //大人だけいる状態
                $number_people = $adult;
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    return $number_people;
}
?>