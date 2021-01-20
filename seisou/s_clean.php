<?php
    //定数宣言
    //DBへ接続
    include("../front/f_customer.php");

    //清掃情報確認画面の枠組みの作成のための定数
    //部屋番号の配列
    $DATA201_235 = ([201, 202, 203, 205, 206, 207, 208, 210,
                    211, 212, 213, 215, 216, 217, 218, 220,
                    221, 222, 223, 225, 226, 227, 228, 230,
                    231, 232, 233, 235]);
    $DATA301_335 = ([301, 302, 303, 305, 306, 307, 308, 310,
                    311, 312, 313, 315, 316, 317, 318, 320,
                    321, 322, 323, 325, 326, 327, 328, 330,
                    331, 332, 333, 335]);
    $DATA401_435 = ([401, 402, 403, 405, 406, 407, 408, 410,
                    411, 412, 413, 415, 416, 417, 418, 420,
                    421, 422, 423, 425, 426, 427, 428, 430,
                    431, 432, 433, 435]);
    $ROOM_DATA = ([$DATA201_235, $DATA301_335, $DATA401_435]); //2次元配列化
    $NUM_OF_ROOMS = 28; //1フロアの部屋数
    $NUM_OF_FLOOR = 3; //部屋があるフロア数
    $ALL_ROOM = $NUM_OF_ROOMS * $NUM_OF_FLOOR; //ホテルの全ての部屋数
    $LINE_BREAK = 8; //8個の要素tdで改行
    $LINK_PHP = "s_clean_edit.php"; //phpのURL

//総合TOPからの遷移時にform(get)でroginを与えてもらう。
//ログインして、この画面に遷移したときに掃除情報テーブル(room)を更新するように設定する。

//部屋情報テーブルを全て更新する関数
function SCleanMainP(){
    global $DATA201_235,$DATA301_335,$DATA401_435,$ROOM_DATA,$NUM_OF_ROOMS,$NUM_OF_FLOOR,$ALL_ROOM;
    $today = date("Y-m-d");
    $room_clean = 0; //初期値は0
    //今日の日付を取得
    try{
        //ホテルの階数分ループ
        for ($floor_count = 0; $floor_count < $NUM_OF_FLOOR; $floor_count++){
            //1階の部屋数分だけループ
            for ($room_count = 0; $room_count < $NUM_OF_ROOMS; $room_count++){
                //まずは顧客情報テーブルから、清掃状況を抜き取る
                //そのために部屋番号からIDを取り出し、存在するかどうか確認する。
                $res_id = bool_stay($today, $ROOM_DATA[$floor_count][$room_count]);
                //予約が存在しているか確認する
                if($res_id != 0){
                    //部屋が存在しており、予約IDから清掃状況（チェックイン状態）を取り出す。
                    echo($res_id."<br>test<br>");
                    $room_clean = ischeckin($res_id); 
                    print_r($room_clean);
                }
                //次にSCleanUpdateP($room_number, $room_clean)を実行する。
                SCleanUpdateP($ROOM_DATA[$floor_count][$room_count], $room_clean);
            }
            echo ($floor_count);
        }
        //最後までループしているか確認
        echo ($floor_count."<br>".$ROOM_DATA[$floor_count][$room_count]."<br>".$room_count."<br>");
        //抜き出した情報を登録する。
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    return $number_people;
}

//清掃情報確認画面の枠組みに反映
//清掃情報確認画面の枠組みの清掃状況を取り出し
//ここで参照する色を決めている
function SCleanManagemantP($room_number){
    global $pdo;
    $room_clean = 0; //清掃状況、初期値は0で宿泊予定者がいないことを示す。
    $stmt = $pdo -> query("SELECT room_clean FROM room WHERE room_number = ".$room_number);
    //fetch
    while ($row = $stmt -> fetch()){
        //$room_number = $row["room_number"];
        $room_clean = $row["room_clean"];
        //echo($room_number.",".$room_clean."<br>");
    }
    return $room_clean;
}

//宿泊人数を表示
//これを改良することによって、本日と明日の人数を変更することができるはず、
function SCleanNumberP($day_number, $room_number){
    global $pdo;
    $number_people = 0; //その部屋の人数初期値は0
    try{
        $people_sql = "SELECT adult, child FROM customer WHERE stay_date = ".$day_number." AND room_1 = ".$room_number;
        //2部屋めが生まれたらこの処理が必要かも知れないそしてAND以降を（）でくくる？
        //."OR room_2 = ".$room_number."OR room_3 = ".$room_number
        $stmt = $pdo -> query($people_sql);
        while ($row = $stmt -> fetch()){
            $adult = $row["adult"];
            $child = $row["child"];
        }
        if(isset($adult)){
            if(isset($child)){
                //大人も子供もいる状態
                $number_people = $adult + $child;
            }else{
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

//清掃状況を更新する
//部屋番号とその清掃状況を渡して更新する。
function SCleanUpdateP($room_number, $room_clean){
    global $pdo;
    try{
        $update_sql = "UPDATE room SET room_clean = ".$room_clean." WHERE room_number = ".$room_number.";";
        $stmt = $pdo -> query($update_sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}
?>
