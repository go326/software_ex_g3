<?php

    include 's_clean.php';

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