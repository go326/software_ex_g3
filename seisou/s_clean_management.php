<?php
     
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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
        <script type="text/javascript" src="seisou.js"></script>
        <title>seisou</title>

    </head>

    <body>
        <header>
            <h1> 清掃情報管理画面</h1>
            <ul>
                <li id="view_date"></li>
            </ul>
        </header>

        <!--清掃情報確認画面の枠組みの作成-->
        <?php
            for ($table = 0; $table < $NUM_OF_FLOOR; $table){
                echo ("<table>");
                //echo ("table-test<br>");
                //ホテルの１階分だけループする。
                for ($tr = 0; $tr <= $NUM_OF_FLOOR; $tr++){
                    //echo ("tr-test".$NUM_OF_FLOOR."<br>");
                    echo ("<tr>");
                    $room_count = 0; //1階の部屋数のカウント
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
                        echo ("<a href = \" ".$LINK_PHP."\"?room_number=".$ROOM_DATA[$table][$room_count].">");
                        //1セルの表示名
                        echo ($ROOM_DATA[$table][$room_count]);
                        echo ("</a>");
                        echo ("</td>");
                        $room_count++;
                    }
                    echo ("</tr>");
                }
                echo ("</table>");
            }
        ?>
        
    </body>
</html>

<?php
    //清掃情報確認画面の枠組みに反映
    //SCleanManagemantP();


    //原因不明だが、POST方式に変更する予定
    
    //phpとして別のファイルにするべき?
    //清掃情報更新
    if(isset($_GET["room_number"]) && isset($_GET["room_clean"])){
        $room_number = $_GET["room_number"];
        $room_clean = $_GET["room_clean"];
        SCleanEditP($room_number,$room_clean);
    }


//清掃情報確認画面の枠組みの清掃状況を反映
function SCleanManagemantP(){
    global $pdo,$room_number,$room_clean;
    $stmt = $pdo -> query("SELECT * FROM room");
    //fetch
    while ($row = $stmt -> fetch()){
        $room_number = $row["room_number"];
        $room_clean = $row["room_clean"];
        echo($room_number.",".$room_clean."<br>");
    }
    //return [$room_number,$room_clean];
}

//宿泊人数を表示
function SCleanNumberP(){
    echo ("test");
}

//色についてのphpのfunctionを作成する。


//phpとして別のファイルにするべき？
//掃除状況を変更する,清掃状況管理画面に戻る
function SCleanEditP($room_number,$room_clean){
    global $pdo;
    try{
        $sc_sql = "UPDATE room SET room_clean = ".$room_clean." WHERE room_number = ".$room_number;
        $stmt = $pdo -> prepare($sc_sql);
        $stmt -> execute();
        echo ("実行に成功しました。<br>");
        echo ($room_number."号室を");
        if($room_clean == 0){
            echo("掃除していない");
        }else if($room_clean == 1){
            echo("チェックイン状態");
        }else if($room_clean == 2){
            echo("掃除済み");
        }
        echo ("に変更しました。<br>");
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    $back_URL = "clean_management.html";
    echo ("<form action = ".$back_URL.">");
    echo ("<button type = \" submit \">戻る</button>");
    echo ("</form>");
}

//list($room_number,$room_clean) = SCleanManagemantP();
//var_dump($room_number);
//var_dump($room_clean);

?>
