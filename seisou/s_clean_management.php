<?php
    
    include '../db_connect.php';


    //SCleanManagemantP();

    if(isset($_POST['room_number'])){
        $room_number = $_POST[('room_number')];
        echo ($room_number);
        SCleanEditP($room_number);
    }
    
function SCleanManagemantP(){
    global $pdo,$room_number,$room_clean;
    $stmt = $pdo -> query("SELECT * FROM room");
    //fetch
    while ($row = $stmt -> fetch()){
        $room_number = $row["room_number"];
        $room_clean = $row["room_clean"];
        echo ($room_number.",".$room_clean."<br>");
    }
    //return [$room_number,$room_clean];
}

function SCleanNumberP(){
    echo ("test");
}

function SCleanEditP($room_number){
    echo ($room_number."test");
}

//list($room_number,$room_clean) = SCleanManagemantP();
//var_dump($room_number);
//var_dump($room_clean);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>seisou</title>
    </head>

    <body>
        <h1> 清掃情報管理画面php</h1>

        <form method = “POST” action = s_clean_management.php>
            <input type="submit" value="201" name="room_number"　>
            <!--onclick="SCleanManagemantP()">-->
        </form>
    </body>
</html>
