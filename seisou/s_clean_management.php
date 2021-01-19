<?php
    //定数宣言
    //DBへ接続
    include '../db_connect.php';
    include '../front/f_customer.php';

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
    if(isset($_GET["update"])){
        SCleanMainP();
    }

//部屋情報テーブルを全て更新する関数
function SCleanMainP(){
    global $pdo;
     $today = date("Y-m-d");

    //今日の日付を取得
    try{
        //ホテルの階数分ループ
        for ($floor_count = 0; $floor_count < $NUM_OF_FLOOR; $floor_count++){
            //1階の部屋数分だけループ
            for ($room_count = 0; $room_count < $NUM_OF_ROOMS; $room_count++){
                //まずは顧客情報テーブルから、清掃状況を抜き取る
                //そのために部屋番号からIDを取り出し、存在するかどうか確認する。
                $res_id = bool_stay($today, $room);
                if($res_id != 0){
                    //部屋が存在しており、予約IDから清掃状況（チェックイン状態）を取り出す。
                    $room_clean = 0;
                    //次にSCleanUpdateP($room_number, $room_clean)を実行する。
                    SCleanUpdateP($ROOM_DATA[$floor_count][$room_count], $room_clean);
                }else{
                    SCleanUpdateP($ROOM_DATA[$floor_count][$room_count],0);
                }
            }
        }
        //最後までループしているか確認
        echo ($ROOM_DATA[$floor_count][$room_count]."<br>");
        //抜き出した情報を登録する。
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

            <div class="right">
                <!--日付取得-->
                <?php
                    $date = date("Y-m-d");
                    echo ($date."<br>");
                    $next_date = date("Y-m-d", strtotime("+1 day"));
                ?>
            </div>

            <!--更新ボタン-->
            <form action = "s_clean_management.php" method="get">
                <button type = "submit" name = "update" value = "1" onclick = "<?php SCleanMainP();?>">
                更新    
                </button>
            </form>

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
    try{
        $update_sql = "UPDATE room SET room_clean = ".$room_clean." WHERE room_number = ".$room_number.";";
        $stmt = $pdo -> query($people_sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}
?>
