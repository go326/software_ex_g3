<?php

require(dirname(__FILE__) . "/../../db_connect.php");

$stmt;
global $pdo;
ini_set('display_errors', "On");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
function db_update($value)
{
    global $pdo, $stmt;
    try {
        $sql = 'UPDATE customer set stay_date = ?, stay_count = ?, customer_name = ?, customer_address = ?, phone_number = ?,';
        $sql .= ' adult = ?, child = ?, customer_plan = ?, is_dinner = ?, dinner_menu = ?, is_breakfast = ?, breakfast_menu = ?,';
        $sql .= ' room_1 = ?, room_2 = ?, room_3 = ?, customer_remark = ? WHERE reseravetion_id = ?';
        $stmt = $pdo->prepare($sql);
        $dt = new DateTime($value[0] . '/' . $value[1] . '/' . $value[2]); //宿泊日
        $stay_day = $dt->format('Y-m-d');
        $ID = $dt->format('Ymd');
        $ID .= $value[14];
        $is_dinner = get_num($value[10]);
        $is_breakfast = get_num($value[12]);
        
	$stmt->bindValue(1, $stay_day, PDO::PARAM_STR); //宿泊日
        $stmt->bindValue(2, $value[3], PDO::PARAM_STR); //泊数
        $stmt->bindValue(3, $value[4], PDO::PARAM_STR); //氏名
        $stmt->bindValue(4, $value[5], PDO::PARAM_STR); //住所
        $stmt->bindValue(5, $value[6], PDO::PARAM_STR); //電話番号
        $stmt->bindValue(6, $value[7], PDO::PARAM_INT); //大人
	
	set_null(7, $value[8], 1); //子供
        $stmt->bindValue(8, $value[9], PDO::PARAM_STR); //プラン
        $stmt->bindValue(9, (int)$is_dinner, PDO::PARAM_INT); //is夕食
        set_null(10, $value[11], 2); //メニュー
        $stmt->bindValue(11, (int)$is_breakfast, PDO::PARAM_INT); //is朝食
        set_null(12, $value[13], 2); //メニュー
        $stmt->bindValue(13, $value[14], PDO::PARAM_INT); //部屋１
        set_null(14, $value[15], 1); //部屋２
        set_null(15, $value[16], 1); //部屋３
        set_null(16, $value[17], 2); //備考
        $stmt->bindValue(17, $ID, PDO::PARAM_INT); //ID
       $stmt->execute();
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}

function db_insert($value)
{
    global $pdo, $stmt;
    try {
        $sql = 'INSERT INTO customer VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0,?)';
        $stmt = $pdo->prepare($sql);
        $dt = new DateTime(); //予約日
        $today = $dt->format('Y-m-d');
        $dt = new DateTime($value[0] . '/' . $value[1] . '/' . $value[2]); //宿泊日
        $stay_day = $dt->format('Y-m-d');
        $ID = $dt->format('Ymd');
        $ID .= $value[14];
        $is_dinner = get_num($value[10]);
        $is_breakfast = get_num($value[12]);

        $stmt->bindValue(1, $ID, PDO::PARAM_INT); //ID
        $stmt->bindValue(2, $stay_day, PDO::PARAM_STR); //宿泊日
        $stmt->bindValue(3, $today, PDO::PARAM_STR);    //予約日
        $stmt->bindValue(4, $value[3], PDO::PARAM_STR);  //泊数
        $stmt->bindValue(5, $value[4], PDO::PARAM_STR);  //氏名
        $stmt->bindValue(6, $value[5], PDO::PARAM_STR);  //住所
        $stmt->bindValue(7, $value[6], PDO::PARAM_STR);  //電話番号
        $stmt->bindValue(8, $value[7], PDO::PARAM_INT);  //大人
        set_null(9, $value[8], 1); //子供
        $stmt->bindValue(10, $value[9], PDO::PARAM_STR); //プラン
        $stmt->bindValue(11, (int)$is_dinner, PDO::PARAM_INT); //is夕食
        set_null(12, $value[11], 2);  //メニュー
        $stmt->bindValue(13, (int)$is_breakfast, PDO::PARAM_INT); //is朝食
        set_null(14, $value[13], 2); //メニュー
        $stmt->bindValue(15, $value[14], PDO::PARAM_INT); //部屋１
        set_null(16, $value[15], 1); //部屋２
        set_null(17, $value[16], 1); //部屋３
        set_null(18, $value[17], 2); //備考
        $stmt->execute();
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
}

function get_num($name)
{
    if (strcmp($name, "有") == 0) {
        $num = 1;
    } else if (strcmp($name, "無") == 0) {
        $num = 0;
    }
    return $num;
}
function set_null($num, $name, $flag)
{
    global $stmt;
    if (strcmp($name, "なし") == 0) {
        $stmt->bindValue($num, null, PDO::PARAM_NULL);
    } else if ($flag == 1) {
        $stmt->bindValue($num, $name, PDO::PARAM_INT);
    } else if ($flag == 2) {
        $stmt->bindValue($num, $name, PDO::PARAM_STR);
    }
}
