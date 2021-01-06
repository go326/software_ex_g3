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
        $date = date("Y-m-d");
        echo ($date . "<br>");
        $next_date = date("Y-m-d", strtotime("+1 day"));
        ?>

        <span class="sample0"><button class="bg_color0"></button></span>掃除していない、予約なしの状態<br>
        <span class="sample1"><button class="bg_color0"></button></span>お客様がチェックインしている状態<br>
        <span class="sample2"><button class="bg_color0"></button></span>掃除済み状態<br>
    </header>

    <!--清掃情報確認画面の枠組みの作成-->
    <!--formがget方式だがpostにする予定最悪このまま-->
    <form method="P" action="s_clean_edit.php">
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
            //$SCMroom_clean = SCleanManagemantP($value[0]);
            //bg_color0,1,2あるがこれを文字列結合で判断している。
            echo ("<button class = room_button bg_color" . $SCMroom_clean . " type = submit value = " . $ROOM_DATA[$table][$room_count] . " name = room_number >");

            //1セルの表示名
            //1行目
            echo ($value);
            //改行
            echo ("<br>");

            echo cus_name($value) . "<br>";
            //今日の宿泊者数
            //$number_people = SCleanNumberP($date, $ROOM_DATA[$table][$room_count]);
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
    $data = $smt->fetch(PDO::FETCH_ASSOC);
    return $data;
}

//宿泊人数を表示
function SCleanNumberP($day_number, $room_number)
{
    global $pdo;
    $number_people = 0; //その部屋の人数初期値は0
    try {
        $people_sql = "SELECT adult, child FROM customer WHERE stay_date = " . $day_number . " AND room_1 = " . $room_number;
        //2部屋めが生まれたらこの処理が必要かも知れないそしてAND以降を（）でくくる？
        //."OR room_2 = ".$room_number."OR room_3 = ".$room_number
        $stmt = $pdo->query($people_sql);
        while ($row = $stmt->fetch()) {
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
<!-- <script type="text/javascript">
    //import Rein from "./maketable.js";
    let room = <?php echo $data; ?>;
</script>
<?php
//header("Location:./f_top.html");
?>
<script type="text/javascript">
    /**
     * tableの生成関数
     */
    //変数、定数の宣言
    const NUM_OF_ROOMS = 28; //1フロアの部屋数
    const NUM_OF_FLOOR = 3; //部屋があるフロア数
    const LINE_BREAK = 8; //8個の要素tdで改行
    const ID_NAME = "maintable"; //取得するID
    const LINK_HTML = "f_information/f_information_details.html";

    /**Tableの生成関数 */
    function makeTable(tabledata) {
        //table要素の生成
        var table = document.createElement('table');
        var count = 0;
        for (var i = 0; i < 4; i++) {
            //tr要素の生成
            var tr = document.createElement('tr');
            //LINE_BREAK分のdd(部屋)を並べると改行
            for (var j = 0; j < LINE_BREAK; j++) {
                //1フロアの部屋数分を作成するとbreak
                if (count === NUM_OF_ROOMS) {
                    break;
                }
                //tdの生成
                var td = document.createElement('td');
                //<a>の追加
                var a = document.createElement('a');
                //href属性追加～tdへaタグを追加(?以降がパラメータ)
                //phpから配列を受け取るように書き換える
                a.setAttribute("href", LINK_HTML + "?" + tabledata[count]);
                a.textContent = tabledata[count];
                td.appendChild(a);
                //trへtdを追加
                tr.appendChild(td);
                count++;
            }
            //tableへtr追加
            table.appendChild(tr);
        }
        document.getElementById(ID_NAME).appendChild(table);
    }
    //HTMLからの呼び出し
    //function call_makeTable() {
    //print(room);
    makeTable(room);
    // makeTable(data201_235);
    // makeTable(data301_335);
    // makeTable(data401_435);
    //   }


    //部屋番号の配列
    // var data201_235 = [201, 202, 203, 205, 206, 207, 208, 210,
    //     211, 212, 213, 215, 216, 217, 218, 220,
    //     221, 222, 223, 225, 226, 227, 228, 230,
    //     231, 232, 233, 235
    // ];
    // var data301_335 = [301, 302, 303, 305, 306, 307, 308, 310,
    //     311, 312, 313, 315, 316, 317, 318, 320,
    //     321, 322, 323, 325, 326, 327, 328, 330,
    //     331, 332, 333, 335
    // ];
    // var data401_435 = [401, 402, 403, 405, 406, 407, 408, 410,
    //     411, 412, 413, 415, 416, 417, 418, 420,
    //     421, 422, 423, 425, 426, 427, 428, 430,
    //     431, 432, 433, 435
    // ];

    //tableの値の取得
    function getTable() {
        alert("in");
        var tableData = document.getElementById(ID_NAME);
        var rowlen = tableData.rows.length;
        for (var i = 0; i < rowlen; i++) {
            for (var j = 0; j < tableData.rows[i].cells.length; j++) {
                var txtTabledata = tableData.rows[i].cells[j].appendChild[0].value;
            }
        }
    }
</Script> -->