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
    $ROOM_DATA = ([$DATA201_235, $DATA301_335, $DATA401_435]);
    $NUM_OF_ROOMS = 28;//1フロアの部屋数
    $NUM_OF_FLOOR = 3; //部屋があるフロア数
    $LINE_BREAK = 8;//8個の要素tdで改行
    $LINK_PHP = "s_clean_edit.php"; //phpのURL


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
            <?php
                $date = date("Y-m-d");
                echo ($date."<br>");
                $next_date = date("Y-m-d", strtotime("+1 day"));
                //echo ($next_date."<br>");
            ?>
        </header>

        <!--清掃情報確認画面の枠組みの作成-->
        <form method="get" action = "s_clean_edit.php">
        <?php
            for ($table = 0; $table < $NUM_OF_FLOOR; $table++){
                echo ("<table>");
                //echo ("table-test<br>");
                //ホテルの１階分だけループする。
                $room_count = 0; //1階の部屋数のカウント
                for ($tr = 0; $tr <= $NUM_OF_FLOOR; $tr++){
                    //echo ("tr-test".$NUM_OF_FLOOR."<br>");
                    echo ("<tr>");
                    //表の１行に表示する部屋数分だけループする
                    for ($td = 0; $td < $LINE_BREAK ; $td++){
                        //echo ("if-test".$LINE_BREAK."<br>");
                        //1階の部屋数表を作成したら終了し、次の階へ
                        if($room_count == $NUM_OF_ROOMS){
                            break;
                        }
                        //1セルの表示開始
                        //echo ("td-test".$NUM_OF_ROOMS."<br>");
                        echo ("<td>");
                        //1部屋のリンク
                        //echo ("<a href = \" ".$LINK_PHP."\"?room_number=".$ROOM_DATA[$table][$room_count].">");
                        $SCMroom_clean = SCleanManagemantP($ROOM_DATA[$table][$room_count]);

                        echo ("<button class = \"room_button bg_color".$SCMroom_clean."\" type = \"submit\" value = \"".$ROOM_DATA[$table][$room_count]."\" name = \"room_number\" >");
                        //1セルの表示名
                        //1行目
                        echo ($ROOM_DATA[$table][$room_count]);
                        //改行
                        echo ("<br>");
                        //現在の宿泊者数
                        $number_people = SCleanNumberP($date, $ROOM_DATA[$table][$room_count]);
                        echo ($number_people."人");
                        echo ("<br>");
                        //次の日の宿泊者数
                        $number_people = SCleanNumberP($next_date, $ROOM_DATA[$table][$room_count]);
                        echo ($number_people."人");
                        //echo ("</a>");
                        echo ("</button>");
                        echo ("</td>\n");
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
    //SCleanManagemantP();


    //原因不明だが、POST方式に変更する予定


//清掃情報確認画面の枠組みの清掃状況を取り出し
function SCleanManagemantP($room_number){
    global $pdo;
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
    $number_people = 0;
    try{
        $people_sql = "SELECT adult, child FROM customer WHERE stay_date = ".$day_number." AND room_1 = ".$room_number;
        //."OR room_2 = ".$room_number."OR room_3 = ".$room_number
        echo ($people_sql);
        $stmt = $pdo -> query($people_sql);
        echo ("start while ");
        while ($row = $stmt -> fetch()){
            $adult = $row["adult"];
            $child = $row["child"];
        }

        echo ("start if");
        if(isset($adult)){
            if(isset($child)){
                //大人も子供もいる状態
                $number_people = $adult + $child;
            }else{
                //大人だけいる状態
                $number_people = $adult;
            }
        }
        return $number_people;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

//色についてのphpのfunctionを作成する。

//list($room_number,$room_clean) = SCleanManagemantP();
//var_dump($room_number);
//var_dump($room_clean);

?>
