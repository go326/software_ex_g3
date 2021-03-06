<?php
    include("s_clean.php");

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
    SCleanMainP();
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
                    <!-- <form action = "../i_general_top.html">
                        <input id="submit_button" type="submit" name="submit"value = "総合TOP画面へ戻る">
                    </form> -->
        <input id="submit_button" type="button" onclick="location.href='../i_general_top.html'" value="TOP画面に戻る">

                </div>
            <!--</div>-->

            <div class="right">
                <!--日付取得-->
                <?php
                    $dt = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
                    $date = $dt->format("Y-m-d");
                    echo ($date."<br>");
                    $next_date = $dt->add(DateInterval::createFromDateString("1day"))->format('Y-m-d');
                    //$next_date = $dtdate("Y-m-d", strtotime("+1 day"));
                ?>
            </div>

            <span class = "sample0"><button class = "bg_color0"></button></span>お客様がチェックインしていない状態<br>
            <span class = "sample1"><button class = "bg_color0"></button></span>お客様がチェックインしている状態<br>
            <span class = "sample3"><button class = "bg_color0"></button></span>未清掃<br>
            <span class = "sample2"><button class = "bg_color0"></button></span>清掃済<br>
        </header>

        <!--清掃情報確認画面の枠組みの作成-->
        <!--formがget方式だがpostにする予定最悪このまま-->
        <form method="post" action = "s_clean_edit.php">
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
                        $room_number = $ROOM_DATA[$table][$room_count];
                        //今日と明日の予約の人数を取得するための予約IDを探す
                        $today_res_id = bool_stay($date, $room_number);
                        $next_res_id = bool_stay($next_date, $room_number);
                        //echo ($today_res_id.",".$next_res_id."<br>");
                        //今日の宿泊者数を取得
                        $today_people = SCleanNumber($today_res_id);
                        //明日の宿泊者数を取得
                        $next_people = SCleanNumber($next_res_id);

                        //1セルの表示開始
                        echo ("<td>");
                        $SCMroom_clean = SCleanManagemantP($room_number);
                        if($SCMroom_clean == 10){
                            echo ("<button class = \"room_button\" type = \"submit\" value = \"".$room_number."\" name = \"room_number\" disabled>");
                        }else{
                            //bg_color0,1,2あるがこれを文字列結合で判断している。
                            //2,3ならボタン押せる
                            echo ("<button class = \"room_button bg_color".$SCMroom_clean."\" type = \"submit\" value = \"".$room_number."\" name = \"room_number\"");
                            if($SCMroom_clean == 0 || $SCMroom_clean == 1){
                                echo ("disabled");
                            }
                            echo (">");
                        }
                        //1セルの表示名
                        //1行目
                        echo ($room_number);

                        //改行
                        echo ("<br>");

                        //2行目
                        echo ("本日".$today_people."人");
                        echo ("<br>");

                        //３行目
                        echo ("明日".$next_people."人");
                        
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