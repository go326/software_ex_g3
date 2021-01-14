<?php
    //定数宣言
    //DBへ接続
    include '../db_connect.php';

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
    $LINE_BREAK = 8; //8個の要素tdで改行
    $LINK_PHP = "s_clean_edit.php"; //phpのURL

//総合TOPからの遷移時にform(get)でroginを与えてもらう。
//ログインして、この画面に遷移したときに掃除情報テーブル(room)を更新するように設定する。
    if(isset($_GET["rogin"])){
        //SCleanMainP();
    }

//ログインしたときに部屋情報テーブルを更新する関数
function SCleanMainP(){
    global $pdo;
    //今日の日付を取得
    $date = date("Y-m-d");
    try{
        //テーブル全ての情報を削除する。
        $delete_sql = "DELETE FROM room";
        $stmt = $pdo -> prepare($delete_sql);
        $stmt -> execute();
        echo ("過去のテーブルの削除に成功しました。<br>");

        //まずは情報を抜き出す
        $make_sql = "SELECT room1,customer_checkin  FROM customer WHERE stay_date = ".$day_number;
        //2部屋めが生まれたらあとで考える

        $stmt = $pdo -> query($make_sql);
        while ($row = $stmt -> fetch()){
            $room_number = $row["room1"];
            $room_clean = $row["customer_checkin"];
        }

        //抜き出した情報を登録する。
        $insert_sql = "INSERT INTO room (room_number, room_clean) VALUES ('201', '0');";

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


    //html開始
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
            <!--<div class="button-position-c">-->
                <div class="input#submit_button">
                    <form action = "../i_general_top.html">
                        <input id="submit_button" type="submit" name="submit"value = "総合TOP画面へ戻る">
                    </form>
                </div>
            <!--</div>-->

            <!--更新ボタン-->
            <form action = "s_clean_management.php">

                <input type>            
            <!--日付取得-->
            <?php
                $date = date("Y-m-d");
                echo ($date."<br>");
                $next_date = date("Y-m-d", strtotime("+1 day"));
            ?>

            <span class = "sample0"><button class = "bg_color0"></button></span>掃除していない、予約なしの状態<br>
            <span class = "sample1"><button class = "bg_color0"></button></span>お客様がチェックインしている状態<br>
            <span class = "sample2"><button class = "bg_color0"></button></span>掃除済み状態<br>
        </header>

        <!--清掃情報確認画面の枠組みの作成-->
        <!--formがget方式だがpostにする予定最悪このまま-->
        <form method="get" action = "s_clean_edit.php">
        <?php
            //３階分テーブルを作成する
            for ($table = 0; $table < $NUM_OF_FLOOR; $table++){
                echo ("<table>");
                //ホテルの１階分だけループする。
                $room_count = 0; //1階の部屋数のカウント
                for ($tr = 0; $tr <= $NUM_OF_FLOOR; $tr++){
                    echo ("<tr>");
                    //表の１行に表示する部屋数分だけループする
                    for ($td = 0; $td < $LINE_BREAK ; $td++){
                        //1階の部屋数だけ表を作成したら終了し、次の階へ
                        if($room_count == $NUM_OF_ROOMS){
                            break;
                        }
                        //1セルの表示開始
                        echo ("<td>");
                        //1部屋のリンク現在はボタンで作成
                        //echo ("<a href = \" ".$LINK_PHP."\"?room_number=".$ROOM_DATA[$table][$room_count].">");
                        $SCMroom_clean = SCleanManagemantP($ROOM_DATA[$table][$room_count]);
                        //bg_color0,1,2あるがこれを文字列結合で判断している。
                        echo ("<button class = \"room_button bg_color".$SCMroom_clean."\" type = \"submit\" value = \"".$ROOM_DATA[$table][$room_count]."\" name = \"room_number\" >");

                        //1セルの表示名
                        //1行目
                        echo ($ROOM_DATA[$table][$room_count]);
                        //改行
                        echo ("<br>");
                        //今日の宿泊者数
                        $number_people = SCleanNumberP($date, $ROOM_DATA[$table][$room_count]);
                        echo ("本日".$number_people."人");
                        echo ("<br>");
                        //明日の宿泊者数
                        $number_people = SCleanNumberP($next_date, $ROOM_DATA[$table][$room_count]);
                        echo ("明日".$number_people."人");
                        //echo ("</a>");
                        echo ("</button>");
                        echo ("</td>\n");
                        //１セル終了
                        $room_count++;
                    }
                    echo ("</tr>");
                }
                echo ("</table>\n");
            }
        ?>
        </form>
    </body>
</html>

<?php
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

function SCleanUpdateP(){

}
?>
