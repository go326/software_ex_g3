<!DOCTYPE html>

<?php
include("../db_connect.php");

global $pdo;

//$todayに$room番の部屋が使われているかを判定
//返り値 予約ID   または 0
function bool_stay($today, $room)
{
    global $pdo;
    $sql = "SELECT * FROM customer where room_1 = ? or room_2 = ? or room_3 = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $room, PDO::PARAM_INT);
    $stmt->bindValue(2, $room, PDO::PARAM_INT);
    $stmt->bindValue(3, $room, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $value) {
        $dt = new DateTime($value['stay_date']);
        $date = $dt->format('Y-m-d');
        for ($i = 1; $i <= $value['stay_count']; $i++) {
            if ($date == $today) {
                return $value['reseravetion_id'];
            }
            $date = $dt->add(DateInterval::createFromDateString("1day"))->format('Y-m-d');
        }
    }
    return 0;
}

//予約のお客様名を返す
function cus_name($ID)
{
    global $pdo;
    $sql = "SELECT customer_name FROM customer where reseravetion_id = ?";
    $smt = $pdo->prepare($sql);
    $smt->bindValue(1, $ID, PDO::PARAM_STR);
    $smt->execute();
    $data = $smt->fetch(PDO::FETCH_ASSOC);
    return $data['customer_name'] . " 様";
}


//宿泊人数を表示
function SCleanNumberP($ID)
{
    global $pdo;
    $number_people = 0; //その部屋の人数初期値は0
    try {
        $people_sql = "SELECT adult, child FROM customer where reseravetion_id = ? ";
        $stmt = $pdo->prepare($people_sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_STR);
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

function delete($ID)
{
    global $pdo;
    $sql = "DELETE FROM customer where reseravetion_id = ?";
    $smt = $pdo->prepare($sql);
    $smt->bindValue(1, $ID, PDO::PARAM_STR);
    $smt->execute();
    echo "削除されました．";
}

function checkin($ID)
{
    global $pdo;
    $checkin = ischeckin($ID);
    if ($checkin == 0) {
        $checkin = 1;
    } else {
        $checkin = 3;
    }
    $sql = "UPDATE customer SET customer_checkin = ? WHERE reseravetion_id = ?";
    $smt = $pdo->prepare($sql);
    $smt->bindValue(1, $checkin, PDO::PARAM_INT);
    $smt->bindValue(2, $ID, PDO::PARAM_STR);
    $smt->execute();
}

function stay($ID)
{
    global $pdo;
    $checkin = ischeckin($ID);
    if ($checkin == 1) {
        $checkin = 2;
    } else if ($checkin == 2) {
        $checkin = 1;
    }
    $sql = "UPDATE customer set customer_checkin = 2 WHERE reseravetion_id = ?";
    $smt = $pdo->prepare($sql);
    $smt->bindValue(1, $ID, PDO::PARAM_STR);
    $smt->execute();
}

//checkin状態を取得、返す
function ischeckin($ID)
{
    global $pdo;
    ini_set('display_errors', "On");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    try {
        $sql = "SELECT customer_checkin FROM customer WHERE reseravetion_id = ?";
        $smt = $pdo->prepare($sql);
        $smt->bindValue(1, $ID, PDO::PARAM_STR);
        $smt->execute();
        $data = $smt->fetch();
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
    return $data;
}
